<?php

namespace App\Http\Services;

use App\Models\Attribute;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AttributeServices
{
    public function get($id = null)
    {
        try {
            $attribute = Attribute::query();
            if (!empty($id)) {
                $attribute = $attribute->where('id', $id)->first();
                return $attribute;
            } 
            return $attribute->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function store(Request $data) {
        try {
            $data->validate([
                'name' => 'required|string',
                'type' => 'required|string|in:text,date,number,select',
            ]);
            return Attribute::create($data->all());
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Update an existing attribute
    public function update($id, Request $data) {
        try {
            $attribute = Attribute::find($id);
            
            if(empty($attribute)){
                return "Attribute Not Found";
            }
            $attribute->update($data->all());
            return $attribute;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Delete an attribute
    public function delete($id) {
        try {
            $attribute = Attribute::find($id);
            
            if(empty($attribute)){
                return "Attribute Not Found";
            }
            $attribute->delete();
            return "deleted";
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
