<?php

namespace App\Livewire;

use App\Models\Post;
use Filament\Forms\Components\TextInput;
use App\Models\namakota;
use App\Models\namaclub;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class Inputdata extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Club2')
                    ->description('Masukan Banyak Club Sekaligus')
                    ->schema([
                        Repeater::make('club')
                            ->schema([
                                TextInput::make('clubmulti')
                                    ->required()
                                    ->label('Masukan Nama Club'),

                                Select::make('namakota2')
                                    ->required()
                                    ->options(namakota::query()->pluck('namakota', 'namakota'))

                            ])
                            ->columns(2)
                    ]),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function create(): void
    {
        $form = $this->form->getState();
        try {
            DB::beginTransaction();

            $dataToInsert = [];
            foreach ($form['club'] as $data) {
                if (isset($data['clubmulti']) && $data['clubmulti'] !== '') {
                    $dataToInsert[] = [
                        'namaklub' => $data['clubmulti'],
                        'asalklub' => $data['namakota2'],
                    ];
                }
            }

            if (!empty($dataToInsert)) {
                namaclub::insert($dataToInsert);
            }

            DB::commit();

            Notification::make()
                ->title('Berhasil disimpan')
                ->body('Record berhasil disimpan')
                ->icon('heroicon-o-document-text')
                ->iconColor('success')
                ->color('success')
                ->success()
                ->send();

            $this->form->fill();
        } catch (\Throwable $th) {
            DB::rollBack();

            Notification::make()
                ->title('Error ' . $th->getMessage())
                ->danger()
                ->color('danger')
                ->send();
        }
    }



    public function render(): View
    {
        return view('livewire.inputdata');
    }
}
