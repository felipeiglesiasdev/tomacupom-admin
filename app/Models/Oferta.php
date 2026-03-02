<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Oferta extends Model
{
    use HasFactory;

    // ===================================================
    // DEFINICAO DA CONEXAO DO BANCO PRINCIPAL
    // ===================================================

    protected $connection = 'mysql_dados';

    // ===================================================
    // DEFINICAO DA TABELA (CASE SENSITIVE)
    // ===================================================

    protected $table = 'OFERTAS';

    // ===================================================
    // CHAVE PRIMARIA PERSONALIZADA
    // ===================================================

    protected $primaryKey = 'ID_OFERTA';

    // ===================================================
    // CAMPOS ATRIBUIVEIS EM MASSA
    // ===================================================

    protected $fillable = [
        'ID_LOJA',
        'TITULO',
        'DESCRICAO',
        'LINK_OFERTA',
        'IMAGEM_OFERTA',
        'DATA_INICIO',
        'DATA_EXPIRACAO',
        'STATUS',
    ];

    // ===================================================
    // RELACIONAMENTO: OFERTA PERTENCE A UMA LOJA
    // ===================================================

    public function loja(): BelongsTo
    {
        return $this->belongsTo(
            Loja::class,
            'ID_LOJA',
            'ID_LOJA'
        );
    }

    // ===================================================
    // SCOPE: APENAS OFERTAS ATIVAS
    // ===================================================

    public function scopeAtivas(Builder $query): Builder
    {
        return $query->where('STATUS', 1);
    }

    // ===================================================
    // SCOPE: OFERTAS VIGENTES (NAO EXPIRADAS)
    // ===================================================

    public function scopeVigentes(Builder $query): Builder
    {
        return $query->where(function (Builder $inner): void {
            $inner
                ->whereNull('DATA_EXPIRACAO')
                ->orWhereDate('DATA_EXPIRACAO', '>=', now()->toDateString());
        });
    }

    // ===================================================
    // SCOPE: OFERTAS EXPIRADAS
    // ===================================================

    public function scopeExpiradas(Builder $query): Builder
    {
        return $query->whereDate('DATA_EXPIRACAO', '<', now()->toDateString());
    }

    // ===================================================
    // SCOPE: ORDENAR POR DATA DE CRIACAO DESC
    // ===================================================

    public function scopeOrdenadas(Builder $query): Builder
    {
        return $query->orderByDesc('CREATED_AT');
    }
}