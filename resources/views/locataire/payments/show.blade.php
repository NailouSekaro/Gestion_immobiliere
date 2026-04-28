@extends('layouts.template')


@section('title', 'Détail du paiement')


@section('content')
    <div class="container mx-auto px-4 py-8 max-w-3xl">


        <div class="bg-white shadow-xl rounded-3xl p-8">
            <h2 class="text-2xl font-bold mb-6">Paiement {{ $payment->periode }}</h2>


            <div class="grid grid-cols-2 gap-4 text-sm mb-6">
                <p><strong>Bien :</strong> {{ $payment->property->nom }}</p>
                <p><strong>Montant :</strong> {{ number_format($payment->montant, 0, ',', ' ') }} FCFA</p>
                <p><strong>Statut :</strong> {{ ucfirst($payment->statut) }}</p>
                <p><strong>Date limite :</strong> {{ $payment->date_limite }}</p>
            </div>


            @if ($payment->statut !== 'paye')
                <form method="POST" action="{{ route('locataire.payments.fedapay', $payment) }}">
                    @csrf
                    <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold">
                        Payer avec FedaPay
                    </button>
                </form>
            @else
                <a href="{{ route('paiements.receipt', $payment) }}"
                    class="block text-center bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl">
                    Télécharger le reçu
                </a>
            @endif
        </div>
    </div>
@endsection
