<div>
    <section class="mx-auto max-w-full px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="mb-4" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
                <li>
                    <a href="{{ route('circuit-court.map') }}" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" /></svg>
                    </a>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" /></svg>
                    <a href="{{ route('circuit-court.localites') }}" class="ml-4 text-sm text-gray-500 hover:text-gray-700">Localités</a>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" /></svg>
                    <span class="ml-4 text-sm text-gray-700">{{ $city }}</span>
                </li>
            </ol>
        </nav>

        <h1 class="font-lobster font-bold w-full flex items-center text-2xl md:text-4xl text-carto-main mb-2">
            {{ $city }}
            <span class="flex-1 border-b border-carto-green ml-2"></span>
        </h1>

        <h2 class="text-xl lg:text-3xl text-carto-pink px-3 my-4">
            {{ $this->shops->count() }} acteurs trouvés
        </h2>

        @if ($this->shops->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500">Aucun acteur dans cette localité.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-y-4 lg:grid-cols-3 sm:gap-x-6 sm:gap-y-4 lg:gap-x-4">
                @foreach ($this->shops as $shop)
                    @include('livewire.circuit-court.partials.shop-card', ['shop' => $shop])
                @endforeach
            </div>
        @endif
    </section>
</div>
