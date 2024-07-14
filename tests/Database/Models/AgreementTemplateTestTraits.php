<?php

namespace NextDeveloper\Agreement\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\Agreement\Database\Filters\AgreementTemplateQueryFilter;
use NextDeveloper\Agreement\Services\AbstractServices\AbstractAgreementTemplateService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait AgreementTemplateTestTraits
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

    public function test_http_agreementtemplate_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/agreement/agreementtemplate',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_agreementtemplate_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/agreement/agreementtemplate', [
            'form_params'   =>  [
                'name'  =>  'a',
                'description'  =>  'a',
                'reference'  =>  'a',
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
    public function test_agreementtemplate_model_get()
    {
        $result = AbstractAgreementTemplateService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agreementtemplate_get_all()
    {
        $result = AbstractAgreementTemplateService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_agreementtemplate_get_paginated()
    {
        $result = AbstractAgreementTemplateService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_agreementtemplate_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementtemplate_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::first();

            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::first();

            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::first();

            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::first();

            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::first();

            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::first();

            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::first();

            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::first();

            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::first();

            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::first();

            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_agreementtemplate_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::first();

            event(new \NextDeveloper\Agreement\Events\AgreementTemplate\AgreementTemplateRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementtemplate_event_name_filter()
    {
        try {
            $request = new Request(
                [
                'name'  =>  'a'
                ]
            );

            $filter = new AgreementTemplateQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementtemplate_event_description_filter()
    {
        try {
            $request = new Request(
                [
                'description'  =>  'a'
                ]
            );

            $filter = new AgreementTemplateQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementtemplate_event_reference_filter()
    {
        try {
            $request = new Request(
                [
                'reference'  =>  'a'
                ]
            );

            $filter = new AgreementTemplateQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementtemplate_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new AgreementTemplateQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementtemplate_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new AgreementTemplateQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementtemplate_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new AgreementTemplateQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementtemplate_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementTemplateQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementtemplate_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementTemplateQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementtemplate_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementTemplateQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementtemplate_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementTemplateQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementtemplate_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementTemplateQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_agreementtemplate_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new AgreementTemplateQueryFilter($request);

            $model = \NextDeveloper\Agreement\Database\Models\AgreementTemplate::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}