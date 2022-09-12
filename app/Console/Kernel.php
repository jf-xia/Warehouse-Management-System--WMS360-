<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Channel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\TestCommand::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        Log::info ('corn start');

        $channels = Channel::get()->toArray();

        if(($key = array_search('ebay',array_column($channels,'channel_term_slug'))) !== false){
            if($channels[$key]['is_active'] == 1){
                Log::info('ebay sync start');
                $schedule->call('App\Http\Controllers\EbayOrderSyncController@syncOrderFromEbayClicked')->everyMinute();
                Log::info('campaign started');
                $schedule->call('App\Http\Controllers\EbayMasterProductController@checkCampaign')->timezone('Europe/London')->everyFifteenMinutes();
                Log::info('ebay sync done');
            }
        }
        if(($key = array_search('onbuy',array_column($channels,'channel_term_slug'))) !== false){
            if($channels[$key]['is_active'] == 1){
                $schedule->call('App\Http\Controllers\OnbuyController@leadListingCheck')->timezone('Europe/London')->daily();
                $schedule->call('App\Http\Controllers\OnbuyController@checkAndMakeLeadListing')->everyFifteenMinutes();
                Log::info('onbuy sync start');
                $schedule->call('App\Http\Controllers\OnbuyOrderSyncController@syncOrderFromOnbuyClicked')->everyMinute();
                Log::info('onbuy sync end');
            }
        }


        if(($key = array_search('woocommerce',array_column($channels,'channel_term_slug'))) !== false){
            if($channels[$key]['is_active'] == 1){
                Log::info('woo sync start');
                $schedule->call('App\Http\Controllers\WoocomOrderSyncController@syncOrderFromWoocommerceClicked')->everyMinute();
                Log::info('woo sync done');
            }
        }

        if(($key = array_search('amazon',array_column($channels,'channel_term_slug'))) !== false){
            if($channels[$key]['is_active'] == 1){
                Log::info('Amazon Sync Start');
                $schedule->call('App\Http\Controllers\AmazonController@orderSync')->everyFifteenMinutes();
                Log::info('Amazon Sync End');
            }
        }

        if(($key = array_search('shopify',array_column($channels,'channel_term_slug'))) !== false){
            if($channels[$key]['is_active'] == 1){
                Log::info('Shopify Sync Start');
                $schedule->call('App\Http\Controllers\Shopify\OrderController@shopifyOrder')->everyMinute();
                Log::info('Shopify Sync End');
            }
        }

        //        $schedule->call('App\Http\Controllers\EbayMasterProductController@checkEndedProduct')->timezone('Europe/London')->daily();


//            ->timezone('Europe/London');

        Log::info('corn end');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
