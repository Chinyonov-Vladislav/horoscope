<?php

use App\Http\Controllers\pages\InfoAboutUserController;
use App\Http\Controllers\pages\MainPageController;
use App\Http\Controllers\Pages\PredictionsController;
use App\Http\Controllers\pages\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', [MainPageController::class, 'index'])->name("main");
Route::get("/profile",[ProfileController::class,'index'])->name('profile')->middleware('auth');
Route::get('/infoAboutUser',[InfoAboutUserController::class, 'index'])->name('infoAboutUserPage')->middleware('auth');
Route::post('/infoAboutUser',[InfoAboutUserController::class,'addNewInfo'])->name('AddNewInfoAboutUser')->middleware('auth');
Route::post('/redactInfoAboutUser',[InfoAboutUserController::class, 'redactInfo'])->name('redactInfoAboutUser')->middleware('auth');
Route::get('/predictions/page={number_page}',[PredictionsController::class, 'index'])->name('predictions')->middleware('auth');
Route::get('/predictions/add',[PredictionsController::class,'addNewPrediction'])->name('addNewPrediction')->middleware('auth');
Route::post('/predictions/add',[PredictionsController::class,'addNewPredictionToDatabase'])->name('addNewPredictionToDatabase')->middleware('auth');
Route::delete("/predictions/delete/{id}",[PredictionsController::class,'DeletePrediction'])->name("deletePrediction")->middleware('auth');
Route::get("/predictions/redact/{id}",[PredictionsController::class,"RedactPrediction"])->name('redactPrediction')->middleware('auth');
Route::post("/predictions/redact",[PredictionsController::class,'SaveRedactPrediction'])->name('saveRedactPrediction')->middleware('auth');
Route::post("/reset-password",[ProfileController::class,'ResetPassword'])->name('reset-password')->middleware('guest');
Route::get('/predictions/download_excel',[PredictionsController::class,'DownloadExcel'])->name('download_excel')->middleware('auth');
Route::get('/profile/changePassword',[ProfileController::class,'changePasswordView'])->name('view_change_password')->middleware('auth');
Route::post('/profile/changePassword',[ProfileController::class, 'changePassword'])->name('changePassword')->middleware('auth');
Route::post('/predictions/showPredictionByDay',[PredictionsController::class, 'showPredictionByDay'])->name('showPredictionByDay');
Auth::routes();
//Route::get("/auth",[AuthorizationController::class, 'index'])->name("auth");
//Route::get("/registration",[RegistrationController::class, 'index'])->name("registration");



//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

