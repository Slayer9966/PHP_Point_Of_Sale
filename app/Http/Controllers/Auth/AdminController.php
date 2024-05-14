<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;




class AdminController extends Controller
{
    
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'unique'=>['required']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'Text_Password'=>$request->password,
            'Unique_Password' => $request->unique,
        ]);

      

     

        return redirect()->back();
    }

    public function destroy($id)
    {
        // Find the Products record by its ID
        $user = User::find($id);
    
      
           
            // Delete the Products record from the database
            $user->delete();
    
            // Redirect with a success message
            return redirect()->back()->with('success', 'User has been deleted successfully.');
        }
    public function changePassword(Request $request){
           if($request->un==auth()->user()->Unique_Password){
            $user = User::find($request->id);
           }
    }

    public function edit2($id)
{
   $User=User::find($id);
   if($User){
    return response()->json([
        'status'=>200,
        'User'=>$User,

    ]);}
    else{
        return response()->json([
            'status'=>404,
            'Products'=>"Data not found",
    
        ]);
    }
   
}
public function update(Request $request)
{
    // Find the Products by its ID (assuming you have the model binding set up in your routes)
    $user = User::find($request->id);

    // Check if the Products with the given ID exists
   

    // Check if the 'Unique_Password' provided matches the currently authenticated user's 'Unique_Password'
    if ($request->un != auth()->user()->Unique_Password) {
      
        return redirect()->back()->with('error', 'Incorrect unique password');
    }

    
  

    // Update the other fields directly
    $user->password =  Hash::make($request->password);
    $user->Text_Password =  $request->input('password');
    
    
    
 // Update historical arrays
 

    // Save the changes to the database
    $user->save();
    

    // Redirect with a success message
    return redirect()->back()->with('success', 'Item has been updated successfully.');
}

public function UserLogin($id){
    $user = User::find($id);
    Auth::login($user);
    return view('cashier');
}
}
