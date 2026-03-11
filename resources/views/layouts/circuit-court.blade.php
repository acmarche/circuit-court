<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Circuit Court Marche-en-Famenne' }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="grid min-h-screen antialiased font-roboto text-carto-main" style="grid-template-rows: auto 1fr auto;">
        {{-- Header --}}
        <header class="bg-carto-green" x-data="{ mobileMenuOpen: false }">
            <nav class="flex items-center justify-between p-4 lg:px-8 text-white" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="{{ route('circuit-court.map') }}" class="-m-1.5 p-1.5">
                        <h1 class="lg:ml-3 font-lobster font-bold flex items-center flex-row md:gap-3">
                            <span class="text-xl md:text-3xl mr-2 lg:mr-0">Circuit court</span>
                            <span class="text-base md:text-3xl">Marche-en-Famenne</span>
                        </h1>
                    </a>
                </div>

                {{-- Mobile hamburger --}}
                <div class="flex lg:hidden">
                    <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-white" x-on:click="mobileMenuOpen = true">
                        <span class="sr-only">Ouvrir le menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>

                {{-- Desktop nav --}}
                <div class="hidden lg:flex lg:gap-x-12 font-roboto font-medium">
                    <a href="{{ route('circuit-court.map') }}" class="flex flex-col justify-center items-center lg:text-lg font-semibold leading-6 hover:text-carto-pink transition">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" /></svg>
                        <span>Carte</span>
                    </a>
                    <a href="{{ route('circuit-court.acteurs') }}" class="flex flex-col justify-center items-center lg:text-lg font-semibold leading-6 hover:text-carto-pink transition">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
                        <span>Liste</span>
                    </a>
                    <a href="{{ route('circuit-court.about') }}" class="flex flex-col justify-center items-center lg:text-lg font-semibold leading-6 hover:text-carto-pink transition">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>
                        <span>A propos</span>
                    </a>
                </div>

                <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-2">
                    <a href="https://www.marche.be" target="_blank" title="Site de la Ville" class="hover:opacity-70 transition">
                        <img class="w-24" alt="Ville de Marche" src="{{ asset('images/Marche_logo_Transparent.png') }}">
                    </a>
                    <a href="https://adl.marche.be" target="_blank" title="Agence de Développement Local" class="mr-12 hover:opacity-70 transition">
                        <img class="w-24" alt="ADL" src="{{ asset('images/ADL_Logo.png') }}">
                    </a>
                </div>
            </nav>

            {{-- Mobile menu --}}
            <div x-show="mobileMenuOpen" x-cloak class="lg:hidden" role="dialog" aria-modal="true">
                <div class="fixed inset-0 z-40" x-on:click="mobileMenuOpen = false"></div>
                <div x-show="mobileMenuOpen"
                     x-transition:enter="transition ease-in-out duration-300 transform"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300 transform"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="fixed inset-y-0 right-0 z-40 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                    <div class="flex items-center justify-between">
                        <a href="https://www.marche.be" class="-m-1.5 p-1.5" target="_blank">
                            <img class="h-8 w-auto" src="{{ asset('images/Marche_logo_Transparent.png') }}" alt="">
                        </a>
                        <a href="https://adl.marche.be" class="-m-1.5 p-1.5" target="_blank">
                            <img class="h-8 w-auto" src="{{ asset('images/ADL_Logo.png') }}" alt="">
                        </a>
                        <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" x-on:click="mobileMenuOpen = false">
                            <span class="sr-only">Fermer le menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-gray-500/10">
                            <div class="space-y-2 py-6">
                                <a href="{{ route('circuit-court.map') }}" x-on:click="mobileMenuOpen = false" class="flex flex-col justify-center items-center -mx-3 rounded-lg px-3 py-2 text-base font-semibold leading-7 text-carto-main hover:text-carto-pink">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" /></svg>
                                    <span>Carte</span>
                                </a>
                                <a href="{{ route('circuit-court.acteurs') }}" x-on:click="mobileMenuOpen = false" class="flex flex-col justify-center items-center -mx-3 rounded-lg px-3 py-2 text-base font-semibold leading-7 text-carto-main hover:text-carto-pink">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
                                    <span>Liste</span>
                                </a>
                                <a href="{{ route('circuit-court.about') }}" x-on:click="mobileMenuOpen = false" class="flex flex-col justify-center items-center -mx-3 rounded-lg px-3 py-2 text-base font-semibold leading-7 text-carto-main hover:text-carto-pink">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>
                                    <span>A propos</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="bg-carto-gray-200">
            <div class="mx-auto max-w-7xl overflow-hidden px-6 py-4 sm:py-12 lg:px-8">
                <nav class="-mb-6 columns-2 sm:flex sm:justify-center sm:space-x-12" aria-label="Footer">
                    <div class="pb-6">
                        <a href="{{ route('circuit-court.map') }}" class="leading-6 text-white hover:text-carto-pink">Carte</a>
                    </div>
                    <div class="pb-6">
                        <a href="{{ route('circuit-court.acteurs') }}" class="leading-6 text-white hover:text-carto-pink">Liste</a>
                    </div>
                    <div class="pb-6">
                        <a href="{{ route('circuit-court.filieres') }}" class="leading-6 text-white hover:text-carto-pink">Par filière</a>
                    </div>
                    <div class="pb-6">
                        <a href="{{ route('circuit-court.localites') }}" class="leading-6 text-white hover:text-carto-pink">Par localité</a>
                    </div>
                    <div class="pb-6">
                        <a href="{{ route('circuit-court.about') }}" class="leading-6 text-white hover:text-carto-pink">A propos</a>
                    </div>
                </nav>
                <p class="mt-10 text-center leading-5 text-white/80">
                    <a href="https://www.marche.be/administration/rgpd">
                        &copy; {{ date('Y') }} Marche-en-Famenne, Administration communale. Tous droits réservés.
                    </a>
                </p>
            </div>
        </footer>

        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
        @livewireScripts
    </body>
</html>
