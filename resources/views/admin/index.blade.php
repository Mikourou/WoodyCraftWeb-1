<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des commandes') }}
        </h2>
    </x-slot>

    <!-- Message de réussite -->
    @if (session()->has('message'))
        <div class="mt-3 mb-4 list-disc list-inside text-sm text-green-600">
            {{ session('message') }}
        </div>
    @endif


    <!-- Tableau des commandes -->
    <div class="overflow-x-auto mt-6">
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left border border-gray-300">{{ __('ID Commande') }}</th>
                    <th class="px-4 py-2 text-left border border-gray-300">{{ __('ID Client') }}</th>
                    <th class="px-4 py-2 text-left border border-gray-300">{{ __('Type de Paiement') }}</th>
                    <th class="px-4 py-2 text-left border border-gray-300">{{ __('Date de Commande') }}</th>
                    <th class="px-4 py-2 text-left border border-gray-300">{{ __('Prix') }}</th>
                    <th class="px-4 py-2 text-left border border-gray-300">{{ __('Statut de Commande') }}</th>
                    <th class="px-4 py-2 text-left border border-gray-300">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $o)

                @php
                    $commande_statut = "";

                    if ($o->statut_commande === 0) {
                        $commande_statut = "en attente de validation";
                    } elseif ($o->statut_commande == 1) {
                        $commande_statut = "commande validée";
                    } elseif ($o->statut_commande == 2) {
                        $commande_statut = "commande annulée";
                    }
                @endphp

                    <tr>
                        <td class="px-4 py-2 border border-gray-300">{{ $o->id }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $o->user_id }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $o->type_paiement }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $o->date_commande }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $o->total_prix }}€</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $commande_statut }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            <a href="{{ route('admin.edit', ['id' => $o->id]) }}" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow">
                                {{ __('Valider') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
