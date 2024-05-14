<?php

namespace App\Http\Controllers;


use App\Models\Stocks;
use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    
     public function Detail($id){
        $stocks = Stocks::where('product_id', $id)->get();
        $image=Products::find($id);

        
    
        return view('ProductDetail', ['stocks' => $stocks],['image'=>$image]);
     }
    public function store(Request $request)
    {
        do {
            $randomNumber = rand(100000000, 999999999);
        } while (Products::where('Product_Code', $randomNumber)->exists());
        // Validate the incoming data (adjust the validation rules as needed)
        $Price = (int) $request->input('price');
        $Sales=(int)$request->input('Sprice');
        $quantity = $request->input('quantity');
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('Images'), $imageName);
        // Create a new products record
        $products = Products::create([
            'user_id' => auth()->user()->id,
            'Name' => $request->input('name'),
            'Quantity'=>$request->input('quantity') ,// Replace with actual customer value
            'Price' => $Price,
            'SalePrice'=>$Sales,
           
             // Replace with actual status value
           
            'Product_Code' => $randomNumber, // Replace with actual details value
            'ProductImage'=> 'Images/' . $imageName,
           
        
        
        ]);
        $Stocks=Stocks::create([
            'product_id'=>$products->id,
            'product_name' => $request->input('name'),
            'product_quantity'=>$request->input('quantity') ,// Replace with actual customer value
            'product_price' => $Price,
            'product_SalePrice'=>$Sales,

        ]);
        
        // Redirect to a success page or return a response as needed
        return redirect()->back()->with('success', 'Item has been successfully saved.');;
        
    }
    public function destroy($id)
    {
        // Find the Products record by its ID
        $product = Products::find($id);
    
        if ($product) {
            // Delete the associated images
            if ($product->ProductImage) {
                $imagePath = public_path($product->ProductImage);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
    
           
            // Delete the Products record from the database
            $product->delete();
    
            // Redirect with a success message
            return redirect()->back()->with('success', 'Item has been deleted successfully.');
        }
    
        // Handle the case where the Products with the given $id is not found
        return redirect()->back()->with('error', 'Item not found.');
    }
    
    public function update(Request $request, Products $tail)
{
    // Find the Products by its ID (assuming you have the model binding set up in your routes)
    $product = Products::find($request->id);

    // Check if the Products with the given ID exists
    if (!$product) {
        // Handle the case where the Products with the given $id is not found.
        // You can return an error message or redirect as needed.
        return redirect()->back()->with('error', 'Products not found.');
    }

    // Check if the 'Unique_Password' provided matches the currently authenticated user's 'Unique_Password'
    if ($request->unique_password != auth()->user()->Unique_Password) {
        // Handle the case where the Unique_Password doesn't match.
        // You can return an error message or redirect as needed.
        return redirect()->back()->with('error', 'Incorrect $produc.');
    }

    // Check if a new image file is provided
    if ($request->hasFile('image')) {
        // Delete the previous image
        $previousImage = public_path($product->ProductImage);
        if (file_exists($previousImage)) {
            unlink($previousImage);
        }

        // Handle the new image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('Images'), $imageName);

        // Update the 'Product_Image' field with the new image path
        $product->ProductImage = 'Images/' . $imageName;
    }

    // Update the other fields directly
    $product->Price = (int) $request->input('price');
    $product->SalePrice=(int) $request->input('Sprice');
    $product->Quantity += $request->input('quantity');
    $product->Name = $request->input('name');
 // Update historical arrays
 $Stocks=Stocks::create([
    'product_id'=>$product->id,
    'product_name' => $request->input('name'),
    'product_quantity'=>$request->input('quantity') ,// Replace with actual customer value
    'product_price' => $request->input('price'),
    'product_SalePrice'=>(int)$request->input('Sprice'),

]);


    // Save the changes to the database
    $product->save();
    

    // Redirect with a success message
    return redirect()->back()->with('success', 'Item has been updated successfully.');
}

    
public function edit1($id)
{
   $Products=Products::find($id);
   if($Products){
    return response()->json([
        'status'=>200,
        'Products'=>$Products,

    ]);}
    else{
        return response()->json([
            'status'=>404,
            'Products'=>"Data not found",
    
        ]);
    }
   
}
public function getTotalQuantity($productId)
    {
        $product = Products::find($productId);

        if ($product) {
            $totalQuantity = $product->Quantity;
            return response()->json(['totalQuantity' => $totalQuantity]);
        }

        return response()->json(['error' => 'Product not found'], 404);
    }
    public function Barcode(){
        
        $user = auth()->user();

    // Retrieve only the data for the authenticated user
    $Data = Products::where('user_id', $user->id)->get();

    
        return view('PrintBarcode',['Data' => $Data]);
    }
    
}
