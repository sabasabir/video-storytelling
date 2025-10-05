<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'file_path',
        'thumbnail',
        'size',
        'status',
        'duration',
    ];

    // relation with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
