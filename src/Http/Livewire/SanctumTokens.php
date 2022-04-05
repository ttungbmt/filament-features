<?php
namespace FilamentPro\Features\Http\Livewire;

use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Tables;
use FilamentPro\Features\Features;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Sanctum\PersonalAccessToken;
use Livewire\Component;

class SanctumTokens extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected $listeners = ['tokenCreated' => 'render'];

    public function render()
    {
        return view('filament-features::livewire.sanctum-tokens');
    }

    protected function getTableQuery(): Builder
    {
        return PersonalAccessToken::where('tokenable_id', auth()->id());
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->date()
                ->label('Date created'),
        ];
    }

    public static function getPermissions(){
        return Features::options(Features::sanctum(), 'permissions', ['create', 'read', 'update', 'delete']);
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\IconButtonAction::make('edit')
                ->action('edit')
                ->icon('heroicon-o-pencil-alt')
                ->modalWidth('sm')
                ->mountUsing(
                    fn ($form, $record) => $form->fill($record->toArray())
                )
                ->form([
                    Forms\Components\TextInput::make('name'),
                    Forms\Components\CheckboxList::make('abilities')
                        ->label(__('filament-features::default.fields.abilities'))
                        ->options(self::getPermissions())
                        ->columns(2)
                        ->required()
                        ->afterStateHydrated(function ($component, $state) {
                            $abilities = self::getPermissions();
                            $selected = collect($abilities)
                                ->filter(function ($item, $key) use ($state) {
                                    return in_array($item, $state);
                                })
                                ->keys()
                                ->toArray();
                            $component->state($selected);
                        }),
                ]),
            Tables\Actions\IconButtonAction::make('delete')
                ->action('delete')
                ->color('danger')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation(),
        ];
    }

    public function delete($record)
    {
        $record->delete();
    }

    public function edit($record, $data)
    {
        $indexes = $data['abilities'];
        $abilities = self::getPermissions();
        $selected = collect($abilities)
            ->filter(function ($item, $key) use ($indexes) {
                return in_array($key, $indexes);
            })
            ->toArray();
        $record->update([
            'abilities' => array_values($selected),
        ]);
        Filament::notify(
            'success',
            __('filament-features::profile.sanctum.update.notify')
        );
    }
}
