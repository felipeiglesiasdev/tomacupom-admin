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
    // CONFIGURACAO BASE
    // ===================================================
    protected $connection = 'mysql_app';

    protected $table = 'lojas';

    protected $primaryKey = 'id_loja';

    protected $fillable = [
        'nome',
        'slug',
        'titulo_pagina',
        'descricao_pagina',
        'url_site',
        'url_base_afiliado',
        'logo_image_link',
        'alt_text_logo',
        'status',
    ];

    // ===================================================
    // RELACIONAMENTOS
    // ===================================================
    public function seo(): HasOne
    {
        return $this->hasOne(LojaSeo::class, 'id_loja', 'id_loja');
    }

    public function cupons(): HasMany
    {
        return $this->hasMany(Cupom::class, 'id_loja', 'id_loja');
    }

    public function ofertas(): HasMany
    {
        return $this->hasMany(Oferta::class, 'id_loja', 'id_loja');
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(Categoria::class, 'loja_categoria', 'id_loja', 'id_categoria')
            ->withTimestamps();
    }

    // ===================================================
    // SCOPES
    // ===================================================
    public function scopeAtivas(Builder $query): Builder
    {
        return $query->where('status', 1);
    }

    public function scopeOrdenadas(Builder $query): Builder
    {
        return $query->orderBy('nome');
    }
}
