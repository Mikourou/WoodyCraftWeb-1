<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ __('Category') }} : {{ $categories->libelle }}
        </h2>
    </x-slot>

    <!-- Description de la catégorie -->
    <div class="py-6 max-w-3xl mx-auto">
        <p class="text-lg text-gray-700">{{ $categories->description }}</p>
    </div>

    <!-- Grille des puzzles de la catégorie -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @foreach($puzzles as $p)
            <a href="{{ route('puzzles.show', $p->id) }}" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 transform hover:scale-105">
                @if ($p->path_image)
                    <img src="{{ asset($p->path_image) }}" alt="{{ $p->nom }}" class="w-full h-40 object-cover rounded-lg mb-4">
                @else
                    <div class="w-full h-40 flex items-center justify-center bg-gray-200 text-gray-500 rounded-lg mb-4">
                        @lang('No image available')
                    </div>
                @endif
                <h3 class="text-xl font-semibold text-gray-800">{{ $p->nom }}</h3>
            </a>
        @endforeach
    </div>
</x-app-layout>
