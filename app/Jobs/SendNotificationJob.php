<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $title           = null;
    public $message         = null;
    public $device_ids      = null;
    public $small_picture   = null;
    public $big_picture     = null;
    public $channel         = null;
    public $additional_data = [];
    protected $firebase;
    private $channelForBackgroundNoise;

    public function __construct($title, $message, $device_ids = null, $small_picture = null, $big_picture = null, array $additional_data = [], $channelForBackgroundNoise = null)
    {
        $this->title                     = $title;
        $this->message                   = $message;
        $this->device_ids                = $device_ids;
        $this->small_picture             = $small_picture;
        $this->big_picture               = $big_picture;
        $this->additional_data           = $additional_data;
        $this->firebase                  = app(Factory::class);
        $this->channelForBackgroundNoise = $channelForBackgroundNoise;
    }

    public function handle()
    {
        $firebase  = $this->firebase->withServiceAccount(base_path('/firebase.json'));
        $messaging = $firebase->createMessaging();

        foreach ($this->device_ids as $token) {
            \Log::info('Send Notificcation job');
            \Log::info($token);

            try {
                if ($this->channelForBackgroundNoise) {
                    $this->additional_data['fullscreen'] = 'yes';
                }
                $message = CloudMessage::fromArray([
                    'notification' => [
                        'title' => $this->title,
                        'body'  => $this->message,
                        'image' => $this->big_picture,
                    ],
                    'data'         => $this->additional_data,
                    "name"         => 'Turfy',
                    'android'      => [
                        'notification' => [
                            "sound"      => "notification_sound.wav",
                            "channel_id" => $this->channelForBackgroundNoise,
                        ],
                    ],
                    'apns'         => [
                        'payload' => [
                            'aps' => [
                                'sound' => $this->channelForBackgroundNoise ? 'notification_sound.wav' : 'default',
                            ],
                        ],
                    ],
                    "token"        => $token,
                ]);
                $messaging->send($message);
            } catch (\Throwable $th) {
                // \Log::info($th->getMessage());
            }
        }

    }
}
