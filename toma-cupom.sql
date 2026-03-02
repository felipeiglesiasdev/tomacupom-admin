-- ===================================================
-- BANCO DE DADOS: TOMA CUPOM
-- ===================================================

-- =========================
-- TABELA: LOJAS
-- =========================
CREATE TABLE LOJAS (
    ID_LOJA                 BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,                 -- ID DA LOJA
    NOME                    VARCHAR(150) NOT NULL,                                       -- NOME DA LOJA (EX.: ADIDAS)
    SLUG                    VARCHAR(160) NOT NULL,                                       -- SLUG PARA URL (EX.: ADIDAS) /LOJA/ADIDAS
    TITULO_PAGINA           VARCHAR(255) NOT NULL,                                       -- TITULO H1 DA PAGINA (EX.: CUPONS ADIDAS)
    DESCRICAO_PAGINA        VARCHAR(255) NOT NULL,                                       -- DESCRICAO DO HEADER (EX.: ENCONTRE OS MELHORES CUPONS...)
    URL_SITE                VARCHAR(255) NULL,                                           -- URL DO SITE DA LOJA (NAO AFILIADO)
    URL_BASE_AFILIADO       VARCHAR(255) NULL,                                           -- URL BASE DE AFILIADO (SEM ROTAS)
    LOGO_IMAGE_LINK         VARCHAR(255) NULL,                                           -- LINK DO LOGO (RAPIDO PRA LISTAGEM)
    ALT_TEXT_LOGO           VARCHAR(255) NULL,                                           -- ALT DO LOGO (RAPIDO PRA LISTAGEM)
    STATUS                  TINYINT UNSIGNED NOT NULL DEFAULT 1,                         -- 1=ATIVO / 0=INATIVO
    CREATED_AT              TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,                -- DATA CRIACAO
    UPDATED_AT              TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- DATA UPDATE
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_UNICODE_CI;

-- =========================
-- RESTRICOES E INDICES: LOJAS
-- =========================
CREATE UNIQUE INDEX UQ_LOJAS_SLUG              ON LOJAS (SLUG);                          -- GARANTE URL UNICA
CREATE INDEX IDX_LOJAS_STATUS                  ON LOJAS (STATUS);                        -- LISTAGEM DE LOJAS ATIVAS 
CREATE INDEX IDX_LOJAS_NOME                    ON LOJAS (NOME);                          -- BUSCA / ORDENACAO POR NOME (OPCIONAL)

-- =========================
-- TABELA: LOJAS_SEO (RELACAO 1:1 COM LOJAS)
-- =========================
CREATE TABLE LOJAS_SEO (
    ID_LOJA                 BIGINT UNSIGNED PRIMARY KEY,                                 -- PK = FK (GARANTE 1 SEO POR LOJA)
    TITLE_SEO               TEXT NULL,                                                   -- TITLE SEO
    DESCRIPTION_SEO         TEXT NULL,                                                   -- META DESCRIPTION
    KEYWORDS_SEO            TEXT NULL,                                                   -- OPCIONAL (POUCO USADO HOJE)
    TEXT_CONTENT_SEO        LONGTEXT NULL,                                               -- TEXTO LONGO (CONTEUDO SEO)
    CREATED_AT              TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,                -- DATA CRIACAO
    UPDATED_AT              TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- DATA UPDATE
    CONSTRAINT FK_LOJAS_SEO_LOJAS
        FOREIGN KEY (ID_LOJA) REFERENCES LOJAS(ID_LOJA) ON DELETE CASCADE                -- SE DELETAR LOJA, SOME SEO
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_UNICODE_CI;

-- =========================
-- TABELA: CUPONS
-- =========================
CREATE TABLE CUPONS (
    ID_CUPOM                BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,                 -- ID DO CUPOM
    ID_LOJA                 BIGINT UNSIGNED NOT NULL,                                   -- ID DA LOJA
    TITULO                  VARCHAR(255) NOT NULL,                                      -- TITULO DO CUPOM
    DESCRICAO               TEXT NULL,                                                  -- DESCRICAO
    REGRAS                  TEXT NULL,                                                  -- REGRAS
    CODIGO                  VARCHAR(50) NULL,                                           -- CODIGO (SE FOR CUPOM DE CODIGO)
    TIPO                    TINYINT UNSIGNED NOT NULL DEFAULT 1,                         -- 1=CODIGO / 2=OFERTA SEM CODIGO (SE QUISER)
    LINK_REDIRECIONAMENTO   VARCHAR(255) NULL,                                          -- LINK DE AFILIADO (FINAL)
    DATA_INICIO             DATE NULL,                                                  -- DATA DE INICIO (PROGRAMACAO)
    DATA_EXPIRACAO          DATE NULL,                                                  -- DATA DE EXPIRACAO
    STATUS                  TINYINT UNSIGNED NOT NULL DEFAULT 1,                         -- 1=ATIVO / 0=INATIVO
    CREATED_AT              TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,                -- DATA CRIACAO
    UPDATED_AT              TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- DATA UPDATE
    CONSTRAINT FK_CUPONS_LOJAS
        FOREIGN KEY (ID_LOJA) REFERENCES LOJAS(ID_LOJA) ON DELETE CASCADE                -- SE DELETAR LOJA, SOME CUPOM
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_UNICODE_CI;

-- =========================
-- INDICES: CUPONS (FOCO EM CONSULTAS REAIS)
-- PADRAO COMUM: LISTAR CUPONS ATIVOS DE UMA LOJA, ORDENADOS POR PRIORIDADE E EXPIRACAO
-- =========================
CREATE INDEX IDX_CUPONS_LOJA_STATUS             ON CUPONS (ID_LOJA, STATUS);                -- LISTAGEM RAPIDA DA LOJA
CREATE INDEX IDX_CUPONS_LOJA_EXPIRACAO          ON CUPONS (ID_LOJA, DATA_EXPIRACAO);        -- FILTRO POR EXPIRACAO POR LOJA
CREATE INDEX IDX_CUPONS_STATUS_EXPIRACAO        ON CUPONS (STATUS, DATA_EXPIRACAO);         -- HOME / GERAL: ATIVOS E EXPIRANDO
CREATE INDEX IDX_CUPONS_EXPIRACAO               ON CUPONS (DATA_EXPIRACAO);                 -- BUSCA POR EXPIRACAO (OPCIONAL)
CREATE INDEX IDX_CUPONS_CODIGO                  ON CUPONS (CODIGO);                         -- BUSCA POR CODIGO (OPCIONAL)

-- =========================
-- TABELA: OFERTAS
-- =========================
CREATE TABLE OFERTAS (
    ID_OFERTA               BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,                 -- ID DA OFERTA
    ID_LOJA                 BIGINT UNSIGNED NOT NULL,                                   -- ID DA LOJA
    TITULO                  VARCHAR(255) NOT NULL,                                      -- TITULO
    DESCRICAO               TEXT NULL,                                                  -- DESCRICAO
    LINK_OFERTA             VARCHAR(255) NOT NULL,                                      -- LINK DA OFERTA (AFILIADO OU NAO)
    IMAGEM_OFERTA           VARCHAR(255) NULL,                                          -- LINK DA IMAGEM
    DATA_INICIO             DATE NULL,                                                  -- DATA DE INICIO (PROGRAMACAO)
    DATA_EXPIRACAO          DATE NULL,                                                  -- DATA DE EXPIRACAO
    STATUS                  TINYINT UNSIGNED NOT NULL DEFAULT 1,                         -- 1=ATIVO / 0=INATIVO
    CREATED_AT              TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,                -- DATA CRIACAO
    UPDATED_AT              TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- DATA UPDATE
    CONSTRAINT FK_OFERTAS_LOJAS
        FOREIGN KEY (ID_LOJA) REFERENCES LOJAS(ID_LOJA) ON DELETE CASCADE                -- SE DELETAR LOJA, SOME OFERTA
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_UNICODE_CI;

-- =========================
-- INDICES: OFERTAS
-- =========================
CREATE INDEX IDX_OFERTAS_LOJA_STATUS            ON OFERTAS (ID_LOJA, STATUS);     -- LISTAGEM RAPIDA DA LOJA
CREATE INDEX IDX_OFERTAS_LOJA_EXPIRACAO         ON OFERTAS (ID_LOJA, DATA_EXPIRACAO);    -- EXPIRACAO POR LOJA
CREATE INDEX IDX_OFERTAS_STATUS_EXPIRACAO       ON OFERTAS (STATUS, DATA_EXPIRACAO);     -- HOME / GERAL
CREATE INDEX IDX_OFERTAS_EXPIRACAO              ON OFERTAS (DATA_EXPIRACAO);             -- BUSCA POR EXPIRACAO (OPCIONAL)

-- =========================
-- TABELA: CATEGORIAS
-- =========================
CREATE TABLE CATEGORIAS (
    ID_CATEGORIA            BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,                 -- ID DA CATEGORIA
    NOME                    VARCHAR(100) NOT NULL,                                      -- NOME
    SLUG                    VARCHAR(120) NOT NULL                                       -- SLUG UNICO (EX.: ELETRONICOS)
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_UNICODE_CI;

-- =========================
-- INDICES: CATEGORIAS
-- =========================
CREATE UNIQUE INDEX UQ_CATEGORIAS_SLUG          ON CATEGORIAS (SLUG);                    -- SLUG UNICO
CREATE INDEX IDX_CATEGORIAS_NOME               ON CATEGORIAS (NOME);                    -- BUSCA POR NOME (OPCIONAL)

-- =========================
-- TABELA: LOJA_CATEGORIA (N:N)
-- =========================
CREATE TABLE LOJA_CATEGORIA (
    ID_LOJA                 BIGINT UNSIGNED NOT NULL,                                   -- ID DA LOJA
    ID_CATEGORIA            BIGINT UNSIGNED NOT NULL,                                   -- ID DA CATEGORIA
    CREATED_AT              TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,               -- DATA CRIACAO (AJUDA EM AUDITORIA)
    PRIMARY KEY (ID_LOJA, ID_CATEGORIA),                                                -- PK COMPOSTA
    CONSTRAINT FK_LOJA_CATEGORIA_LOJAS
        FOREIGN KEY (ID_LOJA) REFERENCES LOJAS(ID_LOJA) ON DELETE CASCADE,              -- REMOVE RELACOES AO DELETAR LOJA
    CONSTRAINT FK_LOJA_CATEGORIA_CATEGORIAS
        FOREIGN KEY (ID_CATEGORIA) REFERENCES CATEGORIAS(ID_CATEGORIA) ON DELETE CASCADE -- REMOVE RELACOES AO DELETAR CATEGORIA
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4 COLLATE=UTF8MB4_UNICODE_CI;

-- =========================
-- INDICES: LOJA_CATEGORIA
-- =========================
CREATE INDEX IDX_LOJA_CATEGORIA_CATEGORIA_LOJA  ON LOJA_CATEGORIA (ID_CATEGORIA, ID_LOJA); -- BUSCA POR CATEGORIA -> LOJAS

