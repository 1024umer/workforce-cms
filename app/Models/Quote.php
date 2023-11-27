<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post',
    ];
    protected $appends = ['created_at_formatted'];
    protected $with = ['image'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function image(){
        return $this->morphOne(File::class,'fileable');
    }
    public function comments(){
        return $this->hasMany(QuoteComment::class);
    }
    public function getCreatedAtFormattedAttribute(){
        return date('d M Y', strtotime($this->created_at));
    }
}
