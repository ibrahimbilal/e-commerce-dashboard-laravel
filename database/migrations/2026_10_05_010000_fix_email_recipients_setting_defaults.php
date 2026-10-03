<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $typeDefaults = [
            'new_order_recipients_type' => 'custom',
            'out_of_stock_recipients_type' => 'custom',
            'order_canceled_recipients_type' => 'custom',
        ];

        foreach ($typeDefaults as $key => $value) {
            DB::table('settings')
                ->where('setting_key', $key)
                ->where(function ($query) {
                    $query->whereNull('setting_value')
                        ->orWhere('setting_value', '');
                })
                ->update([
                    'setting_value' => $value,
                    'updated_at' => now(),
                ]);
        }

        $recipientKeys = [
            'new_order_recipients',
            'out_of_stock_recipients',
            'order_canceled_recipients',
        ];

        foreach ($recipientKeys as $key) {
            DB::table('settings')
                ->where('setting_key', $key)
                ->where(function ($query) {
                    $query->whereNull('setting_value')
                        ->orWhere('setting_value', '');
                })
                ->update([
                    'setting_value' => '[]',
                    'updated_at' => now(),
                ]);
        }

        $booleanKeys = [
            'email_new_order',
            'email_out_of_stock',
            'email_order_canceled',
            'email_order_confirmed',
            'email_order_shipped',
            'email_order_completed',
            'email_order_refunded',
        ];

        foreach ($booleanKeys as $key) {
            DB::table('settings')
                ->where('setting_key', $key)
                ->where(function ($query) {
                    $query->whereNull('setting_value')
                        ->orWhere('setting_value', '');
                })
                ->update([
                    'setting_value' => '0',
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        // Non-destructive.
    }
};
