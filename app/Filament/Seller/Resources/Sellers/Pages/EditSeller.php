<?php

namespace App\Filament\Seller\Resources\Sellers\Pages;

use App\Filament\Seller\Resources\Sellers\SellerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;

class EditSeller extends EditRecord
{
    protected static string $resource = SellerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //DeleteAction::make(),
            EditAction::make()
            ->label('Change Password')
            ->schema([
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->default(null),

            ]),
        ];
    }
}
