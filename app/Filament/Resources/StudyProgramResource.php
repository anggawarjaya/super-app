<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudyProgramResource\Pages;
use App\Filament\Resources\StudyProgramResource\Pages\CreateStudyProgram;
use App\Filament\Resources\StudyProgramResource\Pages\EditStudyProgram;
use App\Filament\Resources\StudyProgramResource\Pages\ListStudyPrograms;
use App\Filament\Resources\StudyProgramResource\RelationManagers;
use App\Models\StudyProgram;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudyProgramResource extends Resource
{
    protected static ?string $model = StudyProgram::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $navigationLabel = 'Program Studi';

    protected static ?int $navigationSort = 4;

    protected static ?string $pluralModelLabel = 'Program Studi';

    protected static ?string $modelLabel = 'Program Studi';

    protected static ?string $slug = 'program-studi';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('department_id')
                    ->relationship('department', 'name')
                    ->required()
                    ->label('Jurusan'),
                TextInput::make('name')
                    ->required()
                    ->label('Program Studi')
                    ->placeholder('Ilmu Komputer')
                    ->unique()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('department.faculty.name')
                    ->label('Fakultas')
                    ->sortable()
                    ->searchable()
                    ->visibleFrom('md'),
                TextColumn::make('department.name')
                    ->label('Jurusan')
                    ->sortable()
                    ->searchable()
                    ->visibleFrom('md'),
                TextColumn::make('name')
                    ->label('Program Studi')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diubah pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label('Dihapus pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->striped();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudyPrograms::route('/'),
            'create' => CreateStudyProgram::route('/create'),
            'edit' => EditStudyProgram::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
