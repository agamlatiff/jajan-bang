<?php

namespace Database\Seeders;

use App\Models\Barcode;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarcodeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $admin = User::first();

    if (!$admin) {
      $this->command->error('No user found. Please run UserSeeder first.');
      return;
    }

    $tableCodes = [
      'A1001',
      'A1002',
      'A1003',
      'B2001',
      'B2002',
      'B2003',
      'C3001',
      'C3002',
      'C3003',
      'D4001',
      'D4002',
      'D4003',
      'H9751',
      'T5188',
    ];

    // Ensure qr_codes directory exists
    Storage::disk('public')->makeDirectory('qr_codes');

    foreach ($tableCodes as $code) {
      $host = '127.0.0.1:8000/' . $code;
      $svgFilePath = 'qr_codes/' . $code . '.svg';

      // Generate SVG QR code
      $svgContent = QrCode::format('svg')->margin(1)->size(200)->generate($host);
      Storage::disk('public')->put($svgFilePath, $svgContent);

      Barcode::firstOrCreate(
        ['table_number' => $code],
        [
          'users_id' => $admin->id,
          'image' => $svgFilePath,
          'qr_value' => $host,
        ]
      );
    }

    $this->command->info('Barcode seeder completed with QR code images generated.');
  }
}
