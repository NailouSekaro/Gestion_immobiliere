@extends('layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --primary-light: #e0e7ff;
            --success: #10b981;
            --success-dark: #059669;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --light: #f8fafc;
            --dark: #1e293b;
            --gray: #64748b;
            --card-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            --card-hover-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            min-height: 100vh;
        }

        .container-fluid {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* En-tête */
        .page-header {
            margin-bottom: 2.5rem;
            animation: fadeInDown 0.5s ease forwards;
            opacity: 0;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
        }

        .page-title i {
            margin-right: 0.75rem;
            font-size: 1.8rem;
        }

        .page-subtitle {
            color: var(--gray);
            font-size: 1rem;
            margin: 0;
        }

        .refresh-btn {
            background: white;
            border: 2px solid var(--primary-light);
            color: var(--primary);
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.1);
        }

        .refresh-btn:hover {
            background: var(--primary);
            color: white;
            transform: rotate(180deg);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.2);
        }

        /* Statistiques */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.5s ease forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary), var(--primary-dark));
        }

        .stat-card:nth-child(2)::before { background: linear-gradient(180deg, #10b981, #059669); }
        .stat-card:nth-child(3)::before { background: linear-gradient(180deg, #f59e0b, #d97706); }
        .stat-card:nth-child(4)::before { background: linear-gradient(180deg, #3b82f6, #2563eb); }
        .stat-card:nth-child(5)::before { background: linear-gradient(180deg, #8b5cf6, #7c3aed); }
        .stat-card:nth-child(6)::before { background: linear-gradient(180deg, #ec4899, #db2777); }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-light), rgba(67, 97, 238, 0.2));
        }

        .stat-card:nth-child(2) .stat-icon { background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.4)); }
        .stat-card:nth-child(3) .stat-icon { background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.4)); }
        .stat-card:nth-child(4) .stat-icon { background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(59, 130, 246, 0.4)); }
        .stat-card:nth-child(5) .stat-icon { background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(139, 92, 246, 0.4)); }
        .stat-card:nth-child(6) .stat-icon { background: linear-gradient(135deg, rgba(236, 72, 153, 0.2), rgba(236, 72, 153, 0.4)); }

        .stat-icon i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .stat-card:nth-child(2) .stat-icon i { color: #10b981; }
        .stat-card:nth-child(3) .stat-icon i { color: #f59e0b; }
        .stat-card:nth-child(4) .stat-icon i { color: #3b82f6; }
        .stat-card:nth-child(5) .stat-icon i { color: #8b5cf6; }
        .stat-card:nth-child(6) .stat-icon i { color: #ec4899; }

        .trend-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .trend-up {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .trend-down {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .trend-neutral {
            background: rgba(100, 116, 139, 0.1);
            color: #64748b;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--gray);
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .stat-subtitle {
            font-size: 0.8rem;
            color: var(--gray);
            margin-top: 0.5rem;
        }

        /* Cartes principales */
        .main-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 1200px) {
            .main-content {
                grid-template-columns: 1fr;
            }
        }

        .chart-card, .side-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: var(--transition);
            animation: fadeIn 0.6s ease forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .chart-card:hover, .side-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-hover-shadow);
        }

        .card-header {
            padding: 1.5rem;
            background: linear-gradient(120deg, var(--primary), var(--primary-dark));
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-header h6 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .card-header h6 i {
            margin-right: 0.75rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Liste des propriétés */
        .property-list {
            max-height: 400px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .property-list::-webkit-scrollbar {
            width: 6px;
        }

        .property-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .property-list::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 3px;
        }

        .property-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #f8fafc;
            border-radius: 12px;
            border-left: 4px solid var(--primary);
            transition: var(--transition);
            animation: slideInRight 0.5s ease forwards;
            opacity: 0;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .property-item:hover {
            transform: translateX(5px);
            background: #f0f9ff;
        }

        .property-item.occupied {
            border-left-color: var(--success);
        }

        .property-item.vacant {
            border-left-color: var(--warning);
        }

        .property-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            background: linear-gradient(135deg, var(--primary-light), rgba(67, 97, 238, 0.2));
        }

        .property-item.occupied .property-icon {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.4));
        }

        .property-item.vacant .property-icon {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.4));
        }

        .property-icon i {
            color: var(--primary);
            font-size: 1.25rem;
        }

        .property-item.occupied .property-icon i { color: #10b981; }
        .property-item.vacant .property-icon i { color: #f59e0b; }

        .property-info {
            flex: 1;
        }

        .property-name {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .property-details {
            font-size: 0.85rem;
            color: var(--gray);
        }

        .property-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-left: 0.5rem;
        }

        .status-occupied {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .status-vacant {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        /* Paiements en retard */
        .overdue-list {
            max-height: 200px;
            overflow-y: auto;
        }

        .overdue-item {
            padding: 1rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border-radius: 12px;
            border-left: 4px solid var(--danger);
            animation: slideInRight 0.5s ease forwards;
            opacity: 0;
        }

        .overdue-item:hover {
            transform: translateX(3px);
        }

        .overdue-tenant {
            font-weight: 600;
            color: #991b1b;
            margin-bottom: 0.25rem;
        }

        .overdue-details {
            font-size: 0.85rem;
            color: #7f1d1d;
        }

        .overdue-amount {
            font-weight: 700;
            color: var(--danger);
        }

        /* Tableau des paiements récents */
        .recent-payments-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-top: 2rem;
            animation: fadeInUp 0.5s ease forwards;
            opacity: 0;
        }

        .table-responsive {
            overflow-x: auto;
            position: relative;
        }

        .table {
            margin: 0;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 800px;
        }

        .table th {
            background: #1e293b;
            color: white;
            font-weight: 600;
            padding: 1rem;
            text-align: left;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #334155;
        }

        .table th i {
            margin-right: 0.5rem;
            opacity: 0.8;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
        }

        .table tbody tr {
            transition: var(--transition);
            opacity: 0;
            transform: translateY(10px);
            animation: fadeInUp 0.5s ease forwards;
        }

        .table tbody tr:nth-child(1) { animation-delay: 0.1s; }
        .table tbody tr:nth-child(2) { animation-delay: 0.2s; }
        .table tbody tr:nth-child(3) { animation-delay: 0.3s; }
        .table tbody tr:nth-child(4) { animation-delay: 0.4s; }
        .table tbody tr:nth-child(5) { animation-delay: 0.5s; }

        .table tbody tr:hover {
            background-color: #f0f9ff;
            transform: scale(1.01);
        }

        .tenant-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .tenant-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-light);
        }

        .tenant-name {
            font-weight: 500;
            color: var(--dark);
        }

        .amount-cell {
            font-weight: 700;
            color: var(--primary-dark);
        }

        .status-badge {
            display: inline-block;
            padding: 0.4rem 0.9rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .status-paid {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
        }

        .status-pending {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
        }

        .status-overdue {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
        }

        /* Aperçu rapide */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .quick-action-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            cursor: pointer;
            border: 2px solid transparent;
            animation: fadeInUp 0.5s ease forwards;
            opacity: 0;
        }

        .quick-action-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-hover-shadow);
            border-color: var(--primary);
        }

        .action-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, var(--primary-light), rgba(67, 97, 238, 0.2));
        }

        .quick-action-card:nth-child(2) .action-icon { background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.4)); }
        .quick-action-card:nth-child(3) .action-icon { background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.4)); }
        .quick-action-card:nth-child(4) .action-icon { background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(59, 130, 246, 0.4)); }

        .action-icon i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .quick-action-card:nth-child(2) .action-icon i { color: #10b981; }
        .quick-action-card:nth-child(3) .action-icon i { color: #f59e0b; }
        .quick-action-card:nth-child(4) .action-icon i { color: #3b82f6; }

        .action-title {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .action-description {
            font-size: 0.85rem;
            color: var(--gray);
        }

        /* Animations */
        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
        .animate-delay-4 { animation-delay: 0.4s; }
        .animate-delay-5 { animation-delay: 0.5s; }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }
        }

        /* Chargement */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid var(--primary-light);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <!-- En-tête -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-tachometer-alt"></i>Tableau de Bord
                </h1>
                <p class="page-subtitle">Aperçu global de votre gestion immobilière</p>
            </div>
            <div class="refresh-btn" onclick="updateStats()" title="Actualiser">
                <i class="fas fa-sync-alt"></i>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="quick-actions">
        <div class="quick-action-card animate-delay-1" onclick="window.location.href='{{ route('payments.create') }}'">
            <div class="action-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="action-title">Nouveau Paiement</div>
            <div class="action-description">Enregistrer un paiement de loyer</div>
        </div>

        <div class="quick-action-card animate-delay-2" onclick="window.location.href='{{ route('cautions.create') }}'">
            <div class="action-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="action-title">Nouvelle Caution</div>
            <div class="action-description">Enregistrer une caution locative</div>
        </div>

        <div class="quick-action-card animate-delay-3" onclick="window.location.href='{{ route('consommations-eau.create') }}'">
            <div class="action-icon">
                <i class="fas fa-tint"></i>
            </div>
            <div class="action-title">Relevé d'Eau</div>
            <div class="action-description">Enregistrer une consommation d'eau</div>
        </div>

        <div class="quick-action-card animate-delay-4" onclick="window.location.href='{{ route('properties.create') }}'">
            <div class="action-icon">
                <i class="fas fa-home"></i>
            </div>
            <div class="action-title">Nouvelle Propriété</div>
            <div class="action-description">Ajouter une nouvelle propriété</div>
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="stats-grid">
        <!-- Revenus Totaux -->
        <div class="stat-card animate-delay-1">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="trend-badge trend-up">
                    <i class="fas fa-arrow-up me-1"></i>12%
                </div>
            </div>
            <div class="stat-label">Revenus Totaux</div>
            <h3 class="stat-value">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} XAF</h3>
            <div class="stat-subtitle">Revenus générés ce mois</div>
        </div>

        <!-- Propriétés -->
        <div class="stat-card animate-delay-2">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="trend-badge trend-neutral">
                    <i class="fas fa-minus me-1"></i>Stable
                </div>
            </div>
            <div class="stat-label">Propriétés</div>
            <h3 class="stat-value">{{ $stats['occupied_properties'] }}/{{ $stats['total_properties'] }}</h3>
            <div class="stat-subtitle">{{ $stats['occupied_properties'] }} occupées • {{ $stats['vacant_properties'] }} libres</div>
        </div>

        <!-- Locataires -->
        <div class="stat-card animate-delay-3">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="trend-badge trend-up">
                    <i class="fas fa-arrow-up me-1"></i>5%
                </div>
            </div>
            <div class="stat-label">Locataires Actifs</div>
            <h3 class="stat-value">{{ $stats['total_tenants'] }}</h3>
            <div class="stat-subtitle">Taux d'occupation: {{ $stats['total_properties'] > 0 ? round(($stats['occupied_properties'] / $stats['total_properties']) * 100) : 0 }}%</div>
        </div>

        <!-- Paiements -->
        <div class="stat-card animate-delay-4">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="trend-badge trend-down">
                    <i class="fas fa-arrow-down me-1"></i>3%
                </div>
            </div>
            <div class="stat-label">Paiements</div>
            <h3 class="stat-value">{{ $stats['total_payments'] }}</h3>
            <div class="stat-subtitle">{{ $stats['pending_payments'] }} en attente</div>
        </div>

        <!-- Caution Totale -->
        <div class="stat-card animate-delay-5">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="trend-badge trend-up">
                    <i class="fas fa-arrow-up me-1"></i>8%
                </div>
            </div>
            <div class="stat-label">Caution Totale</div>
            <h3 class="stat-value">{{ number_format($totalCautions, 0, ',', ' ') }} XAF</h3>
            <div class="stat-subtitle">Caution en gestion</div>
        </div>

        <!-- Messages -->
        <div class="stat-card animate-delay-6">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="trend-badge trend-up">
                    <i class="fas fa-arrow-up me-1"></i>15%
                </div>
            </div>
            <div class="stat-label">Messages</div>
            <h3 class="stat-value">{{ $stats['unread_messages'] }}</h3>
            <div class="stat-subtitle">Messages non lus</div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="main-content">
        <!-- Graphique -->
        <div class="chart-card">
            <div class="card-header">
                <h6><i class="fas fa-chart-line"></i>Revenus des 6 derniers mois</h6>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="side-container">
            <!-- Propriétés récentes -->
            <div class="side-card mb-4">
                <div class="card-header">
                    <h6><i class="fas fa-home"></i>Propriétés Récentes</h6>
                </div>
                <div class="card-body">
                    <div class="property-list">
                        @foreach($recentProperties as $property)
                        <div class="property-item {{ $property->statut === 'occupé' ? 'occupied' : 'vacant' }}"
                             style="animation-delay: {{ $loop->index * 0.1 }}s">
                            <div class="property-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="property-info">
                                <div class="property-name">
                                    {{ $property->nom ?: 'Propriété #'.$property->id }}
                                    <span class="property-status status-{{ $property->statut === 'occupé' ? 'occupied' : 'vacant' }}">
                                        {{ $property->statut }}
                                    </span>
                                </div>
                                <div class="property-details">
                                    {{ $property->ville }}
                                    @if($property->loyer_mensuel)
                                    • {{ number_format($property->loyer_mensuel, 0, ',', ' ') }} XAF
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Paiements en retard -->
            <div class="side-card">
                <div class="card-header">
                    <h6><i class="fas fa-exclamation-triangle"></i>Paiements en Retard</h6>
                </div>
                <div class="card-body">
                    <div class="overdue-list">
                        @forelse($overduePayments as $payment)
                        <div class="overdue-item" style="animation-delay: {{ $loop->index * 0.1 }}s">
                            <div class="overdue-tenant">
                                <i class="fas fa-user me-1"></i>{{ $payment->user->prenom }} {{ $payment->user->nom }}
                            </div>
                            <div class="overdue-details">
                                {{ $payment->property->adresse ?? 'Non spécifié' }}
                                <br>
                                <span class="overdue-amount">
                                    {{ number_format($payment->montant, 0, ',', ' ') }} XAF
                                </span>
                                • Retard: {{ $payment->jours_retard ?? 0 }} jours
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-3">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <p class="text-muted">Aucun paiement en retard</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Paiements récents -->
    <div class="recent-payments-card animate-delay-3">
        <div class="card-header">
            <h6><i class="fas fa-history"></i>Paiements Récents (7 derniers jours)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user"></i> Locataire</th>
                            <th><i class="fas fa-home"></i> Propriété</th>
                            <th><i class="fas fa-money-bill"></i> Montant</th>
                            <th><i class="fas fa-calendar"></i> Période</th>
                            <th><i class="fas fa-clock"></i> Date</th>
                            <th><i class="fas fa-circle"></i> Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPayments as $payment)
                        <tr style="animation-delay: {{ $loop->index * 0.1 }}s">
                            <td>
                                <div class="tenant-info">
                                    @if($payment->user && $payment->user->photo_profil)
                                    <img src="{{ asset('storage/' . $payment->user->photo_profil) }}"
                                         alt="{{ $payment->user->prenom }}"
                                         class="tenant-avatar">
                                    @else
                                    <div class="tenant-avatar" style="background: linear-gradient(135deg, var(--primary-light), var(--primary)); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="tenant-name">{{ $payment->user->prenom ?? '-' }} {{ $payment->user->nom ?? '' }}</div>
                                        <small class="text-muted">{{ $payment->user->email ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $payment->property->adresse ?? '-' }}</strong>
                                @if($payment->property && $payment->property->ville)
                                <br><small class="text-muted">{{ $payment->property->ville }}</small>
                                @endif
                            </td>
                            <td class="amount-cell">{{ number_format($payment->montant, 0, ',', ' ') }} XAF</td>
                            <td>{{ $payment->periode }}</td>
                            <td>{{ optional($payment->date_paiement)->format('d/m/Y H:i') ?? '—' }}</td>
                            <td>
                                <span class="status-badge {{ $payment->statut === 'paye' ? 'status-paid' : ($payment->statut === 'en_attente' ? 'status-pending' : 'status-overdue') }}">
                                    <i class="fas {{ $payment->statut === 'paye' ? 'fa-check-circle' : ($payment->statut === 'en_attente' ? 'fa-clock' : 'fa-exclamation-triangle') }} me-1"></i>
                                                                   {{ $payment->statut === 'paye' ? 'Payé' :
                                   ($payment->statut === 'en_attente' ? 'En attente' : 'En retard') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach

                        @if($recentPayments->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-history fa-3x mb-3 opacity-50"></i><br>
                                Aucun paiement récent dans les 7 derniers jours
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer rapide / infos supplémentaires (optionnel) -->
    <div class="text-center mt-5 pt-4 text-muted small">
        <p>Gestion Immobilière • {{ date('Y') }} • Version 1.2.3</p>
        <p class="mt-2">
            <i class="fas fa-clock me-1"></i>Dernière mise à jour :
            <span id="last-update">{{ now()->format('d/m/Y à H:i') }}</span>
        </p>
    </div>
</div>

<!-- Scripts -->
<script>
    // Mise à jour de la date de dernière actualisation
    function updateLastUpdate() {
        const now = new Date();
        const options = {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        document.getElementById('last-update').textContent =
            now.toLocaleDateString('fr-FR', options).replace(',', ' à');
    }

    // Graphique des revenus (exemple de données - à adapter avec tes vraies données)
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($months ?? ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin']) !!},
            datasets: [{
                label: 'Revenus (XAF)',
                data: {!! json_encode($revenueData ?? [1200000, 1450000, 1380000, 1620000, 1780000, 1950000]) !!},
                borderColor: '#4361ee',
                backgroundColor: 'rgba(67, 97, 238, 0.15)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4361ee',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(30, 41, 59, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#e2e8f0',
                    borderColor: '#4361ee',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y.toLocaleString('fr-FR') + ' XAF';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(226, 232, 240, 0.15)' },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('fr-FR');
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Rafraîchissement manuel (à implémenter selon tes besoins)
    function updateStats() {
        // Ici tu peux faire un appel AJAX pour rafraîchir les données
        // Exemple : location.reload();
        alert('Rafraîchissement des statistiques... (à implémenter)');
        updateLastUpdate();
    }

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        updateLastUpdate();

        // Animation d'apparition progressive des cartes
        document.querySelectorAll('.stat-card, .chart-card, .side-card, .recent-payments-card')
            .forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, 100 + (index * 80));
            });
    });
</script>

@endsection
