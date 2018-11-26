<?php

Route::get('admin/role-permission', function(){
	echo 'Hello from the calculator package!';
});

// Route::prefix('admin')->group(function () {
//     Route::get('/', 'Amdxion\RolePermission\Controllers\RolePermissionController@index')->middleware('web')->name('admin.index');
//     Route::get('/roles', 'Amdxion\RolePermission\Controllers\RolePermissionController@roles')->name('admin.role.list')
//         ->middleware('can:list-roles');
//     Route::get('/permissions', 'Amdxion\RolePermission\Controllers\RolePermissionController@permissions')->middleware(['can:list-permissions'])->name('admin.permission.list');
// });

Route::group(['middleware' => ['web'],'prefix'=>'admin'], function () {
    Route::get('/', 'Amdxion\RolePermission\Controllers\RolePermissionController@index')->middleware('can:see-all-admin')->name('admin.index');
    Route::get('/roles', 'Amdxion\RolePermission\Controllers\RolePermissionController@roles')->middleware('can:list-roles')->name('admin.role.list');
    Route::get('/permissions', 'Amdxion\RolePermission\Controllers\RolePermissionController@permissions')->middleware('can:list-permissions')->name('admin.permission.list');
});