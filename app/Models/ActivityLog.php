<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

         /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'action_type',
        'changed_fields',
        'entity_type',
        'entity_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'changed_fields' => 'array',
        'entity_id' => 'int'
    ];

    /**
     * Get changed_fields Array 
     * 
     * Accessor (getter)
     * 
     * @return void
     */
    public function getChangedFieldsAttribute(){
        return json_decode($this->attributes['changed_fields'] , true);
    }

    /**
     * Set changed_fields json
     * 
     * Mutator (setter)
     * 
     * @param [type] $data
     *
     * @return void
     */
    public function setChangedFieldsAttribute($data){
        $this->attributes['changed_fields'] = json_encode($data);
    }

}
