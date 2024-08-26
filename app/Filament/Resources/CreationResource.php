<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CreationResource\Pages;
use App\Filament\Resources\CreationResource\Pages\CreateCreation;
use App\Filament\Resources\CreationResource\Pages\EditCreation;
use App\Filament\Resources\CreationResource\Pages\ListCreations;
use App\Filament\Resources\CreationResource\RelationManagers;
use App\Models\Creation;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Components\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CreationResource extends Resource
{
    protected static ?string $model = Creation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Kreativitas';

    protected static ?int $navigationSort = 6;

    protected static ?string $pluralModelLabel = 'Kreativitas';

    protected static ?string $modelLabel = 'Kreativitas';

    protected static ?string $slug = 'kreativitas';

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->hidden($user->hasRole('Anggota'))
                    ->label('Nama Akun Pengguna')
                    ->required(),
                Select::make('category_creation_id')
                    ->relationship('category_creation', 'name')
                    ->label('Kategori Kreativitas')
                    ->required(),
                TextInput::make('title')
                    ->required()
                    ->label('Judul Kreativitas')
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
                FileUpload::make('image')
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
                Textarea::make('link')
                    ->label('Link Postingan')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();
        $queryModifier = function (Builder $query) {
            $user = Auth::user();
            if ($user->hasRole('Anggota')) {
                $query->where('user_id', $user->id);
            }
        };
        return $table
        ->modifyQueryUsing($queryModifier)
            ->columns([
                TextColumn::make('index')
                    ->rowIndex()
                    ->label('No')
                    ->width(40),
                ImageColumn::make('image')
                    ->label('Gambar'),
                TextColumn::make('user.name')
                    ->numeric()
                    ->hidden($user->hasRole('Anggota'))
                    ->sortable()
                    ->label('Nama Anggota'),
                TextColumn::make('category_creation.name')
                    ->label('Kategori Kreativitas')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')
                    ->searchable()
                    ->label('Judul Kreativitas'), 
                TextColumn::make('slug')
                    ->searchable()
                    ->url(fn ($record) => url($record->slug))
                    ->openUrlInNewTab()
                    ->label('Slug')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('link')
                    ->searchable()
                    ->label('Link Postingan')
                    ->url(fn ($record) => url($record->link))
                    ->openUrlInNewTab(),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->wrap()
                    ->html()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('status')
                    ->sortable()
                    ->icon(fn (string $state): string => match ($state) {
                        '0' => 'heroicon-o-clock',
                        '1' => 'heroicon-o-check-circle',
                        '2' => 'heroicon-o-x-mark',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'info',
                        '1' => 'success',
                        '2' => 'danger',
                    }),
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
                Action::make('Setujui')
                    ->label('Setujui')
                    ->button()
                    ->action(function (Creation $record): void {
                        $record->update(['status' => 1]);
                        Notification::make()
                            ->title('Status berhasil diubah menjadi 1')
                            ->success()
                            ->duration(5000)
                            ->send();
                    })
                    ->visible(fn (Creation $record) => $record->status === 0 && !auth()->user()->hasRole('Anggota'))
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
            'index' => ListCreations::route('/'),
            'create' => CreateCreation::route('/create'),
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
