<div>
    <section class="mx-auto max-w-full px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <h1 class="font-lobster font-bold w-full flex items-center text-2xl md:text-4xl text-carto-main mb-6">
            Filières
            <span class="flex-1 border-b border-carto-green ml-2"></span>
        </h1>

        <p class="text-lg text-carto-gray-300 mb-8 font-lobster italic">
            Découvrez les acteurs du circuit court par filière.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($this->tags as $tag)
                <a href="{{ route('circuit-court.filiere.show', $tag) }}"
                   class="flex items-center gap-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm hover:shadow-md hover:border-carto-pink/30 transition-all duration-200 group">
                    @if ($tag->icon)
                        <img src="{{ asset('storage/bottin/tags/'.$tag->icon) }}" alt="" class="w-8 h-8">
                    @else
                        <svg class="w-8 h-8 text-carto-gray-200 group-hover:text-carto-pink transition" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" /></svg>
                    @endif
                    <div>
                        <span class="font-medium text-carto-main group-hover:text-carto-pink transition">{{ $tag->name }}</span>
                        <span class="text-sm text-carto-gray-200 ml-1">({{ $tag->shops_count }})</span>
                        @if ($tag->description)
                            <p class="text-xs text-gray-500 mt-0.5">{{ Str::limit($tag->description, 60) }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </section>
</div>
