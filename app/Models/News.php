<?php

namespace App\Models;

use App\Traits\HasHistory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasHistory;
    protected $table = 'news';
    protected $fillable = [
        'judul',
        'desk',
        'kategori_id',

        'created_by',
        'updated_by',
    ];

    public function categories() {
        return $this->belongsTo(Type::class, 'kategori_id');
    }

    public function cover()
    {
        return $this->hasOne(File::class, 'refid');
    }
}
