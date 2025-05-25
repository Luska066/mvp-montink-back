<?php

use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    try{
        throw new \Exception("Forbidden",401);
    }catch (Exception $e) {
        return \App\Exceptions\InternalServerError::create($e);
    }
});
