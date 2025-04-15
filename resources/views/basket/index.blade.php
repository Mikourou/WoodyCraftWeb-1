<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Basket')
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <!-- Affichage des messages de session -->
        @if (session()->has('message'))
            <div class="bg-blue-100 border border-blue-500 text-blue-700 p-4 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Vérification si le panier contient des articles -->
        @if (count($basket) > 0)
            <h1 class="text-2xl font-bold mb-4">Mon panier</h1>
            <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-200 mb-4">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-2 text-left">Produit</th>
                            <th class="py-3 px-2 text-left">Prix</th>
                            <th class="py-3 px-2 text-left">Quantité</th>
                            <th class="py-3 px-2 text-left">Total</th>
                            <th class="py-3 px-2 text-left">Opérations</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @php $total = 0; @endphp <!-- Initialisation du total général -->

                        <!-- Parcourir les articles du panier -->
                        @foreach ($basket as $puzzleId => $puzzles)
                            @php
                                $nom = $puzzles['puzzle']['nom'];
                                $prix = $puzzles['puzzle']['prix'];
                                $quantity = $puzzles['quantity'];
                                $total += $prix * $quantity;
                            @endphp
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-4 px-2 flex items-center">
                                    @if (isset($puzzles['puzzle']['path_image']))
                                        <div class="flex flex-col items-center">
                                            <img src="{{ asset($puzzles['puzzle']['path_image']) }}"
                                                 alt="{{ $nom }}"
                                                 class="h-20 w-20 object-cover rounded mb-1">
                                            <span class="text-center text-gray-800">{{ $nom }}</span>
                                        </div>
                                    @else
                                        <p>@lang('No image available')</p>
                                    @endif
                                </td>
                                <td class="py-4 px-2">{{ number_format($prix, 2) }} €</td>
                                <td class="py-4 px-2">
                                    <form action="{{ route('basket.store', $puzzles['puzzle']['id']) }}" method="POST">
                                        @csrf
                                        <input type="number"
                                               name="quantity"
                                               value="{{ $quantity }}"
                                               class="border border-gray-300 rounded p-1 w-16 mr-2">
                                        <button type="submit" class="bg-blue-500 text-white rounded p-1 hover:bg-blue-600">
                                            Actualiser
                                        </button>
                                    </form>
                                </td>
                                <td class="py-4 px-2">{{ number_format($prix * $quantity, 2) }}€</td>
                                <td class="py-4 px-2">
                                    <form method="POST" action="{{ route('basket.destroy', $puzzles['puzzle']['id']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 text-white rounded p-1 hover:bg-red-600">
                                            Retirer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="font-bold">
                            <td colspan="4" class="py-4 px-2 text-left">Total général</td>
                            <td class="py-4 px-2">{{ number_format($total, 2) }}€</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex space-x-4 mt-4">
                <!-- Bouton pour passer au paiement -->
                <form action="{{ route('vA') }}" method="GET">
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow">
                        @lang('Passer au paiement')
                    </button>
                </form>

                <!-- Formulaire pour vider le panier -->
                <form action="{{ route('basket.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-400 text-white font-semibold py-2 px-4 rounded-lg shadow">
                        Vider le panier
                    </button>
                </form>
            </div>
        @else
            <div class="bg-red-100 border border-red-500 text-red-700 p-4 rounded mb-4">
                Votre panier est vide.
            </div>
        @endif

    </div>
</x-app-layout>
