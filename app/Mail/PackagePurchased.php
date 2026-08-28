<?php

namespace App\Mail;

use App\Models\PackagePurchase;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PackagePurchased extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public PackagePurchase $purchase)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your ARM Ayurveda package is active');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.package-purchased');
    }
}
