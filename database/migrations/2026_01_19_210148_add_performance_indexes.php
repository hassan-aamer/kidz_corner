<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Adding performance indexes for frequently queried columns.
     * This significantly improves query performance for filtering and sorting.
     */
    public function up(): void
    {
        // Products table indexes
        Schema::table('products', function (Blueprint $table) {
            $table->index('active', 'idx_products_active');
            $table->index('position', 'idx_products_position');
            $table->index(['category_id', 'active'], 'idx_products_category_active');
        });

        // Categories table indexes
        Schema::table('categories', function (Blueprint $table) {
            $table->index('active', 'idx_categories_active');
            $table->index('position', 'idx_categories_position');
        });

        // Orders table indexes
        Schema::table('orders', function (Blueprint $table) {
            $table->index('session_id', 'idx_orders_session');
            $table->index('status', 'idx_orders_status');
            $table->index('created_at', 'idx_orders_created');
        });

        // Carts table indexes
        Schema::table('carts', function (Blueprint $table) {
            $table->index('session_id', 'idx_carts_session');
        });

        // Cart items table indexes
        Schema::table('cart_items', function (Blueprint $table) {
            $table->index('cart_id', 'idx_cart_items_cart');
        });

        // Cities table indexes
        Schema::table('cities', function (Blueprint $table) {
            $table->index('parent_id', 'idx_cities_parent');
            $table->index('active', 'idx_cities_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_active');
            $table->dropIndex('idx_products_position');
            $table->dropIndex('idx_products_category_active');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_active');
            $table->dropIndex('idx_categories_position');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('idx_orders_session');
            $table->dropIndex('idx_orders_status');
            $table->dropIndex('idx_orders_created');
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropIndex('idx_carts_session');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropIndex('idx_cart_items_cart');
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->dropIndex('idx_cities_parent');
            $table->dropIndex('idx_cities_active');
        });
    }
};
