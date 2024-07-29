<?php

namespace NextDeveloper\Agreement\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use NextDeveloper\Commons\Database\Filters\AbstractQueryFilter;


/**
 * This class automatically puts where clause on database so that use can filter
 * data returned from the query.
 */
class WebhooksQueryFilter extends AbstractQueryFilter
{

    /**
     * @var Builder
     */
    protected $builder;
    
    public function source($value)
    {
        return $this->builder->where('source', 'like', '%' . $value . '%');
    }

    public function isProcessed($value)
    {
        if(!is_bool($value)) {
            $value = false;
        }

        return $this->builder->where('is_processed', $value);
    }

    public function createdAtStart($date)
    {
        return $this->builder->where('created_at', '>=', $date);
    }

    public function createdAtEnd($date)
    {
        return $this->builder->where('created_at', '<=', $date);
    }

    public function updatedAtStart($date)
    {
        return $this->builder->where('updated_at', '>=', $date);
    }

    public function updatedAtEnd($date)
    {
        return $this->builder->where('updated_at', '<=', $date);
    }

    public function deletedAtStart($date)
    {
        return $this->builder->where('deleted_at', '>=', $date);
    }

    public function deletedAtEnd($date)
    {
        return $this->builder->where('deleted_at', '<=', $date);
    }

    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
