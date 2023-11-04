<?php

namespace App\Jobs;

use App\Mail\SendNotificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Mail;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {}

    public function handle(): void
    {
        DB::table('payment_projections')
            ->select(['id', 'name', 'email', 'debtAmount', 'debtID', 'debtDueDate'])
            ->where(['send_notification' => 0])
            ->orderBy('id')
            ->chunk(1, static function($items) {
                collect($items)->each(static function ($row) {
                    $row->debtAmount = number_format($row->debtAmount, 2, ',', '.');
                    $row->debtDueDate = 'R$ '.date('d/m/Y', strtotime($row->debtDueDate));

                    $email = new SendNotificationMail($row);
                    Mail::to($row->email)->send($email);
                    DB::table('payment_projections')
                        ->where('id', $row->id)
                        ->update(['send_notification' => 1]);
                });
        });
    }
}
