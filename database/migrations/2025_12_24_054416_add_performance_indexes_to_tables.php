<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Index for foods table - frequently joined with categories
        Schema::table('foods', function (Blueprint $table) {
            $table->index('categories_id', 'idx_foods_categories');
        });

        // Composite index for transactions - frequently filtered by status and date
        Schema::table('transactions', function (Blueprint $table) {
            $table->index(['payment_status', 'created_at'], 'idx_transactions_payment_status_date');
            $table->index('order_status', 'idx_transactions_order_status');
        });

        // Indexes for transaction_items - foreign keys
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->index('transaction_id', 'idx_transaction_items_transaction');
            $table->index('foods_id', 'idx_transaction_items_foods');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foods', function (Blueprint $table) {
            $table->dropIndex('idx_foods_categories');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex('idx_transactions_payment_status_date');
            $table->dropIndex('idx_transactions_order_status');
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropIndex('idx_transaction_items_transaction');
            $table->dropIndex('idx_transaction_items_foods');
        });
    }
};
