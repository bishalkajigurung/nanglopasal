<?php

namespace App\Filament\Seller\Resources\Sellers\Pages;

use App\Filament\Seller\Resources\Sellers\SellerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSellers extends ListRecords
{
    protected static string $resource = SellerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //CreateAction::make(),
        ];
    }
}
