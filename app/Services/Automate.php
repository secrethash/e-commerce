<?php

namespace App\Services;

use File;
use Shopper\Framework\Models\Shop\Order\Order;
use Shopper\Framework\Models\Shop\Order\OrderStatus;
use Str;

class Automate {

    const GRACE_TIME = 25;

    public static function failsOrder()
    {
        Order::where('status', OrderStatus::PENDING)
            ->where('updated_at', '<', now()->subMinutes(self::GRACE_TIME))
            ->update([
                'status' => OrderStatus::CANCELLED,
            ]);
        return;
    }

    /**
     * TODO: Cleanup PDF Storage
     *
     * @return void
     */
    // public static function cleanUpPdfStorage()
    // {
    //     //
    //     $path = config('services.pdf.storage');
    //     $fullPath = storage_path('app/'.$path);
    //     $files = File::files($fullPath);

    //     foreach ($files as $file)
    //     {
    //         $name = $file->getFilenameWithoutExtension();
    //         $pnr = Str::replaceFirst('_summary', '', $name);

    //         $booking = Booking::wherePnr($pnr)->first();
    //         $afterOneMonth = $booking->journey->addMonth();

    //         if ($booking->is_complete AND $afterOneMonth->lessThan(now()))
    //         {
    //             File::delete($fullPath.'/'.$file->getFilename());
    //         }
    //     }
    // }

}
