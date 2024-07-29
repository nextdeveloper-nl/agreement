<?php

namespace NextDeveloper\Agreement\Database\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use NextDeveloper\Commons\Database\Traits\Filterable;
use NextDeveloper\Agreement\Database\Observers\WebhooksObserver;
use NextDeveloper\Commons\Database\Traits\UuidId;
use NextDeveloper\Commons\Common\Cache\Traits\CleanCache;
use NextDeveloper\Commons\Database\Traits\Taggable;

/**
 * Webhooks model.
 *
 * @package  NextDeveloper\Agreement\Database\Models
 * @property integer $id
 * @property string $uuid
 * @property string $source
 * @property $data
 * @property boolean $is_processed
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Webhooks extends Model
{
    use Filterable, UuidId, CleanCache, Taggable;
    use SoftDeletes;


    public $timestamps = true;

    protected $table = 'agreement_webhooks';


    /**
     @var array
     */
    protected $guarded = [];

    protected $fillable = [
            'source',
            'data',
            'is_processed',
    ];

    /**
      Here we have the fulltext fields. We can use these for fulltext search if enabled.
     */
    protected $fullTextFields = [

    ];

    /**
     @var array
     */
    protected $appends = [

    ];

    /**
     We are casting fields to objects so that we can work on them better
     *
     @var array
     */
    protected $casts = [
    'id' => 'integer',
    'source' => 'string',
    'data' => 'array',
    'is_processed' => 'boolean',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'deleted_at' => 'datetime',
    ];

    /**
     We are casting data fields.
     *
     @var array
     */
    protected $dates = [
    'created_at',
    'updated_at',
    'deleted_at',
    ];

    /**
     @var array
     */
    protected $with = [

    ];

    /**
     @var int
     */
    protected $perPage = 20;

    /**
     @return void
     */
    public static function boot()
    {
        parent::boot();

        //  We create and add Observer even if we wont use it.
        //parent::observe(WebhooksObserver::class);

        self::registerScopes();
    }

    public static function registerScopes()
    {
        $globalScopes = config('agreement.scopes.global');
        $modelScopes = config('agreement.scopes.agreement_webhooks');

        if(!$modelScopes) { $modelScopes = [];
        }
        if (!$globalScopes) { $globalScopes = [];
        }

        $scopes = array_merge(
            $globalScopes,
            $modelScopes
        );

        if($scopes) {
            foreach ($scopes as $scope) {
                static::addGlobalScope(app($scope));
            }
        }
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
