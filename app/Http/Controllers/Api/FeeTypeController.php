<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\FeeTypeResource;
use App\Models\FeeType;
use Illuminate\Http\Request;

class FeeTypeController extends Controller
{
    public function index()
    {
        $types = FeeType::get();
        return FeeTypeResource::collection($types);
    }
}
