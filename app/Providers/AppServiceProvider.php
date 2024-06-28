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
            $notifications = History::orderBy('created_at', 'desc')->get();
            $view->with('notifications', $notifications);
        });

        View::composer('components.editor.header', function ($view) {
            $notifications = History::where(function ($query) {
                $query->where('change_detail', 'like', '%created book%')
                    ->orWhere('change_detail', 'like', '%updated book%');
                })
                ->orderBy('created_at', 'desc')
                ->get();

            $view->with('notifications', $notifications);
        });

        View::composer('components.author.header', function ($view) {
            $notifications = History::where(function ($query) {
                $query->where('change_detail', 'like', '%reviewed%')
                    ->orWhere('change_detail', 'like', '%change review%')
                    ->orWhere('change_detail', 'like', '%delete review%');
                })
                ->orderBy('created_at', 'desc')->get();
            $view->with('notifications', $notifications);
        });
    }
}
