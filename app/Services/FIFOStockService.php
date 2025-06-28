<?php

namespace App\Services;

use App\Models\ItemPurchase;
use App\Models\ItemConsumptionLog;
use App\Models\ProductItemConsumptionLog;
use App\Models\Item;
use Illuminate\Support\Facades\Log;

class FIFOStockService
{
    public function processStockConsumption($itemId, $requestedQuantity, $product, $item)
    {
        // We already have the item object passed in

        // Get all purchases with remaining stock in FIFO order
        $purchases = ItemPurchase::where('item_id', $item->id)
            ->where('remaining_quantity', '>', 0)
            ->orderBy('purchase_date')
            ->get();

        // Check total available stock
        $totalAvailableStock = $purchases->sum('remaining_quantity');
        
        if ($totalAvailableStock < $requestedQuantity) {
            throw new \Exception('Insufficient stock available');
        }

        $consumedQuantity = 0;
        $totalCost = 0;
        $consumptionDetails = [];

        // Process each purchase in FIFO order
        foreach ($purchases as $purchase) {
            if ($consumedQuantity >= $requestedQuantity) break;

            $available = $purchase->remaining_quantity;
            $toConsume = min($available, $requestedQuantity - $consumedQuantity);

            if ($toConsume > 0) {
                // Calculate cost for this batch
                $batchCost = $purchase->purchase_price * $toConsume;
                
                // Update remaining quantity
                ItemPurchase::where('id', $purchase->id)
                    ->decrement('remaining_quantity', $toConsume);

                $totalCost += $batchCost;
                $consumedQuantity += $toConsume;

                // Store consumption details
                $consumptionDetails[] = [
                    'item_purchase_id' => $purchase->id,
                    'quantity' => $toConsume,
                    'unit_price' => $purchase->purchase_price,
                    'total_cost' => $batchCost,
                    'item_id' => $item->id,
                    'product_id' => $product->id,
                    'unit_cost' => $purchase->purchase_price,
                    'notes' => "Consumed for product: {$product->name}"
                ];
            }
        }

        // Verify we consumed the exact quantity
        if ($consumedQuantity != $requestedQuantity) {
            throw new \Exception('Error in stock consumption calculation');
        }

        // Log all consumptions
        foreach ($consumptionDetails as $detail) {
            Log::info( 'helper' .  json_encode($detail));

            ItemConsumptionLog::create($detail);
        }

        return [
            'total_cost' => $totalCost,
            'consumption_details' => $consumptionDetails
        ];
    }

    public function returnStock($itemId, $quantity)
    {
        // Get all purchases for this item in FIFO order
        $purchases = ItemPurchase::where('item_id', $itemId)
            ->orderBy('purchase_date')
            ->get();

        // Calculate how much to return to each purchase
        $remainingQuantity = $quantity;
        foreach ($purchases as $purchase) {
            if ($remainingQuantity <= 0) break;
            
            // Calculate how much we can return to this purchase
            $toReturn = min($remainingQuantity, $purchase->quantity - $purchase->remaining_quantity);
            
            if ($toReturn > 0) {
                ItemPurchase::where('id', $purchase->id)
                    ->increment('remaining_quantity', $toReturn);
                
                $remainingQuantity -= $toReturn;
            }
        }
    }
}
