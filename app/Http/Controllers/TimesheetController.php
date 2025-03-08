<?php

namespace App\Http\Controllers;

use App\Http\Services\TimesheetServices;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    private $timesheetServices;
    public function __construct()
    {
        $this->timesheetServices = new TimesheetServices;
    }
    public function get($id = null)
    {
        $timesheet = $this->timesheetServices->get($id);
        return response()->json(['data' => $timesheet]);
    }
    public function store(Request $request)
    {
        $project =  $this->timesheetServices->store($request);
        return response()->json(['data' => $project]);
    }
    public function update($id,Request $request)
    {
        $project =  $this->timesheetServices->update($id,$request);
        return response()->json(['data' => $project]);
    }
    public function delete($id)
    {
        $project =  $this->timesheetServices->delete($id);
        return response()->json(['data' => $project]);
    }
}
