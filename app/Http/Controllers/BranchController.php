<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
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

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'img_path' => 'required|string|max:255',
            'user_id' => 'required|exists:users,user_id',
        ]);

        if (!$validated){
           
        }

        $branch = Branch::create($validated);

        return response()->json([
                'status' => 'success',
                'message' => 'Data has been retrieved',
                'data' => $branch,
            ], 200);

        }catch (ValidationException $e){
             return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
                'error' => $e->getMessage(),
            ], 422);

        }catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Fail to create branch',
                'error' => $e->getMessage(),
            ], 500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $branch = Branch::find($id);

        
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        //
    }
}
