<?php

namespace App\Traits;

use App\Models\NotificationModels\FirebaseToken;
use Kreait\Firebase\Messaging\CloudMessage;

trait FirebaseFCM
{
    /**
     * @param $textMessage
     * @param $data
     * @param array $tokens
     * @param null $task_id
     * @return bool
     */
    public function sendNotificationToDevices($textMessage, $data, array $tokens = [], $order_id = null, $topic = null)
    {

        $messaging = app('firebase.messaging');
        $config = [
            'notification' => [
                'title' => 'Car Viseta',
                'body' => $textMessage,
                'order_id' => $order_id
            ],
            'data' => $data, // optional

            'android' => [
                'priority' => 'high',
                'notification' => [
                    'default_vibrate_timings' => true,
                    'default_sound' => true,
                    'notification_priority' => 'PRIORITY_HIGH' // PRIORITY_LOW , PRIORITY_DEFAULT , PRIORITY_HIGH , PRIORITY_MAX
                ],
            ],
            'apns' => [
                'payload' => [
                    'aps' => [
                        'sound' => 'default',
                    ],
                ],
            ],

        ];

        if ($topic) {
//            dd($topic);
            $config['topic'] = $topic;

            $message = CloudMessage::fromArray($config);

            $messaging->send($message);
        } else {
            $message = CloudMessage::fromArray($config);

            $messaging->sendMulticast($message, $tokens);
        }
        return true;
    }

    protected function checkFirebaseToken($userId, $token)
    {
        if ($userId) {
            FirebaseToken::where('user_id', $userId)->delete();
        }

        FirebaseToken::create([
            'token' => $token,
            'user_id' => $userId
        ]);

    }


}
