<?php

namespace Nour\Filter;


trait FilterTrait
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new FilterScope());
    }

}
