<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\Catch_;

class BranchController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $userId = Auth::user()->id;

            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'address' => 'required|string|max:255',
                'img_path' => 'required|string|max:255',
            ]);

            $branch = Branch::create($validated + ['user_id' => $userId]);

            return response()->json([
                'status' => 'success',
                'message' => 'Branch has been created.',
                'data' => $branch
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials.',
                'error' => $e,
            ], 422);
        } catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add branch.',
                'error' => $e,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();

            $branch = Branch::where('user_id', $user->id)->get();

            if($branch->isEmpty()){
                return response()->json([
                    'status' => 'success',
                    'error' => 'Data not found or does not exist',
            ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data has been successfully retrieved',
                'data' => $branch,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data has been successfully retrieved',
                'data' => $e,
            ], 200);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        try {
            $validated = $request->validate([
                'name' => 'nullable|string|max:100',
                'address' => 'nullable|string|max:255',
                'img_path' => 'nullable|string|max:255',
            ]);

            $branch->update(array_filter($validated, function($value){
                return $value !== null;
            }));

            return response()->json([
                'status' => 'success',
                'message' => 'Data has been successfully retrieved',
                'data' => $branch,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials',
                'error' => $e,
            ], 422);
        } catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials',
                'error' => $e,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Branch $branch)
    // {
    //     $user = Auth::user();

    //     $branch = 


    // }
}
