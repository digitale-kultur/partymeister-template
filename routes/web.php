<?php

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

Route::get('/', static function () {
    return redirect('/start');
});

Route::get('backend/competition_labels/prize_money', 'Backend\CompetitionLabels\ExportController@prizeMoney')
    ->name('backend.competition_prizes.export.labels')
    ->middleware(['web', 'web_auth', 'navigation']);

Route::get('backend/competition_labels/competition_ranks', 'Backend\CompetitionLabels\ExportController@competitionRanks')
    ->name('backend.competition_prizes.export.labels')
    ->middleware(['web', 'web_auth', 'navigation']);

