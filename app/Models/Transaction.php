<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Transaction extends Model
{
    use HasFactory;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['order_status', 'payment_status'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Transaksi {$eventName}");
    }

    protected $fillable = [
        'invoice_number',
        'customer_name',
        'customer_phone',
        'table_number',
        'total_price',
        'payment_method',
        'payment_status',
        'order_status',
        'midtrans_order_id',
    ];

    protected $casts = [
        'order_status' => OrderStatus::class,
        'payment_status' => PaymentStatus::class,
    ];

    public function barcodes()
    {
        return $this->belongsTo(Barcode::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItems::class, "transaction_id");
    }

    /**
     * Update order status with transition check
     */
    public function updateOrderStatus(OrderStatus $newStatus): bool
    {
        if ($this->order_status && !$this->order_status->canTransitionTo($newStatus)) {
            return false;
        }

        $this->order_status = $newStatus;
        $this->save();

        // TODO: Dispatch event for real-time updates
        // event(new OrderStatusUpdated($this));

        return true;
    }

    /**
     * Check if order is active (not completed or cancelled)
     */
    public function isActive(): bool
    {
        return !in_array($this->order_status, [
            OrderStatus::DELIVERED,
            OrderStatus::CANCELLED,
        ]);
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->order_status, [
            OrderStatus::PENDING,
            OrderStatus::CONFIRMED,
        ]);
    }

    /**
     * Scope for active orders
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('order_status', [
            OrderStatus::DELIVERED->value,
            OrderStatus::CANCELLED->value,
        ]);
    }

    /**
     * Scope for today's orders
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Get formatted total price
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }
}
