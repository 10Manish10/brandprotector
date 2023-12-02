<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', '2fa']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Channels
    Route::delete('channels/destroy', 'ChannelsController@massDestroy')->name('channels.massDestroy');
    Route::resource('channels', 'ChannelsController');

    // Clients
    Route::delete('clients/destroy', 'ClientsController@massDestroy')->name('clients.massDestroy');
    Route::post('clients/media', 'ClientsController@storeMedia')->name('clients.storeMedia');
    Route::post('clients/ckmedia', 'ClientsController@storeCKEditorImages')->name('clients.storeCKEditorImages');
    Route::get('clients/channels/{subid}', 'ClientsController@getChannelBySubscription')->name('clients.getChannelBySubscription');
    Route::resource('clients', 'ClientsController');

    // Email Templates
    Route::delete('email-templates/destroy', 'EmailTemplatesController@massDestroy')->name('email-templates.massDestroy');
    Route::post('email-templates/media', 'EmailTemplatesController@storeMedia')->name('email-templates.storeMedia');
    Route::post('email-templates/ckmedia', 'EmailTemplatesController@storeCKEditorImages')->name('email-templates.storeCKEditorImages');
    Route::resource('email-templates', 'EmailTemplatesController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Subscription
    Route::delete('subscriptions/destroy', 'SubscriptionController@massDestroy')->name('subscriptions.massDestroy');
    Route::resource('subscriptions', 'SubscriptionController');

    // Cron Jobs
    Route::delete('crons/destroy', 'CronController@massDestroy')->name('crons.massDestroy');
    Route::resource('crons', 'CronController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
        Route::post('profile/two-factor', 'ChangePasswordController@toggleTwoFactor')->name('password.toggleTwoFactor');
    }
});
Route::group(['namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Two Factor Authentication
    if (file_exists(app_path('Http/Controllers/Auth/TwoFactorController.php'))) {
        Route::get('two-factor', 'TwoFactorController@show')->name('twoFactor.show');
        Route::post('two-factor', 'TwoFactorController@check')->name('twoFactor.check');
        Route::get('two-factor/resend', 'TwoFactorController@resend')->name('twoFactor.resend');
    }
});

// General
Route::get('/scrap/update-dataset-runs/{runId?}', 'DatasetsScrap@updateStatus')->name('datascrap.updateDatasetRuns');

// Amazon Channel
Route::get('/amazon/create-dataset/{channelId}/{clientId}/{keyword}', 'AmazonController@createDataset')->name('amazon.createDataset');
Route::get('/amazon/save-data/{channelId}/{clientId}/{keyword}/{datasetId?}', 'AmazonController@saveData')->name('amazon.saveData');

// Google Channel
Route::get('/google/create-dataset/{channelId}/{clientId}/{keyword}', 'GoogleController@createDataset')->name('google.createDataset');
Route::get('/google/save-data/{channelId}/{clientId}/{keyword}/{datasetId?}', 'GoogleController@saveData')->name('google.saveData');

// Ebay Channel
Route::get('/ebay/create-dataset/{channelId}/{clientId}/{keyword}', 'EbayController@createDataset')->name('ebay.createDataset');
Route::get('/ebay/save-data/{channelId}/{clientId}/{keyword}/{datasetId?}', 'EbayController@saveData')->name('ebay.saveData');

// Etsy Channel
Route::get('/etsy/create-dataset/{channelId}/{clientId}/{keyword}', 'EtsyController@createDataset')->name('etsy.createDataset');
Route::get('/etsy/save-data/{channelId}/{clientId}/{keyword}/{datasetId?}', 'EtsyController@saveData')->name('etsy.saveData');

// AliExpress Channel
Route::get('/aliexpress/create-dataset/{channelId}/{clientId}/{keyword}', 'AliExpressController@createDataset')->name('aliexpress.createDataset');
Route::get('/aliexpress/save-data/{channelId}/{clientId}/{keyword}/{datasetId?}', 'AliExpressController@saveData')->name('aliexpress.saveData');

// Walmart Channel
Route::get('/walmart/create-dataset/{channelId}/{clientId}/{keyword}', 'WalmartController@createDataset')->name('walmart.createDataset');
Route::get('/walmart/save-data/{channelId}/{clientId}/{keyword}/{datasetId?}', 'WalmartController@saveData')->name('walmart.saveData');

Route::get('/test/{channelId}/{clientId}', 'AmazonController@test')->name('amazon.test');

// Reports
Route::get('/reports', 'ReportsController@test')->name('reports');
Route::get('/reports/{clientId}/{channelId}/{cname}/{keyword}', 'ReportsController@getReport')->name('reports.getReport');
Route::post('/reports/{clientId}/{channelId}/{cname}/{keyword}', 'ReportsController@createReport')->name('reports.createReport');
Route::get('/reports/export/{clientId}/{range?}', 'ReportsController@exportReport')->name('reports.exportReport');
Route::get('/reports/email/{clientId}/{range?}', 'ReportsController@emailReport')->name('reports.emailReport');

// Subscription Plans
Route::get('/plans', 'Plans@test')->name('plans')->name('home');
Route::post('/plans/create', 'Plans@createPayment')->name('plans.createPayment');
Route::middleware('api.key')->post('/plans/webhook/paymentStatus', 'Plans@paymentWebhook')->name('plans.paymentWebhook');

// sendInfringmentMail
Route::post('/sendInfringmentMail', 'Plans@sendInfringmentMail')->name('sendInfringmentMail');
