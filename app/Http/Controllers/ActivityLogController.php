<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityLogFilterRequest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(ActivityLogFilterRequest $request){

        $query = ActivityLog::query();
        $query = $request->filled('entity_id') ? $query->where('entity_id' , $request->entity_id) : $query;
        $query = $request->filled('entity_type') ? $query->where('entity_type' , $request->entity_type) : $query;
        $query = $request->filled('action_type') ? $query->where('action_type' , $request->action_type) : $query;
        $query = $request->filled('sort') ? $query->orderBy('created_at' , $request->sort) : $query;

        return response()->json([
            'success' => true,
            'logs' => $query->paginate(10)
        ]);
    }
}
