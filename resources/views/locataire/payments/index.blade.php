@extends('layouts.template')
@section('content')
    <div class="container py-4">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="bg-green-100 rounded-2xl p-4 shadow-sm h-100">
                    <p class="text-sm text-green-700 mb-1">Total payé</p>
                    <h2 class="text-2xl font-bold text-green-800 mb-0">{{ number_format($totalPaye, 0, ',', ' ') }} FCFA</h2>
                </div>
            </div>

            <div class="col-md-4">
                <div class="bg-yellow-100 rounded-2xl p-4 shadow-sm h-100">
                    <p class="text-sm text-yellow-700 mb-1">Paiements en attente</p>
                    <h2 class="text-2xl font-bold mb-0">{{ $enAttente }}</h2>
                </div>
            </div>

            <div class="col-md-4">
                <div class="bg-red-100 rounded-2xl p-4 shadow-sm h-100">
                    <p class="text-sm text-red-700 mb-1">Paiements en retard</p>
                    <h2 class="text-2xl font-bold mb-0">{{ $enRetard }}</h2>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="p-4">Période</th>
                        <th>Bien</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td class="p-4">{{ $payment->periode }}</td>
                            <td>{{ $payment->property->nom ?? '-' }}</td>
                            <td>{{ number_format($payment->montant, 0, ',', ' ') }} FCFA</td>
                            <td>
                                <span class="badge {{ $payment->statut === 'paye' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ ucfirst(str_replace('_', ' ', $payment->statut)) }}
                                </span>
                            </td>
                            <td class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('paiements.show', $payment) }}" class="btn btn-sm btn-outline-primary">
                                    Voir
                                </a>

                                @if ($payment->statut !== 'paye')
                                    <form method="POST" action="{{ route('locataire.payments.fedapay', $payment) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            Payer avec FedaPay
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('paiements.receipt', $payment) }}" class="btn btn-sm btn-success">
                                        Télécharger le reçu
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4">Aucun paiement trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $payments->links() }}</div>
    </div>
@endsection
