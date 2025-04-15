<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Récapitulatif de la commande')
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        @if ($basket)
            <h1 class="text-2xl font-bold mb-4">Votre commande</h1>
            <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-200 mb-4">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-2 text-left">Produit</th>
                            <th class="py-3 px-2 text-left">Prix</th>
                            <th class="py-3 px-2 text-left">Quantité</th>
                            <th class="py-3 px-2 text-left">Total</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">

                        @php
                            $totalP = 0;
                        @endphp

                        @foreach ($basket as $puzzleId => $puzzles)
                            @php
                                $nom = $puzzles['puzzle']['nom'] ?? 'Nom indisponible';  // Récupérer le nom du puzzle
                                $prix = $puzzles['puzzle']['prix'] ?? 0;  // Récupérer le prix du puzzle
                                $quantity = $puzzles['quantity'] ?? 1;  // Récupérer la quantité
                                $total = $prix * $quantity;  // Calculer le total pour cet article
                                $imagePath = $puzzles['puzzle']['path_image'] ?? null; // Récupérer l'image
                                $totalP += $prix * $quantity;
                            @endphp
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-4 px-2 flex items-center">
                                    @if ($imagePath)
                                        <div class="flex flex-col items-center">
                                            <img src="{{ asset($imagePath) }}" alt="{{ $nom }}" class="h-20 w-20 object-cover rounded mb-1">
                                            <span class="text-center text-gray-800">{{ $nom }}</span>
                                        </div>
                                    @else
                                        <p>@lang('No image available')</p>
                                    @endif
                                </td>
                                <td class="py-4 px-2">{{ number_format($prix, 2) }} €</td>
                                <td class="py-4 px-2">{{ $quantity }}</td>
                                <td class="py-4 px-2">{{ number_format($total, 2) }} €</td>
                            </tr>
                        @endforeach

                        <tr class="font-bold">
                        <td colspan="3" class="py-4 px-2 text-left">Total général</td>
                        <td class="py-4 px-2">{{ $totalP }} €</td>




                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-red-100 border border-red-500 text-red-700 p-4 rounded mb-4">Aucun produit dans le panier</div>
        @endif

        <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow">
            <a href="{{ route('paiement.methode') }}">{{__('Choose a payment method')}}</a>
        </button>
    </div>
</x-app-layout>
