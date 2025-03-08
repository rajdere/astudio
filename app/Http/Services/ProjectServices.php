<?php

namespace App\Http\Services;

use App\Models\AttributeValue;
use App\Models\project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProjectServices
{
    public function get($id = null, Request $request)
    {
        try {
            $project = Project::query();
            if (!empty($id)) {
                $project = $project->with('attributes')->where('id', $id)->first();
                return $project;
            }
            if ($request->has('filters')) {
                foreach ($request->filters as $key => $value) {
                    $project->whereHas('attributes', function ($q) use ($key, $value) {
                        $q->where('value', $value);
                    });
                }
            }

            return $project->with('attributes')->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function update($id,Request $request){
        try {
            // Find the project
            $project = Project::find($id);
            if(empty($project)){
                return "Project Not Found";
            }

            // Update project fields
            $project->update([
                'name' => $request->name ?? $project->name,
                'status' => $request->status ?? $project->status,
            ]);

            // Update or create dynamic attributes
            if (isset($request['attributes'])) {
                foreach ($request->input('attributes') as $attribute) {
                    AttributeValue::updateOrCreate(
                        [
                            'attribute_id' => $attribute['attribute_id'],
                            'entity_id' => $project->id,
                        ],
                        [
                            'value' => $attribute['value'],
                        ]
                    );
                }
            }
            return $project->load('attributes');
        }catch(Exception $e){
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'status' => 'required|string',
                'attributes' => 'array',
                'attributes.*.attribute_id' => 'required|exists:attributes,id',
                'attributes.*.value' => 'required',
            ]);

            $project = Project::create($request->only('name', 'status'));

            foreach ($request->input('attributes') as $attribute) {
                AttributeValue::create([
                    'attribute_id' => $attribute['attribute_id'],
                    'entity_id' => $project->id,
                    'value' => $attribute['value'],
                ]);
            }

            return $project->load('attributes');
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }catch (Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function delete($id){
        try{
            $project = Project::find($id);
            if(empty($project)){
                return "Project Not Found";
            }
            // Delete associated attribute values
            AttributeValue::where('entity_id', $project->id)->delete();

            // Delete the project
            $project->delete();
            return "deleted";
        }catch (Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
