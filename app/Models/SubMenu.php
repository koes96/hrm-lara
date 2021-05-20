<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SubMenu extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id',
        'menu_id',
        'title',
        'url'
    ];

    protected $keyType = 'string';
    //public $incrementing = false;
}
