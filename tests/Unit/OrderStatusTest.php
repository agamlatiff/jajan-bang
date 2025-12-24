<?php

namespace Tests\Unit;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use PHPUnit\Framework\TestCase;

class OrderStatusTest extends TestCase
{
  public function test_order_status_has_correct_labels(): void
  {
    $this->assertEquals('Menunggu Konfirmasi', OrderStatus::PENDING->label());
    $this->assertEquals('Sedang Diproses', OrderStatus::PREPARING->label());
    $this->assertEquals('Siap Diambil', OrderStatus::READY->label());
    $this->assertEquals('Selesai', OrderStatus::DELIVERED->label());
    $this->assertEquals('Dibatalkan', OrderStatus::CANCELLED->label());
  }

  public function test_pending_can_transition_to_confirmed(): void
  {
    $this->assertTrue(OrderStatus::PENDING->canTransitionTo(OrderStatus::CONFIRMED));
  }

  public function test_pending_can_transition_to_cancelled(): void
  {
    $this->assertTrue(OrderStatus::PENDING->canTransitionTo(OrderStatus::CANCELLED));
  }

  public function test_pending_cannot_transition_to_delivered(): void
  {
    $this->assertFalse(OrderStatus::PENDING->canTransitionTo(OrderStatus::DELIVERED));
  }

  public function test_preparing_can_transition_to_ready(): void
  {
    $this->assertTrue(OrderStatus::PREPARING->canTransitionTo(OrderStatus::READY));
  }

  public function test_delivered_cannot_transition(): void
  {
    $this->assertFalse(OrderStatus::DELIVERED->canTransitionTo(OrderStatus::PENDING));
    $this->assertFalse(OrderStatus::DELIVERED->canTransitionTo(OrderStatus::CANCELLED));
  }

  public function test_order_status_has_colors(): void
  {
    $this->assertStringContainsString('yellow', OrderStatus::PENDING->color());
    $this->assertStringContainsString('green', OrderStatus::READY->color());
    $this->assertStringContainsString('red', OrderStatus::CANCELLED->color());
  }
}
