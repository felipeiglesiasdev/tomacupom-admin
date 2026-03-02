<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categoria extends Model
{
    use HasFactory;

    protected $connection = 'mysql_app';

    protected $table = 'categorias';

    protected $primaryKey = 'id_categoria';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'slug',
    ];

    public function lojas(): BelongsToMany
    {
        return $this->belongsToMany(Loja::class, 'loja_categoria', 'id_categoria', 'id_loja')
            ->withTimestamps();
    }

    public function scopeOrdenadas(Builder $query): Builder
    {
        return $query->orderBy('nome');
    }
}
