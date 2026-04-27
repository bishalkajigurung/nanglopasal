<?php

namespace App\Observers;

use App\Mail\SellerApprovalMail;
use App\Models\Admin;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SellerObserver
{
    /**
     * Handle the Seller "created" event.
     */
    public function created(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "updated" event.
     */
    public function updated(Seller $seller): void
    {
        if ($seller->isDirty('status') && $seller->status == "active") {
            $password = rand(10000, 99999);
            $seller->password = Hash::make($password);
            $seller->saveQuietly();
            // send email to seller
            Mail::to($seller->email)->send(new SellerApprovalMail($seller, $password));

        }
    }

    /**
     * Handle the Seller "deleted" event.
     */
    public function deleted(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "restored" event.
     */
    public function restored(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "force deleted" event.
     */
    public function forceDeleted(Seller $seller): void
    {
        //
    }
}
