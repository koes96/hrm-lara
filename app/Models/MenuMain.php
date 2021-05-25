<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MenuMain extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id',
        'menu',
        'judul',
        'icon'
    ];

    public $keyType = 'string';
    // public $incrementing = false;
}
