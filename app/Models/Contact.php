<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'address',
        'phone',
        'instagram',
        'tiktok',
        'youtube',
        'linkedin',
        'twitter',
        'line',
        'telegram',
        'whatsapp',
        'map',
        'fax',
        'email',
        'working_hours',
    ];
}
