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
    // DEFINICAO DA TABELA 
    // ===================================================

    protected $table = 'lojas_seo';

    // ===================================================
    // CHAVE PRIMARIA (PK = FK)
    // ===================================================

    protected $primaryKey = 'id_loja';

    // ===================================================
    // NAO E AUTO INCREMENT (PK VEM DA LOJA)
    // ===================================================

    public $incrementing = false;

    // ===================================================
    // CAMPOS ATRIBUIVEIS EM MASSA
    // ===================================================

    protected $fillable = [
        'id_loja',
        'title_seo',
        'description_seo',
        'keywords_seo',
        'text_content_seo',
    ];

    // ===================================================
    // RELACIONAMENTO: SEO PERTENCE A UMA LOJA
    // ===================================================

    public function loja(): BelongsTo
    {
        return $this->belongsTo(
            Loja::class,
            'id_loja',
            'id_loja'
        );
    }
}