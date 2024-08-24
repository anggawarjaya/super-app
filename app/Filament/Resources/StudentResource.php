<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\Pages\CreateStudent;
use App\Filament\Resources\StudentResource\Pages\EditStudent;
use App\Filament\Resources\StudentResource\Pages\ListStudents;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
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

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $navigationLabel = 'Mahasiswa';

    protected static ?int $navigationSort = 6;

    protected static ?string $pluralModelLabel = 'Mahasiswa';

    protected static ?string $modelLabel = 'Mahasiswa';

    protected static ?string $slug = 'mahasiswa';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profil')
                    ->schema([
                        Select::make('user_id')
                            ->label('Nama Akun Pengguna')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->noSearchResultsMessage('Akun pengguna tidak ditemukan.')
                            ->searchPrompt('Cari akun pengguna')
                            ->searchingMessage('Mencari akun pengguna...')
                            ->placeholder('Pilih Akun Pengguna')
                            ->preload()
                            ->required(),
                        Select::make('study_program_id')
                            ->label('Program Studi')
                            ->relationship('study_program', 'name')
                            ->searchable()
                            ->noSearchResultsMessage('Program Studi Tidak Ditemukan.')
                            ->searchPrompt('Cari Program Studi')
                            ->searchingMessage('Mencari Program Studi...')
                            ->placeholder('Pilih Program Studi')
                            ->preload()
                            ->required(),
                        TextInput::make('nim')
                            ->label('Nomor Induk Mahasiswa (NIM)')
                            ->required()
                            ->maxLength(10),
                    ])
                    ->compact()
                    ->columns(3),
                Section::make('Identitas')
                    ->schema([
                        DatePicker::make('tanggal_lahir')
                            ->required(),
                        Textarea::make('tempat_lahir')
                            ->required(),
                        Textarea::make('tempat_domisili')
                            ->required(),
                    ])
                    ->compact()
                    ->columns(3),
                Section::make('Pendidikan')
                    ->schema([
                        TextInput::make('sd')
                            ->maxLength(255)
                            ->label('SD/MI')
                            ->required(),
                        TextInput::make('smp')
                            ->maxLength(255)
                            ->label('SMP/MTS')
                            ->required(),
                        TextInput::make('sma_smk')
                            ->maxLength(255)
                            ->label('SMA/SMK/MA')
                            ->required(),
                        TextInput::make('ipk')
                            ->label('Indeks Prestasi Kumulatif')
                            ->numeric()
                            ->inputMode('decimal')
                            ->minValue(0.00)
                            ->maxValue(4.00)
                            ->step(0.01)
                            ->default(0.00)
                            ->required(),
                        FileUpload::make('lhs')
                            ->label('Lembar Hasil Studi')
                            ->acceptedFileTypes(['application/pdf'])    
                            ->downloadable()
                            ->directory('lhs')
                            ->maxSize(1024)
                            ->columnSpan('full')
                            ->required(),
                    ])
                    ->compact()
                    ->columns(4),
                Section::make('Media Sosial')
                    ->schema([
                        TextInput::make('wa')
                            ->maxLength(255),
                        TextInput::make('instagram')
                            ->maxLength(255),
                        TextInput::make('tiktok')
                            ->maxLength(255),
                        TextInput::make('x')
                            ->maxLength(255),
                        TextInput::make('youtube')
                            ->maxLength(255),
                        TextInput::make('facebook')
                            ->maxLength(255),
                        TextInput::make('linkedin')
                            ->maxLength(255),
                        TextInput::make('telegram')
                            ->maxLength(255),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->compact()
                    ->columns(4),
                Textarea::make('quote')
                    ->columnSpanFull(),
                Textarea::make('kompetensi')
                    ->columnSpanFull(),
                Textarea::make('testimoni')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image(),
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
                    ->label('Foto'),
                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('study_program.name')
                    ->label('Program Studi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nim')
                    ->label('NIM')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.email')
                    ->copyable()
                    ->copyMessage('Email sudah disalin')
                    ->copyMessageDuration(1500)
                    ->searchable(),  
                TextColumn::make('sd')
                    ->label('SD/MI')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('smp')
                    ->label('SMP/MTS')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sma_smk')
                    ->label('SMA/SMK/MA')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tempat_domisili')
                    ->label('Tempat Domisili')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('ipk')
                    ->label('IPK')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('instagram')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tiktok')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('youtube')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('facebook')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('linkedin')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('twitter')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('line')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('telegram')
                    ->searchable()
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
            'index' => ListStudents::route('/'),
            'create' => CreateStudent::route('/create'),
            'edit' => EditStudent::route('/{record}/edit'),
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
