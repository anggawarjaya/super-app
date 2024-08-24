<?php

namespace App\Filament\Resources\CreationResource\Pages;

use App\Filament\Resources\CreationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCreations extends ListRecords
{
    protected static string $resource = CreationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
