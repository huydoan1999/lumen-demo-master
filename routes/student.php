<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */
// $app->get('/', function () use ($app) {
//     return $app->version();
// });

$api = app('Dingo\Api\Routing\Router');

// v1 version API
$api->version('v1', ['prefix' => 'api/v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
    $api->group(['middleware' => ['api.locale']], function ($api) {
        //Login
        $api->get('students/view-list', [
            'as' => 'student.viewList',
            'uses' => 'StudentController@viewList',//trỏ tới controller viewList
        ]);

        $api->get('students/create-form', [
            'as' => 'student.viewCreateFormGet',
            'uses' => 'StudentController@viewCreateForm', //trỏ tới controller viewCreateForm by get
        ]);

        $api->get('students/delete', [
            'as' => 'student.delete',
            'uses' => 'StudentController@delete',//trỏ tới controller delete
        ]);

        $api->post('students/create-form', [
            'as' => 'student.viewCreateFormPost',
            'uses' => 'StudentController@viewCreateForm',//trỏ tới controller viewCreateForm by post
        ]);

        $api->post('students/edit-form', [
            'as' => 'student.viewEditFormPost',
            'uses' => 'StudentController@viewEditForm',//trỏ tới controller viewEditForm by post
        ]);

        $api->get('students/edit-form', [
            'as' => 'student.viewEditFormGet',
            'uses' => 'StudentController@viewEditForm',//trỏ tới controller viewEditForm by get
        ]);
    });
});


// v2 version API
$api->version('v1', ['prefix' => 'api', 'namespace' => 'App\Http\Controllers\Api\V2'], function ($api) {
    $api->group(['middleware' => ['api.locale']], function ($api) {
        //Login
        $api->get('students/list', [
            'as' => 'student.list',
            'uses' => 'StudentController@listItems',//trỏ tới controller viewEditForm by get
        ]);

        $api->post('students/add', [
            'as' => 'student.add',
            'uses' => 'StudentController@add',//trỏ tới controller viewEditForm by get
        ]);
        $api->post('students/delete', [
            'as' => 'student.delete',
            'uses' => 'StudentController@delete',//trỏ tới controller viewEditForm by get
        ]);
        $api->get('students/edit', [
            'as' => 'student.edit_by_get',
            'uses' => 'StudentController@edit',//trỏ tới controller viewEditForm by get
        ]);
        $api->post('students/edit', [
            'as' => 'student.edit_by_post',
            'uses' => 'StudentController@edit',//trỏ tới controller viewEditForm by get
        ]);
    });
});
