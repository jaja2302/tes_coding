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
use Filament\Forms\Get;
use Filament\Forms\Set;

class Pertandingan extends Component implements HasForms
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
                Section::make('Input Data')
                    ->description('Masukan Data Pertandingan CLub')
                    ->schema([
                        Repeater::make('pertandingan')
                            ->schema([
                                Select::make('club1')
                                    ->options(namaclub::query()->pluck('namaklub', 'id'))
                                    ->required()
                                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                        // dd($state);
                                        $params = namaclub::query()
                                            ->whereNotIn('id', [$state])
                                            ->pluck('namaklub', 'id')
                                            ->toArray();

                                        // dd($params);
                                        $set('club2', $params);
                                    })
                                    ->live()
                                    ->label('Masukan Nama Club Pertama'),
                                Select::make('club22')
                                    ->required()
                                    ->options(fn ($get) => $get('club2') ?: [])
                                    ->label('Masukan Nama Club Kedua'),
                                TextInput::make('skor1')
                                    ->required()
                                    ->label('Skor Club Pertama')
                                    ->numeric(),
                                TextInput::make('skor2')
                                    ->required()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        self::getdatapertandingan($get, $set);
                                    })
                                    ->label('Skor Club Kedua')
                                    ->live(true)
                                    ->numeric(),
                                TextInput::make('datahasilskor')
                                    ->label('Hasil Pertandingan')
                                    ->default('menghitung')
                                    ->afterStateHydrated(function (Get $get, Set $set) {
                                        self::getdatapertandingan($get, $set);
                                    })
                                    ->readOnly(),
                            ])
                            ->columns(2)
                    ]),


            ])
            ->columns(2)
            ->statePath('data');
    }
    public static function getdatapertandingan(Get $get, Set $set): void
    {

        $skor2 = $get('skor2');
        $skor1 = $get('skor1');
        $club1 = $get('club1');
        $club2 = $get('club22');

        $namaclub1 = namaclub::query()
            ->where('id', $club1)
            ->pluck('namaklub', 'id')->first();
        $namaclub2 = namaclub::query()
            ->where('id', $club2)
            ->pluck('namaklub', 'id')->first();

        // dd($params1);
        if ($skor1 > $skor2) {
            $clubresult = $namaclub1 . ' ' . 'menang';
        } else if ($skor1 < $skor2) {
            $clubresult = $namaclub2 . ' ' . 'menang';
        } else if ($skor1 == $skor2) {
            $clubresult = 'Seri';
        } else {
            $clubresult = '-';
        }

        // $test = [
        //     'test' => 'test'
        // ];
        $set('datahasilskor', $clubresult);
    }
    public function create(): void
    {
        // dd($this->form->getState());
        $form = $this->form->getState();
        try {
            DB::beginTransaction();
            $trackdata = new namaclub();
            $trackdata->namaklub = $form['clubsolos'];
            $trackdata->asalklub = $form['namakota'];
            // dd($form['members'][0]['clubmulti']);
            if ($form['members'][0]['clubmulti'] !== null) {
                foreach ($form['members'] as $data) {
                    $dataToInsert[] = [
                        'namaklub' => $data['clubmulti'],
                        'asalklub' => $data['namakota2'],
                    ];
                }
                dd($dataToInsert);
                if (!nullOrEmptyString($dataToInsert)) {
                    namaclub::insert($dataToInsert);
                }
            }
            $trackdata->save();

            DB::commit();

            Notification::make()
                ->title('Berhasil disimpan')
                ->body(' Record berhasil disimpan')
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


    public function render()
    {
        return view('livewire.pertandingan');
    }
}
