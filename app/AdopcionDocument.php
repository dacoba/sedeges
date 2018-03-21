<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdopcionDocument extends Model
{
    protected $table = 'adopcion_documents';
    protected $fillable = [
        'name', 'type', 'mime', 'size', 'file', 'solicitud_id',
    ];
}
