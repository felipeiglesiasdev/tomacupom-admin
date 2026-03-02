<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cupom extends Model
{
    use HasFactory;

    protected $connection = 'mysql_app';

    protected $table = 'cupons';

    protected $primaryKey = 'id_cupom';

    protected $fillable = [
        'id_loja',
        'titulo',
        'descricao',
        'regras',
        'codigo',
        'tipo',
        'link_redirecionamento',
        'data_inicio',
        'data_expiracao',
        'status',
    ];

    public function loja(): BelongsTo
    {
        return $this->belongsTo(Loja::class, 'id_loja', 'id_loja');
    }

    public function scopeAtivas(Builder $query): Builder
    {
        return $query->where('status', 1);
    }

    public function scopeVigentes(Builder $query): Builder
    {
        return $query->where(function (Builder $inner): void {
            $inner->whereNull('data_expiracao')->orWhereDate('data_expiracao', '>=', now()->toDateString());
        });
    }

    public function scopeExpiradas(Builder $query): Builder
    {
        return $query->whereDate('data_expiracao', '<', now()->toDateString());
    }

    public function scopeOrdenadas(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }
}
