<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('panel', \BlueClient\Controller\PanelController::class . '@index')->name('panel');
    Route::get('panel/items/{id}', \BlueClient\Controller\PanelController::class . '@remove')->name('panel-item-remove');
});
