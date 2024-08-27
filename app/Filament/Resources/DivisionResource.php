<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DivisionResource\Pages;
use App\Filament\Resources\DivisionResource\Pages\CreateDivision;
use App\Filament\Resources\DivisionResource\Pages\EditDivision;
use App\Filament\Resources\DivisionResource\Pages\ListDivisions;
use App\Filament\Resources\DivisionResource\RelationManagers;
use App\Models\Division;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DivisionResource extends Resource
{
    protected static ?string $model = Division::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $navigationLabel = 'Divisi';

    protected static ?int $navigationSort = 9;

    protected static ?string $pluralModelLabel = 'Divisi';

    protected static ?string $modelLabel = 'Divisi';

    protected static ?string $slug = 'divisi';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('cohort_id')
                    ->relationship('cohort', 'name')
                    ->label('Angkatan')
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->label('Divisi')
                    ->maxLength(255),
                RichEditor::make('description')
                    ->toolbarButtons([
                        'bold',
                        'bulletList',
                        'orderedList',
                        'blockquote',
                        'italic',
                        'link',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->label('Deskripsi'),
                RichEditor::make('Vision')
                    ->toolbarButtons([
                        'bold',
                        'bulletList',
                        'orderedList',
                        'blockquote',
                        'italic',
                        'link',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->label('Visi'),
                RichEditor::make('mission')
                    ->toolbarButtons([
                        'bold',
                        'bulletList',
                        'orderedList',
                        'blockquote',
                        'italic',
                        'link',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->label('Misi'),
                FileUpload::make('image')
                    ->label('Gambar')
                    ->maxSize(1024*5)
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '1:1',
                        'none'
                    ])
                    ->loadingIndicatorPosition('left')
                    ->panelLayout('integrated')
                    ->removeUploadedFileButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Gambar'),
                TextColumn::make('cohort.name')
                    ->searchable()
                    ->sortable()
                    ->label('Angkatan'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Divisi'),
                TextColumn::make('slug')
                    ->searchable()
                    ->label('Link Tautan')
                    ->copyable(),
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
            ]);
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
            'index' => ListDivisions::route('/'),
            'create' => CreateDivision::route('/create'),
            'edit' => EditDivision::route('/{record}/edit'),
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
