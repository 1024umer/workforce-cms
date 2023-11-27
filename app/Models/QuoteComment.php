<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'quote_id',
        'comment',
    ];
    protected $appends = ['created_at_formatted'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function getCreatedAtFormattedAttribute(){
        return date('l, F d, Y \a\t h:i a', strtotime($this->created_at));
    }
}
