<?php

namespace NextDeveloper\Agreement\Services;

use NextDeveloper\Agreement\Jobs\ProcessWebhookJob;
use NextDeveloper\Agreement\Services\AbstractServices\AbstractWebhooksService;

/**
 * This class is responsible from managing the data for Webhooks
 *
 * Class WebhooksService.
 *
 * @package NextDeveloper\Agreement\Database\Models
 */
class WebhooksService extends AbstractWebhooksService
{

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    /**
     * Create a new Webhook
     *
     * @param array $data
     * @return mixed
     */
    public static function create(array $data)
    {
        $data = parent::create($data);

        dispatch(new ProcessWebhookJob());

        return $data;
    }
}
