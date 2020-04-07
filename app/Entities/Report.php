<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['file_path', 'created_by'];
    protected $perPage = 10;

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getExtensionAttribute()
    {
        return explode('.', $this->file_path)[1];
    }

    public function getFilePrefixAttribute()
    {
        return explode('_', $this->file_path)[0] . $this->id;
    }

    public function getFileNameAttribute()
    {
        return $this->file_prefix . '.' . $this->extension;
    }
}
