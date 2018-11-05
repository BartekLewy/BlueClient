<?php

Route::get('panel', \BlueClient\Controller\PanelController::class . '@index');
Route::delete('panel/items/{id}', \BlueClient\Controller\PanelController::class . '@remove')->name('panel-item-remove');