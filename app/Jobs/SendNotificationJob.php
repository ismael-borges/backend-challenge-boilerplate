<?php

namespace App\Jobs;

use App\Mail\SendNotificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {}

    public function handle(): void
    {
        DB::table('payment_projections')->select(['id', 'name', 'email'])
            ->where(['send_notification' => 0])
            ->orderBy('id')
            ->chunk(100, static function($items) {
                collect($items)->each(static function ($row) {
                    $email = new SendNotificationMail();
                    \Illuminate\Support\Facades\Mail::to($row->email)->send($email);
                    DB::table('payment_projections')
                        ->where('id', $row->id)
                        ->update(['send_notification' => 1]);
                });
        });
    }
}
