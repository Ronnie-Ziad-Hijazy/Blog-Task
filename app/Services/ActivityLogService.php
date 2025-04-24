<?php


namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogService
{
    public static function log($action, $entityType, $entityId, $changedFields = null)
    {
        $exists = ActivityLog::where([
            'action_type' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
        ])->whereDate('created_at', now()->toDateString())->exists();
    
        if ($exists) {
            return;
        }
    
        // Save log
        ActivityLog::create([
            'action_type' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'changed_fields' => $changedFields,
        ]);
    }
}