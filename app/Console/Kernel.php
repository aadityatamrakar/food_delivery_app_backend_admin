<?php

namespace App\Console;

use App\Http\Controllers\Controller;
use App\Order;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $time = 0;
            $orders = Order::where('status', 'PROC')->get();
            foreach($orders as $order){
                if($order->type == 'delivery'){
                    $time = $order->restaurant->delivery_time;
                }else if($order->type == 'pickup'){
                    $time = $order->restaurant->pickup_time;
                }
                if(Carbon::now()->diffInMinutes(Carbon::parse($order->created_at)) > $time){
                    $order->status='CMPT';
                    $order->save();
                }
            }
        })->everyMinute();
    }
}
