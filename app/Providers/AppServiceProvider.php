<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('components.admin.header', function ($view) {
            $userId = FacadesAuth::id();
            $notifications = Notifikasi::with(['user', 'bab.status'])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();
            $unreadCount = Notifikasi::where('user_id', $userId)->where('is_read', false)->count();
            $view->with('notifications', $notifications)->with('unreadCount', $unreadCount);
        });
        View::composer('components.reviewer.header', function ($view) {
            $userId = FacadesAuth::id();
            $notifications = Notifikasi::with(['user', 'bab.status'])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();
            $unreadCount = Notifikasi::where('user_id', $userId)->where('is_read', false)->count();
            $view->with('notifications', $notifications)->with('unreadCount', $unreadCount);
        });

        View::composer('components.author.header', function ($view) {
            $userId = FacadesAuth::id();
            $notifications = Notifikasi::with(['user', 'bab.status'])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();
            $unreadCount = Notifikasi::where('user_id', $userId)->where('is_read', false)->count();
            $view->with('notifications', $notifications)->with('unreadCount', $unreadCount);
        });
    }
}
