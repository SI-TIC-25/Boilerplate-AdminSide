<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $table = 'sessions_class';

    protected $fillable = [
        'class_id',
        'topic',
        'session_date',
        'duration_minutes',
    ];

    protected $casts = [
        'session_date' => 'datetime',
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
