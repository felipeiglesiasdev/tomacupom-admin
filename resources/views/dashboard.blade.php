<x-layouts.app title="DASHBOARD" header="DASHBOARD">
    <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <x-components.card label="LOJAS ATIVAS" :value="$totalLojasAtivas" />
        <x-components.card label="CUPONS ATIVOS" :value="$totalCuponsAtivos" />
        <x-components.card label="OFERTAS ATIVAS" :value="$totalOfertasAtivas" />
        <x-components.card label="CATEGORIAS" :value="$totalCategorias" />
    </div>
</x-layouts.app>
