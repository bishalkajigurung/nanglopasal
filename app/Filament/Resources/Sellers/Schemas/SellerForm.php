<?php

namespace App\Filament\Resources\Sellers\Schemas;

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
                TextInput::make('password')
                    ->password()
                    ->default(null),
                TextInput::make('shop_name')
                    ->required(),
                TextInput::make('khalti_secret_key')
                    ->default(null),
                Select::make('status')
                    ->options(['active' => 'Active', 'pending' => 'Pending', 'inactive' => 'Inactive'])
                    ->default('pending')
                    ->required(),
                DatePicker::make('expire_date'),
                TextInput::make('contact')
                    ->required(),
            ]);
    }
}
