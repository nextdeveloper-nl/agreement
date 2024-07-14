<?php

namespace NextDeveloper\Agreement\Http\Requests\Templates;

use NextDeveloper\Commons\Http\Requests\AbstractFormRequest;

class TemplatesCreateRequest extends AbstractFormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
        'description' => 'required|string',
        'reference' => 'required|string',
        ];
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}