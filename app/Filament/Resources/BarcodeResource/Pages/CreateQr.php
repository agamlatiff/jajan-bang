<?php

namespace App\Filament\Resources\BarcodeResource\Pages;

use App\Filament\Resources\BarcodeResource;
use Filament\Resources\Pages\Page;

class CreateQr extends Page
{
  protected static string $resource = BarcodeResource::class;
  protected static string $view = "filament.resources.barcode-resource.pages.create.create-qr";
  
  public $table_number;
  
  public function mount(): void {
    $this->form->fill();
    $this->table_number = strtoupper(chr(rand(65,90)) . rand(1000,9999));
  }

}