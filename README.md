# TOMA CUPOM - PORTAL ADMIN LARAVEL

## CONFIGURACAO
1. COPIE O ARQUIVO `.env.example` PARA `.env`.
2. AJUSTE AS CONEXOES:
   - `DB_CONNECTION=mysql` PARA ADMIN/AUTH.
   - `DB_APP_*` PARA O BANCO PRINCIPAL (MYSQL_APP).
3. GERE CHAVE E RODE MIGRATIONS.

## COMANDOS
```bash
php artisan key:generate
php artisan migrate
php artisan migrate --database=mysql_app
php artisan db:seed
npm install
npm run dev
```

## ACESSO AO ADMIN
- URL: `/admin`
- LOGIN ADMIN: `admin@tomacupom.com`
- LOGIN EDITOR: `editor@tomacupom.com`
- SENHA PADRAO: `password123`

## RECURSOS DO PORTAL
- DASHBOARD COM METRICAS
- CRUD DE LOJAS + SEO 1:1
- CRUD DE CUPONS (COM DUPLICAR)
- CRUD DE OFERTAS
- CRUD DE CATEGORIAS
- VINCULO LOJA X CATEGORIAS (N:N)
- FLASH MESSAGES E PAGINACAO
- LAYOUT RESPONSIVO COM TAILWIND
