<?php 

Route::group(['prefix' => 'ajtarragona/tid','middleware' => ['web'],'as'=>'tid.'	], function () {
    // Route::get('/login', 'Ajtarragona\TID\Controllers\TIDController@login')->name('login');
    Route::get('/handleResponse', 'Ajtarragona\TID\Controllers\TIDController@handleReponse')->name('handleResponse');
    Route::post('/setsession', 'Ajtarragona\TID\Controllers\TIDController@setsession')->name('setsession');
});

Route::group(['prefix' => 'ajtarragona/tid','middleware' => ['web','tid'],'as'=>'tid.'	], function () {
    Route::get('/logout', 'Ajtarragona\TID\Controllers\TIDController@logout')->name('logout');
});
