<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $user = User::where('email', $request->email)->first();

    return response()->json([
        'token' => $user->createToken('api-token')->plainTextToken,
            ]);
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('guru', 'App\Http\Controllers\Api\GuruController');
    Route::apiResource('siswa', 'App\Http\Controllers\Api\SiswaController');
    Route::apiResource('industri', 'App\Http\Controllers\Api\IndustriController');
    Route::apiResource('pkl', 'App\Http\Controllers\Api\PklController');
});


