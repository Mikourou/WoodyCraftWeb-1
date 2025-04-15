<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des commandes') }}
        </h2>
    </x-slot>

    @php
        $articles = json_decode($order->articles, true); // Decode le JSON en tableau associatif
    @endphp

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('admin.update') }}" method="post">
                @csrf
                @method('PUT') <!-- method PUT pour mettre à jour le statut -->

                <!-- ajoute un champ caché pour que l'ID de la commande soit bien envoyé avec la requête -->
                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Détails
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Informations
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- ID -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <strong>ID:</strong>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->id }}
                            </td>
                        </tr>
                        <!-- Type de Paiement -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <strong>Type de Paiement:</strong>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->type_paiement }}
                            </td>
                        </tr>
                        <!-- Date de Commande -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <strong>Date de Commande:</strong>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->date_commande }}
                            </td>
                        </tr>
                        <!-- articles -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <strong>articles:</strong>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if(is_array($articles))

                                    <ul class="list-disc">

                                        @foreach($articles as $article)

                                            <li class="list-disc">produit : {{ $article['nom'] }} - quantité : {{ $article['quantity']}} - {{ $article['prix']}}€</li>

                                        @endforeach

                                    </ul>

                                @endif

                                @php
                                    $articles_json = json_encode($articles);
                                @endphp

                            </td>
                        </tr>
                        <!-- Prix -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <strong>Prix:</strong>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->total_prix }}€
                            </td>
                        </tr>
                        <!-- Methode paiement -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <strong>Méthode de paiement:</strong>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->methode_paiement }}
                            </td>
                        </tr>
                        <!-- Statut Commande -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <strong>Statut Commande:</strong>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <x-input-label for="statut_commande_{{ $order->id }}" :value="__('Statut Commande')" />
                                <select id="statut_commande_{{ $order->id }}" name="statut_commande" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="0" @if($order->statut_commande == 0) selected @endif>
                                        {{ __('En attente') }}
                                    </option>
                                    <option value="1" @if($order->statut_commande == 1) selected @endif>
                                        {{ __('Validé') }}
                                    </option>
                                    <option value="2" @if($order->statut_commande == 2) selected @endif>
                                        {{ __('Annulée') }}
                                    </option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>


                <div class="flex justify-end mt-10 mb-8 ml-8 mr-8">
                    <button type="submit" class="bg-green-500 hover:bg-green-400 text-white font-semibold py-2 px-6 rounded-lg shadow">
                        {{ __('Confirmer les modifications') }}
                    </button>
                </div>


            </form>
        </div>
    </div>
</x-app-layout>
