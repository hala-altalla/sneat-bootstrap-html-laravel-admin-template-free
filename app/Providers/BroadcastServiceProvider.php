<?php

namespace App\Providers;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;
class BroadcastServiceProvider extends ServiceProvider
{





    public function boot(): void
    {
        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}