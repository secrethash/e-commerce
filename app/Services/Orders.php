<?php

namespace App\Services;

use Shopper\Framework\Models\Shop\Order\Order;
use Str;
use URL;

class Orders {

    public function __construct(protected Order $order) {}

    public static function make(Order $order): static
    {
        return new static($order);
    }

    public function pdfInvoice()
    {
        $url = $this->generateSignedInvoice(30);
        $filename = Str::snake(config('app.name')."-{$this->order->number}");
        $pdf = Pdf::getOrGenerate($filename, $url);
        return $pdf;
    }

    /**
     * Generate a temp signed invoice "Download" URL
     *
     * @param $validity in minutes
     * @return string $url
     */
    public function generateSignedDownloadInvoice($validity = null): string
    {
        if ($validity)
        {
            $url = URL::temporarySignedRoute(
                'user.orders.download.invoice', now()->addMinutes($validity), ['order' => $this->order->number]
            );
        }
        else
        {
            $url = URL::signedRoute(
                'user.orders.download.invoice', ['order' => $this->order->number]
            );
        }

        return $url;
    }

    /**
     * Generate a temp signed invoice URL
     *
     * @param $validity in minutes
     * @return string $url
     */
    public function generateSignedInvoice($validity = null): string
    {
        if ($validity)
        {
            $url = URL::temporarySignedRoute(
                'user.orders.invoice', now()->addMinutes($validity), ['order' => $this->order->number]
            );
        }
        else
        {
            $url = URL::signedRoute(
                'user.orders.invoice', ['order' => $this->order->number]
            );
        }

        return $url;
    }
}
