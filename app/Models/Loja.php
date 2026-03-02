<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Loja extends Model
{
    use HasFactory;

    // ===================================================
    // DEFINICAO DA CONEXAO DO BANCO PRINCIPAL
    // ===================================================

    protected $connection = 'mysql_dados';

    // ===================================================
    // DEFINICAO DA TABELA (CASE SENSITIVE)
    // ===================================================

    protected $table = 'LOJAS';

    // ===================================================
    // CHAVE PRIMARIA PERSONALIZADA
    // ===================================================

    protected $primaryKey = 'ID_LOJA';

    // ===================================================
    // CAMPOS ATRIBUIVEIS EM MASSA
    // ===================================================

    protected $fillable = [
        'NOME',
        'SLUG',
        'TITULO_PAGINA',
        'DESCRICAO_PAGINA',
        'URL_SITE',
        'URL_BASE_AFILIADO',
        'LOGO_IMAGE_LINK',
        'ALT_TEXT_LOGO',
        'STATUS',
    ];

    // ===================================================
    // RELACIONAMENTOS
    // ===================================================

    public function seo(): HasOne
    {
        return $this->hasOne(
            LojaSeo::class,
            'ID_LOJA',
            'ID_LOJA'
        );
    }

    public function cupons(): HasMany
    {
        return $this->hasMany(
            Cupom::class,
            'ID_LOJA',
            'ID_LOJA'
        );
    }

    public function ofertas(): HasMany
    {
        return $this->hasMany(
            Oferta::class,
            'ID_LOJA',
            'ID_LOJA'
        );
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(
            Categoria::class,
            'LOJA_CATEGORIA',
            'ID_LOJA',
            'ID_CATEGORIA'
        )->withTimestamps();
    }

    // ===================================================
    // SCOPES
    // ===================================================

    public function scopeAtivas(Builder $query): Builder
    {
        return $query->where('STATUS', 1);
    }

    public function scopeOrdenadas(Builder $query): Builder
    {
        return $query->orderBy('NOME');
    }
}