<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_app';

    public function up(): void
    {
        Schema::connection($this->connection)->create('lojas', function (Blueprint $table): void {
            $table->id('id_loja');
            $table->string('nome', 150);
            $table->string('slug', 160)->unique();
            $table->string('titulo_pagina', 255);
            $table->string('descricao_pagina', 255);
            $table->string('url_site', 255)->nullable();
            $table->string('url_base_afiliado', 255)->nullable();
            $table->string('logo_image_link', 255)->nullable();
            $table->string('alt_text_logo', 255)->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->index('status');
            $table->index('nome');
        });

        Schema::connection($this->connection)->create('lojas_seo', function (Blueprint $table): void {
            $table->unsignedBigInteger('id_loja')->primary();
            $table->text('title_seo')->nullable();
            $table->text('description_seo')->nullable();
            $table->text('keywords_seo')->nullable();
            $table->longText('text_content_seo')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->foreign('id_loja')->references('id_loja')->on('lojas')->cascadeOnDelete();
        });

        Schema::connection($this->connection)->create('cupons', function (Blueprint $table): void {
            $table->id('id_cupom');
            $table->foreignId('id_loja')->constrained('lojas', 'id_loja')->cascadeOnDelete();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->text('regras')->nullable();
            $table->string('codigo', 50)->nullable();
            $table->unsignedTinyInteger('tipo')->default(1);
            $table->string('link_redirecionamento', 255)->nullable();
            $table->date('data_inicio')->nullable();
            $table->date('data_expiracao')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->index(['id_loja', 'status']);
            $table->index(['id_loja', 'data_expiracao']);
            $table->index(['status', 'data_expiracao']);
            $table->index('data_expiracao');
            $table->index('codigo');
        });

        Schema::connection($this->connection)->create('ofertas', function (Blueprint $table): void {
            $table->id('id_oferta');
            $table->foreignId('id_loja')->constrained('lojas', 'id_loja')->cascadeOnDelete();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->string('link_oferta', 255);
            $table->string('imagem_oferta', 255)->nullable();
            $table->date('data_inicio')->nullable();
            $table->date('data_expiracao')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->index(['id_loja', 'status']);
            $table->index(['id_loja', 'data_expiracao']);
            $table->index(['status', 'data_expiracao']);
            $table->index('data_expiracao');
        });

        Schema::connection($this->connection)->create('categorias', function (Blueprint $table): void {
            $table->id('id_categoria');
            $table->string('nome', 100);
            $table->string('slug', 120)->unique();
            $table->index('nome');
        });

        Schema::connection($this->connection)->create('loja_categoria', function (Blueprint $table): void {
            $table->foreignId('id_loja')->constrained('lojas', 'id_loja')->cascadeOnDelete();
            $table->foreignId('id_categoria')->constrained('categorias', 'id_categoria')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->primary(['id_loja', 'id_categoria']);
            $table->index(['id_categoria', 'id_loja']);
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('loja_categoria');
        Schema::connection($this->connection)->dropIfExists('categorias');
        Schema::connection($this->connection)->dropIfExists('ofertas');
        Schema::connection($this->connection)->dropIfExists('cupons');
        Schema::connection($this->connection)->dropIfExists('lojas_seo');
        Schema::connection($this->connection)->dropIfExists('lojas');
    }
};
