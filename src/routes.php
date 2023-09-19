<?php 

Route::group(['prefix' => 'ajtarragona/tid','middleware' => ['web','language'],'as'=>'tid.'	], function () {
    // Route::get('/login', 'Ajtarragona\TID\Controllers\TIDController@login')->name('login');
    Route::get('/handleResponse', 'Ajtarragona\TID\Controllers\TIDController@handleReponse')->name('handleResponse');
    Route::get('/setsession', 'Ajtarragona\TID\Controllers\TIDController@setsession')->name('setsession');
});

Route::group(['prefix' => 'ajtarragona/tid','middleware' => ['web','language','tid'],'as'=>'tid.'	], function () {
    Route::get('/logout', 'Ajtarragona\TID\Controllers\TIDController@logout')->name('logout');
});
