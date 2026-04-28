@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-file-contract me-2"></i>Gestion des Contrats
                        </h4>
                        <a href="{{ route('contracts.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-1"></i> Nouveau Contrat
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th><i class="fas fa-hashtag me-1"></i> N° Contrat</th>
                                    <th><i class="fas fa-user me-1"></i> Locataire</th>
                                    <th><i class="fas fa-home me-1"></i> Propriété</th>
                                    <th><i class="fas fa-calendar me-1"></i> Période</th>
                                    <th><i class="fas fa-money-bill me-1"></i> Loyer</th>
                                    <th><i class="fas fa-circle me-1"></i> Statut</th>
                                    <th><i class="fas fa-cogs me-1"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contracts as $contract)
                                <tr>
                                    <td>
                                        <strong>{{ $contract->numero_contrat }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $contract->created_at->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $contract->user->photo_profil ? asset('storage/' . $contract->user->photo_profil) : asset('images/default-avatar.png') }}"
                                                 class="rounded-circle me-2" width="30" height="30" alt="{{ $contract->user->prenom }}">
                                            <div>
                                                {{ $contract->user->prenom }} {{ $contract->user->nom }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $contract->property->adresse }}
                                        <br>
                                        <small class="text-muted">{{ $contract->property->ville }}</small>
                                    </td>
                                    <td>
                                        {{ $contract->date_debut->format('d/m/Y') }} -
                                        {{ $contract->date_fin->format('d/m/Y') }}
                                        <br>
                                        <small class="text-muted">{{ $contract->duree_mois }} mois</small>
                                    </td>
                                    <td>
                                        <strong class="text-success">{{ number_format($contract->loyer_mensuel, 0, ',', ' ') }} XAF</strong>
                                        <br>
                                        <small>Caution: {{ number_format($contract->caution, 0, ',', ' ') }} XAF</small>
                                    </td>
                                    <td>
                                        @php
                                        $statusColors = [
                                            'actif' => 'success',
                                            'expire' => 'secondary',
                                            'resilie' => 'danger',
                                            'avenant' => 'info'
                                        ];
                                        $statusIcons = [
                                            'actif' => 'check-circle',
                                            'expire' => 'clock',
                                            'resilie' => 'times-circle',
                                            'avenant' => 'file-alt'
                                        ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$contract->statut] }}">
                                            <i class="fas fa-{{ $statusIcons[$contract->statut] }} me-1"></i>
                                            {{ ucfirst($contract->statut) }}
                                        </span>
                                        @if($contract->estActif())
                                        <br>
                                        <small class="text-muted">{{ $contract->joursRestants() }} jours restants</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('contracts.show', $contract) }}" class="btn btn-info btn-sm" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('contracts.download', $contract) }}" class="btn btn-primary btn-sm" title="Télécharger">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a href="{{ route('contracts.preview', $contract) }}" class="btn btn-secondary btn-sm" title="Aperçu" target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            @if($contract->statut === 'actif')
                                            <form action="{{ route('contracts.terminate', $contract) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm" title="Résilier"
                                                        onclick="return confirm('Résilier ce contrat?')">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                            @endif
                                            <form action="{{ route('contracts.destroy', $contract) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Supprimer"
                                                        onclick="return confirm('Supprimer ce contrat?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-file-contract fa-3x mb-3"></i>
                                        <p>Aucun contrat enregistré</p>
                                        <a href="{{ route('contracts.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> Créer un contrat
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($contracts->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $contracts->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
