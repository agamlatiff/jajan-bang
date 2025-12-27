<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorAuth extends Page implements HasForms
{
  use InteractsWithForms;

  protected static ?string $navigationIcon = 'heroicon-o-shield-check';

  protected static string $view = 'filament.pages.two-factor-auth';

  protected static ?string $navigationLabel = 'Two-Factor Auth';

  protected static ?string $title = '🔐 Two-Factor Authentication';

  protected static ?string $navigationGroup = 'Keamanan';

  protected static ?int $navigationSort = 100;

  public ?string $code = '';
  public ?string $qrCodeSvg = null;
  public ?string $secret = null;
  public bool $is2FAEnabled = false;

  public function mount(): void
  {
    $user = auth()->user();
    $this->is2FAEnabled = $user->two_factor_enabled ?? false;

    if (!$this->is2FAEnabled) {
      $google2fa = new Google2FA();
      $this->secret = $user->two_factor_secret ?: $google2fa->generateSecretKey();

      // Generate QR Code
      $qrCodeUrl = $google2fa->getQRCodeUrl(
        config('app.name'),
        $user->email,
        $this->secret
      );

      $renderer = new ImageRenderer(
        new RendererStyle(200),
        new SvgImageBackEnd()
      );
      $writer = new Writer($renderer);
      $this->qrCodeSvg = $writer->writeString($qrCodeUrl);

      // Save secret (not enabled yet)
      if (!$user->two_factor_secret) {
        $user->update(['two_factor_secret' => $this->secret]);
      }
    }
  }

  public function enable2FA(): void
  {
    $user = auth()->user();
    $google2fa = new Google2FA();

    if ($google2fa->verifyKey($user->two_factor_secret, $this->code)) {
      $user->update(['two_factor_enabled' => true]);
      $this->is2FAEnabled = true;

      Notification::make()
        ->title('2FA Aktif!')
        ->success()
        ->body('Two-Factor Authentication berhasil diaktifkan.')
        ->send();
    } else {
      Notification::make()
        ->title('Kode Salah')
        ->danger()
        ->body('Kode verifikasi tidak valid. Silakan coba lagi.')
        ->send();
    }
  }

  public function disable2FA(): void
  {
    $user = auth()->user();
    $user->update([
      'two_factor_enabled' => false,
      'two_factor_secret' => null,
    ]);
    $this->is2FAEnabled = false;
    $this->secret = null;
    $this->qrCodeSvg = null;

    Notification::make()
      ->title('2FA Dinonaktifkan')
      ->warning()
      ->body('Two-Factor Authentication telah dinonaktifkan.')
      ->send();

    $this->redirect(static::getUrl());
  }

  public static function canAccess(): bool
  {
    return auth()->check();
  }
}
