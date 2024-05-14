<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Models\Bill;
use App\Models\Sold;
use App\Models\Stocks;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Validation\ValidationException;

class BillController extends Controller
{
    public function bill(){
        $userId = Auth::id();

    // Retrieve bills associated with the current user
    $userBills = Bill::where('user_id', $userId)->get();
    $Products = Products::where('user_id', $userId)->get();

    // You can pass $userBills to your view or process it further as needed
    return view('Bill', ['userBills' => $userBills,'Products'=>$Products]);
    }
   
public function getUpdatedBill()
{
    // Retrieve the updated bill data (you can adjust this based on your actual logic)
    $updatedBill = Bill::where('user_id', Auth::id())->get();

    return response()->json(['updatedBill' => $updatedBill]);
}
public function addToBill(Request $request)
{
    try {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = Auth::id();
        $product = Products::find($request->input('product_id'));

        $existingBill = Bill::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($existingBill) {
            return response()->json(['error' => 'Product already in the bill']);
        }

        $bill =  Bill::create([
            'user_id' => $userId,
            'product_id' => $product->id,
            'product_name' => $product->Name,
            'product_price' => $product->SalePrice,
            'product_quantity' => 1,
        ]);

        $bill->save();

        return response()->json(['success' => 'Product added to the bill successfully']);
    } catch (ValidationException $e) {
        return response()->json(['error' => $e->getMessage()], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}

    
public function sell(Request $request)
{
    // Get the currently authenticated user (cashier)
    $user = auth()->user();

    // Get all items in the current bill for the user
    $itemsInBill = $user->bills;

    // Start a database transaction
    DB::beginTransaction();

    try {
        // Loop through each item in the bill and update the products table
        foreach ($itemsInBill as $item) {
            // Find the product associated with the item in the bill
            $product = Products::find($item->product_id);

            // Check if the product exists
            if ($product) {
                // Subtract the quantity from the oldest non-zero stock entries for the product
                $remainingQuantity = $item->product_quantity;

                $stocks = Stocks::where('product_id', $item->product_id)
                    ->where('product_quantity', '>', 0)
                    ->orderBy('created_at')
                    ->get();

                foreach ($stocks as $stock) {
                    // Fetch the price from the current stock entry
                    $priceToAdd = $stock->product_price;

                    // Check if the price is greater than zero before processing
                    if ($priceToAdd > 0) {
                        // Subtract the quantity from the current stock entry
                        $quantityToSubtract = min($remainingQuantity, $stock->product_quantity);

                        // Update the quantity in the stocks table
                        $stock->product_quantity -= $quantityToSubtract;
                        $stock->save();

                        // Update the quantity in the products table
                        $product->Quantity -= $quantityToSubtract;
                        $product->save();

                        // Attempt to locate an existing row in the sold table
                        $existingSoldProduct = Sold::where('product_id', $item->product_id)
                            ->where('user_id', $user->id)
                            ->first();

                        // Calculate profit based on the difference between sale price and stock price
                        $profit = ($product->SalePrice - $priceToAdd) * $quantityToSubtract;
                        \Log::info('SalePrice: ' . $product->SalePrice);
                        \Log::info('PriceToAdd: ' . $priceToAdd);
                        \Log::info('QuantityToSubtract: ' . $quantityToSubtract);
                        \Log::info('Calculated Profit: ' . $profit);

                        // If an existing row is found, update it; otherwise, insert a new row
                       
                            // Add the price to the sold table
                            Sold::create([
                                'product_id' => $item->product_id,
                                'user_id' => $user->id,
                                'product_name' => $item->product_name,
                                'product_price' => $product->SalePrice * $quantityToSubtract,
                                'product_quantity' => $quantityToSubtract,
                                'Profit' => $profit,
                            ]);
                       

                        // Update the quantity left to subtract
                        $remainingQuantity -= $quantityToSubtract;

                        // If no remaining quantity, break out of the loop
                        if ($remainingQuantity == 0) {
                            break;
                        }
                    }
                }

                // Remove the item from the bill
                $item->delete();
            } else {
                // Handle the case where there is no product found
                throw new \Exception('No product found for the item in the bill.');
            }
        }

        // Commit the transaction
        DB::commit();

        // Generate and stream the PDF
        return view('receipt', ['itemsInBill' => $itemsInBill]);
      
    } catch (\Exception $e) {
        // If an error occurs, rollback the transaction
        DB::rollBack();

        // Handle the error (you might want to log it or display an error message)
        return redirect()->back()->with('error', $e->getMessage());
    }
}







public function deleteBill($billId)
{
    $bill = Bill::find($billId);

    if ($bill) {
        $bill->delete();

        return redirect()->back()->with('success', 'Bill item deleted successfully.');
    } else {
        return redirect()->back()->with('error', 'Bill not found.');
    }
}
public function updateQuantity(Request $request)
{
    $productId = $request->input('Id');
    $quantity = $request->input('quantity');
    $Product=Bill::find($productId);
    if($Product){
        $Product->product_quantity=$quantity;
        $Product->save();
        return response()->json(['message' => 'Quantity updated successfully']);
    } else {
        return response()->json(['message' => 'Product not found'], 404);
    }
}
}