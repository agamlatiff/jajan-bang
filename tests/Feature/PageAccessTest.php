<?php

namespace Tests\Feature;

use App\Models\Barcode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageAccessTest extends TestCase
{
  use RefreshDatabase;

  protected function setUp(): void
  {
    parent::setUp();

    // Create a test barcode/table
    Barcode::create([
      'table_number' => 'A1',
      'qr_code' => 'test-qr-code',
    ]);
  }

  public function test_scan_page_is_accessible(): void
  {
    $response = $this->get('/scan');
    $response->assertStatus(200);
  }

  public function test_home_redirects_without_table_number(): void
  {
    $response = $this->get('/');
    // Should redirect to scan page if no table number in session
    $response->assertRedirect('/scan');
  }

  public function test_home_accessible_with_table_number_in_session(): void
  {
    $response = $this->withSession(['table_number' => 'A1'])
      ->get('/');

    $response->assertStatus(200);
  }

  public function test_order_tracking_page_accessible(): void
  {
    $response = $this->get('/track-order');
    $response->assertStatus(200);
  }

  public function test_kitchen_dashboard_accessible(): void
  {
    $response = $this->get('/kitchen');
    $response->assertStatus(200);
  }

  public function test_cart_redirects_without_table(): void
  {
    $response = $this->get('/cart');
    $response->assertRedirect('/scan');
  }

  public function test_checkout_redirects_without_table(): void
  {
    $response = $this->get('/checkout');
    $response->assertRedirect('/scan');
  }
}
