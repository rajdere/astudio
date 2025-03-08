<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'status'];
    protected $with = ['attributes'];

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    public function attributes()
    {
        return $this->hasMany(AttributeValue::class, 'entity_id');
    }
}
