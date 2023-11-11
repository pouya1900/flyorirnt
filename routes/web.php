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

Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::post('/search', 'HomeController@search')->name('search');
    Route::post('/AutoComplete', 'HomeController@auto_complete')->name('auto_complete');


    Route::post('/aaa', 'TestController@aaa')->name('aaa');
    Route::post('/bbb', 'TestController@bbb')->name('bbb');
    Route::post('/ccc', 'TestController@ccc')->name('ccc');


    Route::get('/multi/{origin1}/{destination1}/{depart1}/{origin2}/{destination2}/{depart2}/{class}/{adl}/{chl}/{inf}/{none_stop?}/{origin3?}/{destination3?}/{depart3?}/{origin4?}/{destination4?}/{depart4?}', 'FlightController@multi')->name('multi');
    Route::get('/flights/{origin}/{destination}/{depart}/{return}/{class}/{adl}/{chl}/{inf}/{none_stop?}', 'FlightController@index')->name('flights');
    Route::post('/reorder', 'FlightController@reorder')->name('reorder');
    Route::post('/filter', 'FlightController@filter')->name('filter');
    Route::post('/AirRules', 'FlightController@air_rules')->name('air_rules');
    Route::post('/bagRules', 'FlightController@bagRules')->name('bagRules');
    Route::post('/select_flight', 'FlightController@select_flight')->name('select_flight');
    Route::post('/ajax_flight', 'FlightController@ajax_flight')->name('ajax_flight');
    Route::post('/ajax_flight_multi', 'FlightController@ajax_flight_multi')->name('ajax_flight_multi');
    Route::post('/ajax_flight_other_days', 'FlightController@ajax_flight_other_days')->name('ajax_flight_other_days');

    Route::get('/passengers/{flight_token}', 'TicketController@passengers')->name('passengers_info');
    Route::post('/passengers/check', 'TicketController@passengers_check')->name('passengers_check');
    Route::get('/payment/{book_token}', 'TicketController@payment')->name('payment');
    Route::get('/PaymentProcess/{book_token}', 'TicketController@process_payment')->name('process_payment');
    Route::get('/confirm/{method}', 'TicketController@confirm_payment')->name('confirm_payment');
    Route::get('/cancel/{book_token}', 'TicketController@cancel_payment')->name('cancel_payment');

    Route::get('/ticket-issue', 'TicketController@ticket_issue_scheduler')->name('ticket_issue');
    Route::get('/capture-payment', 'TicketController@capture_payment_scheduler')->name('capture_payment');


    Route::get('/CIPIran', 'CIPController@cip_iran')->name('cip_iran');
    Route::post('/CIPsearch', 'CIPController@search')->name('cip_search');
    Route::get('/cip/{dir}/{airport}/{date}/{adl}/{chl}/{inf}/{type}/{airline}', 'CIPController@index')->name('CIPs');
    Route::get('/CipPassengers/{num}/{airport}/{date}/{adl}/{chl}/{inf}/{airline}', 'CIPController@cip_passengers')->name('cip_passengers');
    Route::post('/AutoCompleteAirline', 'CIPController@auto_complete_airline')->name('auto_complete_airline');
    Route::post('/CipPassengers/check', 'CIPController@cip_passengers_check')->name('cip_passengers_check');
    Route::post('/transfer_data', 'CIPController@transfer_data')->name('transfer_data');
    Route::get('/CipPayment/{book_token}', 'CIPController@payment')->name('cip_payment');
    Route::get('/CipPaymentProcess/{book_token}', 'CIPController@cip_process_payment')->name('cip_process_payment');
    Route::get('/Cip_confirm/{method}', 'CIPController@cip_confirm_payment')->name('cip_confirm_payment');
    Route::get('/CipCancel/{book_token}', 'CIPController@cip_cancel_payment')->name('cip_cancel_payment');


    Route::get('/blog', 'BlogController@index')->name('blog');
    Route::get('/blog/post/{id}', 'BlogController@post')->name('post');
    Route::get('/about_us', 'SiteController@about_us')->name('about_us');
    Route::get('/contact', 'SiteController@contact')->name('contact');
    Route::post('/contact/send', 'SiteController@send_message')->name('contact.send_message');
    Route::get('/faqs', 'SiteController@faqs')->name('faqs');
    Route::get('/AGB', 'SiteController@AGB')->name('AGB');
    Route::get('/privacy', 'SiteController@privacy')->name('privacy');
    Route::get('/imprint', 'SiteController@imprint')->name('imprint');


    Route::get('/test/{s}', 'TestController@test')->name('test');


    Route::get('/profile/login', 'UserController@login')->name('login');
    Route::post('/profile/log', 'UserController@do_login')->name('do_login');
    Route::get('/profile/register', 'UserController@register')->name('register');
    Route::post('/profile/reg', 'UserController@do_register')->name('do_register');
    Route::get('/profile/confirm/{token}', 'UserController@confirm')->name('confirm');
    Route::get('/profile/forgot', 'UserController@forgot')->name('forgot');
    Route::post('/profile/send_reset_link', 'UserController@send_reset_link')->name('send_reset_link');
    Route::get('/profile/reset/{token}', 'UserController@reset_password')->name('reset_password');
    Route::post('/profile/do_reset', 'UserController@do_reset')->name('do_reset');


    Route::get('/airlines', 'AirlineController@index')->name('airlines.index');

    Route::get('/iframe-result-search', 'FlightController@iframe_result')->name('iframe-result-search');
    Route::get('/iframe-result', 'FlightController@ads_iframe')->name('iframe-result');

});

