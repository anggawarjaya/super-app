<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'study_program_id',
        'nim',
        'image',
        'sd',
        'smp',
        'sma_smk',
        'tanggal_lahir',
        'tempat_lahir',
        'tempat_domisili',
        'ipk',
        'lhs',
        'instagram',
        'tiktok',
        'youtube',
        'facebook',
        'linkedin',
        'twitter',
        'line',
        'telegram',
        'quote',
        'kompetensi',
        'testimoni',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function study_program() : BelongsTo 
    {
        return $this->belongsTo(StudyProgram::class);
    }
}
