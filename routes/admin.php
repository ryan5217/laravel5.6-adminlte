<?php

Auth::routes();

Route::group(['namespace'=>'Admin','middleware' => ['auth','menu','permission']],function(){
    Route::get('/', 'IndexController@index');

    Route::group(['prefix'=>'permissions'],function(){
        Route::any('index/{pid?}','PermissionsController@index') -> name('admin.permissions.index');
        Route::get('create/{pid?}','PermissionsController@create') -> name('admin.permissions.create');
        Route::post('store/{pid?}','PermissionsController@store') -> name('admin.permissions.store');
        Route::get('destroy/{id}','PermissionsController@destroy') -> name('admin.permissions.destroy');
        Route::get('edit/{id}','PermissionsController@edit') -> name('admin.permissions.edit');
        Route::post('update/{id}','PermissionsController@update') -> name('admin.permissions.update');
    });

    Route::group(['prefix'=>'roles'],function(){
        Route::any('index','RolesController@index') -> name('admin.roles.index');
        Route::get('create','RolesController@create') -> name('admin.roles.create');
        Route::post('store','RolesController@store') -> name('admin.roles.store');
        Route::get('destroy/{id}','RolesController@destroy') -> name('admin.roles.destroy');
        Route::get('edit/{id}','RolesController@edit') -> name('admin.roles.edit');
        Route::post('update/{id}','RolesController@update') -> name('admin.roles.update');
    });

    Route::group(['prefix'=>'user'],function(){
        Route::any('index','UserController@index') -> name('admin.user.index');
        Route::get('create','UserController@create') -> name('admin.user.create');
        Route::post('store','UserController@store') -> name('admin.user.store');
        Route::get('destroy/{id}','UserController@destroy') -> name('admin.user.destroy');
        Route::get('edit/{id}','UserController@edit') -> name('admin.user.edit');
        Route::post('update/{id}','UserController@update') -> name('admin.user.update');
    });


});
