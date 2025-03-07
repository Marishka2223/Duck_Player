<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bb extends Model
{
   protected $fillable = ['title', 'content', 'price', 'status','user_id'];
   
   public function user(){
      return $this->belongsTo(User::class);
   }
}
