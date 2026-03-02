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
    // DEFINICAO DA TABELA (CASE SENSITIVE)
    // ===================================================

    protected $table = 'CATEGORIAS';

    // ===================================================
    // CHAVE PRIMARIA PERSONALIZADA
    // ===================================================

    protected $primaryKey = 'ID_CATEGORIA';

    // ===================================================
    // TABELA POSSUI TIMESTAMPS? NAO (NAO EXISTE UPDATED_AT)
    // ===================================================

    public $timestamps = false;

    // ===================================================
    // CAMPOS QUE PODEM SER ATRIBUIDOS EM MASSA
    // ===================================================

    protected $fillable = [
        'NOME',
        'SLUG',
    ];

    // ===================================================
    // RELACIONAMENTO N:N COM LOJAS
    // ===================================================

    public function lojas(): BelongsToMany
    {
        return $this->belongsToMany(
            Loja::class,
            'LOJA_CATEGORIA',
            'ID_CATEGORIA',
            'ID_LOJA'
        )->withTimestamps();
    }

    // ===================================================
    // SCOPE PARA ORDENAR POR NOME
    // ===================================================

    public function scopeOrdenadas(Builder $query): Builder
    {
        return $query->orderBy('NOME');
    }
}