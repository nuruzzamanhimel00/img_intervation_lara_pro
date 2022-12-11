<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;
    protected $fillable = ['image', 'image_type'];
    protected $table = "images";

    const BACKUP_IMAGE = 'backup_image';
    const BLUR_IMAGE = 'blur_image';

    //image store path
    const IMAGE_STORE_PATH = 'image/storage';
}
