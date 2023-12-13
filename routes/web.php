<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/','App\Http\Controllers\HomeController@index')->name('home');
Route::get('/login','App\Http\Controllers\LoginController@Login')->name('login');
Route::post('/signin','App\Http\Controllers\LoginController@SignIn')->name('signin');

Route::namespace('App\Http\Controllers\Dashboard')->prefix('dashbord')->middleware('auth')->name('dashboard.')->group(function(){

    //home
    Route::get('/','HomeController@index')->name('home');
    Route::get('/profile','HomeController@Profile')->name('profile');
    Route::post('/profile/update','HomeController@ProfileUpdate')->name('profile.update');
    Route::get('/changePassword','HomeController@changePassword')->name('changePassword');
    Route::post('/changePassword/update','HomeController@changePasswordUpdate')->name('changePassword.update');
    Route::post('/logout','HomeController@Logout')->name('logout');


    Route::middleware('checkAdmin')->group(function(){
        //customer
        Route::get('customers','CustomerController@index')->name('customers.index');
        Route::get('customers/getOrders/{id}','CustomerController@orders')->name('customers.getOrders');
        Route::get('customers/getOrders/{id}/waiting','CustomerController@waiting')->name('customers.getOrders.waiting');
        Route::get('customers/getOrders/{id}/onWay','CustomerController@onWay')->name('customers.getOrders.onWay');
        Route::get('customers/getOrders/{id}/completed','CustomerController@completed')->name('customers.getOrders.completed');
        Route::get('customers/getOrders/{id}/customerCancel','CustomerController@customerCancel')->name('customers.getOrders.customerCancel');
        

        Route::post('customers/getOrders/adminCancel','CustomerController@adminCancel')->name('customers.getOrders.adminCancel');
        Route::get('customers/create','CustomerController@create')->name('customers.create');
        Route::get('customers/edit/{id}','CustomerController@edit')->name('customers.edit');
        Route::get('customers/show/{id}','CustomerController@show')->name('customers.show');
        Route::post('customers/store','CustomerController@store')->name('customers.store');
        Route::post('customers/search','CustomerController@search')->name('customers.search');
        Route::patch('customers/update/{id}','CustomerController@update')->name('customers.update');
        Route::post('customers/destroy/','CustomerController@destroy')->name('customers.destroy');


        //delivery
        Route::get('deliverys','DeliveryController@index')->name('deliverys.index');
        Route::get('deliverys/getOrders/{id}','DeliveryController@orders')->name('deliverys.getOrders');
        Route::get('deliverys/getOrders/{id}/cancelShipping','DeliveryController@cancelShipping')->name('deliverys.getOrders.cancelShipping');
        Route::get('deliverys/getOrders/{id}/price','DeliveryController@price')->name('deliverys.getOrders.price');
        Route::post('deliverys/getOrders/{id}/price/edit','DeliveryController@priceEdit')->name('deliverys.getOrders.price.edit');
        Route::post('deliverys/getOrders/{id}/search','DeliveryController@searchOrder')->name('deliverys.getOrders.search');
        
        Route::post('deliverys/getOrders/cancelDelivery','DeliveryOrderController@cancelDelivery')->name('deliverys.cancel');
        Route::get('deliverys/getOrders/{id}/waiting','DeliveryController@waiting')->name('deliverys.getOrders.waiting');
        Route::get('deliverys/getOrders/{id}/onWay','DeliveryController@onWay')->name('deliverys.getOrders.onWay');
        Route::get('deliverys/getOrders/{id}/completed','DeliveryController@completed')->name('deliverys.getOrders.completed');
        Route::get('deliverys/getOrders/{id}/customerCancel','DeliveryController@customerCancel')->name('deliverys.getOrders.customerCancel');
        Route::get('deliverys/create','DeliveryController@create')->name('deliverys.create');
        Route::get('deliverys/edit/{id}','DeliveryController@edit')->name('deliverys.edit');
        Route::get('deliverys/show/{id}','DeliveryController@show')->name('deliverys.show');
        Route::post('deliverys/store','DeliveryController@store')->name('deliverys.store');
        Route::post('deliverys/search','DeliveryController@search')->name('deliverys.search');
        Route::patch('deliverys/update/{id}','DeliveryController@update')->name('deliverys.update');
        Route::post('deliverys/destroy','DeliveryController@destroy')->name('deliverys.destroy');


        //admin
        Route::get('admins','AdminController@index')->name('admins.index');
        Route::get('admins/create','AdminController@create')->name('admins.create');
        Route::post('admins/store','AdminController@store')->name('admins.store');
        Route::post('admins/search','AdminController@search')->name('admins.search');


        //order
        Route::get('orders/pendding','OrderController@pendding')->name('orders.pendding');
        Route::post('orders/pendding/delete','OrderController@penddingDelete')->name('orders.pendding.delete');
        Route::get('orders/pendding/price/{id}','OrderController@setPenddingPriceCreate')->name('orders.penddingSetPrice.Create');
        Route::post('orders/pendding/price/{id}','OrderController@setPenddingPrice')->name('orders.penddingSetPrice.Store');

        Route::get('orders/{customer}','OrderController@index')->name('orders.index');
        Route::get('orders/{customer}/pay','OrderController@adminPay')->name('orders.adminPay');
        Route::get('orders/{customer}/onWay','OrderController@onWay')->name('orders.onWay');
        Route::get('orders/{customer}/orderCancel','OrderController@orderCancel')->name('orders.orderCancel');
        Route::get('orders/{customer}/adminAmoutShipping','OrderController@adminAmoutShipping')->name('orders.adminAmoutShipping');
        Route::get('orders/{order}/setOrderCancel','OrderController@setOrderCancel')->name('orders.setOrderCancel');
        Route::get('orders/{customer}/waiting','OrderController@waiting')->name('orders.waiting');
        Route::get('orders/{customer}/completed','OrderController@completed')->name('orders.completed');
        Route::get('orders/{customer}/customerCancel','OrderController@customerCancel')->name('orders.customerCancel');
        Route::get('orders/{customer}/adminCancel','OrderController@adminCancel')->name('orders.adminCancel');
        Route::get('orders/{customer}/delivery/{id}','OrderController@delivery')->name('orders.delivery');
        Route::get('orders/{customer}/create','OrderController@create')->name('orders.create');
        Route::get('orders/{customer}/edit/{id}','OrderController@edit')->name('orders.edit');
        Route::get('orders/{customer}/show/{id}','OrderController@show')->name('orders.show');
        Route::post('orders/store','OrderController@store')->name('orders.store');
        Route::post('orders/{customer}/search','OrderController@search')->name('orders.search');
        Route::post('orders/{customer}/pay','OrderController@pay')->name('orders.pay');
        Route::post('orders/{customer}/update/{id}','OrderController@update')->name('orders.update');
        Route::post('orders/{customer}/delivery/{id}','OrderController@setDelivey')->name('orders.setDelivey');
        Route::post('orders/destroy/','OrderController@destroy')->name('orders.destroy');
        Route::post('orders/{customer}/search','OrderController@search')->name('orders.search');
        Route::get('orders/amoutShipping/{id}','OrderController@amoutShipping')->name('orders.amoutShipping');

    });

    Route::middleware('checkDelivery')->group(function(){
        Route::get('delivery/orders','DeliveryOrderController@index')->name('delivery.orders.index');
        Route::get('delivery/orders/onWay','DeliveryOrderController@onWay')->name('delivery.orders.onWay');
        Route::get('delivery/orders/waiting','DeliveryOrderController@waiting')->name('delivery.orders.waiting');
        Route::get('delivery/orders/completed','DeliveryOrderController@completed')->name('delivery.orders.completed');
        Route::get('delivery/orders/show/{id}','DeliveryOrderController@show')->name('delivery.orders.show');
        Route::patch('delivery/orders/update/{id}','DeliveryOrderController@update')->name('delivery.orders.update');
        Route::get('delivery/orders/agree/{id}','DeliveryOrderController@agree')->name('delivery.orders.agree');
        Route::post('delivery/orders/searchOrder','DeliveryOrderController@searchOrder')->name('delivery.orders.searchOrder');
    });
    Route::middleware('checkCustomer')->group(function(){
        Route::get('customer/orders','CustomerOrderController@index')->name('customer.orders.index');
        Route::get('customer/orders/create','CustomerOrderController@create')->name('customer.orders.create');
        Route::post('customer/orders/store','CustomerOrderController@store')->name('customer.orders.store');

        Route::post('customer/orders/search','CustomerOrderController@search')->name('customer.orders.search');
        Route::get('customer/orders/onWay','CustomerOrderController@onWay')->name('customer.orders.onWay');
         Route::get('customer/orders/pay','CustomerOrderController@pay')->name('customer.orders.pay');
         Route::get('customer/orders/amount','CustomerOrderController@amount')->name('customer.orders.amount');
        Route::get('customer/orders/waiting','CustomerOrderController@waiting')->name('customer.orders.waiting');
        Route::get('customer/orders/completed','CustomerOrderController@completed')->name('customer.orders.completed');
        Route::get('customer/orders/cancel','CustomerOrderController@cancel')->name('customer.orders.cancel');
        Route::get('customer/orders/show/{id}','CustomerOrderController@show')->name('customer.orders.show');
    });



   
});
