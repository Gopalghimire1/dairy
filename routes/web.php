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


Route::get('/','HomeController@home');

 Route::get('/pass', function () {
     $pass = bcrypt('admin');
     dd($pass);
 });




Route::match(['get', 'post'], 'login', 'AuthController@login')->name('login');
Route::match(['get', 'post'], 'logout', 'AuthController@logout')->name('logout');

Route::group([ 'middleware' => 'role:admin','prefix'=>'admin'],function (){
    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

    // XXX farmer routes
    Route::match(['get', 'post'], 'farmers', 'Admin\FarmerController@addFarmer')->name('admin.farmer');
    Route::get('farmer-list','Admin\FarmerController@listFarmer')->name('list.farmer');
    Route::post('farmer-list-by-center','Admin\FarmerController@listFarmerByCenter')->name('list.farmer.bycenter');
    Route::match(['get', 'post'],'farmer/update','Admin\FarmerController@updateFarmer')->name('update.farmer');
    Route::get('farmer/delete/{id}','Admin\FarmerController@deleteFarmer')->name('delete.farmer')->middleware('authority');
    Route::get('farmer/detail/{id}','Admin\FarmerController@farmerDetail')->name('farmer.detail');
    Route::post('load-date','Admin\FarmerController@loadDate')->name('farmer.loaddetail');

    // XXX  farmer advance
    Route::get('farmer-advances', 'Admin\AdvanceController@index')->name('admin.farmer.advance');
    Route::post('farmer-advance-add', 'Admin\AdvanceController@addFormerAdvance')->name('admin.farmer.advance.add');
    Route::post('farmer-advance-list', 'Admin\AdvanceController@listFarmerAdvance')->name('admin.farmer.advance.list');
    Route::post('farmer-advance-update', 'Admin\AdvanceController@updateFormerAdvance')->name('admin.farmer.advance.update');
    Route::get('farmer-advance-delete/{id}', 'Admin\AdvanceController@deleteFarmerAdvance')->middleware('authority');
    Route::post('farmer-advance-list-by-date', 'Admin\AdvanceController@advanceListByDate')->name('admin.advance.list.by.date');

    // XXX farmer due payments
    Route::get('farmer-due','Admin\FarmerController@due')->name('admin.farmer.due');
    Route::post('farmer-due-load','Admin\FarmerController@dueLoad')->name('admin.farmer.due.load');
    Route::post('farmer-pay-save','Admin\FarmerController@paymentSave')->name('admin.farmer.pay.save');

    Route::match(['GET','POST'],'farmer-add-due-list','Admin\FarmerController@addDueList')->name('admin.farmer.due.add.list');
    Route::match(['GET','POST'],'farmer-add-due','Admin\FarmerController@addDue')->name('admin.farmer.due.add');

    // XXX collection centers
    Route::get('collection-centers', 'Admin\CenterController@index')->name('admin.collection');
    Route::post('collection-center-add', 'Admin\CenterController@addCollectionCenter')->name('add.center');
    Route::get('collection-center-list', 'Admin\CenterController@listCenter')->name('list.center');
    Route::get('collection-center-delete-{id}', 'Admin\CenterController@deleteCenter')->name('delete.center')->middleware('authority');
    Route::post('collection-center-update', 'Admin\CenterController@updateCollectionCenter')->name('update.center')->middleware('authority');

    // XXX milk data
    Route::get('milk-data','Admin\MilkController@index')->name('admin.milk');
    Route::post('milk-data-save/{type}','Admin\MilkController@saveMilkData')->name('store.milk');
    Route::post('milk-data-update','Admin\MilkController@update')->name('store.milk.update');
    Route::post('milk-data-delete','Admin\MilkController@delete')->name('store.milk.delete');
    Route::post('milk-data-load','Admin\MilkController@milkDataLoad')->name('load.milk.data');
    Route::post('farmer-data-load','Admin\MilkController@loadFarmerData')->name('load.farmer.data');

    // XXX snf and fats
    Route::get('snf-fats','Admin\SnffatController@index')->name('admin.snf.fat');
    Route::post('snf-fats-data','Admin\SnffatController@snffatDataLoad')->name('load.snffat.data');
    Route::post('snf-fats-save','Admin\SnffatController@saveSnffatData')->name('store.snffat');
    Route::post('snf-fats-update','Admin\SnffatController@update')->name('store.snffat.update');
    Route::post('snf-fats-delete','Admin\SnffatController@delete')->name('store.snffat.delete');

    // XXX items
    Route::get('items','Admin\ItemController@index')->name('admin.item');
    Route::post('item-add','Admin\ItemController@saveItems')->name('admin.item.save');
    Route::get('item-delete/{id}','Admin\ItemController@deleteItem')->name('admin.item.delete')->middleware('authority');
    Route::post('item-update','Admin\ItemController@updateItem');

    // XXX sell items
    Route::get('sell-items','Admin\SellitemController@index')->name('admin.sell.item');
    Route::post('sell-item-add','Admin\SellitemController@addSellItem')->name('admin.sell.item.add');
    Route::post('sell-item-list','Admin\SellitemController@sellItemList')->name('admin.sell.item.list');
    Route::post('sell-item-update','Admin\SellitemController@updateSellItem')->name('admin.sell.item.update');
    Route::post('sell-item-delete', 'Admin\SellitemController@deleteSellitem')->middleware('authority');



    // XXX  expensess
    Route::get('expenses', 'Admin\ExpenseController@index')->name('admin.exp');
    Route::post('expense-add', 'Admin\ExpenseController@addExpense')->name('admin.exp.add');
    Route::post('expense-list', 'Admin\ExpenseController@listExpense')->name('admin.exp.list');
    Route::get('expense-delete/{id}', 'Admin\ExpenseController@deleteExpense')->middleware('authority');

    // XXX suppliers
    Route::get('suppliers', 'Admin\SupplierController@index')->name('admin.sup');
    Route::post('add-supplier','Admin\SupplierController@addSupplier')->name('admin.sup.add');
    Route::get('supplier-list', 'Admin\SupplierController@supplierList')->name('admin.sup.list');
    Route::get('supplier-delete/{id}', 'Admin\SupplierController@deleteSupplier')->middleware('authority');
    Route::post('supplier/update','Admin\SupplierController@updateSupplier');

    // XXX supplier bills

    Route::get('supplier-bills', 'Admin\SupplierController@indexBill')->name('admin.sup.bill');
    Route::post('supplier-bill-add', 'Admin\SupplierController@addBill')->name('admin.sup.bill.add');
    Route::get('supplier-bill-list', 'Admin\SupplierController@listBill')->name('admin.sup.bill.list');
    Route::post('supplier-bill-update', 'Admin\SupplierController@updateBill')->name('admin.sup.bill.update');
    Route::get('supplier-bill-delete/{id}', 'Admin\SupplierController@deleteBill')->middleware('authority');


    // XXX distributer
    Route::get('distributers', 'Admin\DistributerController@index')->name('admin.dis');
    Route::post('distributer-add', 'Admin\DistributerController@addDistributer')->name('admin.dis.add');
    Route::get('distributer-list', 'Admin\DistributerController@DistributerList')->name('admin.dis.list');
    Route::post('distributer-update', 'Admin\DistributerController@updateDistributer')->name('admin.dis.update');
    Route::get('distributer/delete/{id}', 'Admin\DistributerController@DistributerDelete')->middleware('authority');

    Route::get('distributer/detail/{id}','Admin\DistributerController@distributerDetail')->name('distributer.detail');
    Route::post('distributer/detail','Admin\DistributerController@distributerDetailLoad')->name('distributer.detail.load');


    Route::get('distributer/opening','Admin\DistributerController@opening')->name('distributer.detail.opening');
    Route::post('distributer/opening/list','Admin\DistributerController@loadLedger')->name('distributer.detail.opening.list');
    Route::post('distributer/ledger','Admin\DistributerController@ledger')->name('distributer.detail.ledger');
    Route::post('distributer/ledger/update','Admin\DistributerController@updateLedger')->name('distributer.detail.ledger.update');

    // XXX distributer sell

    Route::get('distributer-sells', 'Admin\DistributersellController@index')->name('admin.dis.sell');
    Route::post('distributer-sell-add', 'Admin\DistributersellController@addDistributersell')->name('admin.dis.sell.add');
    Route::post('distributer-sell-list', 'Admin\DistributersellController@listDistributersell')->name('admin.dis.sell.list');
    Route::post('distributer-sell-del', 'Admin\DistributersellController@deleteDistributersell')->name('admin.dis.sell.del')->middleware('authority');

    //XXX Distributor Payments
    Route::get('distributer-payment', 'Admin\DistributorPaymentController@index')->name('admin.dis.payemnt');
    Route::post('distributer-due-list', 'Admin\DistributorPaymentController@due')->name('admin.dis.due');
    Route::post('distributer-due-pay', 'Admin\DistributorPaymentController@pay')->name('admin.dis.pay');


    // XXX XXX employees
    Route::get('employees', 'Admin\EmployeeController@index')->name('admin.emp');
    Route::post('employee-add', 'Admin\EmployeeController@addEmployee')->name('admin.emp.add');
    Route::post('employee/update', 'Admin\EmployeeController@updateEmployee');
    Route::get('employee-list', 'Admin\EmployeeController@employeeList')->name('admin.emp.list');
    Route::get('employee/delete/{id}', 'Admin\EmployeeController@employeeDelete')->middleware('authority');
    Route::get('employee/detail/{id}', 'Admin\EmployeeController@employeeDetail')->middleware('Detail');

    Route::get('employee/advance','Admin\EmployeeController@advance')->name('admin.emp.advance');
    Route::post('employee/addadvance','Admin\EmployeeController@addAdvance')->name('admin.emp.advance.add');
    Route::post('employee/getadvance','Admin\EmployeeController@getAdvance')->name('admin.emp.advance.list');
    Route::post('employee/deladvance','Admin\EmployeeController@delAdvance')->name('admin.emp.advance.del')->middleware('authority');;
    Route::post('employee/updateadvance','Admin\EmployeeController@updateAdvance')->name('admin.emp.advance.update')->middleware('authority');

    // XXX products
    Route::group(['prefix' => 'product'], function () {
        Route::name('product.')->group(function(){
            Route::get('','Admin\ProductController@index')->name('home');
            Route::post('add','Admin\ProductController@add')->name('add');
            Route::post('update','Admin\ProductController@update')->name('update')->middleware('authority');
            Route::post('del','Admin\ProductController@del')->name('del')->middleware('authority');
        });
    });


    // XXX Milk payment
    Route::group(['prefix' => 'milk-payment'], function () {
        Route::name('milk.payment.')->group(function(){
            Route::match(['GET','POST'],'','Admin\MilkPaymentController@index')->name('home');
            // Route::post('load','Admin\ProductController@index')->name('load');
            Route::post('add','Admin\MilkPaymentController@add')->name('add');
            Route::post('update','Admin\MilkPaymentController@update')->name('update')->middleware('authority');
            // Route::post('del','Admin\ProductController@del')->name('del')->middleware('authority');
        });
    });


    // XXX Ledgers
    Route::group(['prefix' => 'ledger'], function () {
        Route::name('ledger.')->group(function(){
            Route::match(['GET','POST'],'update','LedgerController@update')->name('update');
            Route::match(['GET','POST'],'sellupdate','LedgerController@sellUpdate')->name('sellupdate');
            Route::match(['GET','POST'],'payupdate','LedgerController@payUpdate')->name('payupdate');

            Route::match(['GET','POST'],'del','LedgerController@del')->name('del');
            Route::group(['prefix' => 'farmer'], function () {
                Route::name('farmer.')->group(function(){
                    Route::match(['GET','POST'],'update','FarmerLedgerController@update')->name('update');
                    Route::match(['GET','POST'],'sellupdate','FarmerLedgerController@sellUpdate')->name('sellupdate');
                    Route::match(['GET','POST'],'selldel','FarmerLedgerController@sellDel')->name('selldel');
                    Route::match(['GET','POST'],'payupdate','FarmerLedgerController@payUpdate')->name('payupdate');
                    Route::match(['GET','POST'],'del','FarmerLedgerController@del')->name('del');
                });
            });
        });
    });


    Route::group(['prefix' => 'report'], function () {
        Route::name('report.')->group(function(){

            Route::get('','ReportController@index')->name('home');

            Route::match(['GET','POST'],'farmer','ReportController@farmer')->name('farmer');
            Route::post('farmer/changeSession','ReportController@farmerSession')->name('farmer.session');
            Route::post('farmer/single/changeSession','ReportController@farmerSingleSession')->name('farmer.single.session');

            Route::match(['GET','POST'],'milk','ReportController@milk')->name('milk');
            Route::match(['GET','POST'],'sales','ReportController@sales')->name('sales');
            Route::match(['GET','POST'],'distributor','ReportController@distributor')->name('dis');
            Route::match(['GET','POST'],'employee','ReportController@employee')->name('emp');
            Route::post('employee/changeSession','ReportController@employeeSession')->name('emp.session');

        });
    });


    Route::group(['prefix' => 'user'], function(){
        Route::name('user.')->group(function(){
            Route::match(['GET','POST'],'','Admin\UserController@index')->name('users');
            Route::match(['GET','POST'],'add','Admin\UserController@userAdd')->name('add');
            Route::match(['GET','POST'],'delete/{id}','Admin\UserController@delete')->name('delete');
            Route::match(['GET','POST'],'update/{update}','Admin\UserController@update')->name('update');
            Route::match(['GET','POST'],'change/password','Admin\UserController@changePassword')->name('change.password');
            Route::match(['GET','POST'],'non-super-admin/change/password/{id}','Admin\UserController@nonSuperadminChangePassword')->name('non.super.admin.change.password');
        });
    });
});



