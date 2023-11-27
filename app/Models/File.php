<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $appends = ['full_url','created_at_formatted', 'created_at_formatted_sec'];
    protected $fillable = [
        'url', 'fileable_id', 'fileable_type', 'table_name', 'original_name',
    ];
    public function fileable()
    {
        return $this->morphTo();
    }
    public function getFullUrlAttribute()
    {
        return env('IMAGE_URL', asset('storage')).'/'.($this->url);
    }
    public function getCreatedAtFormattedAttribute(){
        return date('Y-m-d h:i a',strtotime($this->created_at));
    }
    public function getCreatedAtFormattedSecAttribute(){
        return date('l, F d, Y \a\t h:i a', strtotime($this->created_at));
    }
}