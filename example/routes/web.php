<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Jobs\TranslateJob;
use App\Models\Job;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    $job = Job::first();
    TranslateJob::dispatch($job);

   return 'Done';
});

Route::view('/', 'home');
Route::view('/contact', 'contact');

//Route::resource('jobs', JobController::class);

Route::controller(JobController::class)->group(static function () {
    Route::get('/jobs','index');
    Route::get('/jobs/create','create');
    Route::post('/jobs','store')->middleware('auth');
    Route::get('/jobs/{job}','show');

    Route::get('/jobs/{job}/edit','edit')
        ->middleware('auth')
        ->can('edit', 'job');

    Route::patch('/jobs/{job}','update');
    Route::delete('/jobs/{job}','destroy');
});


Route::controller(RegisteredUserController::class)->group(static function () {
    Route::get('/register','create');
    Route::post('/register','store');
});

Route::controller(SessionController::class)->group(static function () {
    Route::get('/login','create')->name('login');
    Route::post('/login','store');
    Route::post('/logout','destroy');
});
