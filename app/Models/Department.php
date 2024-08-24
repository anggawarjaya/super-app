<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'faculty_id',
    ];

    public function study_programs() : HasMany 
    {
        return $this->hasMany(StudyProgram::class);
    }

    public function faculty() : BelongsTo 
    {
        return $this->belongsTo(Faculty::class);
    }
}
