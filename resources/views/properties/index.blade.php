@extends('layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --success: #4cc9f0;
            --success-dark: #3a8fb8;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --card-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            padding: 2rem 0;
        }

        .container-fluid {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            overflow: hidden;
            background: white;
            margin-bottom: 2rem;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding: 1.5rem 2rem;
            font-weight: 600;
            background: linear-gradient(120deg, var(--primary), var(--primary-dark)) !important;
            color: white;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: rgb(9, 9, 9);
            display: flex;
            align-items: center;
            margin: 0;
        }

        .page-title i {
            margin-right: 12px;
            font-size: 1.5rem;
        }

        .btn {
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-light {
            background: white;
            color: var(--gray);
            border: 1px solid #dee2e6;
        }

        .btn-light:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-success {
            background: linear-gradient(to right, var(--success), var(--success-dark));
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(76, 201, 240, 0.4);
        }

        /* Styles spécifiques pour les boutons d’action */
        .action-btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            opacity: 1 !important; /* Assure que les boutons ne sont pas transparents */
            color: white !important;
            border-radius: 8px;
            margin: 0 0.2rem;
            transition: var(--transition);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-info {
            background: linear-gradient(to right, #60a5fa, #3b82f6);
        }

        .btn-warning {
            background: linear-gradient(to right, #facc15, #d97706);
        }

        .btn-danger {
            background: linear-gradient(to right, #f87171, #dc2626);
        }

        .btn-group {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            background: #2d3748;
            color: white;
            font-weight: 600;
            padding: 1rem;
            text-align: left;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
        }

        .table tr {
            transition: var(--transition);
            opacity: 0;
            transform: translateY(10px);
            animation: fadeInUp 0.5s ease forwards;
        }

        .table tr:nth-child(1) { animation-delay: 0.1s; }
        .table tr:nth-child(2) { animation-delay: 0.2s; }
        .table tr:nth-child(3) { animation-delay: 0.3s; }
        .table tr:nth-child(4) { animation-delay: 0.4s; }
        .table tr:nth-child(5) { animation-delay: 0.5s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table tr:hover {
            background-color: #f0f9ff;
            transform: scale(1.01);
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .badge i {
            margin-right: 0.4rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            font-weight: 500;
            opacity: 0;
            animation: fadeIn 0.5s ease forwards;
        }

        .alert-success {
            background: linear-gradient(to right, #34d399, #059669);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(to right, #f87171, #dc2626);
            color: white;
        }

        .alert i {
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.9rem 1.2rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            transition: var(--transition);
            font-size: 1rem;
            background-color: #f9fafc;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            outline: none;
            background-color: white;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px;
            padding-right: 3rem;
        }

        .filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background: #f9fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--gray);
            margin-bottom: 1rem;
        }

        .tooltip {
            position: relative;
        }

        .tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #2d3748;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.85rem;
            white-space: nowrap;
            z-index: 1000;
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 0 10px;
            }

            .card-body {
                padding: 1.5rem;
            }

            .filters {
                flex-direction: column;
            }

            .btn-group {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .btn-group .btn {
                flex: 1;
                text-align: center;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-title {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="page-header">
                            <h4 class="page-title">
                                <i class="fas fa-home me-2"></i>Gestion des Propriétés
                            </h4>
                            <a href="{{ route('properties.create') }}" class="btn btn-light">
                                <i class="fas fa-plus me-1"></i> Nouvelle Propriété
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            </div>
                        @endif

                        <div class="filters">
                            <div class="form-group">
                                <input type="text" id="searchInput" class="form-control" placeholder="Rechercher par nom ou adresse...">
                            </div>
                            <div class="form-group">
                                <select id="statusFilter" class="form-control">
                                    <option value="">Tous les statuts</option>
                                    <option value="libre">Libre</option>
                                    <option value="occupé">Occupé</option>
                                    <option value="maintenance">Maintenance</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select id="cityFilter" class="form-control">
                                    <option value="">Toutes les villes</option>
                                    @foreach ($properties->pluck('ville')->unique() as $ville)
                                        <option value="{{ $ville }}">{{ $ville }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th><i class="fas fa-home me-1"></i> Propriété</th>
                                        <th><i class="fas fa-map-marker-alt me-1"></i> Adresse</th>
                                        <th><i class="fas fa-city me-1"></i> Ville</th>
                                        <th><i class="fas fa-money-bill-wave me-1"></i> Loyer</th>
                                        <th><i class="fas fa-user me-1"></i> Locataire</th>
                                        <th><i class="fas fa-circle me-1"></i> Statut</th>
                                        <th><i class="fas fa-cogs me-1"></i> Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="propertyTable">
                                    @forelse($properties as $property)
                                        <tr data-status="{{ $property->statut }}" data-city="{{ $property->ville }}">
                                            <td>
                                                <strong>{{ $property->nom ?: 'Propriété #' . $property->id }}</strong>
                                                <br>
                                                <small class="text-muted">{{ ucfirst($property->type) }}</small>
                                            </td>
                                            <td>{{ Str::limit($property->adresse, 30) }}</td>
                                            <td>{{ $property->ville }}</td>
                                            <td>
                                                <strong class="text-success">{{ number_format($property->loyer_mensuel, 0, ',', ' ') }} XAF</strong>
                                                <br>
                                                <small>{{ $property->nombre_pieces }} pièces</small>
                                            </td>
                                            <td>
                                                @if ($property->locataireActuel)
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $property->locataireActuel->photo_profil ? asset('storage/' . $property->locataireActuel->photo_profil) : asset('images/default-avatar.jpg') }}"
                                                             class="rounded-circle me-2" width="30" height="30"
                                                             alt="{{ $property->locataireActuel->prenom }}">
                                                        <div>
                                                            {{ $property->locataireActuel->prenom }} {{ $property->locataireActuel->nom }}
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Aucun locataire</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'libre' => 'success',
                                                        'occupé' => 'primary',
                                                        'maintenance' => 'warning',
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $statusColors[$property->statut] }}">
                                                    <i class="fas fa-{{ $property->statut === 'libre' ? 'check' : ($property->statut === 'occupé' ? 'user' : 'tools') }} me-1"></i>
                                                    {{ ucfirst($property->statut) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('properties.show', $property) }}"
                                                       class="action-btn btn-info tooltip" data-tooltip="Voir les détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('properties.edit', $property) }}"
                                                       class="action-btn btn-warning tooltip" data-tooltip="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if ($property->statut === 'occupé')
                                                        <form action="{{ route('properties.liberer', $property) }}"
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="action-btn btn-success tooltip"
                                                                    data-tooltip="Libérer la propriété"
                                                                    onclick="return confirm('Libérer cette propriété ?')">
                                                                <i class="fas fa-door-open"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('properties.destroy', $property) }}"
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="action-btn btn-danger tooltip"
                                                                data-tooltip="Supprimer"
                                                                onclick="return confirm('Supprimer cette propriété ?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="empty-state">
                                                <i class="fas fa-home fa-3x mb-3"></i>
                                                <p>Aucune propriété enregistrée</p>
                                                <a href="{{ route('properties.create') }}" class="btn btn-success">
                                                    <i class="fas fa-plus me-1"></i> Ajouter une propriété
                                                </a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($properties->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $properties->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const cityFilter = document.getElementById('cityFilter');
            const rows = document.querySelectorAll('#propertyTable tr:not(.empty-state)');

            function filterTable() {
                const searchText = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                const cityValue = cityFilter.value;

                rows.forEach(row => {
                    const name = row.querySelector('td:nth-child(1) strong').textContent.toLowerCase();
                    const address = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const status = row.getAttribute('data-status');
                    const city = row.getAttribute('data-city');

                    const matchesSearch = name.includes(searchText) || address.includes(searchText);
                    const matchesStatus = !statusValue || status === statusValue;
                    const matchesCity = !cityValue || city === cityValue;

                    row.style.display = matchesSearch && matchesStatus && matchesCity ? '' : 'none';
                });
            }

            searchInput.addEventListener('input', filterTable);
            statusFilter.addEventListener('change', filterTable);
            cityFilter.addEventListener('change', filterTable);
        });
    </script>
</body>
</html>
@endsection
