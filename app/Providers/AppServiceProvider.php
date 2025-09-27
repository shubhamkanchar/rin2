<?php

namespace App\Providers;

use App\Channels\DatabaseChannel;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use Illuminate\Notifications\Channels\DatabaseChannel as IlluminateDatabaseChannel;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->instance(IlluminateDatabaseChannel::class, new DatabaseChannel);
        
        Facades\View::composer('layouts.app', function (View $view) {
            $user = Auth::user();
            if($user){
                try{
                    $notifications = $user
                        ->unreadNotifications()
                        ->where(function ($query) {
                            $query->whereNull('expires_at')
                                ->orWhere('expires_at', '>', now());
                        })
                        ->get(); 
                    $notificationCount = $notifications->count();
                    $view->with([
                        'notifications' => $notifications,
                        'notificationCount' => $notificationCount 
                    ]);
                }catch(Exception $e){
                    $notifications = [];
                    $notificationCount = 0;
                    $view->with([
                        'notifications' => $notifications,
                        'notificationCount' => $notificationCount 
                    ]);
                }
            }
        });
    }
}
