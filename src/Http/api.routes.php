<?php

Route::prefix('agreement')->group(function () {
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

// EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE




});





