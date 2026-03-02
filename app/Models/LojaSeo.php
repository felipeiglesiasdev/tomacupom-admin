<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LojaSeo extends Model
{
    use HasFactory;

    // ===================================================
    // DEFINICAO DA CONEXAO DO BANCO PRINCIPAL
    // ===================================================

    protected $connection = 'mysql_dados';

    // ===================================================
    // DEFINICAO DA TABELA (CASE SENSITIVE)
    // ===================================================

    protected $table = 'LOJAS_SEO';

    // ===================================================
    // CHAVE PRIMARIA (PK = FK)
    // ===================================================

    protected $primaryKey = 'ID_LOJA';

    // ===================================================
    // NAO E AUTO INCREMENT (PK VEM DA LOJA)
    // ===================================================

    public $incrementing = false;

    // ===================================================
    // CAMPOS ATRIBUIVEIS EM MASSA
    // ===================================================

    protected $fillable = [
        'ID_LOJA',
        'TITLE_SEO',
        'DESCRIPTION_SEO',
        'KEYWORDS_SEO',
        'TEXT_CONTENT_SEO',
    ];

    // ===================================================
    // RELACIONAMENTO: SEO PERTENCE A UMA LOJA
    // ===================================================

    public function loja(): BelongsTo
    {
        return $this->belongsTo(
            Loja::class,
            'ID_LOJA',
            'ID_LOJA'
        );
    }
}