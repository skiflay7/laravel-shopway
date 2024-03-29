<?php

namespace App\Mail;

use App\Models\Orders\Order;
use App\Models\Shop;
use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public Shop $shop;
    public User $user;
    public Order $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Order $order)
    {
        $this->shop = Shop::first();
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from($this->shop->email, $this->shop->name)
            ->subject(__('Your order has been confirmed!'))
            ->markdown('email.confirm-order', [
                'url' => route('users.orders.show', $this->order),
            ]);
    }
}
