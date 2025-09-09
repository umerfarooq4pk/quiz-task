<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['user_id', 'correct', 'wrong', 'skipped'];
    public function user() {
        return $this->belongsTo(User::class);
    }
}
