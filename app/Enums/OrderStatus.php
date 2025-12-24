<?php

namespace App\Enums;

enum OrderStatus: string
{
  case PENDING = 'pending';
  case CONFIRMED = 'confirmed';
  case PREPARING = 'preparing';
  case READY = 'ready';
  case DELIVERED = 'delivered';
  case CANCELLED = 'cancelled';

  /**
   * Get human-readable label
   */
  public function label(): string
  {
    return match ($this) {
      self::PENDING => 'Menunggu Konfirmasi',
      self::CONFIRMED => 'Dikonfirmasi',
      self::PREPARING => 'Sedang Diproses',
      self::READY => 'Siap Diambil',
      self::DELIVERED => 'Selesai',
      self::CANCELLED => 'Dibatalkan',
    };
  }

  /**
   * Get color class for UI
   */
  public function color(): string
  {
    return match ($this) {
      self::PENDING => 'bg-yellow-100 text-yellow-800',
      self::CONFIRMED => 'bg-blue-100 text-blue-800',
      self::PREPARING => 'bg-orange-100 text-orange-800',
      self::READY => 'bg-green-100 text-green-800',
      self::DELIVERED => 'bg-gray-100 text-gray-800',
      self::CANCELLED => 'bg-red-100 text-red-800',
    };
  }

  /**
   * Get icon for status
   */
  public function icon(): string
  {
    return match ($this) {
      self::PENDING => 'clock',
      self::CONFIRMED => 'check-circle',
      self::PREPARING => 'fire',
      self::READY => 'bell',
      self::DELIVERED => 'check-double',
      self::CANCELLED => 'x-circle',
    };
  }

  /**
   * Check if order can transition to given status
   */
  public function canTransitionTo(OrderStatus $status): bool
  {
    return match ($this) {
      self::PENDING => in_array($status, [self::CONFIRMED, self::CANCELLED]),
      self::CONFIRMED => in_array($status, [self::PREPARING, self::CANCELLED]),
      self::PREPARING => in_array($status, [self::READY, self::CANCELLED]),
      self::READY => in_array($status, [self::DELIVERED]),
      self::DELIVERED, self::CANCELLED => false,
    };
  }

  /**
   * Get next possible statuses
   */
  public function nextStatuses(): array
  {
    return match ($this) {
      self::PENDING => [self::CONFIRMED, self::CANCELLED],
      self::CONFIRMED => [self::PREPARING, self::CANCELLED],
      self::PREPARING => [self::READY, self::CANCELLED],
      self::READY => [self::DELIVERED],
      self::DELIVERED, self::CANCELLED => [],
    };
  }
}
