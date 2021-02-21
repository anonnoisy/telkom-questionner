<?php

use App\Http\Controllers\{
    RespondentController,
    GroupController,
    SurveyController,
    SurveyorController,
};
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::prefix('admin')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('respondents', RespondentController::class);
    Route::resource('groups', GroupController::class);
    Route::resource('surveys', SurveyController::class);
});

Route::prefix('questioner')->name('questioner.')->group(function () {
    Route::middleware(['questioner.check_survey'])->group(function () {
        Route::get('login', [SurveyorController::class, 'loginView'])->name('login');
        Route::get('register', [SurveyorController::class, 'registerView'])->name('register');
    });

    Route::post('login', [SurveyorController::class, 'login'])->name('start');
    Route::post('register', [SurveyorController::class, 'register'])->name('register-start');

    Route::middleware(['questioner.check_nik'])->group(function () {
        Route::get('start-questioner', [SurveyorController::class, 'startQuestioner'])->name('ongoing');
    });

    Route::post('finish-questioner', [SurveyorController::class, 'finishQuestioner'])->name('finish');
    Route::get('thank-you', [SurveyorController::class, 'thankYou'])->name('thanks');
    Route::get('sorry', [SurveyorController::class, 'sorry'])->name('sorry');
});
