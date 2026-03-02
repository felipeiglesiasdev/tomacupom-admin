<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categoria extends Model
{
    use HasFactory;

    // ===================================================
    // DEFINICAO DA CONEXAO DO BANCO DE DADOS PRINCIPAL
    // ===================================================

    protected $connection = 'mysql_dados';

    // ===================================================
    // DEFINICAO DA TABELA
    // ===================================================

    protected $table = 'categorias';

    // ===================================================
    // CHAVE PRIMARIA PERSONALIZADA
    // ===================================================

    protected $primaryKey = 'id_categoria';

    // ===================================================
    // CATEGORIAS NAO TEM created_at/updated_at
    // ===================================================

    public $timestamps = false;

    // ===================================================
    // CAMPOS ATRIBUIVEIS EM MASSA
    // ===================================================

    protected $fillable = [
        'nome',
        'slug',
    ];

    // ===================================================
    // RELACIONAMENTO N:N COM LOJAS
    // OBS: NAO USAR withTimestamps() POIS A PIVOT TEM APENAS created_at
    // ===================================================

    public function lojas(): BelongsToMany
    {
        return $this->belongsToMany(
            Loja::class,
            'loja_categoria',
            'id_categoria',
            'id_loja'
        );
    }

    // ===================================================
    // SCOPE PARA ORDENAR POR NOME
    // ===================================================

    public function scopeOrdenadas(Builder $query): Builder
    {
        return $query->orderBy('nome');
    }
}