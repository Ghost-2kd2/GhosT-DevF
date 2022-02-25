<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

   protected $fillable =[
       'plant_id',
       'image_name',
       'image_path',
   ];
}