<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MenuAkses extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id',
        'role_id',
        'menu_id'
    ];

    protected $keyType = 'string';
    public $incrementing = false;
}
