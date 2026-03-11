{{-- Shop preview slide-over panel --}}
@php
    use App\Models\Shop;$previewShop = $previewShopId
        ? Shop::with(['tags' => fn ($q) => $q->where('private', false), 'categories', 'medias'])
            ->whereHas('tags', fn ($q) => $q->where('slug', 'circuit-court'))
            ->find($previewShopId)
        : null;
@endphp

<div
    x-data="{ open: @entangle('previewShopId') }"
    x-on:shop-preview-opened.window="$nextTick(() => open = true)"
>
    <template x-teleport="body">
        <div x-show="open" x-cloak class="relative z-50" role="dialog" aria-modal="true">
            {{-- Backdrop --}}
            <div x-show="open"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-carto-main/30 backdrop-blur-sm"
                 wire:click="closePreview">
            </div>

            <div class="fixed inset-0 flex justify-end">
                <div x-show="open"
                     x-transition:enter="transition ease-in-out duration-300 transform"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300 transform"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="relative w-full max-w-md overflow-hidden bg-white shadow-2xl flex flex-col">

                    @if ($previewShop)
                        {{-- Header --}}
                        <header class="bg-carto-green text-white p-5 shrink-0">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="text-2xl font-lobster font-bold">{{ $previewShop->company }}</h2>
                                    <address class="flex items-center gap-2 mt-2 not-italic text-sm text-white/90">
                                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                             stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                                        </svg>
                                        {{ $previewShop->street }} {{ $previewShop->number }}, {{ $previewShop->city }}
                                    </address>
                                </div>
                                <button type="button" wire:click="closePreview"
                                        class="shrink-0 -mr-1 -mt-1 flex h-10 w-10 items-center justify-center rounded-full text-white/80 hover:text-white hover:bg-white/10 transition">
                                    <span class="sr-only">Fermer</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                         stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </header>

                        {{-- Content --}}
                        <div class="flex-1 overflow-y-auto p-5 space-y-5">
                            {{-- Cover image --}}
                            @php
                                $mainImage = $previewShop->medias->first(fn ($m) => $m->is_main) ?? $previewShop->medias->first();
                            @endphp
                            @if ($mainImage)
                                <img src="{{ asset('storage/'.$mainImage->file_name) }}"
                                     alt="{{ $previewShop->company }}"
                                     class="w-full h-48 object-cover rounded-lg">
                            @endif

                            {{-- Contact --}}
                            <div>
                                <h3 class="text-sm font-bold uppercase text-gray-500 mb-3">Contact</h3>
                                <div class="space-y-2">
                                    @if ($previewShop->phone)
                                        <a href="tel:{{ $previewShop->phone }}"
                                           class="flex items-center gap-3 text-sm hover:text-carto-pink transition">
                                            <svg class="w-5 h-5 text-carto-gray-300 shrink-0" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                                            </svg>
                                            {{ $previewShop->phone }}
                                        </a>
                                    @endif
                                    @if ($previewShop->mobile)
                                        <a href="tel:{{ $previewShop->mobile }}"
                                           class="flex items-center gap-3 text-sm hover:text-carto-pink transition">
                                            <svg class="w-5 h-5 text-carto-gray-300 shrink-0" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/>
                                            </svg>
                                            {{ $previewShop->mobile }}
                                        </a>
                                    @endif
                                    @if ($previewShop->email)
                                        <a href="mailto:{{ $previewShop->email }}"
                                           class="flex items-center gap-3 text-sm hover:text-carto-pink transition">
                                            <svg class="w-5 h-5 text-carto-gray-300 shrink-0" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                                            </svg>
                                            {{ $previewShop->email }}
                                        </a>
                                    @endif
                                    @if ($previewShop->pmr)
                                        <div class="flex items-center gap-3 text-sm text-carto-green">
                                            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm-2 7h4v3h3l1.5 5h-2.1l-1.05-3.5H8.65L7.6 17H5.5L7 12h3V9z"/>
                                            </svg>
                                            Accès PMR
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Social links --}}
                            @if ($previewShop->website || $previewShop->facebook || $previewShop->youtube || $previewShop->tiktok || $previewShop->twitter || $previewShop->linkedin || $previewShop->instagram)
                                <div class="flex gap-3">
                                    @if ($previewShop->website)
                                        <a href="{{ $previewShop->website }}" target="_blank"
                                           class="p-2 rounded-full bg-gray-100 text-carto-gray-300 hover:text-carto-pink hover:bg-gray-200 transition"
                                           title="Site web">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"/>
                                            </svg>
                                        </a>
                                    @endif
                                    @if ($previewShop->facebook)
                                        <a href="{{ $previewShop->facebook }}" target="_blank"
                                           class="p-2 rounded-full bg-gray-100 text-carto-gray-300 hover:text-carto-pink hover:bg-gray-200 transition"
                                           title="Facebook">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                            </svg>
                                        </a>
                                    @endif
                                    @if ($previewShop->instagram)
                                        <a href="{{ $previewShop->instagram }}" target="_blank"
                                           class="p-2 rounded-full bg-gray-100 text-carto-gray-300 hover:text-carto-pink hover:bg-gray-200 transition"
                                           title="Instagram">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            {{-- Categories/Sectors --}}
                            @if ($previewShop->categories->isNotEmpty())
                                <div>
                                    <h3 class="text-sm font-bold uppercase text-gray-500 mb-2">Secteurs</h3>
                                    <div class="space-y-1">
                                        @foreach ($previewShop->categories as $category)
                                            <div class="flex items-center gap-2">
                                                @if ($category->icon)
                                                    <img src="{{ asset('storage/bottin/icons/'.$category->icon) }}"
                                                         alt="" class="w-5 h-5">
                                                @else
                                                    <svg class="w-5 h-5 text-carto-gray-200" fill="none"
                                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M6 6h.008v.008H6V6Z"/>
                                                    </svg>
                                                @endif
                                                <span class="text-sm">{{ $category->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Tags --}}
                            @if ($previewShop->tags->isNotEmpty())
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($previewShop->tags as $tag)
                                        <a href="{{ route('circuit-court.filiere.show', $tag) }}"
                                           class="inline-flex items-center gap-1 rounded-full bg-carto-green/10 px-3 py-1 text-xs font-medium text-carto-main hover:bg-carto-green/20 transition">
                                            @if ($tag->icon)
                                                <img src="{{ asset('storage/bottin/tags/'.$tag->icon) }}" alt=""
                                                     class="w-4 h-4">
                                            @endif
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Description --}}
                            @if ($previewShop->comment1)
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $previewShop->comment1 }}</p>
                            @endif
                        </div>

                        {{-- Footer --}}
                        <footer class="bg-carto-green p-4 shrink-0">
                            <a href="{{ route('circuit-court.acteur.show', $previewShop) }}"
                               class="block w-full rounded-lg bg-white/20 px-4 py-2.5 text-center text-sm font-medium text-white hover:bg-white/30 transition">
                                Voir la fiche complète
                            </a>
                        </footer>
                    @endif
                </div>
            </div>
        </div>
    </template>
</div>
