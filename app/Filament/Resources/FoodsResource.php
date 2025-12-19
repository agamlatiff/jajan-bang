<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FoodsResource\Pages;
use App\Models\Foods;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FoodsResource extends Resource
{
    protected static ?string $model = Foods::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory("foods")
                    ->disk("public")
                    ->required()
                    ->maxSize(2048) // 2MB in KB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->helperText('Format: JPG, PNG, WEBP. Maksimal ukuran file: 2 MB')
                    ->validationMessages([
                        'max' => 'Ukuran file terlalu besar! Maksimal 2 MB.',
                    ])
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->columnSpanFull()
                    ->prefix("Rp")
                    ->reactive(),
                Forms\Components\Toggle::make('is_promo')
                    ->reactive(),
                Forms\Components\Select::make('percent')
                    ->options([
                        10 => "10%",
                        25 => "25%",
                        35 => "35%",
                        50 => "50%",
                    ])->columnSpanFull()
                    ->reactive()
                    ->hidden(fn($get) => !$get("is_promo"))
                    ->afterStateUpdated(function ($set, $get, $state) {
                        if ($get("is_promo") && $get("price") && $get("percent")) {
                            $discount = ($get("price") * (int) $get("percent")) / 100;
                            $set("price_afterdiscount", $get("price") - $discount);
                        } else {
                            $set("price_afterdiscount", $get("price"));
                        }
                    }),
                Forms\Components\TextInput::make('price_afterdiscount')
                    ->numeric()
                    ->prefix("Rp")
                    ->readOnly()
                    ->columnSpanFull()
                    ->hidden(fn($get) => !$get("is_promo")),
                Forms\Components\Select::make('categories_id')
                    ->relationship("categories", "name")
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')->disk("public"),
                Tables\Columns\TextColumn::make('price')
                    ->sortable()->money("IDR"),
                Tables\Columns\TextColumn::make('price_afterdiscount')
                    ->sortable()->money("IDR"),
                Tables\Columns\TextColumn::make('percent')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_promo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('categories.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListFoods::route('/'),
            'create' => Pages\CreateFoods::route('/create'),
            'edit' => Pages\EditFoods::route('/{record}/edit'),
        ];
    }
}
