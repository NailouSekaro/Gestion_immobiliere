@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-file-contract me-2"></i>Contrat {{ $contract->numero_contrat }}
                        </h4>
                        <div class="btn-group">
                            <a href="{{ route('contracts.download', $contract) }}" class="btn btn-light">
                                <i class="fas fa-download me-1"></i> PDF
                            </a>
                            <a href="{{ route('contracts.index') }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-1"></i> Retour
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <i class="fas fa-info-circle me-2"></i>Informations du Contrat
                                </div>
                                <div class="card-body">
                                    <p><strong>N° Contrat:</strong> {{ $contract->numero_contrat }}</p>
                                    <p><strong>Statut:</strong>
                                        <span class="badge bg-{{ $contract->statut === 'actif' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($contract->statut) }}
                                        </span>
                                    </p>
                                    <p><strong>Période:</strong>
                                        {{ $contract->date_debut->format('d/m/Y') }} - {{ $contract->date_fin->format('d/m/Y') }}
                                    </p>
                                    <p><strong>Durée:</strong> {{ $contract->duree_mois }} mois</p>
                                    @if($contract->date_signature)
                                    <p><strong>Signé le:</strong> {{ $contract->date_signature->format('d/m/Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <i class="fas fa-money-bill-wave me-2"></i>Conditions Financières
                                </div>
                                <div class="card-body">
                                    <p><strong>Loyer mensuel:</strong>
                                        <span class="text-success">{{ number_format($contract->loyer_mensuel, 0, ',', ' ') }} XAF</span>
                                    </p>
                                    <p><strong>Loyer annuel:</strong>
                                        {{ number_format($contract->loyer_annuel, 0, ',', ' ') }} XAF
                                    </p>
                                    <p><strong>Caution:</strong>
                                        {{ number_format($contract->caution, 0, ',', ' ') }} XAF
                                    </p>
                                    <p><strong>Devise:</strong> {{ $contract->devise }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Locataire et Propriété -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <i class="fas fa-user me-2"></i>Locataire
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ $contract->user->photo_profil ? asset('storage/' . $contract->user->photo_profil) : asset('images/default-avatar.png') }}"
                                             class="rounded-circle me-3" width="60" height="60" alt="{{ $contract->user->prenom }}">
                                        <div>
                                            <h6>{{ $contract->user->prenom }} {{ $contract->user->nom }}</h6>
                                            <small class="text-muted">{{ $contract->user->email }}</small>
                                        </div>
                                    </div>
                                    <p><strong>Téléphone:</strong> {{ $contract->user->telephone ?? 'Non renseigné' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <i class="fas fa-home me-2"></i>Propriété
                                </div>
                                <div class="card-body">
                                    <h6>{{ $contract->property->nom ?: 'Propriété #' . $contract->property->id }}</h6>
                                    <p>{{ $contract->property->adresse }}</p>
                                    <p>{{ $contract->property->ville }}, {{ $contract->property->pays }}</p>
                                    <p><strong>{{ $contract->property->nombre_pieces }} pièces</strong> - {{ $contract->property->surface }} m²</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <i class="fas fa-bolt me-2"></i>Actions
                        </div>
                        <div class="card-body">
                            <div class="btn-group">
                                <a href="{{ route('contracts.download', $contract) }}" class="btn btn-primary">
                                    <i class="fas fa-download me-1"></i> Télécharger le PDF
                                </a>
                                <a href="{{ route('contracts.preview', $contract) }}" class="btn btn-secondary" target="_blank">
                                    <i class="fas fa-eye me-1"></i> Aperçu
                                </a>
                                @if(auth()->user()->isAdmin() && !$contract->date_signature)
                                <form action="{{ route('contracts.sign', $contract) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-signature me-1"></i> Marquer comme signé
                                    </button>
                                </form>
                                @endif
                                @if(auth()->user()->isAdmin() && $contract->statut === 'actif')
                                <form action="{{ route('contracts.terminate', $contract) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning"
                                            onclick="return confirm('Résilier ce contrat?')">
                                        <i class="fas fa-ban me-1"></i> Résilier
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
