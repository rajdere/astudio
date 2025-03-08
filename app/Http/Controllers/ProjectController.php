<?php

namespace App\Http\Controllers;

use App\Http\Services\ProjectServices;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    private $projectServices;
    public function __construct()
    {
        $this->projectServices = new ProjectServices;
    }
    public function get($id = null, Request $request)
    {
        $project = $this->projectServices->get($id, $request);
        return response()->json(['data' => $project]);
    }

    public function store(Request $request)
    {
        $project =  $this->projectServices->store($request);
        return response()->json(['data' => $project]);
    }
    public function update($id,Request $request)
    {
        $project =  $this->projectServices->update($id,$request);
        return response()->json(['data' => $project]);
    }
    public function delete($id)
    {
        $project =  $this->projectServices->delete($id);
        return response()->json(['data' => $project]);
    }
}
