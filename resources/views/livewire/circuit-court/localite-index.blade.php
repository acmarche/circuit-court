<div>
    <section class="mx-auto max-w-full px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <h1 class="font-lobster font-bold w-full flex items-center text-2xl md:text-4xl text-carto-main mb-6">
            Localités
            <span class="flex-1 border-b border-carto-green ml-2"></span>
        </h1>

        <p class="text-lg text-carto-gray-300 mb-8 font-lobster italic">
            Découvrez les acteurs du circuit court par localité.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($this->localities as $locality)
                <a href="{{ route('circuit-court.localite.show', ['city' => $locality->city]) }}"
                   class="flex items-center gap-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm hover:shadow-md hover:border-carto-pink/30 transition-all duration-200 group">
                    <svg class="w-6 h-6 text-carto-gray-200 group-hover:text-carto-pink transition shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    <span class="font-medium text-carto-main group-hover:text-carto-pink transition">{{ $locality->city }}</span>
                    <span class="text-sm text-carto-gray-200">({{ $locality->shops_count }})</span>
                </a>
            @endforeach
        </div>
    </section>
</div>
