<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/status', function(){
    return response()->json(
        [
            'status' => "OK!",
            'message' => "API is running OK!"
        ]
    );
});
