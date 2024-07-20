<?php

// app/Services/FirebaseService.php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\FirebaseException;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $serviceAccountPath = config('firebase.credentials');

        try {
            $firebase = (new Factory)
                ->withServiceAccount($serviceAccountPath);

            $this->messaging = $firebase->createMessaging();
        } catch (FirebaseException $e) {
            // Handle the exception
            // You can log the error or throw a custom exception
            throw new \Exception('Could not create Firebase service: ' . $e->getMessage());
        }
    }

    public function sendNotification($title, $body, $token)
    {
        $message = [
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'token' => $token,
        ];

        return $this->messaging->send($message);
    }
}
