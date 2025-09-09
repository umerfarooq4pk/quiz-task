<?php

use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', [QuizController::class, 'index'])->name('quiz.index');
Route::post('/start', [QuizController::class, 'start'])->name('quiz.start');
Route::post('/next-question', [QuizController::class, 'nextQuestion'])->name('quiz.next');
Route::post('/finish', [QuizController::class, 'submitResult'])->name('quiz.result');
Route::get('/results', [QuizController::class, 'results'])->name('quiz.results');
