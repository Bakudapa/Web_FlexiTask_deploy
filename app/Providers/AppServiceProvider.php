<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Auth::class, function ($app) {
            $credentialsPath = storage_path('app/firebase_credentials.json');

            // ✅ Cegah crash jika file tidak ada atau tidak bisa dibaca
            if (!file_exists($credentialsPath) || !is_readable($credentialsPath)) {
                Log::warning('⚠️ Firebase credentials not accessible: ' . $credentialsPath);
                return null;
            }

            try {
                $factory = (new Factory)
                    ->withServiceAccount($credentialsPath)
                    ->withProjectId('flexi-task-5d512');

                return $factory->createAuth();
            } catch (\Throwable $e) {
                Log::error('❌ Failed to initialize Firebase Auth: ' . $e->getMessage());
                return null;
            }
        });
    }
}
