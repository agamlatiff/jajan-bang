<?php

namespace App\Enums;

enum PaymentStatus: string
{
  case PENDING = 'pending';
  case PAID = 'paid';
  case FAILED = 'failed';
  case REFUNDED = 'refunded';

  /**
   * Get human-readable label
   */
  public function label(): string
  {
    return match ($this) {
      self::PENDING => 'Menunggu Pembayaran',
      self::PAID => 'Sudah Dibayar',
      self::FAILED => 'Gagal',
      self::REFUNDED => 'Dikembalikan',
    };
  }

  /**
   * Get color class for UI
   */
  public function color(): string
  {
    return match ($this) {
      self::PENDING => 'bg-yellow-100 text-yellow-800',
      self::PAID => 'bg-green-100 text-green-800',
      self::FAILED => 'bg-red-100 text-red-800',
      self::REFUNDED => 'bg-purple-100 text-purple-800',
    };
  }
}
