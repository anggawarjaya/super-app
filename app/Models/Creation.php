<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Creation extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_creation_id',
        'slug',
        'title',
        'description',
        'image',
        'link',
        'n_like',
        'status',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function category_creation() : BelongsTo 
    {
        return $this->belongsTo(CategoryCreation::class);
    }
}
