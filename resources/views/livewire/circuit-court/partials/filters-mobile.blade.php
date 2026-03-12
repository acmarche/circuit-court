{{-- Mobile filter slide-out --}}
<div
    x-data="{ open: false }"
    x-on:open-mobile-filters.window="open = true"
    class="lg:hidden"
>
    {{-- Trigger button --}}
    <button type="button" x-on:click="open = true" class="inline-flex items-center gap-1 px-4 mt-4 sm:px-0">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
        </svg>
        <span class="text-sm font-medium text-carto-main">Filtres</span>
    </button>

    {{-- Overlay --}}
    <template x-teleport="body">
        <div x-show="open" x-cloak class="relative z-50" role="dialog" aria-modal="true">
            <div x-show="open"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-carto-main/25 backdrop-blur-sm"
                 x-on:click="open = false">
            </div>

            <div class="fixed inset-0 flex justify-end">
                <div x-show="open"
                     x-transition:enter="transition ease-in-out duration-300 transform"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300 transform"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="relative w-full max-w-xs overflow-y-auto bg-white py-4 pb-6 shadow-xl">
                    <div class="flex items-center justify-between px-4">
                        <h2 class="text-lg font-medium text-carto-main">Filières et localités</h2>
                        <button type="button" x-on:click="open = false" class="-mr-2 flex h-10 w-10 items-center justify-center p-2 text-carto-gray-200 hover:text-carto-gray-300">
                            <span class="sr-only">Fermer</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-4 px-4" x-data="{ openTab: -1 }">
                        @if ($selectedTags !== [] || $selectedLocality !== '')
                            <button wire:click="clearFilters" class="mb-4 text-xs text-carto-pink hover:underline cursor-pointer">
                                Effacer tous les filtres
                            </button>
                        @endif

                        @foreach ($this->tagGroups as $groupIndex => $group)
                            @if ($group->tags->isNotEmpty())
                                <div class="border-t border-gray-200 pb-4 pt-4">
                                    <button type="button"
                                            x-on:click="openTab = openTab === {{ $groupIndex }} ? -1 : {{ $groupIndex }}"
                                            class="flex w-full items-center justify-between p-2 text-gray-400 hover:text-gray-500">
                                        <span class="text-sm font-medium text-gray-900">{{ $group->name }}</span>
                                        <svg class="h-5 w-5 transition-transform duration-200" :class="openTab === {{ $groupIndex }} ? '-rotate-180' : 'rotate-0'" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div x-show="openTab === {{ $groupIndex }}" x-collapse class="px-2 pb-2 pt-2">
                                        <div class="space-y-4">
                                            @foreach ($group->tags as $tag)
                                                @php($tagShopCount = $tag->shops()->where('enabled', true)->whereHas('tags', fn ($q) => $q->where('slug', 'circuit-court'))->count())
                                                @continue($tagShopCount === 0)
                                                <label for="m-tag-{{ $tag->id }}" class="flex items-center gap-2 cursor-pointer">
                                                    <input id="m-tag-{{ $tag->id }}" type="checkbox"
                                                           wire:click="toggleTag({{ $tag->id }})"
                                                           @checked(in_array($tag->id, $selectedTags, true))
                                                           class="h-4 w-4 rounded border-carto-gray-200 text-carto-pink focus:ring-carto-pink">
                                                    <span class="text-sm text-carto-main">{{ $tag->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <div class="border-t border-gray-200 pb-4 pt-4">
                            <button type="button"
                                    x-on:click="openTab = openTab === 'loc' ? -1 : 'loc'"
                                    class="flex w-full items-center justify-between p-2 text-gray-400 hover:text-gray-500">
                                <span class="text-sm font-medium text-gray-900">Localité</span>
                                <svg class="h-5 w-5 transition-transform duration-200" :class="openTab === 'loc' ? '-rotate-180' : 'rotate-0'" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="openTab === 'loc'" x-collapse class="px-2 pb-2 pt-2">
                                <div class="space-y-4">
                                    @foreach ($this->localities as $locality)
                                        <label for="m-loc-{{ $loop->index }}" class="flex items-center gap-2 cursor-pointer">
                                            <input id="m-loc-{{ $loop->index }}" type="checkbox"
                                                   wire:click="selectLocality('{{ $locality->city }}')"
                                                   @checked($selectedLocality === $locality->city)
                                                   class="h-4 w-4 rounded border-carto-gray-200 text-carto-pink focus:ring-carto-pink">
                                            <span class="text-sm text-carto-main">{{ $locality->city }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
