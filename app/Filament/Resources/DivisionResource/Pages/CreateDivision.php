<?php

namespace App\Filament\Resources\DivisionResource\Pages;

use App\Filament\Resources\DivisionResource;
use App\Models\Cohort;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateDivision extends CreateRecord
{
    protected static string $resource = DivisionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $cohort = Cohort::find($data['cohort_id']);
        if ($cohort) {
            $data['slug'] = Str::slug($cohort->name) .'/'. Str::slug($data['name']);
        } else {
            $data['slug'] = Str::slug($data['name']);
        }
    
        return $data;
    }
}
