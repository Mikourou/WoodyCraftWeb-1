<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a category') }}
        </h2>
    </x-slot>

    <x-puzzles-card>
        <!-- Message de réussite -->
        @if (session()->has('message'))
            <div class="mt-3 mb-4 list-disc list-inside text-sm text-green-600">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('categories.store') }}" method="post">
            @csrf

            <!-- Nom -->
            <div>
                <x-input-label for="libelle" :value="__('libelle')" />
                <x-text-input id="libelle" class="block mt-1 w-full" type="text" name="libelle" :value="old('libelle')" required autofocus />
                <x-input-error :messages="$errors->get('libelle')" class="mt-2" />
            </div>

            <!-- description -->
            <div>
                <x-input-label for="description" :value="__('description')" />
                <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required autofocus />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- image -->
            <div>
                <x-input-label for="path_image" :value="__('image')" />
                <x-text-input id="path_image" class="block mt-1 w-full" type="text" name="path_image" required autofocus />
                <x-input-error :messages="$errors->get('path_image')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-3">
                    {{ __('Send') }}
                </x-primary-button>
            </div>
        </form>
    </x-puzzles-card>
</x-app-layout>
