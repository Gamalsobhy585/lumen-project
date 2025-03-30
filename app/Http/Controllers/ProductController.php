<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
   
    public function index()
    {
        $products= Product::all()->limit(10);
        return response()->json($products);
    }

   
    public function create ( Request $request)
    {
        $this->validate($request(), [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required',
        ]);
        $product = new Product();
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        if($request->hasFile('photo')) {

            $allowedfileExtension=['pdf','jpg','png'];
            $file = $request->file('photo');
            $extenstion = $file->getClientOriginalExtension();
            $check = in_array($extenstion, $allowedfileExtension);
    
            if($check){
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $product->photo = $name;
            }
            }
        $product->save();
        return response()->json(['message' => 'Product created successfully', 'product' => $product]);
    }

   


    
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);

    }

    
  

   
    public function update(Request $request, $id)
    {
        $this->validate($request(), [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required',
        ]);
        $product = Product::find($id);
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        if($request->hasFile('photo')) {

            $allowedfileExtension=['pdf','jpg','png'];
            $file = $request->file('photo');
            $extenstion = $file->getClientOriginalExtension();
            $check = in_array($extenstion, $allowedfileExtension);
    
            if($check){
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $product->photo = $name;
            }
            }
            


        $product->save();
        return response()->json(['message' => 'Product Updated successfully', 'product' => $product]);


    }

    
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
