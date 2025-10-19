<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = ['class_id','student_id','status','enrolled_at'];
    public function class() { return $this->belongsTo(ClassModel::class, 'class_id'); }
    public function student() { return $this->belongsTo(User::class, 'student_id'); }
}
