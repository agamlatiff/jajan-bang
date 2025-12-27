<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionItemsResource\Pages\ListTransactionItems;
use App\Filament\Resources\TransactionResource\Pages;
use App\Enums\OrderStatus;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Support\Htmlable;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Pesanan';

    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?int $navigationSort = 1;

    public static function getGloballySearchableAttributes(): array
    {
        return ['code', 'name', 'phone'];
    }

    public static function getRecordTitle(?Model $record): string|Htmlable|null
    {
        return $record->name;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('external_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('checkout_link')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('barcodes_id')
                    ->label("QR Code")
                    ->image()
                    ->directory("qr_code")
                    ->disk("public")
                    ->default(function ($record) {
                        return $record->barcodes->image ?? null;
                    }),
                Forms\Components\TextInput::make('payment_method')
                    ->required(),
                Forms\Components\TextInput::make('payment_status')
                    ->required(),
                Forms\Components\TextInput::make('subtotal')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('ppn')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label("Transaction Code")
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label("Customer Name")
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label("Phone Number")
                    ->searchable(),
                Tables\Columns\ImageColumn::make('barcodes.image')
                    ->label("Barcode"),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label("Payment Method")
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label("Payment Status")
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'SETTLED', 'PAID', 'SUCCESS' => 'success',
                        'PENDING' => 'warning',
                        'FAILED', 'EXPIRED' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\SelectColumn::make('order_status')
                    ->label("Order Status")
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'preparing' => 'Preparing',
                        'ready' => 'Ready',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->selectablePlaceholder(false),
                Tables\Columns\TextColumn::make('subtotal')
                    ->label("Subtotal")
                    ->numeric()
                    ->money("IDR"),
                Tables\Columns\TextColumn::make('ppn')
                    ->label("PPN")
                    ->numeric()
                    ->money("IDR"),
                Tables\Columns\TextColumn::make('total')
                    ->label("Total")
                    ->numeric()
                    ->money("IDR"),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Created At")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label("Updated At")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('payment_status')
                    ->options([
                        'PENDING' => 'Pending',
                        'SETTLED' => 'Settled/Paid',
                        'FAILED' => 'Failed',
                        'EXPIRED' => 'Expired',
                    ])
                    ->label('Payment Status'),
                SelectFilter::make('order_status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'preparing' => 'Preparing',
                        'ready' => 'Ready',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->label('Order Status'),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from')->label('Dari Tanggal'),
                        DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['from'] ?? null) {
                            $indicators['from'] = 'Dari: ' . $data['from'];
                        }
                        if ($data['until'] ?? null) {
                            $indicators['until'] = 'Sampai: ' . $data['until'];
                        }
                        return $indicators;
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make("See transaction")
                    ->color("success")
                    ->url(
                        fn(Transaction $record): string => static::getUrl("transaction-items.index", [
                            "parent" => $record->id
                        ])
                    )
            ])
            ->bulkActions([
                BulkAction::make('updateStatus')
                    ->label('Update Status')
                    ->icon('heroicon-o-arrow-path')
                    ->form([
                        Select::make('order_status')
                            ->label('Status Baru')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'preparing' => 'Preparing',
                                'ready' => 'Ready',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                    ])
                    ->action(function (Collection $records, array $data): void {
                        $records->each(function ($record) use ($data) {
                            $record->update(['order_status' => $data['order_status']]);
                        });
                    })
                    ->deselectRecordsAfterCompletion(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
            // It might mistake in this route 
            "transaction-items.index" => ListTransactionItems::route("/{record}/items")
        ];
    }
}
