<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            @lang('Liste des catégories')
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Message de réussite -->
            @if (session()->has('message'))
                <div class="mt-3 mb-6 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded text-sm">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Grid pour afficher les catégories -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($cat as $categorie)
                    <a href="{{ route('categories.show', $categorie->id) }}" class="group block p-6 bg-white rounded-lg shadow-lg hover:shadow-2xl transform transition duration-300 hover:scale-105">
                        <!-- Image de la catégorie -->
                        @if ($categorie->path_image)
                            <img src="{{ asset($categorie->path_image) }}" alt="{{ $categorie->libelle }}" class="w-full h-32 object-cover rounded-lg mb-4 group-hover:opacity-90">
                        @else
                            <div class="w-full h-32 flex items-center justify-center bg-gray-200 text-gray-500 rounded-lg mb-4">
                                @lang('No image available')
                            </div>
                        @endif

                        <!-- Nom et description de la catégorie -->
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $categorie->libelle }}</h3>
                        <p class="text-gray-600 text-sm">
                            {{ Str::limit($categorie->description, 100, '...') }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
