<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/sign-in', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
});
Route::post('/register', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
});