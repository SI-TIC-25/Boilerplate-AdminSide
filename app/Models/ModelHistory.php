<?php

namespace App\Models;

use App\Traits\HasHistory;
use Illuminate\Database\Eloquent\Model;

class ModelHistory extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'before',
        'after',
        'action',
        'user_id'
    ];

    protected $casts = [
        'before' => 'array',
        'after' => 'array',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  // <—
    }
}
