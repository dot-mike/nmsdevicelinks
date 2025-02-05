<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'auth'], 'guard' => 'auth'], function () {
    Route::namespace('DotMike\NmsDeviceLinks\Http\Controllers')->group(function () {


        // named routes uses prefix plugin.nmsdevicelinks.
        Route::name('plugin.nmsdevicelinks.')->group(function () {

            // Admin routes
            Route::middleware('can:admin')->prefix('plugin/settings/nmsdevicelinks')->group(function () {
                Route::get('/', 'PluginAdminController@index')->name('index');

                // Manage Device Links
                Route::prefix('devicelinks')->group(function () {
                    Route::get('/', 'DeviceLinksController@index')->name('devicelinks.index');
                    Route::get('/create', 'DeviceLinksController@create')->name('devicelinks.create');
                    Route::post('/', 'DeviceLinksController@store')->name('devicelinks.store');
                    Route::get('/{index}/edit', 'DeviceLinksController@edit')->name('devicelinks.edit');
                    Route::put('/{index}', 'DeviceLinksController@update')->name('devicelinks.update');
                    Route::delete('/{index}', 'DeviceLinksController@destroy')->name('devicelinks.destroy');
                });

                // Manage SNMP Commands
                Route::prefix('snmpcommands')->group(function () {
                    Route::get('/', 'SnmpCommandsController@index')->name('snmpcommands.index');
                    Route::get('/create', 'SnmpCommandsController@create')->name('snmpcommands.create');
                    Route::post('/', 'SnmpCommandsController@store')->name('snmpcommands.store');
                    Route::get('/{index}/edit', 'SnmpCommandsController@edit')->name('snmpcommands.edit');
                    Route::put('/{index}', 'SnmpCommandsController@update')->name('snmpcommands.update');
                    Route::delete('/{index}', 'SnmpCommandsController@destroy')->name('snmpcommands.destroy');
                });
            });

            // Execute SNMP Command
            Route::get('plugins/nmsdevicelinks/snmpcommands/execute/{device}/{command}', 'SnmpCommandsController@execute')
                ->where('device', '[0-9]+')
                ->where('command', '[0-9]+')
                ->name('snmpcommands.execute');
        });
    });
});
