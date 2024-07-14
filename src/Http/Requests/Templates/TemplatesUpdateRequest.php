<?php

namespace NextDeveloper\Agreement\Http\Requests\Templates;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class TemplatesUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string',
        'description' => 'nullable|string',
        'reference' => 'nullable|string',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}