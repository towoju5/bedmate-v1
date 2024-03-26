<?php

use App\Events\Playground;
use App\Http\Controllers\FileUploadController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
    return get_success_response([
        "message" =>  "In the time of myth, in the kingdom of fun, there lived a platform : named Cumrid............"
    ]);
});

// Route::get('/upload', 'FileUploadController@showUploadForm');
// Route::post('/upload', [FileUploadController::class, 'upload']);
// Route::get('email', function()  {
//     return view('mail.email');
// });

Route::get('sample', function () {
    $password = Hash::make('password');
    for ($i = 0; $i < 30; $i++) {
        User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->companyEmail(),
            'is_escort' => true,
            'password' => $password,
            'username' => fake()->userName(),
            'plans' => 'freemium'
        ]);
    }
});

Route::fallback(function () {
    return get_error_response([
        'error' => 'Page Not Found. If error persists, contact support'
    ], 404);
});