<?php

namespace App\Models;

use App\Traits\HasHistory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasHistory;
    protected $table = 'posts';
    protected $fillable = [
        'title',
        'desc',
        'category_id',

        'created_by',
        'updated_by',
    ];

    public function categories() {
        return $this->belongsTo(Type::class, 'category_id');
    }

    public function thumbnail()
    {
        return $this->hasOne(File::class, 'refid');
    }
}
