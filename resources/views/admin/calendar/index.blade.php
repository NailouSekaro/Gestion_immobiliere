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
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --primary-light: #e0e7ff;
            --success: #4cc9f0;
            --success-dark: #3a8fb8;
            --warning: #facc15;
            --warning-dark: #d97706;
            --danger: #dc2626;
            --danger-light: #fee2e2;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --info: #60a5fa;
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

        .calendar-container {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            margin: 0;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: var(--gray);
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
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
            font-size: 0.95rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
        }

        .btn-outline-secondary {
            background: transparent;
            border: 2px solid #64748b;
            color: #64748b;
        }

        .btn-outline-secondary:hover {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            color: white;
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
            color: white;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, var(--success-dark) 0%, var(--success) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(76, 201, 240, 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning) 0%, var(--warning-dark) 100%);
            color: white;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, var(--warning-dark) 0%, var(--warning) 100%);
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            border-radius: 8px;
            min-width: 40px;
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
            box-shadow: var(--card-hover-shadow);
        }

        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border-bottom: 2px solid var(--primary-light);
            padding: 1.5rem 2rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Sélection du mois */
        .month-selector {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border-radius: 12px;
            padding: 1.5rem;
            border: 2px solid #e2e8f0;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: var(--transition);
            background-color: #f9fafc;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            outline: none;
            background-color: white;
        }

        /* Calendrier */
        #calendar {
            min-height: 700px;
            border-radius: 12px;
            overflow: hidden;
        }

        /* Sidebar cards */
        .sidebar-card {
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1.5rem;
            animation: fadeInRight 0.5s ease forwards;
            opacity: 0;
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .sidebar-card .card-header {
            padding: 1rem 1.5rem;
        }

        .sidebar-card .card-body {
            padding: 1rem;
            max-height: 400px;
            overflow-y: auto;
        }

        /* Payment items */
        .payment-item {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: var(--transition);
            animation: fadeInUp 0.5s ease forwards;
            opacity: 0;
        }

        .payment-item:hover {
            border-color: var(--primary-light);
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .payment-item.overdue {
            border-left: 4px solid var(--danger);
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.05) 0%, rgba(220, 38, 38, 0.1) 100%);
        }

        .payment-item.upcoming {
            border-left: 4px solid var(--warning);
            background: linear-gradient(135deg, rgba(250, 204, 21, 0.05) 0%, rgba(250, 204, 21, 0.1) 100%);
        }

        .tenant-info {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .tenant-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .tenant-avatar i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .property-address {
            color: var(--gray);
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .amount-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .amount-upcoming {
            background: linear-gradient(135deg, rgba(250, 204, 21, 0.1) 0%, rgba(250, 204, 21, 0.2) 100%);
            color: var(--warning-dark);
        }

        .amount-overdue {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.1) 0%, rgba(220, 38, 38, 0.2) 100%);
            color: var(--danger);
        }

        .days-info {
            font-size: 0.85rem;
            font-weight: 500;
        }

        .days-warning {
            color: var(--warning-dark);
        }

        .days-danger {
            color: var(--danger);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
            color: var(--gray);
        }

        .empty-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .empty-icon i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
        .animate-delay-4 { animation-delay: 0.4s; }
        .animate-delay-5 { animation-delay: 0.5s; }

        /* FullCalendar custom styles */
        .fc {
            --fc-border-color: #e2e8f0;
            --fc-today-bg-color: rgba(67, 97, 238, 0.1);
            --fc-button-bg-color: var(--primary);
            --fc-button-border-color: var(--primary);
            --fc-button-hover-bg-color: var(--primary-dark);
            --fc-button-hover-border-color: var(--primary-dark);
        }

        .fc .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark);
        }

        .fc-event {
            border-radius: 6px;
            border: none;
            padding: 4px 8px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .fc-event:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .fc-event-paid {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
        }

        .fc-event-upcoming {
            background: linear-gradient(135deg, var(--warning) 0%, var(--warning-dark) 100%);
        }

        .fc-event-overdue {
            background: linear-gradient(135deg, var(--danger) 0%, #b91c1c 100%);
        }

        .fc-daygrid-day-number {
            font-weight: 600;
            color: var(--dark);
        }

        .fc-day-today {
            background-color: rgba(67, 97, 238, 0.05) !important;
        }

        @media (max-width: 992px) {
            .container-fluid {
                padding: 1rem;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            #calendar {
                min-height: 500px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-sm {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="calendar-container">
        <!-- En-tête -->
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-calendar-alt me-2"></i>Calendrier des Échéances
                </h1>
                <p class="page-subtitle">Visualisez et géz toutes les échéances de paiement</p>
            </div>
            <a href="{{ route('payments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Nouveau Paiement
            </a>
        </div>

        <!-- Sélection du mois -->
        <div class="month-selector animate-delay-1">
            <form method="GET" action="{{ route('calendar.index') }}">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="month" class="form-label">
                                <i class="far fa-calendar me-2"></i>Sélectionner le mois
                            </label>
                            <input type="month"
                                   class="form-control"
                                   id="month"
                                   name="month"
                                   value="{{ $currentDate->format('Y-m') }}"
                                   onchange="this.form.submit()">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="btn-group d-flex" role="group">
                            <a href="{{ route('calendar.index', ['month' => $currentDate->copy()->subMonth()->format('Y-m')]) }}"
                               class="btn btn-outline-secondary flex-fill">
                                <i class="fas fa-chevron-left me-2"></i>Mois précédent
                            </a>
                            <a href="{{ route('calendar.index', ['month' => now()->format('Y-m')]) }}"
                               class="btn btn-primary flex-fill mx-2">
                                <i class="fas fa-calendar-day me-2"></i>Ce mois
                            </a>
                            <a href="{{ route('calendar.index', ['month' => $currentDate->copy()->addMonth()->format('Y-m')]) }}"
                               class="btn btn-outline-secondary flex-fill">
                                Mois suivant<i class="fas fa-chevron-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <!-- Calendrier -->
            <div class="col-lg-8">
                <div class="card animate-delay-2">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-check me-2"></i>
                            Calendrier - {{ $currentDate->isoFormat('MMMM YYYY') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Échéances à venir -->
                <div class="sidebar-card animate-delay-3">
                    <div class="card-header" style="border-left: 4px solid var(--warning);">
                        <h6 class="mb-0">
                            <i class="fas fa-clock me-2"></i>Échéances à venir (30 jours)
                        </h6>
                    </div>
                    <div class="card-body">
                        @forelse($upcomingPayments as $index => $payment)
                            <div class="payment-item upcoming animate-delay-{{ ($index % 5) + 1 }}">
                                <div class="tenant-info">
                                    <div class="tenant-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $payment->user->prenom }} {{ $payment->user->nom }}</strong>
                                    </div>
                                </div>

                                <div class="property-address">
                                    <i class="fas fa-home me-1"></i>
                                    {{ $payment->property->adresse }}
                                </div>

                                <div class="amount-badge amount-upcoming">
                                    <i class="fas fa-money-bill-wave me-1"></i>
                                    {{ number_format($payment->montant, 0, ',', ' ') }} XAF
                                </div>

                                <div class="days-info days-warning">
                                    <i class="far fa-calendar me-1"></i>
                                    Échéance: {{ $payment->date_limite->format('d/m/Y') }}
                                    • Dans {{ $payment->date_limite->diffInDays(now()) }} jours
                                </div>

                                <div class="action-buttons">
                                    <form action="{{ route('payments.mark-paid', $payment) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success"
                                                title="Marquer comme payé">
                                            <i class="fas fa-check"></i> Payé
                                        </button>
                                    </form>
                                    <form action="{{ route('payments.send-reminder', $payment) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning"
                                                title="Envoyer un rappel">
                                            <i class="fas fa-bell"></i> Rappel
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="far fa-smile"></i>
                                </div>
                                <p>Toutes les échéances sont à jour !</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Paiements en retard -->
                <div class="sidebar-card animate-delay-4">
                    <div class="card-header" style="border-left: 4px solid var(--danger);">
                        <h6 class="mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>Paiements en Retard
                        </h6>
                    </div>
                    <div class="card-body">
                        @forelse($overduePayments as $index => $payment)
                            <div class="payment-item overdue animate-delay-{{ ($index % 5) + 1 }}">
                                <div class="tenant-info">
                                    <div class="tenant-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $payment->user->prenom }} {{ $payment->user->nom }}</strong>
                                    </div>
                                </div>

                                <div class="property-address">
                                    <i class="fas fa-home me-1"></i>
                                    {{ $payment->property->adresse }}
                                </div>

                                <div class="amount-badge amount-overdue">
                                    <i class="fas fa-money-bill-wave me-1"></i>
                                    {{ number_format($payment->montant, 0, ',', ' ') }} XAF
                                </div>

                                <div class="days-info days-danger">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    En retard depuis {{ $payment->jours_retard }} jours
                                </div>

                                <div class="action-buttons">
                                    <form action="{{ route('payments.mark-paid', $payment) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success"
                                                title="Marquer comme payé">
                                            <i class="fas fa-check"></i> Payé
                                        </button>
                                    </form>
                                    <form action="{{ route('payments.send-reminder', $payment) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning"
                                                title="Envoyer un rappel">
                                            <i class="fas fa-bell"></i> Rappel
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-thumbs-up"></i>
                                </div>
                                <p>Aucun paiement en retard !</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser FullCalendar
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'fr',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        themeSystem: 'standard',
        events: {
            url: '{{ route("calendar.events") }}',
            method: 'GET',
            failure: function() {
                console.error('Erreur lors du chargement des événements');
            }
        },
        eventClick: function(info) {
            const payment = info.event.extendedProps;

            // Créer une modal custom
            const modalHtml = `
                <div class="modal fade" id="paymentModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="fas fa-file-invoice-dollar me-2"></i>
                                    Détails du paiement
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <strong><i class="fas fa-user me-2"></i>Locataire:</strong>
                                    <p class="mb-1">${payment.tenant}</p>
                                </div>
                                <div class="mb-3">
                                    <strong><i class="fas fa-home me-2"></i>Propriété:</strong>
                                    <p class="mb-1">${payment.property}</p>
                                </div>
                                <div class="mb-3">
                                    <strong><i class="fas fa-money-bill-wave me-2"></i>Montant:</strong>
                                    <p class="mb-1 text-primary fw-bold">${payment.amount.toLocaleString('fr-FR')} XAF</p>
                                </div>
                                <div class="mb-3">
                                    <strong><i class="fas fa-calendar-day me-2"></i>Date d'échéance:</strong>
                                    <p class="mb-1">${payment.due_date}</p>
                                </div>
                                <div class="mb-3">
                                    <strong><i class="fas fa-info-circle me-2"></i>Statut:</strong>
                                    <span class="badge ${payment.status === 'paid' ? 'bg-success' : payment.is_overdue ? 'bg-danger' : 'bg-warning'}">
                                        ${payment.status === 'paid' ? 'Payé' : payment.is_overdue ? 'En retard' : 'À venir'}
                                    </span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Fermer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Ajouter la modal au DOM
            if (!document.getElementById('paymentModal')) {
                document.body.insertAdjacentHTML('beforeend', modalHtml);
            }

            // Afficher la modal
            const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
            modal.show();
        },
        eventDidMount: function(info) {
            // Ajouter des classes CSS selon le statut
            if (info.event.extendedProps.status === 'paid') {
                info.el.classList.add('fc-event-paid');
            } else if (info.event.extendedProps.is_overdue) {
                info.el.classList.add('fc-event-overdue');
            } else {
                info.el.classList.add('fc-event-upcoming');
            }

            // Ajouter un tooltip
            info.el.title = `${info.event.title} - ${info.event.extendedProps.amount.toLocaleString('fr-FR')} XAF`;
        },
        dayCellDidRender: function(info) {
            // Ajouter un effet sur les weekends
            const day = info.date.getDay();
            if (day === 0 || day === 6) {
                info.el.style.backgroundColor = 'rgba(0, 0, 0, 0.02)';
            }

            // Ajouter un indicateur pour aujourd'hui
            const today = new Date();
            if (info.date.getDate() === today.getDate() &&
                info.date.getMonth() === today.getMonth() &&
                info.date.getFullYear() === today.getFullYear()) {
                info.el.style.border = '2px solid var(--primary)';
            }
        }
    });

    calendar.render();

    // Animation des éléments
    const animatedElements = document.querySelectorAll('.payment-item, .sidebar-card, .month-selector');
    animatedElements.forEach((element, index) => {
        element.style.animationDelay = `${(index * 0.1) + 0.3}s`;
        element.classList.add('animate__animated');

        if (element.classList.contains('payment-item')) {
            element.classList.add('animate__fadeInUp');
        } else if (element.classList.contains('sidebar-card')) {
            element.classList.add('animate__fadeInRight');
        } else {
            element.classList.add('animate__fadeInUp');
        }
    });

    // Confirmation avant action
    document.querySelectorAll('form[action*="mark-paid"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Confirmez-vous le paiement de cette échéance ?')) {
                e.preventDefault();
            }
        });
    });

    document.querySelectorAll('form[action*="send-reminder"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Envoyer un rappel au locataire ?')) {
                e.preventDefault();
            }
        });
    });

    // Mettre à jour automatiquement le mois
    const monthInput = document.getElementById('month');
    monthInput.addEventListener('change', function() {
        this.form.submit();
    });
});
</script>
@endpush
