<?php

use App\Events\Playground;
use App\Http\Controllers\FileUploadController;
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

<<<<<<< HEAD
Route::get('/', function () {
    return view('welcome');
    return get_success_response([
        "message" =>  "In the time of myth, in the kingdom of fun, there lived a platform : named Cumrid............"
    ]);
});
=======
// Route::get('/', function () {
//     // event(new Playground([
//     //     'message' => 'Hey babe'
//     // ]));
//     return view('welcome');
// });
>>>>>>> d9c9e64fa65359c8b436f513e49a8158be33773b

// Route::get('/upload', 'FileUploadController@showUploadForm');
// Route::post('/upload', [FileUploadController::class, 'upload']);
// Route::get('email', function()  {
//     return view('mail.email');
<<<<<<< HEAD
// });
=======
// });
>>>>>>> d9c9e64fa65359c8b436f513e49a8158be33773b
