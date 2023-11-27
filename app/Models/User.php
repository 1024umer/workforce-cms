<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $appends = ['image_url'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'favourite_color',
        'favourite_movie',
        'favourite_book',
        'favourite_animal',
        'favourite_food',
        'hobbies',
        'dream_vacation',
        'pet_peeves',
        'biggest_fear',
        'superpowers',
        'onewish',
        'talent',
        'bio',
        'is_deleted',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function image(){
        return $this->morphOne(File::class,'fileable');
    }
    public function getImageUrlAttribute(){
        if($this->image){
            return $this->image->full_url;
        }else{
            return 'https://randomuser.me/api/portraits/men/85.jpg';
        }
    }
    // protected static function booted()
    // {
    //     static::addGlobalScope('notdeleted', function (Builder $builder) {
    //         $builder->where('is_deleted', '=', 0);
    //     });
    // }
}
