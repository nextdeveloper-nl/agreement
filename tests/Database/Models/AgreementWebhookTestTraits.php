<?php

namespace NextDeveloper\Agreement\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\Agreement\Database\Filters\AgreementWebhookQueryFilter;
use NextDeveloper\Agreement\Services\AbstractServices\AbstractAgreementWebhookService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait AgreementWebhookTestTraits
{
    public $http;

    /**
     *   Creating the Guzzle object
     */
    public function setupGuzzle()
    {
        $this->http = new Client(
            [
            'base_uri'  =>  '127.0.0.1:8000'
            ]
        );
    }

    /**
     *   Destroying the Guzzle object
     */
    public function destroyGuzzle()
    {
        $this->http = null;
    }

    public function test_http_agreementwebhook_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/agreement/agreementwebhook',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_agreementwebhook_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/agreement/agreementwebhook', [
            'form_params'   =>  [
                'source'  =>  'a',
                            ],
                ['http_errors' => false]
            ]
        );

        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
    }

    /**
     * Get test
     *
     * @return bool
     */
    public function test_agreementwebhook_model_get()
    {
        $result = AbstractAgreementWebhookService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agreementwebhook_get_all()
    {
        $result = AbstractAgreementWebhookService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agreementwebhook_get_paginated()
    {
        $result = AbstractAgreementWebhookService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_agreementwebhook_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementwebhook_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::first();

            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::first();

            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::first();

            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::first();

            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::first();

            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::first();

            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::first();

            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::first();

            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::first();

            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::first();

            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementwebhook_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::first();

            event(new \NextDeveloper\Agreement\Events\AgreementWebhook\AgreementWebhookRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementwebhook_event_source_filter()
    {
        try {
            $request = new Request(
                [
                'source'  =>  'a'
                ]
            );

            $filter = new AgreementWebhookQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementwebhook_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new AgreementWebhookQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementwebhook_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new AgreementWebhookQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementwebhook_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new AgreementWebhookQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementwebhook_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementWebhookQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementwebhook_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementWebhookQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementwebhook_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementWebhookQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementwebhook_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementWebhookQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementwebhook_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementWebhookQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementwebhook_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementWebhookQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementWebhook::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}