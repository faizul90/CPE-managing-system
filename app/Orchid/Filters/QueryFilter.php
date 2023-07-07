<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;

class QueryFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */

    public $parameters = ['batch'];


    public function name(): string
    {
        return '';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        dd($this->request->get('batch'));
        return $builder->where('batch', $this->request->get('batch'));
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [];
    }
}
