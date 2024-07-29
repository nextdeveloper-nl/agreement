<?php

namespace NextDeveloper\Agreement\Http\Requests\Contracts;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class ContractsUpdateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'reference' => 'nullable|string',
        'template_reference' => 'nullable|string',
        'name' => 'nullable|string',
        'description' => 'nullable|string',
        'object_type' => 'nullable|string',
        'object_id' => 'nullable',
        'is_signed' => 'boolean',
        'data' => 'nullable',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}