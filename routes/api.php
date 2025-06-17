<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroqChatController;

Route::post('/groq-chat', [GroqChatController::class, 'ask']);