Route::group(['middleware' => 'role:farmer','prefix'=>'farmer'], function (){
    Route::name('farmer.')->group( function(){
        Route::get('home', 'Users\FarmerDashboardController@index')->name('dashboard');
        Route::post('change/password', 'Users\FarmerDashboardController@changePassword')->name('change.password');
        Route::get('transaction/detail', 'Users\FarmerDashboardController@transactionDetail')->name('milk.detail');
        Route::post('load-data','Users\FarmerDashboardController@loadData')->name('loaddata');
        Route::get('change-password', 'Users\FarmerDashboardController@changePasswordPage')->name('password.page');

    });
});

Route::group(['middleware' => 'role:distributer','prefix'=>'distributor'], function (){
    Route::name('distributer.')->group( function(){
        Route::get('home', 'Users\DistributorDashboardController@index')->name('dashboard');
        Route::post('change/password', 'Users\DistributorDashboardController@changePassword')->name('change.password');
        Route::get('transaction/detail', 'Users\DistributorDashboardController@transactionDetail')->name('transaction.detail');
        Route::post('load-data','Users\DistributorDashboardController@loaddata')->name('loaddata');
        Route::get('change-password', 'Users\DistributorDashboardController@changePasswordPage')->name('password.page');
        Route::get('make-a-request', 'Users\DistributorDashboardController@makeArequest')->name('request');
        Route::post('make-a-request-add', 'Users\DistributorDashboardController@makeArequestAdd')->name('request.add');


    });

});
