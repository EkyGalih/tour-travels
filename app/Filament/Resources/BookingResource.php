<?php

namespace App\Filament\Resources;

use App\Enums\BookingStatus;
use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Order';
    protected static ?string $navigationGroup = 'Transactions';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('user_id')
                ->label('Pemesan')
                ->relationship('user', 'name')
                ->searchable()
                ->disabled()
                ->required(),

            Select::make('tour_id')
                ->label('Paket Tour')
                ->relationship('tour', 'title')
                ->searchable()
                ->required(),

            DatePicker::make('arrival_date')
                ->label('Tanggal Kedatangan')
                ->disabled()
                ->required(),

            TextInput::make('total_price')
                ->label('Total Harga')
                ->prefix('Rp')
                ->numeric()
                ->disabled()
                ->required(),

            Grid::make(12)
                ->schema([
                    Select::make('status')
                        ->options(BookingStatus::class)
                        ->columnSpan(6)
                        ->required(),

                    ViewField::make('proof_image')
                        ->disabled()
                        ->label('Bukti Pembayaran')
                        ->view('filament.components.payment-proof')
                        ->columnSpan(6)
                ]),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Pemesan')->searchable(),
                Tables\Columns\TextColumn::make('tour.title')->label('Paket Tour'),
                Tables\Columns\TextColumn::make('booking_date')
                    ->label('Tanggal')
                    ->date('d M Y'),
                Tables\Columns\TextColumn::make('total_price')->label('Total')->money('IDR', true),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'gray'    => 'pending',
                    'warning' => 'waiting',
                    'success' => 'approved',
                    'danger'  => 'rejected',
                    'secondary' => 'cancelled',
                    'gray'    => 'expired',
                    'info'    => 'refunded',
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
