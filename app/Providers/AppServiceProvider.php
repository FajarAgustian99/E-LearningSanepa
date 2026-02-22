<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share notifikasi ke semua view untuk user yang login
        View::composer('*', function ($view) {

            if (!Auth::check()) {
                return;
            }

            $user = Auth::user();

            // Ambil 10 notifikasi terakhir
            $notifications = $user->notifications()
                ->latest()
                ->take(10)
                ->get();

            // Hitung notifikasi belum dibaca
            $unreadCount = $user->notifications()
                ->where('is_read', false)
                ->count();

            $view->with([
                'notifications' => $notifications,
                'unreadCount'   => $unreadCount,
            ]);
        });
    }
}
