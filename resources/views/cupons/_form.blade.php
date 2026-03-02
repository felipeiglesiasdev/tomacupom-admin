<div class="grid md:grid-cols-2 gap-3">
<select name="id_loja" class="border rounded px-3 py-2" required>@foreach($lojas as $loja)<option value="{{ $loja->id_loja }}" @selected(old('id_loja', $cupom->id_loja ?? '')==$loja->id_loja)>{{ $loja->nome }}</option>@endforeach</select>
<input name="titulo" value="{{ old('titulo', $cupom->titulo ?? '') }}" class="border rounded px-3 py-2" placeholder="TITULO" required>
<input name="codigo" value="{{ old('codigo', $cupom->codigo ?? '') }}" class="border rounded px-3 py-2" placeholder="CODIGO">
<input name="tipo" value="{{ old('tipo', $cupom->tipo ?? 1) }}" type="number" min="1" class="border rounded px-3 py-2" placeholder="TIPO">
<input name="link_redirecionamento" value="{{ old('link_redirecionamento', $cupom->link_redirecionamento ?? '') }}" class="border rounded px-3 py-2 md:col-span-2" placeholder="LINK REDIRECIONAMENTO">
<textarea name="descricao" class="border rounded px-3 py-2 md:col-span-2" placeholder="DESCRICAO">{{ old('descricao', $cupom->descricao ?? '') }}</textarea>
<textarea name="regras" class="border rounded px-3 py-2 md:col-span-2" placeholder="REGRAS">{{ old('regras', $cupom->regras ?? '') }}</textarea>
<input name="data_inicio" type="date" value="{{ old('data_inicio', $cupom->data_inicio ?? '') }}" class="border rounded px-3 py-2">
<input name="data_expiracao" type="date" value="{{ old('data_expiracao', $cupom->data_expiracao ?? '') }}" class="border rounded px-3 py-2">
<select name="status" class="border rounded px-3 py-2"><option value="1" @selected(old('status', $cupom->status ?? 1)==1)>ATIVO</option><option value="0" @selected(old('status', $cupom->status ?? 1)==0)>INATIVO</option></select>
</div>
