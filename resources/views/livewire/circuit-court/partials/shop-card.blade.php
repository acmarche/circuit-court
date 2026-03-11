@props(['shop'])

@php
    $mainImage = $shop->medias->first(fn ($m) => $m->is_main);
    $image = $mainImage
        ? asset('storage/'.$mainImage->file_name)
        : ($shop->medias->first() ? asset('storage/'.$shop->medias->first()->file_name) : null);
@endphp

<article class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm hover:shadow-md transition-shadow duration-300">
    <div class="aspect-4/3 w-full overflow-hidden bg-gray-200">
        @if ($image)
            <img src="{{ $image }}" alt="{{ $shop->company }}" class="h-full w-full object-cover object-center transition-transform duration-500 ease-in-out group-hover:scale-105" loading="lazy">
        @else
            <div class="h-full w-full flex items-center justify-center bg-linear-to-br from-carto-green/20 to-carto-pink/10">
                <svg class="w-16 h-16 text-carto-gray-200" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                </svg>
            </div>
        @endif
    </div>
    <div class="flex flex-1 flex-col space-y-2 p-4">
        <h3 class="text-lg font-bold text-carto-gray-300">
            <a href="{{ route('circuit-court.acteur.show', $shop) }}" class="hover:text-carto-pink transition">
                <span aria-hidden="true" class="absolute inset-0"></span>
                {{ $shop->company }}
            </a>
        </h3>
        <p class="text-sm text-gray-600">
            {{ $shop->city }} - {{ $shop->street }} {{ $shop->number }}
        </p>
        @if ($shop->phone || $shop->mobile)
            <p class="text-xs italic text-gray-500">{{ $shop->phone }} {{ $shop->mobile }}</p>
        @endif
        @if ($shop->comment1)
            <p class="text-sm text-carto-gray-300 line-clamp-3">{{ $shop->comment1 }}</p>
        @endif
        @if ($shop->categories->isNotEmpty())
            <div class="flex flex-wrap gap-1 pt-1">
                @foreach ($shop->categories->take(3) as $category)
                    <span class="text-xs text-carto-gray-200">{{ $category->name }}</span>
                @endforeach
            </div>
        @endif
    </div>
</article>
