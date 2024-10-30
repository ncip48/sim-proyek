<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $activeNavigationIcon = 'heroicon-s-user-group';

    protected static ?string $navigationLabel = 'User';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->autofocus()
                    ->maxLength(255)
                    ->placeholder(__('Name'))
                    ->autocomplete('off')
                    ->rules('required')
                    ->validationMessages([
                        'required' => 'The :attribute is required.',
                    ])
                    ->columnSpan('full')
                    ->markAsRequired(),
                Forms\Components\TextInput::make('email')
                    ->rules(['required', 'email'])
                    ->maxLength(255)
                    ->placeholder(__('Email'))
                    ->autocomplete('off')
                    ->columnSpan('full')
                    ->markAsRequired(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->minLength(8)
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(
                        fn($state) => filled($state)
                    )
                    ->required(fn(string $context): bool => $context === 'create')
                    ->columnSpan('full')
                    ->placeholder(__('Password')),
                Forms\Components\Select::make('role')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->options([
                        '1' => 'Super Admin',
                        '2' => 'Admin',
                    ])
                    ->columnSpan('full')
                    ->label('Role')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('#')
                    ->weight('bold')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'success',
                        '2' => 'blue',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        '1' => 'Super Admin',
                        '2' => 'Admin',
                    })
                    ->badge(),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                // ->label('Hapus')
                // ->successNotificationTitle(fn() => __('User berhasil dihapus')),
                // Tables\Actions\ForceDeleteAction::make(),
                // Tables\Actions\RestoreAction::make(),
            ])
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //         // Tables\Actions\ForceDeleteBulkAction::make(),
            //         // Tables\Actions\RestoreBulkAction::make(),
            //     ]),
            // ])
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
