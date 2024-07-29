<?php

namespace NextDeveloper\Agreement\Http\Requests\Webhooks;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class WebhooksCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'source' => 'nullable|string',
        'data' => 'nullable',
        'is_processed' => 'boolean',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}