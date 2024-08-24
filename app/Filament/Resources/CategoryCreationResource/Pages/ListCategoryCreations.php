<?php

namespace App\Filament\Resources\CategoryCreationResource\Pages;

use App\Filament\Resources\CategoryCreationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryCreations extends ListRecords
{
    protected static string $resource = CategoryCreationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
