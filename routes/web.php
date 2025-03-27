<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;



Route::resource('employees', EmployeeController::class);

// Em routes/web.php
Route::get('/{any}', function () {
    return view('welcome'); 
})->where('any', '.*');

Route::patch('/employees/{id}', [EmployeeController::class, 'update']);
