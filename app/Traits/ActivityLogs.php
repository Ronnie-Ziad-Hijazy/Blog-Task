<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait ActivityLogs
{
    protected static function bootActivityLogs()
    {
        static::created(function ($model) {
            $model->logActivity('CREATE');
        });

        static::updated(function ($model) {
            $model->logActivity('UPDATE', $model->getChangeDetails());
        });

        static::deleted(function ($model) {
            $model->logActivity('DELETE');
        });

        static::retrieved(function ($model) {
            $model->logActivity('READ');
        });
    }

    public function logActivity($action, $changes = null)
    {
        ActivityLog::create([
            'entity_type' => class_basename($this),
            'entity_id' => $this->id,
            'action_type' => $action,
            'changed_fields' => $changes ?? null,
        ]);
    }

    /**
     * Get Changes Details
     *
     * @return void
     */
    protected function getChangeDetails(){
        $changes = $this->getChanges(); // changed fields only
        $original = $this->getOriginal(); // old values before update

        $formatted = [];
        foreach ($changes as $key => $newValue) {
            if($key === 'updated_at') continue;

            $formatted["{$key}_old"] = $original[$key] ?? null;
            $formatted["{$key}_new"] = $newValue;
        }

        return $formatted;
    }
}
