<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\Pages\CreateContact;
use App\Filament\Resources\ContactResource\Pages\EditContact;
use App\Filament\Resources\ContactResource\Pages\ListContacts;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
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

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Data Website';

    protected static ?string $navigationLabel = 'Kontak';

    protected static ?int $navigationSort = 1;

    protected static ?string $pluralModelLabel = 'Kontak';

    protected static ?string $modelLabel = 'Kontak';

    protected static ?string $slug = 'kontak';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('address')
                    ->maxLength(255)
                    ->label('Alamat'),
                TextInput::make('map')
                    ->maxLength(255)
                    ->label('Link Google Maps'),
                TextInput::make('phone')
                    ->maxLength(20)
                    ->label('No Telepon'),
                TextInput::make('whatsapp')
                    ->maxLength(20)
                    ->label('Whatsapp'),
                TextInput::make('telegram')
                    ->maxLength(20)
                    ->label('Telegram'),
                TextInput::make('instagram')
                    ->maxLength(255)
                    ->label('Instagram'),
                TextInput::make('tiktok')
                    ->maxLength(255)
                    ->label('Tiktok'),
                TextInput::make('youtube')
                    ->maxLength(255)
                    ->label('Youtube'),
                TextInput::make('facebook')
                    ->maxLength(255)
                    ->label('Facebook'),
                TextInput::make('linkedin')
                    ->maxLength(255)
                    ->label('Linkedin'),
                TextInput::make('twitter')
                    ->maxLength(255)
                    ->label('X'),
                TextInput::make('line')
                    ->maxLength(255)
                    ->label('Line'),
                TextInput::make('fax')
                    ->maxLength(255)
                    ->label('Fax'),
                TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->label('Email'),
                TextInput::make('working_hours')
                    ->maxLength(255)
                    ->label('Jam Kerja'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('address')
                    ->label('Alamat'),
                TextColumn::make('map')
                    ->label('Link Google Maps'),
                TextColumn::make('phone')
                    ->label('No Telepon'),
                TextColumn::make('whatsapp')
                    ->label('Whatsapp')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('telegram')
                    ->label('Telegram')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('instagram')
                    ->label('Instagram')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tiktok')
                    ->label('Tiktok')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('youtube')
                    ->label('Youtube')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('facebook')
                    ->label('Facebook')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('linkedin')
                    ->label('Linkedin')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('twitter')
                    ->label('X')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('line')
                    ->label('Line')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('fax')
                    ->label('Fax')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email')
                    ->label('Email')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('working_hours')
                    ->label('Jam Kerja')
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
            'index' => ListContacts::route('/'),
            'create' => CreateContact::route('/create'),
            'edit' => EditContact::route('/{record}/edit'),
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
