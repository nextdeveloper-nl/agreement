<?php

namespace NextDeveloper\Agreement\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\Agreement\Database\Filters\AgreementContractQueryFilter;
use NextDeveloper\Agreement\Services\AbstractServices\AbstractAgreementContractService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait AgreementContractTestTraits
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

    public function test_http_agreementcontract_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/agreement/agreementcontract',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_agreementcontract_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/agreement/agreementcontract', [
            'form_params'   =>  [
                'reference'  =>  'a',
                'template_reference'  =>  'a',
                'name'  =>  'a',
                'description'  =>  'a',
                'object_type'  =>  'a',
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
    public function test_agreementcontract_model_get()
    {
        $result = AbstractAgreementContractService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agreementcontract_get_all()
    {
        $result = AbstractAgreementContractService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agreementcontract_get_paginated()
    {
        $result = AbstractAgreementContractService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_agreementcontract_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementcontract_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::first();

            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::first();

            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::first();

            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::first();

            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::first();

            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::first();

            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::first();

            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::first();

            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::first();

            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::first();

            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementcontract_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::first();

            event(new \NextDeveloper\Agreement\Events\AgreementContract\AgreementContractRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementcontract_event_reference_filter()
    {
        try {
            $request = new Request(
                [
                'reference'  =>  'a'
                ]
            );

            $filter = new AgreementContractQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementcontract_event_template_reference_filter()
    {
        try {
            $request = new Request(
                [
                'template_reference'  =>  'a'
                ]
            );

            $filter = new AgreementContractQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementcontract_event_name_filter()
    {
        try {
            $request = new Request(
                [
                'name'  =>  'a'
                ]
            );

            $filter = new AgreementContractQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementcontract_event_description_filter()
    {
        try {
            $request = new Request(
                [
                'description'  =>  'a'
                ]
            );

            $filter = new AgreementContractQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementcontract_event_object_type_filter()
    {
        try {
            $request = new Request(
                [
                'object_type'  =>  'a'
                ]
            );

            $filter = new AgreementContractQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementcontract_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new AgreementContractQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementcontract_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new AgreementContractQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementcontract_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new AgreementContractQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementcontract_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementContractQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementcontract_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementContractQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementcontract_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementContractQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementcontract_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementContractQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementcontract_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementContractQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementcontract_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementContractQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementContract::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}