<?php
// app/Notifications/PriceChangedNotification.php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use App\Models\Usernotification;

class PriceChangedNotification extends Notification
{
    use Queueable;

    protected $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['custom_database', 'firebase'];
    }

    public function toCustomDatabase($notifiable)
    {
        $message = 'The price of ' . $this->product->name . ' has changed to $' . json_decode($this->product->currentPrice)->amount;

        Usernotification::create([
            'user_id' => $notifiable->id,
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'new_price' => $this->product->currentPrice,
            'message' => $message,
        ]);
    }

    public function toFirebase($notifiable)
    {
        $factory = (new Factory)->withServiceAccount(config_path('firebase.json'));
        $messaging = $factory->createMessaging();

        $message = CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification([
                'title' => 'Price Change Notification',
                'body' => 'The price of ' . $this->product->name . ' has changed to $' . $this->product->price,
            ]);

        $messaging->send($message);
    }
}
