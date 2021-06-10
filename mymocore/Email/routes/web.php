<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 6/5/2021
 * Time: 12:12 PM
 */

Route::group([
    'prefix' => config('mymo_core.admin_prefix'),
    'middleware' => ['web', 'admin']
], function () {
    Route::get('setting/email', 'EmailController@index')->name('admin.setting.test-email');
    Route::post('setting/email', 'EmailController@save')->name('admin.setting.save');
    Route::post('setting/email/send-test-mail', 'EmailController@sendTestMail')->name('admin.email.test-email');

    Route::group(['prefix' => 'setting/email-template'], function () {
        Route::get('/', 'EmailTemplateController@index')->name('admin.email-template');
        Route::get('/get-data', 'EmailTemplateController@index')->name('admin.email-template.get-data');
        Route::post('/bulk-actions', 'EmailTemplateController@bulkActions')->name('admin.email-template.bulk-actions');
    });

    Route::group(['prefix' => 'logs/email'], function () {
        Route::get('/', 'EmailLogsController@index')->name('admin.logs.email');

        Route::get('/get-data', 'EmailLogsController@getData')->name('admin.logs.email.getdata');

        Route::post('/status', 'EmailLogsController@status')->name('admin.logs.email.status');

        Route::post('/remove', 'EmailLogsController@remove')->name('admin.logs.email.remove');
    });
});