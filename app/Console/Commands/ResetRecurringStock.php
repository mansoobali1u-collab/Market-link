<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:reset-recurring-stock')]
#[Description('Reset stock quantities for all recurring products')]
class ResetRecurringStock extends Command
{
    
    public function handle()
    {
        Product::where('is_recurring', true)->update([
            'stock_quantity' => DB::raw('default_stock_quantity'),
            'is_available' => true,
        ]);

        $this->info('Recurring stock has been reset.');
    }
}
