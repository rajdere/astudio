<?php

namespace App\Http\Controllers;

use App\Http\Services\AttributeServices;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    private $attributeServices;
    public function __construct()
    {
        $this->attributeServices = new AttributeServices;
    }
    public function get($id = null)
    {
        $attribute = $this->attributeServices->get($id);
        return response()->json(['data' => $attribute],200);
    }
    public function store(Request $request)
    {
        $project =  $this->attributeServices->store($request);
        return response()->json(['data' => $project],200);
    }
    public function update($id,Request $request)
    {
        $project =  $this->attributeServices->update($id,$request);
        return response()->json(['data' => $project],200);
    }
    public function delete($id)
    {
        $project =  $this->attributeServices->delete($id);
        return response()->json(['data' => $project],200);
    }
}
