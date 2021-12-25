<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genero extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['genero', 'abreviado'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function usuarios(): HasMany {
        return $this->hasMany(Usuario::class);
    }
}
