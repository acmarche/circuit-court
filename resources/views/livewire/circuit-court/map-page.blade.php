<div>
    @include('livewire.circuit-court.partials.shop-preview')

    <div class="mx-auto max-w-full px-0 py-8 sm:px-6 sm:py-12 lg:px-8">
        {{-- Welcome hero --}}
        <div class="border-b border-gray-200 pb-6 px-4 sm:px-0">
            <h2 class="font-lobster font-bold mx-auto max-w-max bg-slate-400 bg-linear-to-r from-carto-pink via-carto-main to-carto-gray-200 bg-clip-text text-transparent bg-[length:250px_100%] bg-no-repeat px-10 py-1 text-center text-4xl animate-shimmer">
                Du local, du circuit court, du solidaire...
            </h2>
            <h3 class="text-4xl font-bold font-lobster tracking-tight text-carto-pink mt-2">Carte dynamique</h3>
            <p class="mt-4 text-2xl text-carto-main font-lobster italic">
                Vous trouverez sur cette carte les acteurs et intervenants de différentes filières liées au circuit court dans la commune de Marche-en-Famenne.
            </p>
        </div>

        @include('livewire.circuit-court.partials.filters-mobile')

        <div class="pt-4 grid grid-cols-1 lg:gap-x-8 lg:grid-cols-[auto_minmax(0,1fr)]">
            @include('livewire.circuit-court.partials.filters-sidebar')

            <div>
                <div class="flex flex-row items-center justify-between mb-4">
                    <h2 class="text-xl lg:text-3xl text-carto-pink px-3">
                        {{ $this->shops->count() }} acteurs et intervenants trouvés
                    </h2>
                </div>

                {{-- Map --}}
                <section
                    class="relative overflow-hidden rounded-lg"
                    x-data="circuitCourtMap()"
                    x-init="initMap()"
                    wire:ignore
                >
                    <div id="circuit-court-map" class="w-full h-[70vh] lg:h-[80vh]"></div>
                    <button type="button" x-on:click="window.scrollTo(0, 0)" class="absolute bottom-4 right-4 z-20 md:hidden bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 transition">
                        <svg class="w-8 h-8 text-carto-main hover:text-carto-pink" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                        </svg>
                    </button>
                </section>
            </div>
        </div>
    </div>
</div>

@script
<script>
    Alpine.data('circuitCourtMap', () => ({
        map: null,
        markers: null,

        async initMap() {
            const center = [50.217845, 5.331049];
            this.map = L.map('circuit-court-map').setView(center, 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a>',
                maxZoom: 19,
            }).addTo(this.map);

            this.markers = L.markerClusterGroup();
            this.map.addLayer(this.markers);

            await this.refreshMarkers();

            Livewire.on('filters-changed', () => {
                this.$nextTick(() => this.refreshMarkers());
            });
        },

        async refreshMarkers() {
            const shops = await $wire.getShopsForMap();
            this.markers.clearLayers();

            shops.forEach(shop => {
                if (!shop.lat || !shop.lng) return;

                const iconOptions = shop.icon
                    ? { iconUrl: shop.icon, iconSize: [32, 32], iconAnchor: [16, 32] }
                    : { iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png', iconSize: [25, 41], iconAnchor: [12, 41] };

                const marker = L.marker([shop.lat, shop.lng], {
                    title: shop.company,
                    icon: L.icon(iconOptions),
                });

                marker.on('click', () => {
                    $wire.showPreview(shop.id);
                });

                marker.bindTooltip(shop.company, { direction: 'top', offset: [0, -20] });
                this.markers.addLayer(marker);
            });

            if (shops.length > 0) {
                const bounds = this.markers.getBounds();
                if (bounds.isValid()) {
                    this.map.fitBounds(bounds, { padding: [30, 30] });
                }
            }
        }
    }));
</script>
@endscript
