<?php

namespace App\Filament\Seller\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('discount')
                    ->required()
                    ->label("Discount %")
                    ->numeric()
                    ->suffix('%')
                    ->default('0'),
                RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
                // Toggle::make('stock')
                //    ->required(),
                //TextInput::make('seller_id')
                //   ->required()
                //    ->numeric(),

                Repeater::make("product_varients")
                    ->label('Varients')
                    ->columnSpanFull()
                    ->grid(2)
                    ->relationship('productVarients')
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        TextInput::make('price')
                            ->numeric()
                            ->prefix('Rs.')
                            ->required(),
                        FileUpload::make('image')
                            ->multiple()
                            ->required(),
                    ]),
            ]);
    }
}
