<?php

namespace NextDeveloper\Agreement\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Agreement\Database\Models\Templates;
use NextDeveloper\Commons\Http\Transformers\AbstractTransformer;
use NextDeveloper\Agreement\Http\Transformers\AbstractTransformers\AbstractTemplatesTransformer;

/**
 * Class TemplatesTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\Agreement\Http\Transformers
 */
class TemplatesTransformer extends AbstractTemplatesTransformer
{

    /**
     * @param Templates $model
     *
     * @return array
     */
    public function transform(Templates $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('Templates', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        Cache::set(
            CacheHelper::getKey('Templates', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
