<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ $puzzle->nom }}
        </h2>
    </x-slot>

    <!-- Affichage des messages de session -->
    @if (session()->has('message'))
        <div class="bg-blue-100 border border-blue-500 text-blue-700 p-4 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex justify-center pt-12">
        <div class="max-w-4xl w-full p-8 bg-white shadow-lg rounded-lg flex flex-col lg:flex-row items-start space-y-8 lg:space-y-0 lg:space-x-10">
            <!-- Section de gauche : Description du puzzle -->
            <div class="lg:w-2/3">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $puzzle->nom }}</h1>
                <p class="text-gray-600 leading-relaxed mb-6">
                    <span class="font-semibold text-lg">@lang('Description'):</span> {{ $puzzle->description }}
                </p>

                <div class="text-lg font-bold text-gray-900 mb-6">
                    {{ $puzzle->prix }} €
                </div>

                <!-- Formulaire pour ajouter au panier -->
                <form method="POST" action="{{ route('basket.store', $puzzle) }}" class="space-y-4">
                    @csrf
                    <div class="flex items-center space-x-3">
                        <input type="number" name="quantity" placeholder="@lang('Quantité ?')" class="w-16 text-center border border-gray-300 rounded-full shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-200" min="1" required>
                        <button type="submit" class="bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500 hover:from-purple-600 hover:via-pink-500 hover:to-red-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                            @lang('Ajouter au panier')
                        </button>

                    </div>
                </form>
            </div>

            <!-- Section de droite : Image du puzzle -->
            <div class="lg:w-1/3">
                @if ($puzzle->path_image)
                    <img src="{{ asset($puzzle->path_image) }}" alt="{{ $puzzle->nom }}" class="w-full h-auto max-w-xs rounded-lg shadow-md object-cover">
                @else
                    <div class="bg-gray-200 text-gray-500 h-48 flex items-center justify-center rounded-lg shadow-md">
                        <p>@lang('Aucune image disponible')</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
