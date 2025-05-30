<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'image_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
