
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Choisir un moyen de paiement')
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <!-- Formulaire Carte Bancaire -->
        <div class="border rounded-lg shadow p-6 bg-white">
            <p class="font-semibold text-lg mb-4">Carte Bancaire</p>
            <button onclick="toggleForm('carte-form')" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg mb-4">
                @lang('Payer par Carte Bancaire')
            </button>

            <div id="carte-form" class="hidden mt-4">
                <form action="{{ route('paiement.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type_paiement" value="carte-bancaire"> <!-- Champ caché pour type de paiement -->
                    <input type="hidden" name="date_commande" value="{{ now()->format('Y-m-d') }}">
                    <input type="hidden" name="methode_paiement" value="carte-bancaire"> <!-- Champ caché pour type de paiement -->

                    <div class="mb-4">
                        <label for="card-number" class="block text-left">Numéro de Carte:</label>
                        <input type="text" id="card-number" name="card-number" placeholder="1234 5678 9012 3456" class="border border-gray-300 rounded-lg p-2 w-full" maxlength="19" required>
                        <small class="text-gray-500">Format: 1234 5678 9012 3456</small>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="expiration-date" class="block text-left">Date d'Expiration:</label>
                            <input type="text" id="expiration-date" name="expiration-date" placeholder="MM/AA" class="border border-gray-300 rounded-lg p-2 w-full" required>
                        </div>
                        <div>
                            <label for="cvv" class="block text-left">CVV:</label>
                            <input type="text" id="cvv" name="cvv" class="border border-gray-300 rounded-lg p-2 w-full" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="card-holder" class="block text-left">Nom du Titulaire de la Carte:</label>
                        <input type="text" id="card-holder" name="card-holder" placeholder="Nom sur la carte" class="border border-gray-300 rounded-lg p-2 w-full" required>
                    </div>
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg mt-4">
                        @lang('Confirmer le paiement')
                    </button>
                </form>
            </div>
        </div>

        <!-- Formulaire PayPal -->
        <div class="border rounded-lg shadow p-6 bg-white mt-4">
            <p class="font-semibold text-lg mb-4">Paypal</p>
            <button onclick="toggleForm('paypal-form')" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg mb-4">
                @lang('Payer par Paypal')
            </button>

            <div id="paypal-form" class="hidden mt-4">
                <form action="{{ route('paiement.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type_paiement" value="paypal"> <!-- Champ caché pour type de paiement -->
                    <input type="hidden" name="date_commande" value="{{ now()->format('Y_m-d') }}">
                    <input type="hidden" name="methode_paiement" value="paypal"> <!-- Champ caché pour type de paiement -->

                    <div class="mb-4">
                        <label for="paypal-email" class="block text-left">Email PayPal:</label>
                        <input type="email" id="paypal-email" name="paypal-email" class="border border-gray-300 rounded-lg p-2 w-full" required>
                    </div>
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg mt-4">
                        @lang('Confirmer le paiement')
                    </button>
                </form>
            </div>
        </div>

        <!-- Formulaire Chèque -->
        <div class="border rounded-lg shadow p-6 bg-white mt-4">
            <p class="font-semibold text-lg mb-4">Chèque</p>
            <button onclick="toggleForm('cheque-form')" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg mb-4">
                @lang('Payer par Chèque')
            </button>

            <div id="cheque-form" class="hidden mt-4">
                <form action="{{ route('paiement.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type_paiement" value="cheque"> <!-- Champ caché pour type de paiement -->
                    <input type="hidden" name="date_commande" value="{{ now()->format('Y_m-d') }}">
                    <input type="hidden" name="methode_paiement" value="cheque"> <!-- Champ caché pour type de paiement -->

                    <div class="mb-4">
                        <label for="cheque-name" class="block text-left">Nom du Titulaire du Chèque:</label>
                        <input type="text" id="cheque-name" name="cheque-name" placeholder="Nom sur le chèque" class="border border-gray-300 rounded-lg p-2 w-full" required>
                    </div>
                    <div class="mb-4">
                        <label for="cheque-amount" class="block text-left">Montant:</label>
                        <input type="text" id="cheque-amount" name="cheque-amount" placeholder="Montant du chèque" class="border border-gray-300 rounded-lg p-2 w-full" required>
                    </div>

                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg mt-4">
                        @lang('Confirmer le paiement')
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script pour afficher/masquer le formulaire -->
    <script src={{ asset('js/script.js')  }}></script>



</x-app-layout>



