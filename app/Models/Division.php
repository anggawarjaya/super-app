<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cohort_id',
        'name',
        'slug',
        'image',
        'description',
        'vision',
        'mission'
    ];

    public function cohort() : BelongsTo 
    {
        return $this->belongsTo(Cohort::class);
    }
}
