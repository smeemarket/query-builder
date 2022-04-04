<?php

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('drinkList', function () {
    // $data = Customer::select('customers.customer_id', 'customers.name as cusName', 'drinks.name as dName', 'drinks.price', DB::raw('count(*) as count'))
    // $data = Customer::select('customers.customer_id', 'customers.name as cusName', DB::raw('count(*) as count'))
    $data = Customer::select('customers.customer_id', 'customers.name as cusName', DB::raw('avg(drinks.price) as maxPrice'))
        ->where('drinks.customer_id', 1)
        ->join('drinks', 'drinks.customer_id', 'customers.customer_id')
        ->groupBy('drinks.customer_id')
        // ->join('drinks', function ($join) {
        //     $join->on('customers.customer_id', 'drinks.customer_id')
        //         ->where('customers.customer_id', '>=', 3);
        // })
        ->get();

    dd($data->toArray());
});

Route::get('pizzaList', function () {
    $data = Customer::select('customers.name as customerName', 'pizzas.name as pizzaName')
        ->leftJoin('orders', 'customers.customer_id', 'orders.customer_id')
        ->leftJoin('pizzas', 'pizzas.pizza_id', 'orders.pizza_id')
        ->get();
    dd($data->toArray());
});

Route::get('testing', function () {
    $data = Customer::orderBy('name', 'desc')
        ->get();
    dd($data->toArray());
});