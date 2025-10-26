<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $query = Products::where('user_id', $user->id);

            // Search by name or description
            $search = request()->query('search');
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('description', 'like', "%$search%");
                });
            }

            // Pagination
            $perPage = (int) request()->query('per_page', 10);
            $products = $query->paginate($perPage)->appends(request()->query());

            if ($products->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'No products found',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data has been retrieved.',
                'data' => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       try{
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'description' => 'required|string',
                'price' => 'required|numeric|between:0,999999.99',
                'user_id' => 'required|exists:users,id',
            ]);


            $product = Products::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Product has been added successfully',
                'data'=> $product,
            ], 201);

       }catch (ValidationException $e){ 

            return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'error' => $e->getMessage(),
                ], 422);

       }catch (\Exception $e){

            return response()->json([
                'status' => 'error',
                'message' => 'Product has not been added',
                'error' => $e->getMessage(),
            ], 500);
       }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            
            $user = Auth::user();

            $product = Products::where('product_id', $id)->where('user_id', $user->id)->get()->first();

            if(!$product){
                return response()->json([
                    'status' => 'error',
                    'error'=> 'Product does not exist',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message'=> 'Product has been retrieved',
                'data' => $product
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message'=> 'Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $product)
    {
        try {
            $validated = $request->validate([
                'name' => 'nullable|string|max:100',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric|between:0,999999.99',
                'user_id' => 'nullable|exists:users,id'
            ]);

            // Only update fields that were actually provided
            $product->update(array_filter($validated, function($value) {
                return $value !== null;
            }));

            return response()->json([
                'status' => 'success',
                'message' => 'Product has been updated',
                'data' => $product->fresh()
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'error' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $user = Auth::user();

             $product = Products::where('product_id', $id)
             ->where('user_id', $user->id)->get()->first();

            if(!$product){
                return response()->json([
                    'status' => 'error',
                    'error'=> 'Data does not exist',
                ], 404);
            }

            $product->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Product has been deleted',
                'data' => $product
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete product',
                'error' => $e
            ], 500);
        }
    }
}
