<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SetupIntegration extends Model
{
    use HasFactory;

    /**
     * свойство $casts, чтобы указать,
     * что поле additionally должно обрабатываться как JSON
     */
    protected $casts = [
        'additionally' => 'json',
    ];
}
