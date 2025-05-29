<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderItem::create([
            'order_id' => '01jweaz5p8fcbpx1s8kxah1ctq',
            'product_id' => '01jwedd4fmwgp50zjm75jp2tns',
            'quantity' => '34',
            'price' => '98347834'
        ]);
    }
}
