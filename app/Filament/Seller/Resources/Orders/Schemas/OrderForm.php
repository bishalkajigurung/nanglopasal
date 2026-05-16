<?php

namespace App\Filament\Seller\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'processing' => 'Processing',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
        ])
                    ->default('pending')
                    ->required(),
                TextInput::make('payment_status')
                    ->required()
                    ->default('pending'),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('seller_id')
                    ->required()
                    ->numeric(),
                Select::make('payment_method')
                    ->options(['cod' => 'Cod', 'khalti' => 'Khalti'])
                    ->required(),
            ]);
    }
}
