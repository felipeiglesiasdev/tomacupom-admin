<div class="grid md:grid-cols-2 gap-4">
    <input name="nome" value="{{ old('nome', $loja->nome ?? '') }}" placeholder="NOME" class="border rounded px-3 py-2" required>
    <input name="slug" value="{{ old('slug', $loja->slug ?? '') }}" placeholder="SLUG" class="border rounded px-3 py-2" required>
    <input name="titulo_pagina" value="{{ old('titulo_pagina', $loja->titulo_pagina ?? '') }}" placeholder="TITULO PAGINA" class="border rounded px-3 py-2 md:col-span-2" required>
    <input name="descricao_pagina" value="{{ old('descricao_pagina', $loja->descricao_pagina ?? '') }}" placeholder="DESCRICAO PAGINA" class="border rounded px-3 py-2 md:col-span-2" required>
    <input name="url_site" value="{{ old('url_site', $loja->url_site ?? '') }}" placeholder="URL SITE" class="border rounded px-3 py-2">
    <input name="url_base_afiliado" value="{{ old('url_base_afiliado', $loja->url_base_afiliado ?? '') }}" placeholder="URL BASE AFILIADO" class="border rounded px-3 py-2">
    <input name="logo_image_link" value="{{ old('logo_image_link', $loja->logo_image_link ?? '') }}" placeholder="LOGO URL" class="border rounded px-3 py-2">
    <input name="alt_text_logo" value="{{ old('alt_text_logo', $loja->alt_text_logo ?? '') }}" placeholder="ALT LOGO" class="border rounded px-3 py-2">
    <select name="status" class="border rounded px-3 py-2">
        <option value="1" @selected(old('status', $loja->status ?? 1) == 1)>ATIVO</option>
        <option value="0" @selected(old('status', $loja->status ?? 1) == 0)>INATIVO</option>
    </select>
</div>
