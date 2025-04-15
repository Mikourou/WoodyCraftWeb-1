<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            @lang('Liste des puzzles')
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Message de réussite -->
            @if (session()->has('message'))
                <div class="mt-3 mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded text-sm">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Puzzle List Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($puzzles as $puzzle)
                    <a href="{{ route('puzzles.show', $puzzle->id) }}" class="bg-white rounded-lg overflow-hidden shadow-lg transform transition duration-500 hover:scale-105">
                        @if ($puzzle->path_image)
                            <img src="{{ asset($puzzle->path_image) }}" alt="{{ $puzzle->nom }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500">
                                @lang('No image available')
                            </div>
                        @endif
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-800 text-lg">{{ $puzzle->nom }}</h4>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
