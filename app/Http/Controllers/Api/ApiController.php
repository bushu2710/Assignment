<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ApiController extends Controller
{
    public function getCategories(){
        $categories = Category::all();
        if($categories){

            $response = [
                'success' => true,
                'data' => $categories,
                'message' => 'Category List'
            ];
        }
        else{
            $response = [
                'success' => false,
                'message' => 'Nothing to show'
            ];
        }
        return response($response);
    }

    public function getProducts(){
        $products = Product::all();
        if($products){

            $response = [
                'success' => true,
                'data' => $products,
                'message' => 'Product List'
            ];
        }
        else{
            $response = [
                'success' => false,
                'message' => 'Nothing to show'
            ];
        }
        return response($response);
    }

    public function productListOfCategory($categoryId){
        try{
            $products = Product::where('category', $categoryId)->get();
            
            if($products){

            $response = [
                'success' => true,
                'data' => $products,
                'message' => 'Product List'
            ];
            }
            else{
                $response = [
                    'success' => true,
                    'data' => $products,
                    'message' => "Product Doesn't Exist"
                ];
            }
        }
        catch(Exception $e){
            $response = [
                'success' => false,
                'message' => 'Something went wrong'
            ];
        }
        return response($response);
    }

    public function search(Request $request){
        $text = $request->text;


        try{
            $products = Product::where('title', 'LIKE','%'.$text.'%')->orWhere('product_desc', 'LIKE','%'.$text.'%')
            ->orWhere('status', 'LIKE','%'.$text.'%')->get();
            
            if($products){
                $response = [
                    'success' => true,
                    'data' => $products,
                    'message' => 'Product List'
                ];
            }
            else{
                $response = [
                    'success' => true,
                    'data' => $text,
                    'message' => "Product Doesn't Exist"
                ];
            }
        }
        catch(Exception $e){
            $response = [
                'success' => false,
                'message' => 'Something went wrong'
            ];
        }
        return response($response);
    }

    public function productDetails($productId){
        try{
            $productDetails = Product::find($productId);
           
            if($productDetails){
                $response = [
                    'success' => true,
                    'data' => $productDetails,
                    'message' => 'Product List'
                ];
            }
            else{
                $response = [
                    'success' => true,
                    'data' => $productDetails,
                    'message' => "Product Doesn't Exist"
                ];
            }
        }
        catch(Exception $e){
            $response = [
                'success' => false,
                'message' => 'Something went wrong'
            ];
        }
        return response($response);
    }
}
