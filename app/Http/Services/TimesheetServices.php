<?php

namespace App\Http\Services;

use App\Models\Timesheet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TimesheetServices
{
    public function get($id = null)
    {
        try {
            $timesheet = Timesheet::query();
            if (!empty($id)) {
                $timesheet = $timesheet->where('id', $id)->first();
                return $timesheet;
            } 
            return $timesheet->get();
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
                'task_name' => 'required|string',
                'date' => 'required|string',
                'user_id' => 'required',
                'project_id' => 'required',
                'hours' => 'required'
            ]);
            return Timesheet::create($data->all());
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

    // Update an existing timesheet
    public function update($id, Request $data) {
        try {
            $timesheet = Timesheet::find($id);
            
            if(empty($timesheet)){
                return "Timesheet Not Found";
            }
            $timesheet->update($data->all());
            return $timesheet;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Delete an timesheet
    public function delete($id) {
        try {
            $timesheet = Timesheet::find($id);
            
            if(empty($timesheet)){
                return "Timesheet Not Found";
            }
            $timesheet->delete();
            return "deleted";
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
