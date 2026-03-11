<div>
    <section class="mx-auto max-w-full px-0 py-8 sm:px-6 sm:py-12 lg:px-8">
        {{-- Title --}}
        <h1 class="font-lobster font-bold w-full flex items-center text-2xl md:text-4xl text-carto-main mb-3">
            Liste des acteurs
            <span class="flex-1 border-b border-carto-green ml-2"></span>
        </h1>

        @include('livewire.circuit-court.partials.filters-mobile')

        <h2 class="text-xl lg:text-3xl text-carto-pink px-3 my-4">
            {{ $this->shops->count() }} acteurs et intervenants trouvés
        </h2>

        <div class="pt-4 grid grid-cols-1 lg:grid-cols-[auto_minmax(0,1fr)] lg:gap-x-8">
            @include('livewire.circuit-court.partials.filters-sidebar')

            {{-- Results grid --}}
            <section class="relative overflow-hidden rounded-xl border border-dashed border-gray-400">
                <div class="mx-auto max-w-full px-4 py-4">
                    @if ($this->shops->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucun résultat</h3>
                            <p class="mt-1 text-sm text-gray-500">Essayez de modifier vos filtres.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-y-4 lg:grid-cols-3 sm:gap-x-6 sm:gap-y-4 lg:gap-x-4">
                            @foreach ($this->shops as $shop)
                                @include('livewire.circuit-court.partials.shop-card', ['shop' => $shop])
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </section>
</div>
