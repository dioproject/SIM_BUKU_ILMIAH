<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\History;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('components.admin.header', function ($view) {
            $notifications = History::orderBy('created_at', 'desc')->take(5)->get();
            $view->with('notifications', $notifications);
        });

        View::composer('components.editor.header', function ($view) {
            $notifications = History::orderBy('created_at', 'desc')->take(5)->get();
            $view->with('notifications', $notifications);
        });

        View::composer('components.author.header', function ($view) {
            $notifications = History::orderBy('created_at', 'desc')->take(5)->get();
            $view->with('notifications', $notifications);
        });
    }
}
