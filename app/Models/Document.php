<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    
    protected $fillable = [
        "numero_de_documento", "user_id", "type_request_id",
        "type_document_id", "cod_alumno",
        "numero_recibo", "monto", "estado"
    ];

}
