<?php

namespace App\Livewire;

use App\Models\trackrecord;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Klasemen extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        // table 
        return $table
            ->query(trackrecord::query())
            ->columns([
                TextColumn::make('klub'),
                TextColumn::make('ma'),
                TextColumn::make('me'),
                TextColumn::make('s'),
                TextColumn::make('k'),
                TextColumn::make('gm'),
                TextColumn::make('gk'),
                TextColumn::make('point'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }
    public function render()
    {
        return view('livewire.klasemen');
    }
}
