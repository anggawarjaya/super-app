<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryCreationResource\Pages;
use App\Filament\Resources\CategoryCreationResource\Pages\CreateCategoryCreation;
use App\Filament\Resources\CategoryCreationResource\Pages\EditCategoryCreation;
use App\Filament\Resources\CategoryCreationResource\Pages\ListCategoryCreations;
use App\Filament\Resources\CategoryCreationResource\RelationManagers;
use App\Models\CategoryCreation;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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
use PhpParser\Node\Stmt\Label;

class CategoryCreationResource extends Resource
{
    protected static ?string $model = CategoryCreation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $navigationLabel = 'Kategori Kreativitas';

    protected static ?int $navigationSort = 7;

    protected static ?string $pluralModelLabel = 'Kategori Kreativitas';

    protected static ?string $modelLabel = 'Kategori Kreativitas';

    protected static ?string $slug = 'kategori-kreativitas';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->label('Nama Kategori Kreativitas'),
                RichEditor::make('description')
                    ->label('Deskripsi')
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
                    ]),
                FileUpload::make('image')
                    ->image()
                    ->label('Gambar')
                    ->maxSize(1024)
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '1:1',
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
                TextColumn::make('index')
                    ->rowIndex()
                    ->label('No')
                    ->width(40),
                ImageColumn::make('image')
                    ->label('Gambar'),
                TextColumn::make('name')
                    ->searchable()
                    ->label('Nama Kategori Kreatifitas'),
                TextColumn::make('slug')
                    ->copyable()
                    ->label('Link Akses'),
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
            'index' => ListCategoryCreations::route('/'),
            'create' => CreateCategoryCreation::route('/create'),
            'edit' => EditCategoryCreation::route('/{record}/edit'),
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
