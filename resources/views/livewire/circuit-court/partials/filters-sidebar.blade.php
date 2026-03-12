{{-- Desktop filters sidebar --}}
<aside>
    <h2 class="sr-only">Filtres</h2>
    <div class="hidden lg:block lg:min-w-48">
        <div class="space-y-6 divide-y divide-gray-200">
            {{-- Active filters indicator --}}
            @if ($selectedTags !== [] || $selectedLocality !== '')
                <div class="flex items-center justify-between">
                    <span class="text-sm text-carto-gray-300">Filtres actifs</span>
                    <button wire:click="clearFilters" class="text-xs text-carto-pink hover:underline cursor-pointer">
                        Tout effacer
                    </button>
                </div>
            @endif

            {{-- Tag groups --}}
            @foreach ($this->tagGroups as $group)
                @if ($group->tags->isNotEmpty())
                    <fieldset class="not-first:pt-5">
                        <legend class="block text-sm font-semibold text-gray-900">
                            {{ $group->name }}
                        </legend>
                        <div class="space-y-3 pt-4">
                            @foreach ($group->tags as $tag)
                                @php($tagShopCount = $tag->shops()->where('enabled', true)->whereHas('tags', fn ($q) => $q->where('slug', 'circuit-court'))->count())
                                @continue($tagShopCount === 0)
                                <label for="tag-{{ $tag->id }}" class="flex items-center gap-2 cursor-pointer group">
                                    <input
                                        id="tag-{{ $tag->id }}"
                                        type="checkbox"
                                        wire:click="toggleTag({{ $tag->id }})"
                                        @checked(in_array($tag->id, $selectedTags, true))
                                        class="h-4 w-4 rounded border-carto-gray-200 text-carto-pink focus:ring-carto-pink"
                                    >
                                    @if ($tag->icon)
                                        <img src="{{ asset('storage/bottin/tags/'.$tag->icon) }}" alt="" class="w-5 h-5">
                                    @endif
                                    <span class="text-sm text-carto-main group-hover:text-carto-pink transition">
                                        {{ $tag->name }}
                                        <span class="text-carto-gray-200">({{ $tagShopCount }})</span>
                                    </span>
                                    @if ($tag->description)
                                        <span class="relative group/tip">
                                            <svg class="w-4 h-4 text-carto-pink cursor-help" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                            </svg>
                                            <span class="invisible group-hover/tip:visible absolute left-6 -top-2 z-30 w-48 rounded-lg bg-gray-800 px-3 py-2 text-xs text-white shadow-lg">
                                                {{ $tag->description }}
                                            </span>
                                        </span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                @endif
            @endforeach

            {{-- Localities --}}
            <fieldset class="pt-5">
                <legend class="block text-sm font-semibold text-gray-900">Localité</legend>
                <div class="space-y-3 pt-4">
                    @foreach ($this->localities as $locality)
                        <label for="loc-{{ $loop->index }}" class="flex items-center gap-2 cursor-pointer group">
                            <input
                                id="loc-{{ $loop->index }}"
                                type="checkbox"
                                wire:click="selectLocality('{{ $locality->city }}')"
                                @checked($selectedLocality === $locality->city)
                                class="h-4 w-4 rounded border-carto-gray-200 text-carto-pink focus:ring-carto-pink"
                            >
                            <span class="text-sm text-carto-main group-hover:text-carto-pink transition">
                                {{ $locality->city }}
                                <span class="text-carto-gray-200">({{ $locality->shops_count }})</span>
                            </span>
                        </label>
                    @endforeach
                </div>
            </fieldset>
        </div>
    </div>
</aside>
