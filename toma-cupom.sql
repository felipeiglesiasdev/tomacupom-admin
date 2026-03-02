-- ===================================================
-- BANCO DE DADOS: TOMA CUPOM (MINUSCULO)
-- ===================================================

-- =========================
-- TABELA: lojas
-- =========================
CREATE TABLE lojas (
    id_loja               BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome                  VARCHAR(150) NOT NULL,
    slug                  VARCHAR(160) NOT NULL,
    titulo_pagina         VARCHAR(255) NOT NULL,
    descricao_pagina      VARCHAR(255) NOT NULL,
    url_site              VARCHAR(255) NULL,
    url_base_afiliado     VARCHAR(255) NULL,
    logo_image_link       VARCHAR(255) NULL,
    alt_text_logo         VARCHAR(255) NULL,
    status                TINYINT UNSIGNED NOT NULL DEFAULT 1,
    created_at            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================
-- INDICES: lojas
-- =========================
CREATE UNIQUE INDEX uq_lojas_slug ON lojas (slug);
CREATE INDEX idx_lojas_status ON lojas (status);
CREATE INDEX idx_lojas_nome ON lojas (nome);

-- =========================
-- TABELA: lojas_seo (1:1 com lojas)
-- =========================
CREATE TABLE lojas_seo (
    id_loja               BIGINT UNSIGNED PRIMARY KEY,
    title_seo             TEXT NULL,
    description_seo       TEXT NULL,
    keywords_seo          TEXT NULL,
    text_content_seo      LONGTEXT NULL,
    created_at            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_lojas_seo_lojas
        FOREIGN KEY (id_loja) REFERENCES lojas(id_loja) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================
-- TABELA: cupons
-- =========================
CREATE TABLE cupons (
    id_cupom              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_loja               BIGINT UNSIGNED NOT NULL,
    titulo                VARCHAR(255) NOT NULL,
    descricao             TEXT NULL,
    regras                TEXT NULL,
    codigo                VARCHAR(50) NULL,
    tipo                  TINYINT UNSIGNED NOT NULL DEFAULT 1,
    link_redirecionamento VARCHAR(255) NULL,
    data_inicio           DATE NULL,
    data_expiracao        DATE NULL,
    status                TINYINT UNSIGNED NOT NULL DEFAULT 1,
    created_at            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_cupons_lojas
        FOREIGN KEY (id_loja) REFERENCES lojas(id_loja) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================
-- INDICES: cupons
-- =========================
CREATE INDEX idx_cupons_loja_status ON cupons (id_loja, status);
CREATE INDEX idx_cupons_loja_expiracao ON cupons (id_loja, data_expiracao);
CREATE INDEX idx_cupons_status_expiracao ON cupons (status, data_expiracao);
CREATE INDEX idx_cupons_expiracao ON cupons (data_expiracao);
CREATE INDEX idx_cupons_codigo ON cupons (codigo);

-- =========================
-- TABELA: ofertas
-- =========================
CREATE TABLE ofertas (
    id_oferta             BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_loja               BIGINT UNSIGNED NOT NULL,
    titulo                VARCHAR(255) NOT NULL,
    descricao             TEXT NULL,
    link_oferta           VARCHAR(255) NOT NULL,
    imagem_oferta         VARCHAR(255) NULL,
    data_inicio           DATE NULL,
    data_expiracao        DATE NULL,
    status                TINYINT UNSIGNED NOT NULL DEFAULT 1,
    created_at            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_ofertas_lojas
        FOREIGN KEY (id_loja) REFERENCES lojas(id_loja) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================
-- INDICES: ofertas
-- =========================
CREATE INDEX idx_ofertas_loja_status ON ofertas (id_loja, status);
CREATE INDEX idx_ofertas_loja_expiracao ON ofertas (id_loja, data_expiracao);
CREATE INDEX idx_ofertas_status_expiracao ON ofertas (status, data_expiracao);
CREATE INDEX idx_ofertas_expiracao ON ofertas (data_expiracao);

-- =========================
-- TABELA: categorias
-- =========================
CREATE TABLE categorias (
    id_categoria          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome                  VARCHAR(100) NOT NULL,
    slug                  VARCHAR(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================
-- INDICES: categorias
-- =========================
CREATE UNIQUE INDEX uq_categorias_slug ON categorias (slug);
CREATE INDEX idx_categorias_nome ON categorias (nome);

-- =========================
-- TABELA: loja_categoria (N:N)
-- =========================
CREATE TABLE loja_categoria (
    id_loja               BIGINT UNSIGNED NOT NULL,
    id_categoria          BIGINT UNSIGNED NOT NULL,
    created_at            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_loja, id_categoria),
    CONSTRAINT fk_loja_categoria_lojas
        FOREIGN KEY (id_loja) REFERENCES lojas(id_loja) ON DELETE CASCADE,
    CONSTRAINT fk_loja_categoria_categorias
        FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================
-- INDICES: loja_categoria
-- =========================
CREATE INDEX idx_loja_categoria_categoria_loja ON loja_categoria (id_categoria, id_loja);