<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = ['user_id','token'];

    public function getRouteKeyName()
    {
      return 'token';
    }

    public static function generateToken(User $user){
      return static::create([
        'user_id' => $user->id,
        'token' => str_random(50)
      ]);
    }
    public function user()
    {
      return $this->belongsTo('App\User');
    }
}
