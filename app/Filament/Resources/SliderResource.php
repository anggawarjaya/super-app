<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\Pages\CreateSlider;
use App\Filament\Resources\SliderResource\Pages\EditSlider;
use App\Filament\Resources\SliderResource\Pages\ListSliders;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
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

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Data Website';

    protected static ?string $navigationLabel = 'Slider';

    protected static ?int $navigationSort = 2;

    protected static ?string $pluralModelLabel = 'Slider';

    protected static ?string $modelLabel = 'Slider';

    protected static ?string $slug = 'slider';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Judul'),
                TextInput::make('sub_title')
                    ->maxLength(255)
                    ->label('Sub Judul'),
                TextInput::make('button1')
                    ->maxLength(255)
                    ->label('Tombol 1'),
                TextInput::make('button1_link')
                    ->maxLength(255)
                    ->label('Link Tombol 1'),
                TextInput::make('button2')
                    ->maxLength(255)
                    ->label('Tombol 2'),
                TextInput::make('button2_link')
                    ->maxLength(255)
                    ->label('Link Tombol 2'),
                Select::make('align')
                    ->options([
                        'text-start' => 'Kiri',
                        'text-center' => 'Tengah',
                        'text-end' => 'Kanan',
                    ])
                    ->default('text-center')
                    ->label('Perataan'),
                Select::make('theme')
                    ->options([
                        'Dark' => 'Gelap',
                        'Light' => 'Terang',
                    ])
                    ->default('Light')
                    ->label('Tema'),
                FileUpload::make('image')
                    ->image()
                    ->required()
                    ->label('Gambar')
                    ->maxSize(5120)
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        null,
                        '16:9',
                    ])
                    ->loadingIndicatorPosition('left')
                    ->panelLayout('integrated')
                    ->removeUploadedFileButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left'),
                TextInput::make('order_at')
                    ->numeric()
                    ->default(1)
                    ->label('Urutan')
                    ->required(),
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
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Judul')
                    ->description(fn ($record) => $record->sub_title),
                TextColumn::make('button1')
                    ->badge()
                    ->url(fn ($record) => url($record->button1_link))
                    ->searchable()
                    ->openUrlInNewTab()
                    ->sortable()
                    ->label('Tombol 1'),
                TextColumn::make('button2')
                    ->badge()
                    ->url(fn ($record) => url($record->button2_link))
                    ->searchable()
                    ->openUrlInNewTab()
                    ->sortable()
                    ->label('Tombol 2'),
                TextColumn::make('align')
                    ->searchable()
                    ->sortable()
                    ->label('Perataan')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('theme')
                    ->searchable()
                    ->sortable()
                    ->label('Tema')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('order_at')
                    ->sortable()
                    ->label('Urutan ke')
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ListSliders::route('/'),
            'create' => CreateSlider::route('/create'),
            'edit' => EditSlider::route('/{record}/edit'),
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
