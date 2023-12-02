<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
   use HasFactory;

   protected $fillable = [
      "name",
      'videogame_id',
      'room_owner'
   ];

   protected $attributes = [
      'name' => '', // 
      'videogame_id' => 1,
   ];

   protected $table = 'room';

   public function roomOwner(): BelongsTo
   {
      // to do : esta relacion es con user
      return $this->belongsTo(Member::class); //de esto tengo dudas 
   }

   public function videogame(): BelongsTo
   {
      return $this->belongsTo(Videogame::class); //de esto tengo dudas
   }

   public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'members');
    }
}
