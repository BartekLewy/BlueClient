<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('panel', \BlueClient\Controller\PanelController::class . '@index')->name('panel');
    Route::get('panel/create', \BlueClient\Controller\PanelController::class . '@create')->name('panel-item-create');
    Route::get('panel/edit', \BlueClient\Controller\PanelController::class . '@create')->name('panel-item-edit');
    Route::get('panel/items/{id}', \BlueClient\Controller\PanelController::class . '@remove')->name('panel-item-remove');
    Route::post('panel/save', \BlueClient\Controller\PanelController::class . '@save')->name('panel-item-save');
});
