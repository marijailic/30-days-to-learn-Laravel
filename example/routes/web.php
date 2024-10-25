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

Route::controller(JobController::class)->prefix('jobs')->group(static function () {
    Route::middleware('auth')->group(static function () {
        Route::get('create','create');
        Route::post('','store');

        Route::get('{job}/edit','edit')
            ->can('edit', 'job');

        Route::patch('{job}','update');
        Route::delete('{job}','destroy');
    });

    Route::get('','index');
    Route::get('{job}','show');
});


Route::controller(RegisteredUserController::class)->prefix('register')
    ->middleware('guest')
    ->group(static function () {
        Route::get('','create');
        Route::post('','store');
});

Route::controller(SessionController::class)->group(static function () {
    Route::prefix('login')->group(static function () {
        Route::get('','create')->name('login');
        Route::post('','store');
    });

    Route::post('/logout','destroy')->middleware('auth');
});