Route::group(['namespace' => 'Frontend', 'middleware' => 'user'], function () {

    Route::get('/profile', 'UserController@index')->name('profile');
    Route::get('/profile/logout', 'UserController@logout')->name('logout');
    Route::post('/profile/update', 'UserController@update_info')->name('profile.update_info');


});


//Auth route
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    Route::get('/login', 'Authenticate@login')->name('admin.login');
    Route::post('/log', 'Authenticate@do_login')->name('admin.do_login');

});


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {

    Route::get('/', 'HomeController@index')->name('admin.home');
    Route::get('/search/user/result/{id}', 'HomeController@search_user_result')->name('admin.search_user_result');
    Route::get('/search/ticket/result/{id}', 'HomeController@search_ticket_result')->name('admin.search_ticket_result');

    Route::get('/users', 'UserController@users')->name('admin.users');
    Route::get('/users/{user}', 'UserController@edit')->name('admin.edit_user');
    Route::post('/users/update/{user}', 'UserController@update')->name('admin.update_user');
    Route::post('/users/delete', 'UserController@delete')->name('admin.delete_user');

    Route::get('/tickets', 'HomeController@tickets')->name('admin.tickets');
    Route::get('/tickets/booked', 'HomeController@booked_tickets')->name('admin.booked_tickets');
    Route::get('/tickets/booking', 'HomeController@bookings')->name('admin.bookings');

    Route::get('/payments', 'HomeController@payments')->name('admin.payments');


    Route::get('/cip/tickets', 'CipController@tickets')->name('admin.cip_tickets');
    Route::get('/cip/tickets/booked', 'CipController@booked_tickets')->name('admin.cip_booked_tickets');
    Route::get('/cip/tickets/booking', 'CipController@bookings')->name('admin.cip_bookings');
    Route::get('/cip/search/ticket/result/{id}', 'CipController@search_ticket_result')->name('admin.cip_search_ticket_result');
    Route::post('/cip/update/{id}', 'CipController@update')->name('admin.cip_update');

    Route::get('/setting', 'HomeController@general_setting')->name('admin.general_setting');
    Route::post('/setting/update1', 'HomeController@update_setting1')->name('admin.update_setting1');
    Route::post('/setting/update2', 'HomeController@update_setting2')->name('admin.update_setting2');
    Route::post('/setting/update3', 'HomeController@update_setting3')->name('admin.update_setting3');
    Route::post('/setting/update4', 'HomeController@update_setting4')->name('admin.update_setting4');
    Route::post('/setting/update5', 'HomeController@update_setting5')->name('admin.update_setting5');
    Route::post('/setting/update6', 'HomeController@update_setting6')->name('admin.update_setting6');
    Route::post('/setting/update7', 'HomeController@update_setting7')->name('admin.update_setting7');

    Route::get('/pages', 'PageController@index')->name('admin.pages');
    Route::post('/pages/store', 'PageController@store')->name('admin.pages_store');

    Route::get('/posts', 'PostController@index')->name('admin.posts');
    Route::get('/posts/add', 'PostController@add')->name('admin.add_post');
    Route::post('/posts/store', 'PostController@store')->name('admin.store_post');
    Route::get('/posts/edit/{id}', 'PostController@edit')->name('admin.edit_post');
    Route::post('/posts/update', 'PostController@update')->name('admin.update_post');
    Route::post('/posts/delete', 'PostController@delete')->name('admin.delete_post');

    Route::get('/faqs', 'FaqController@index')->name('admin.faqs');
    Route::get('/faqs/add', 'FaqController@add')->name('admin.add_faq');
    Route::post('/faqs/store', 'FaqController@store')->name('admin.store_faq');
    Route::get('/faqs/edit/{id}', 'FaqController@edit')->name('admin.edit_faq');
    Route::post('/faqs/update', 'FaqController@update')->name('admin.update_faq');
    Route::post('/faqs/delete', 'FaqController@delete')->name('admin.delete_faq');
    Route::get('/upload', 'ImageController@index')->name('admin.upload');
    Route::post('/upload_store', 'ImageController@store')->name('admin.upload_store');

    Route::get('/analyze', 'AnalyzeController@search')->name('admin.analyze');

    Route::get('/agencies', 'UserController@agencies')->name('admin.agencies');
    Route::get('/agencies/show/{user}', 'UserController@agency')->name('admin.agency.show');
    Route::post('/agencies/update/{user}', 'UserController@agency_update')->name('admin.agency.update');
    Route::get('/agencies/payment/update/{user}/{payment}', 'UserController@complete_payment')->name('admin.agency.complete_payment');

});


Route::get('/test_flight', 'TestController@testflight')->name('test_flight');
Route::get('/digi', 'TestController@digi')->name('digi');



