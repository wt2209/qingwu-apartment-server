<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ChargeRuleResource;
use App\Models\ChargeRule;
use Illuminate\Http\Request;

class ChargeRuleController extends Controller
{
    public function index(Request $request)
    {
        $rules = ChargeRule::get();
        return ChargeRuleResource::collection($rules);
    }
}
