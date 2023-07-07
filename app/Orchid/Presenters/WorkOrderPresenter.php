<?php

namespace App\Orchid\Presenters;

use Illuminate\Support\Str;
use Laravel\Scout\Builder;
use Orchid\Screen\Contracts\Personable;
use Orchid\Screen\Contracts\Searchable;
use Orchid\Support\Presenter;

class WorkOrderPresenter extends Presenter
{
    // Add your presenter methods here
    public function label(): string
    {
        return 'Orders';
    }

    public function title(): string
    {
        return $this->entity->order_no;
    }

    public function perSearchShow(): int
    {
        return 3;
    }

    /**
     * Returns a Laravel Scout builder object that can be used to search for matching users.
     * This method is used by the search functionality to retrieve a list of matching results.
     */
    public function searchQuery(string $query = null): Builder
    {
        return $this->entity->search($query);
    }
}
