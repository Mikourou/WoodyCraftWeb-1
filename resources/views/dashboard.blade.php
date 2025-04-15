<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ __('Accueil') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Section message de bienvenue -->
            <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500 p-3 rounded-lg shadow-md text-white text-center">
                <h3 class="text-lg font-semibold">
                    @if(Auth::check())
                        Bienvenue, {{ Auth::user()->user->first_name }}
                    @else
                        Bienvenue, invité
                    @endif
                </h3>
            </div>

            <!-- Puzzle Cards Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($puzzles as $p)
                    <a href="{{ route('puzzles.show', $p->id) }}" class="bg-white rounded-lg overflow-hidden shadow-lg transform transition duration-500 hover:scale-105">
                        @if ($p->path_image)
                            <img src="{{ asset($p->path_image) }}" alt="{{ $p->nom }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500">
                                @lang('No image available')
                            </div>
                        @endif
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-800 text-lg">{{ $p->nom }}</h4>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
