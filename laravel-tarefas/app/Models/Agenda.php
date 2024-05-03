<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    protected $table = "agenda";
    protected $primaryKey = "id";
    protected $fillable = [
        "user_id",
        "nome",
        "descricao",
        "data_conclusao",
        "status",
        "created_at",
    ];

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }
}
