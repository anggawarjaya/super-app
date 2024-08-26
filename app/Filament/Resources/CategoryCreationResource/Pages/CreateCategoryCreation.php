<?php

namespace App\Filament\Resources\CategoryCreationResource\Pages;

use App\Filament\Resources\CategoryCreationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateCategoryCreation extends CreateRecord
{
    protected static string $resource = CategoryCreationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = Str::slug($data['name']);
    
        return $data;
    }
}
