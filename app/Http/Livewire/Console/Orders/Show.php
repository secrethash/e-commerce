<?php

namespace App\Http\Livewire\Console\Orders;

use App\Mail\OrderConfirmed;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;
use Mail;
use Shopper\Framework\Models\Shop\Order\Order;
use Shopper\Framework\Models\Shop\Order\OrderStatus;
// use App\Models\Order;
// use App\Models\Enums\OrderStatus;
use App\Models\Address;
use App\Services\Orders;
use Illuminate\Support\Fluent;
use Str;
use WireUi\Traits\Actions;

class Show extends Component
{
    use Actions;
    use WithPagination;

    public Order $order;

    public int $perPage = 3;

    public ?string $notes = null;

    public function goToOrder(int $id)
    {
        $this->redirectRoute('shopper.orders.show', $id);
    }

    public function cancelOrder()
    {
        $this->order->update(['status' => OrderStatus::CANCELLED]);

        $this->notification()->success(__('Cancelled'), __('This order has been cancelled!'));
    }

    public function leaveNotes()
    {
        $this->validate(['notes' => 'required']);

        $this->order->update(['notes' => $this->notes]);

        // TODO Send notification to the customer about order notes.

        $this->notification()->success(
            __('Notes added'),
            __('Your note has been added and will be emailed to the user on their order.')
        );
    }

    public function register()
    {
        // $this->order->update(['status' => OrderStatus::REGISTER]);
        $this->order->markAsRegistered();
        Mail::to($this->order->customer)->send(new OrderConfirmed($this->order, new Fluent($this->order->amounts)));

        $this->notification()->success(
            __('Updated Status'),
            __('This order has been marked as confirmed and notification has been sent to the customer by email.')
        );
    }

    public function shipped()
    {
        // $this->order->update(['status' => OrderStatus::SHIPPED]);
        $this->order->markAsShipped();
        // Mail::to($this->order->customer)->send(new OrderConfirmed($this->order, new Fluent($this->order->amounts)));

        $this->notification()->success(
            __('Updated Status'),
            __('This order has been marked as shipped.')
        );
    }

    public function markPaid()
    {
        // $this->order->update(['is_paid' => true]);
        $this->order->markAsPaid();

        $this->notification()->success(__('Updated Status'), __('This order is marked as paid!'));
    }

    public function markOutForDelivery()
    {
        // $this->order->update(['status' => OrderStatus::DELIVERY]);
        $this->order->markAsOutForDelivery();

        $this->notification()->success(__('Updated Status'), __('This order is marked as Out For Delivery!'));
    }

    public function markDeliveredAndPaid()
    {
        // $this->order->update([
        //     'is_paid' => true,
        //     'status' => OrderStatus::COMPLETED,
        // ]);
        $this->order->markAsPaid();
        $this->order->markAsCompleted();

        $this->notification()->success(__('Updated Status'), __('This order is marked as delivered & paid!'));
    }

    public function markComplete()
    {
        // $this->order->update(['status' => OrderStatus::COMPLETED]);
        $this->order->markAsCompleted();

        $this->notification()->success(__('Updated Status'), __('This order is marked as complete.'));
    }

    public function downloadInvoice()
    {
        $file = Orders::make($this->order)->pdfInvoice();
        $filename = Str::snake(config('app.name')."-{$this->order->number}").'.pdf';
        return response()->download($file, $filename);
    }

    public function render(): View
    {
        $invoiceURL = Orders::make($this->order)->generateSignedInvoice(30);
        return view('livewire.console.orders.show', [
            'items' => $this->order->items()->with('product')->simplePaginate($this->perPage),
            'nextOrder' => Order::query()->where('id', '>', $this->order->id)->oldest('id')->first() ?? null,
            'prevOrder' => Order::query()->where('id', '<', $this->order->id)->latest('id')->first() ?? null,
            'invoiceURL' => $invoiceURL,
            'billingAddress' => Address::query()
                ->where('user_id', $this->order->customer->id)
                ->where('type', Address::TYPE_BILLING)
                ->where('is_default', true)
                ->first(),
        ]);
    }
}
