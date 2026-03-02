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
    // DEFINICAO DA TABELA
    // ===================================================

    protected $table = 'ofertas';

    // ===================================================
    // CHAVE PRIMARIA PERSONALIZADA
    // ===================================================

    protected $primaryKey = 'id_oferta';

    // ===================================================
    // CAMPOS ATRIBUIVEIS EM MASSA
    // ===================================================

    protected $fillable = [
        'id_loja',
        'titulo',
        'descricao',
        'link_oferta',
        'imagem_oferta',
        'data_inicio',
        'data_expiracao',
        'status',
    ];

    // ===================================================
    // RELACIONAMENTO: OFERTA PERTENCE A UMA LOJA
    // ===================================================

    public function loja(): BelongsTo
    {
        return $this->belongsTo(
            Loja::class,
            'id_loja',
            'id_loja'
        );
    }

    // ===================================================
    // SCOPE: APENAS OFERTAS ATIVAS
    // ===================================================

    public function scopeAtivas(Builder $query): Builder
    {
        return $query->where('status', 1);
    }

    // ===================================================
    // SCOPE: OFERTAS VIGENTES (NAO EXPIRADAS)
    // ===================================================

    public function scopeVigentes(Builder $query): Builder
    {
        return $query->where(function (Builder $inner): void {
            $inner
                ->whereNull('data_expiracao')
                ->orWhereDate('data_expiracao', '>=', now()->toDateString());
        });
    }

    // ===================================================
    // SCOPE: OFERTAS EXPIRADAS
    // ===================================================

    public function scopeExpiradas(Builder $query): Builder
    {
        return $query->whereNotNull('data_expiracao')
            ->whereDate('data_expiracao', '<', now()->toDateString());
    }

    // ===================================================
    // SCOPE: ORDENAR POR DATA DE CRIACAO DESC
    // ===================================================

    public function scopeOrdenadas(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }
}