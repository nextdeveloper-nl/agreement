<?php

Route::prefix('agreement')->group(
    function () {
        Route::prefix('contracts')->group(
            function () {
                Route::get('/', 'Contracts\ContractsController@index');
                Route::get('/actions', 'Contracts\ContractsController@getActions');

                Route::get('{agreement_contracts}/tags ', 'Contracts\ContractsController@tags');
                Route::post('{agreement_contracts}/tags ', 'Contracts\ContractsController@saveTags');
                Route::get('{agreement_contracts}/addresses ', 'Contracts\ContractsController@addresses');
                Route::post('{agreement_contracts}/addresses ', 'Contracts\ContractsController@saveAddresses');

                Route::get('/{agreement_contracts}/{subObjects}', 'Contracts\ContractsController@relatedObjects');
                Route::get('/{agreement_contracts}', 'Contracts\ContractsController@show');

                Route::post('/', 'Contracts\ContractsController@store');
                Route::post('/{agreement_contracts}/do/{action}', 'Contracts\ContractsController@doAction');

                Route::patch('/{agreement_contracts}', 'Contracts\ContractsController@update');
                Route::delete('/{agreement_contracts}', 'Contracts\ContractsController@destroy');
            }
        );

        Route::prefix('templates')->group(
            function () {
                Route::get('/', 'Templates\TemplatesController@index');
                Route::get('/actions', 'Templates\TemplatesController@getActions');

                Route::get('{agreement_templates}/tags ', 'Templates\TemplatesController@tags');
                Route::post('{agreement_templates}/tags ', 'Templates\TemplatesController@saveTags');
                Route::get('{agreement_templates}/addresses ', 'Templates\TemplatesController@addresses');
                Route::post('{agreement_templates}/addresses ', 'Templates\TemplatesController@saveAddresses');

                Route::get('/{agreement_templates}/{subObjects}', 'Templates\TemplatesController@relatedObjects');
                Route::get('/{agreement_templates}', 'Templates\TemplatesController@show');

                Route::post('/', 'Templates\TemplatesController@store');
                Route::post('/{agreement_templates}/do/{action}', 'Templates\TemplatesController@doAction');

                Route::patch('/{agreement_templates}', 'Templates\TemplatesController@update');
                Route::delete('/{agreement_templates}', 'Templates\TemplatesController@destroy');
            }
        );

        Route::prefix('webhooks')->group(
            function () {
                Route::get('/', 'Webhooks\WebhooksController@index');
                Route::get('/actions', 'Webhooks\WebhooksController@getActions');

                Route::get('{agreement_webhooks}/tags ', 'Webhooks\WebhooksController@tags');
                Route::post('{agreement_webhooks}/tags ', 'Webhooks\WebhooksController@saveTags');
                Route::get('{agreement_webhooks}/addresses ', 'Webhooks\WebhooksController@addresses');
                Route::post('{agreement_webhooks}/addresses ', 'Webhooks\WebhooksController@saveAddresses');

                Route::get('/{agreement_webhooks}/{subObjects}', 'Webhooks\WebhooksController@relatedObjects');
                Route::get('/{agreement_webhooks}', 'Webhooks\WebhooksController@show');

                Route::post('/', 'Webhooks\WebhooksController@store');
                Route::post('/{agreement_webhooks}/do/{action}', 'Webhooks\WebhooksController@doAction');

                Route::patch('/{agreement_webhooks}', 'Webhooks\WebhooksController@update');
                Route::delete('/{agreement_webhooks}', 'Webhooks\WebhooksController@destroy');
            }
        );

        // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE








    }
);


























