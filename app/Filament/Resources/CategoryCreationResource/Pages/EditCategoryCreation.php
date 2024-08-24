<?php

namespace App\Filament\Resources\CategoryCreationResource\Pages;

use App\Filament\Resources\CategoryCreationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryCreation extends EditRecord
{
    protected static string $resource = CategoryCreationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
