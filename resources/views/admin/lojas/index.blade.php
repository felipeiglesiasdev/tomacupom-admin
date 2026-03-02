<x-admin.layouts.app title="LOJAS" header="LOJAS">
    <form class="grid md:grid-cols-4 gap-2 mb-4">
        <input name="busca" value="{{ request('busca') }}" placeholder="BUSCA" class="border rounded px-3 py-2">
        <select name="status" class="border rounded px-3 py-2"><option value="">STATUS</option><option value="1" @selected(request('status')==='1')>ATIVO</option><option value="0" @selected(request('status')==='0')>INATIVO</option></select>
        <button class="bg-slate-900 text-white rounded px-4 py-2">FILTRAR</button>
        <a href="{{ route('admin.lojas.create') }}" class="bg-emerald-600 text-white rounded px-4 py-2 text-center">NOVA LOJA</a>
    </form>
    <div class="overflow-auto bg-white border rounded">
    <table class="w-full text-sm"><thead><tr class="border-b"><th class="p-2 text-left">NOME</th><th>STATUS</th><th></th></tr></thead><tbody>
    @forelse($lojas as $loja)
        <tr class="border-b"><td class="p-2">{{ $loja->nome }}</td><td class="text-center">{{ $loja->status ? 'ATIVO' : 'INATIVO' }}</td><td class="p-2 text-right space-x-2"><a href="{{ route('admin.lojas.edit', $loja) }}">EDITAR</a><a href="{{ route('admin.lojas.seo.edit', $loja) }}">SEO</a><a href="{{ route('admin.lojas.categorias.edit', $loja) }}">CATEGORIAS</a><form action="{{ route('admin.lojas.destroy', $loja) }}" method="POST" class="inline">@csrf @method('DELETE')<button onclick="return confirm('CONFIRMAR EXCLUSAO?')">EXCLUIR</button></form></td></tr>
    @empty <tr><td class="p-4">SEM LOJAS</td></tr> @endforelse
    </tbody></table></div>
    <div class="mt-4">{{ $lojas->links() }}</div>
</x-admin.layouts.app>
