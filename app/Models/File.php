<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class File extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'uid'
    ];

    protected static function booted()
    {
        static::creating(function ($file) {
            if (empty($file->uid)) {
                $file->uid = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}