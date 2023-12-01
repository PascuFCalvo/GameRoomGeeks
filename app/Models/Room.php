<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Room extends Model
{
   use HasFactory;

   protected $fillable = [
      'name',
      'description',
      'videogame_id',
      'room_owner_id'
   ];

   public function roomOwner(): BelongsTo
   {
      return $this->belongsTo(Member::class); //de esto tengo dudas
   }

   public function videogame(): BelongsTo
   {
      return $this->belongsTo(Videogame::class); //de esto tengo dudas
   }
}
