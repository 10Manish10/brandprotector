<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Channels
    Route::apiResource('channels', 'ChannelsApiController');

    // Clients
    Route::post('clients/media', 'ClientsApiController@storeMedia')->name('clients.storeMedia');
    Route::apiResource('clients', 'ClientsApiController');

    // Email Templates
    Route::post('email-templates/media', 'EmailTemplatesApiController@storeMedia')->name('email-templates.storeMedia');
    Route::apiResource('email-templates', 'EmailTemplatesApiController');

    // Subscription
    Route::apiResource('subscriptions', 'SubscriptionApiController');
});
