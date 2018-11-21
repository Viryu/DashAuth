<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    if(Auth::check()) {
        return redirect('/dashboard');
    } else {
        return view('auth.login');
    }
});
//Route::get('/dashboard', 'DashboardController@showTotalNumber');
Route::get('/alltransaction','DashboardController@showTransaction');
Route::get('/salesonly','DashboardController@showSalesOnly');
Route::get('/failtransaction','DashboardController@showFailureOnly');
Route::get('/export','DashboardController@exportToExcel');
Route::get('/exportcsv','DashboardController@exportToExcelcsv');
Route::get('/exportToPDF','DashboardController@exportToPDF');
Route::get('/exporterrorxls','DashboardController@exportToExcelError');
Route::get('/exporterrorcsv','DashboardController@exportTOExcelErrorcsv');
Route::get('/exportall','DashboardController@exportToExcelAll');
Route::get('/exportallcsv','DashboardController@exportToExcelAllcsv');
Route::get('/exportToPDFfail','DashboardController@exportToPDFfail');
Route::get('/exportToPDFsuccess','DashboardController@exportToPDFsuccess');
Route::get('/devices','DashboardController@showDevices');
Route::get('/operators','DashboardController@showOperators');
Route::post('/changepassword','DashboardController@changePassword');
Route::post('/settarget','DashboardController@settarget');
Route::get('/projection','DashboardController@financeprojection');
Route::get('/projection/week','DashboardController@financeprojectionweek')->name('week');
Route::get('/projection/month','DashboardController@financeprojectionmonth')->name('month');
Route::get('/projection/year','DashboardController@financeprojectionyear')->name('year');
Route::post('/projection/month','DashboardController@financeprojectionmonth');
Route::post('/projection/year','DashboardController@financeprojectionyear');
Route::get('/map/{name}','DashboardController@mapping');
Route::get('/receipt/{name}','DashboardController@openreceipt');



Auth::routes();

Route::group(['middleware'=>'auth'],function(){
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/dashboard/profile', 'DashboardController@profile')->name('profile');

    Route::group(['middleware'=>'admin'],function(){
        Route::get('/dashboard/register', 'RegisterUserController@registerForm')->name('register');
        Route::post('/dashboard/register', 'RegisterUserController@registerUser')->name('register');
        Route::get('/insertbin','DashboardController@showbin');
        Route::post('/insertnewbin','DashboardController@insertbin');
        Route::get('/dashboard/registerMid', 'RegisterUserController@showMidTidForm')->name('registerMidTid');
        Route::post('/dashboard/registerMid', 'RegisterUserController@registerMidTid')->name('registerMidTid');
        Route::get('/administrator','DashboardController@showAdministrator');
        Route::post('/administrator','DashboardController@showAdministrator');
        Route::post('/activate','DashboardController@activation');
        Route::post('/changepasswordeveryone','DashboardController@changePasswordEveryone');
    });
});


