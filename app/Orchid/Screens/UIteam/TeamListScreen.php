<?php

namespace App\Orchid\Screens\UIteam;

use App\Orchid\Layouts\UIteam\TeamListLayout;
use App\Orchid\Layouts\UIteam\TeamAddLayout;
use App\Models\UnifiInstallerID;
use Orchid\Screen\Screen;
use Orchid\Screen\Action;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Color;

class TeamListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'teams' => UnifiInstallerID::filters()->defaultSort('id', 'desc')->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Team';
    }

    public function description(): ?string
    {
        return 'Team List';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make(__('Add Team'))
                ->icon('bs.plus-circle')
                ->modal('asyncAddTeamModal')
                ->method('saveTeam'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            TeamListLayout::class,
            Layout::modal('asyncAddTeamModal', TeamAddLayout::class)
                ->async('asyncGetTeamModal'),
            Layout::modal('asyncEditTeamModal', TeamAddLayout::class)
                ->async('asyncGetTeamModal'),
        ];
    }

    public function asyncGetTeamModal(UnifiInstallerID $team): iterable
    {
        return [
            'team' => $team,
        ];
    }

    public function saveTeam(Request $request, UnifiInstallerID $team): void
    {
        $reqinput = $request->input('team');
        if($reqinput['team_id']){
            $team->fill($reqinput)->save();
            Toast::info(__('Team updated.'));
        }else
            Toast::info(__('No changes / No ID was added.'));
        
    }
}
