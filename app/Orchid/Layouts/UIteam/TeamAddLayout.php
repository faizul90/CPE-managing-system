<?php

namespace App\Orchid\Layouts\UIteam;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class TeamAddLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('team.team_id')
                ->type('text')
                ->max(255)
                ->title(__('Team ID'))
                ->placeholder(__('Team ID')),

            Input::make('team.owner')
                ->type('text')
                ->max(255)
                ->title(__('Owner'))
                ->placeholder(__('Owner')),

            Input::make('team.site')
                ->type('text')
                ->max(255)
                ->title(__('Site'))
                ->placeholder(__('Site')),

            Input::make('team.remarks')
                ->type('text')
                ->max(255)
                ->title(__('Remark'))
                ->placeholder(__('Remark')),
        ];
    }
}
