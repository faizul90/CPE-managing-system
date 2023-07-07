<?php

namespace App\Orchid\Layouts\UIteam;

use App\Models\UnifiInstallerID;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Carbon\Carbon;
use Orchid\Support\Facades\Layout;

class TeamListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'teams';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [ 

            TD::make('team_id', __('Team ID'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn (UnifiInstallerID $items) => $items->team_id),

            TD::make('owner', __('Owner Name'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn (UnifiInstallerID $items) => ModalToggle::make($items->owner)
                    ->modal('asyncEditTeamModal')
                    ->modalTitle($items->presenter()->title())
                    ->method('saveTeam')
                    ->asyncParameters([
                        'team' => $items->id,
                    ])),

            TD::make('site', __('Site'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (UnifiInstallerID $items) => $items->site),

            TD::make('remarks', __('Remark'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (UnifiInstallerID $items) => $items->remarks),

        ];


    }
}
