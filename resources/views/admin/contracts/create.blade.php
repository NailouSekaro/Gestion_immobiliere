@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-file-contract me-2"></i>Nouveau Contrat
                        </h4>
                        <a href="{{ route('contracts.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-1"></i> Retour
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contracts.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="user_id" class="form-label">Locataire assigne</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">Selectionner un locataire</option>
                                @foreach ($locataires as $locataire)
                                    <option value="{{ $locataire->id }}" data-property-id="{{ $locataire->property_id }}"
                                        data-loyer="{{ $locataire->property->loyer_mensuel ?? 0 }}"
                                        data-caution="{{ $locataire->property->caution ?? 0 }}"
                                        {{ old('user_id') == $locataire->id ? 'selected' : '' }}>
                                        {{ $locataire->prenom }} {{ $locataire->nom }} -
                                        {{ $locataire->property->nom ?: $locataire->property->adresse }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="property_id" id="property_id" value="{{ old('property_id') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_debut" class="form-label">Date de debut</label>
                                <input type="date" name="date_debut" id="date_debut" class="form-control"
                                    value="{{ old('date_debut', now()->toDateString()) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="duree_mois" class="form-label">Duree (mois)</label>
                                <input type="number" name="duree_mois" id="duree_mois" class="form-control"
                                    value="{{ old('duree_mois', 12) }}" min="1" max="36" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="loyer_mensuel" class="form-label">Loyer mensuel</label>
                                <input type="number" name="loyer_mensuel" id="loyer_mensuel" class="form-control"
                                    value="{{ old('loyer_mensuel') }}" min="0" step="1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="caution" class="form-label">Caution</label>
                                <input type="number" name="caution" id="caution" class="form-control"
                                    value="{{ old('caution') }}" min="0" step="1">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="termes" class="form-label">Termes</label>
                            <textarea name="termes" id="termes" class="form-control" rows="4">{{ old('termes') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Etablir le contrat
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userSelect = document.getElementById('user_id');
        const propertyInput = document.getElementById('property_id');
        const loyerInput = document.getElementById('loyer_mensuel');
        const cautionInput = document.getElementById('caution');

        function syncProperty() {
            const selected = userSelect.options[userSelect.selectedIndex];
            if (!selected) {
                return;
            }

            propertyInput.value = selected.dataset.propertyId || propertyInput.value;
            if (!loyerInput.value) {
                loyerInput.value = selected.dataset.loyer || 0;
            }
            if (!cautionInput.value) {
                cautionInput.value = selected.dataset.caution || 0;
            }
        }

        userSelect.addEventListener('change', function() {
            loyerInput.value = '';
            cautionInput.value = '';
            syncProperty();
        });
        syncProperty();
    });
</script>
@endsection
