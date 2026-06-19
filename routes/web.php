<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    DB::table('page_visits')->insert([
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return view('welcome', [
        'visitCount' => DB::table('page_visits')->count(),
        'databasePath' => config('database.connections.sqlite.database'),
    ]);
});
