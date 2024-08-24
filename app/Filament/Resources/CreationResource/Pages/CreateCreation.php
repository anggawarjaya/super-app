<?php

namespace App\Filament\Resources\CreationResource\Pages;

use App\Filament\Resources\CreationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateCreation extends CreateRecord
{
    protected static string $resource = CreationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        $userName = auth()->user()->name;

        $data['slug'] = Str::slug($userName . '-' . $data['title']);
    
        return $data;
    }
}
