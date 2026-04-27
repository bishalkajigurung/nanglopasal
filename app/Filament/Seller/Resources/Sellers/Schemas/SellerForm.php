<?php

namespace App\Filament\Seller\Resources\Sellers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SellerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('shop_name')
                    ->required(),
                TextInput::make('khalti_secret_key')
                    ->default(null),
                TextInput::make('contact')
                    ->required(),
            ]);
    }
}
