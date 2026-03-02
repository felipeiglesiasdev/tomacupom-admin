<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LojaSeo extends Model
{
    use HasFactory;

    // ===================================================
    // CONFIGURACAO BASE
    // ===================================================
    protected $connection = 'mysql_app';

    protected $table = 'lojas_seo';

    protected $primaryKey = 'id_loja';

    public $incrementing = false;

    protected $fillable = [
        'id_loja',
        'title_seo',
        'description_seo',
        'keywords_seo',
        'text_content_seo',
    ];

    // ===================================================
    // RELACIONAMENTOS
    // ===================================================
    public function loja(): BelongsTo
    {
        return $this->belongsTo(Loja::class, 'id_loja', 'id_loja');
    }
}
