<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $user = Auth::user();

            $orders = Order::where('user_id', $user->id);

            $search = request()->query('search');

            $orders->where('status', 'ilike', '%$search%');

            if($orders->isEmpty()){
                return response()->json([
                    'status' => 'error',
                    'error' => 'Order not found',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Product has been successfully retrieved',
                'data' => $orders
                ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server Error',
                'error' => $e,
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
                
            $userId = Auth::user()->id;

            $validated = $request->validate([
                'total_price' => 'required|numeric|between: 0, 999999.99',
                'status' => 'required|string|max:100',
            ]);

            $createdOrder = Order::create($validated + ['user_id' => $userId]);

            return response()->json([
                'status' => 'success',
                'message' => 'Order has been added',
                'data' => $createdOrder,
            ], 201);

        } catch (ValidationException $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
                'error' => $e->getMessage(),
            ], 422);

        } catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Server Error',
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

            $userId = Auth::user()->id;

            $order = Order::where('order_id', $id)->where('user_id', $userId)->get()->first();

            if ($order->isEmpty()){
                return response()->json([
                    'status' => 'error',
                    'error' => 'Invalid credentials',
                ], 404);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Order has been retrieved successfully',
                'data' => $order,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server Error',
                'data' => $e,
            ], 500);
        }   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        try {

            $userId = Auth::user()->id;

            $validated = $request->validate([
                'total_price' => 'nullable|numeric|between:0,999999.99',
                'status' => 'nullable|string|max:100',
            ]);

            $order->update(array_filter($validated, function($value){
                return $value !== null;
            }));
            
            return response()->json([
                'status' => 'success',
                'message' => 'Order has been updated',
                'data' => $order,
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials',
                'data' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Server Error',
                'data' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $order = Order::where('order_id', $id)->first();

            if($order->isEmpty()){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data not found',
                ], 404);
            }

            $order->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data has been deleted',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server Error',
                'error' => $e,
            ], 500);
        }
    }
}
