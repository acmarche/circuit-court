@php
    $mainImage = $shop->medias->first(fn ($m) => $m->is_main);
    $cover = $mainImage
        ? asset('storage/'.$mainImage->file_name)
        : ($shop->medias->first() ? asset('storage/'.$shop->medias->first()->file_name) : null);
    $categoryIcon = $shop->categories->first()?->icon
        ? asset('storage/bottin/icons/'.$shop->categories->first()->icon)
        : null;
@endphp

<div>
    {{-- Cover header --}}
    <header class="relative bg-gray-200" style="height: 30vh;">
        @if ($cover)
            <img src="{{ $cover }}" alt="{{ $shop->company }}" class="w-full h-full object-cover object-center">
        @else
            <div class="w-full h-full bg-linear-to-br from-carto-green/30 to-carto-pink/10"></div>
        @endif
        @if ($categoryIcon)
            <div class="max-w-32 ms-2 md:ms-24 -mt-12 relative z-10">
                <img class="h-20 w-20 sm:h-24 sm:w-24 animate-bounce-in-top" src="{{ $categoryIcon }}" alt="">
            </div>
        @else
            <div class="h-14"></div>
        @endif
    </header>

    {{-- Breadcrumb --}}
    <nav class="mx-auto max-w-full ms-2 md:ms-24 py-3" aria-label="Breadcrumb">
        <ol role="list" class="flex items-center space-x-4">
            <li>
                <a href="{{ route('circuit-court.map') }}" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
                    </svg>
                </a>
            </li>
            <li class="flex items-center">
                <svg class="h-5 w-5 shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                </svg>
                <a href="{{ route('circuit-court.acteurs') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Liste</a>
            </li>
            <li class="flex items-center">
                <svg class="h-5 w-5 shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                </svg>
                <span class="ml-4 text-sm font-medium text-gray-700">{{ $shop->company }}</span>
            </li>
        </ol>
    </nav>

    {{-- Content --}}
    <section class="mx-auto max-w-full ms-2 md:ms-24 py-2 border border-dashed border-gray-400 rounded-lg">
        <div class="flex flex-col w-full gap-2">
            {{-- Title --}}
            <h1 class="font-lobster font-bold w-full flex items-center text-2xl md:text-4xl text-carto-main px-4 pt-4">
                {{ $shop->company }}
                <span class="flex-1 border-b border-carto-green ml-2"></span>
            </h1>

            {{-- Address --}}
            <address class="flex w-fit flex-row items-start gap-2 text-carto-gray-300 px-6 not-italic">
                <svg class="h-8 w-8 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                <span>{{ $shop->street }} {{ $shop->number }}<br>{{ $shop->postal_code }} {{ $shop->city }}</span>
            </address>

            <div class="flex flex-col flex-auto gap-6 p-6">
                {{-- Contact --}}
                <div>
                    <h3 class="text-lg font-bold font-roboto uppercase text-gray-600 mb-3">Informations générales</h3>
                    <div class="max-w-md space-y-3">
                        @if ($shop->phone)
                            <a href="tel:{{ $shop->phone }}" class="flex items-center gap-3 hover:text-carto-pink transition">
                                <svg class="w-6 h-6 text-carto-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
                                {{ $shop->phone }}
                            </a>
                        @endif
                        @if ($shop->mobile)
                            <a href="tel:{{ $shop->mobile }}" class="flex items-center gap-3 hover:text-carto-pink transition">
                                <svg class="w-6 h-6 text-carto-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>
                                {{ $shop->mobile }}
                            </a>
                        @endif
                        @if ($shop->email)
                            <a href="mailto:{{ $shop->email }}" class="flex items-center gap-3 hover:text-carto-pink transition">
                                <svg class="w-6 h-6 text-carto-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                                {{ $shop->email }}
                            </a>
                        @endif
                        @if ($shop->pmr)
                            <div class="flex items-center gap-3 text-carto-green font-medium">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm-2 7h4v3h3l1.5 5h-2.1l-1.05-3.5H8.65L7.6 17H5.5L7 12h3V9z"/></svg>
                                Accès aux personnes à mobilité réduite
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Social links --}}
                @if ($shop->website || $shop->facebook || $shop->youtube || $shop->tiktok || $shop->twitter || $shop->linkedin || $shop->instagram)
                    <div class="flex gap-3">
                        @if ($shop->website)
                            <a href="{{ $shop->website }}" target="_blank" class="p-2.5 rounded-full bg-gray-100 text-carto-gray-300 hover:text-carto-pink hover:bg-gray-200 transition" title="Site web">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" /></svg>
                            </a>
                        @endif
                        @if ($shop->facebook)
                            <a href="{{ $shop->facebook }}" target="_blank" class="p-2.5 rounded-full bg-gray-100 text-carto-gray-300 hover:text-carto-pink hover:bg-gray-200 transition" title="Facebook">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        @endif
                        @if ($shop->instagram)
                            <a href="{{ $shop->instagram }}" target="_blank" class="p-2.5 rounded-full bg-gray-100 text-carto-gray-300 hover:text-carto-pink hover:bg-gray-200 transition" title="Instagram">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                        @endif
                        @if ($shop->youtube)
                            <a href="{{ $shop->youtube }}" target="_blank" class="p-2.5 rounded-full bg-gray-100 text-carto-gray-300 hover:text-carto-pink hover:bg-gray-200 transition" title="YouTube">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                        @endif
                        @if ($shop->tiktok)
                            <a href="{{ $shop->tiktok }}" target="_blank" class="p-2.5 rounded-full bg-gray-100 text-carto-gray-300 hover:text-carto-pink hover:bg-gray-200 transition" title="TikTok">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                            </a>
                        @endif
                        @if ($shop->twitter)
                            <a href="{{ $shop->twitter }}" target="_blank" class="p-2.5 rounded-full bg-gray-100 text-carto-gray-300 hover:text-carto-pink hover:bg-gray-200 transition" title="X (Twitter)">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                        @endif
                        @if ($shop->linkedin)
                            <a href="{{ $shop->linkedin }}" target="_blank" class="p-2.5 rounded-full bg-gray-100 text-carto-gray-300 hover:text-carto-pink hover:bg-gray-200 transition" title="LinkedIn">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                        @endif
                    </div>
                @endif

                {{-- Categories/Sectors --}}
                @if ($shop->categories->isNotEmpty())
                    <div>
                        <h3 class="text-lg font-lobster font-bold text-carto-main mb-2">Secteurs</h3>
                        <ul class="space-y-2">
                            @foreach ($shop->categories as $category)
                                <li class="flex items-center gap-2">
                                    @if ($category->icon)
                                        <img src="{{ asset('storage/bottin/icons/'.$category->icon) }}" alt="" class="w-6 h-6">
                                    @else
                                        <svg class="w-6 h-6 text-carto-gray-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" /></svg>
                                    @endif
                                    <span>{{ $category->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Tags --}}
                @if ($shop->tags->isNotEmpty())
                    <div class="flex flex-wrap gap-2">
                        @foreach ($shop->tags as $tag)
                            <a href="{{ route('circuit-court.filiere.show', $tag) }}" class="inline-flex items-center gap-1.5 rounded-full bg-carto-green/10 px-4 py-1.5 text-sm font-medium text-carto-main hover:bg-carto-green/20 transition">
                                @if ($tag->icon)
                                    <img src="{{ asset('storage/bottin/tags/'.$tag->icon) }}" alt="" class="w-5 h-5">
                                @else
                                    <svg class="w-5 h-5 text-carto-gray-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" /></svg>
                                @endif
                                <span title="{{ $tag->description }}">{{ $tag->name }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Comments/Description --}}
                @if ($shop->comment1)
                    <div class="prose lg:prose-xl">
                        <p>{{ $shop->comment1 }}</p>
                    </div>
                @endif
                @if ($shop->comment2)
                    <div class="prose lg:prose-xl">
                        <p>{{ $shop->comment2 }}</p>
                    </div>
                @endif
                @if ($shop->comment3)
                    <div class="prose lg:prose-xl">
                        <p>{{ $shop->comment3 }}</p>
                    </div>
                @endif

                {{-- Gallery --}}
                @if ($shop->medias->count() > 1)
                    <div>
                        <h3 class="text-lg font-lobster font-bold text-carto-main mb-3">Galerie</h3>
                        <div class="grid gap-4 lg:grid-cols-2">
                            @foreach ($shop->medias as $media)
                                @if (str_starts_with($media->mime_type ?? '', 'image'))
                                    <img
                                        src="{{ asset('storage/bottin/fiches/'.$shop->id.'/'.$media->file_name) }}"
                                        alt="{{ $media->name ?? $shop->company }}"
                                        class="w-full h-72 object-cover bg-slate-300 rounded-lg"
                                        loading="lazy"
                                    >
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Map link --}}
                @if ($shop->latitude && $shop->longitude)
                    <div>
                        <h3 class="text-lg font-lobster font-bold text-carto-main mb-3">Localisation</h3>
                        <a href="https://www.openstreetmap.org/?mlat={{ $shop->latitude }}&mlon={{ $shop->longitude }}#map=16/{{ $shop->latitude }}/{{ $shop->longitude }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 rounded-lg bg-carto-green px-4 py-2 text-sm font-medium text-white hover:bg-carto-green/80 transition">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            Voir sur OpenStreetMap
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
