<x-admin.layouts.app title="DASHBOARD" header="DASHBOARD">
    <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <x-admin.card label="LOJAS ATIVAS" :value="$totalLojasAtivas" />
        <x-admin.card label="CUPONS ATIVOS" :value="$totalCuponsAtivos" />
        <x-admin.card label="OFERTAS ATIVAS" :value="$totalOfertasAtivas" />
        <x-admin.card label="CATEGORIAS" :value="$totalCategorias" />
    </div>
</x-admin.layouts.app>
