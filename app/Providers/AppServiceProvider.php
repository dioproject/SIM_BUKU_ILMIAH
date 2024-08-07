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
            $notifications = Notifikasi::with(['user', 'bab.status'])
                ->whereHas('user', function ($query) {
                    $query->where('user_role', 'ADMIN');
                })
                ->orderBy('created_at', 'desc')
                ->get();
            $view->with('notifications', $notifications);
        });
        View::composer('components.reviewer.header', function ($view) {
            $notifications = Notifikasi::with(['user', 'bab.status'])
                ->whereHas('user', function ($query) {
                    $query->where('user_role', 'REVIEWER');
                })
                ->orderBy('created_at', 'desc')
                ->get();
            $view->with('notifications', $notifications);
        });

        View::composer('components.author.header', function ($view) {
            $notifications = Notifikasi::with(['user', 'bab.status'])
                ->where('user_id', FacadesAuth::id())
                ->orderBy('created_at', 'desc')
                ->get();
            $view->with('notifications', $notifications);
        });
    }
}
