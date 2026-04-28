<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gestion Loyer</title>
    <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:: -->
    <!--[if lt IE 9]>
     <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
     <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
     <![endif]-->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700" rel="stylesheet">

    <!-- themify -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/themify-icons/themify-icons.css') }}">

    <!-- iconfont -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/icofont/css/icofont.css') }}">

    <!-- simple line icon -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/icon/simple-line-icons/css/simple-line-icons.css') }}">

    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">

    <!-- Chartlist chart css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/chartist/dist/chartist.css') }}" type="text/css"
        media="all">

    <!-- Weather css -->
    <link href="{{ asset('assets/css/svg-weather.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">

    <!-- Responsive.css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">

    <style>
        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            color: white;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .icon-primary {
            background: linear-gradient(135deg, #4361ee20, #4361ee40);
            color: #4361ee;
        }

        .icon-success {
            background: linear-gradient(135deg, #4cc9f020, #4cc9f040);
            color: #4cc9f0;
        }

        .icon-warning {
            background: linear-gradient(135deg, #facc1520, #facc1540);
            color: #facc15;
        }

        .icon-danger {
            background: linear-gradient(135deg, #dc262620, #dc262640);
            color: #dc2626;
        }

        .quick-actions {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .action-btn {
            display: flex;
            align-items: center;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .action-btn:hover {
            background: #e9ecef;
            transform: translateX(5px);
            text-decoration: none;
            color: #333;
        }

        .action-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 18px;
            color: white;
        }

        .recent-activity {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .activity-item {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            background: #f8f9fa;
            color: #4361ee;
        }

        .dashboard-section-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4361ee;
        }

        .greeting-message {
            font-size: 1.5rem;
            margin-bottom: 10px;
            font-weight: 300;
        }

        .greeting-time {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .welcome-card {
                padding: 20px;
            }

            .greeting-message {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

{{-- @auth
    @include('partials.chat-widget')
@endauth --}}

<body class="sidebar-mini fixed">
    @include('layouts.topbar')
    <div class="loader-bg">
        <div class="loader-bar">
        </div>
    </div>
    <!-- Sidebar chat start -->
    @include('layouts.sidebar')
    <!-- Sidebar chat end-->
    <div class="content-wrapper">
        <!-- Container-fluid starts -->
        <!-- Main content starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="main-header">
                    <h4>Tableau de bord</h4>
                </div>
            </div>

            @if (session('success'))
                <div
                    style="background: #28a745; color: #fff; padding: 12px; border-radius: 8px; margin: 10px 0; font-weight: bold;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    style="background: #dc3545; color: #fff; padding: 12px; border-radius: 8px; margin: 10px 0; font-weight: bold;">
                    ❌ {{ session('error') }}
                </div>
            @endif

            <!-- Welcome Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="welcome-card">
                        <div class="row">
                            <div class="col-md-8">
                                <h2 class="greeting-message">
                                    @php
                                        $hour = date('H');
                                        if ($hour < 12) {
                                            echo 'Bonjour';
                                        } elseif ($hour < 18) {
                                            echo 'Bon après-midi';
                                        } else {
                                            echo 'Bonsoir';
                                        }
                                        echo ', ' . (auth()->user()->nom ?? 'Cher utilisateur'). (auth()->user()->prenom ? ' ' . auth()->user()->prenom : '');
                                    @endphp
                                    👋
                                </h2>
                                <p class="greeting-time">
                                    {{ date('l d F Y') }} • {{ date('H:i') }}
                                </p>
                                <p>Bienvenue sur votre espace de gestion locative. Tout ce dont vous avez besoin pour gérer efficacement vos propriétés et locataires.</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <i class="fas fa-home fa-4x" style="opacity: 0.8;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="stats-card">
                        <div class="stats-icon icon-primary">
                            <i class="fas fa-home"></i>
                        </div>
                        <h3 >{{ $propertiesCount }}</h3>
                        <p>Propriétés</p>
                        <a href="{{ route('properties.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye mr-1"></i> Voir
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stats-card">
                        <div class="stats-icon icon-success">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 >{{ $tenantsCount }}</h3>
                        <p>Locataires</p>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-eye mr-1"></i> Voir
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stats-card">
                        <div class="stats-icon icon-warning">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h3 >{{ number_format($rentCollected, 0, ',', ' ') }}</h3>
                        <p>Loyers perçus (mois)</p>
                        <a href="{{ route('payments.index') }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-eye mr-1"></i> Voir
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stats-card">
                        <div class="stats-icon icon-danger">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h3 >{{ $maintenanceCount }}</h3>
                        <p>Interventions</p>
                        <a href="{{ route('travaux.index') }}" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-eye mr-1"></i> Voir
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row">
                <div class="col-md-8">
                    <!-- Quick Actions -->
                    <div class="quick-actions">
                        <h4 class="dashboard-section-title">
                            <i class="fas fa-bolt mr-2"></i>Actions rapides
                        </h4>

                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('users.create') }}" class="action-btn">
                                    <div class="action-icon" style="background: #4361ee;">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div>
                                        <strong>Ajouter un locataire</strong>
                                        <p class="text-muted mb-0">Nouveau locataire</p>
                                    </div>
                                </a>

                                <a href="{{ route('payments.create') }}" class="action-btn">
                                    <div class="action-icon" style="background: #4cc9f0;">
                                        <i class="fas fa-money-check-alt"></i>
                                    </div>
                                    <div>
                                        <strong>Enregistrer un loyer</strong>
                                        <p class="text-muted mb-0">Paiement de loyer</p>
                                    </div>
                                </a>

                                <a href="{{ route('travaux.create') }}" class="action-btn">
                                    <div class="action-icon" style="background: #facc15;">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                    <div>
                                        <strong>Planifier une intervention</strong>
                                        <p class="text-muted mb-0">Maintenance/réparation</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-6">
                                <a href="{{ route('properties.create') }}" class="action-btn">
                                    <div class="action-icon" style="background: #dc2626;">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div>
                                        <strong>Ajouter une propriété</strong>
                                        <p class="text-muted mb-0">Nouveau bien immobilier</p>
                                    </div>
                                </a>

                                <a href="{{ route('cautions.create') }}" class="action-btn">
                                    <div class="action-icon" style="background: #10b981;">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div>
                                        <strong>Enregistrer une caution</strong>
                                        <p class="text-muted mb-0">Caution locative</p>
                                    </div>
                                </a>

                                <a href="" class="action-btn">
                                    <div class="action-icon" style="background: #8b5cf6;">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <div>
                                        <strong>Voir les rapports</strong>
                                        <p class="text-muted mb-0">Statistiques et analyses</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="recent-activity">
                        <h4 class="dashboard-section-title">
                            <i class="fas fa-history mr-2"></i>Activités récentes
                        </h4>

                        <div id="recent-activities">
                            <!-- Les activités seront chargées dynamiquement -->
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <div>
                                    <strong>Bienvenue sur votre tableau de bord</strong>
                                    <p class="text-muted mb-0">Commencez par explorer les différentes sections</p>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div>
                                    <strong>Astuce du jour</strong>
                                    <p class="text-muted mb-0">Utilisez les actions rapides pour gagner du temps</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Upcoming Events / Reminders -->
                    <div class="quick-actions">
                        <h4 class="dashboard-section-title">
                            <i class="fas fa-calendar-alt mr-2"></i>Échéances à venir
                        </h4>

                        <div id="upcoming-events">
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                                <div>
                                    <strong>Aucune échéance prochaine</strong>
                                    <p class="text-muted mb-0">Tout est à jour pour le moment</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips & Tricks -->
                    <div class="quick-actions">
                        <h4 class="dashboard-section-title">
                            <i class="fas fa-lightbulb mr-2"></i>Conseils pratiques
                        </h4>

                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Pensez à :</strong> Vérifier régulièrement l'état de vos propriétés
                        </div>

                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>
                            <strong>Bonnes pratiques :</strong> Documentez tous les paiements et contrats
                        </div>

                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Rappel :</strong> Envoyez les quittances de loyer dans les délais
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
    <!--[if lt IE 9]>
      <div class="ie-warning">
          <h1>Warning!!</h1>
          <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
          <div class="iew-container">
              <ul class="iew-download">
                  <li>
                      <a href="http://www.google.com/chrome/">
                          <img src="assets/images/browser/chrome.png" alt="Chrome">
                          <div>Chrome</div>
                      </a>
                  </li>
                  <li>
                      <a href="https://www.mozilla.org/en-US/firefox/new/">
                          <img src="assets/images/browser/firefox.png" alt="Firefox">
                          <div>Firefox</div>
                      </a>
                  </li>
                  <li>
                      <a href="http://www.opera.com">
                          <img src="assets/images/browser/opera.png" alt="Opera">
                          <div>Opera</div>
                      </a>
                  </li>
                  <li>
                      <a href="https://www.apple.com/safari/">
                          <img src="assets/images/browser/safari.png" alt="Safari">
                          <div>Safari</div>
                      </a>
                  </li>
                  <li>
                      <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                          <img src="assets/images/browser/ie.png" alt="">
                          <div>IE (9 & above)</div>
                      </a>
                  </li>
              </ul>
          </div>
          <p>Sorry for the inconvenience!</p>
      </div>
      <![endif]-->
    <!-- Warning Section Ends -->

    <!-- Required Jqurey -->
    <script src="{{ asset('assets/plugins/Jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tether/dist/js/tether.min.js') }}"></script>

    <!-- Required Fremwork -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Scrollbar JS-->
    <script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery.nicescroll/jquery.nicescroll.min.js') }}"></script>

    <!--classic JS-->
    <script src="{{ asset('assets/plugins/classie/classie.js') }}"></script>

    <!-- notification -->
    <script src="{{ asset('assets/plugins/notification/js/bootstrap-growl.min.js') }}"></script>

    <!-- Sparkline charts -->
    <script src="{{ asset('assets/plugins/jquery-sparkline/dist/jquery.sparkline.js') }}"></script>

    <!-- Counter js  -->
    <script src="{{ asset('assets/plugins/waypoints/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/countdown/js/jquery.counterup.js') }}"></script>

    <!-- Echart js -->
    <script src="{{ asset('assets/plugins/charts/echarts/js/echarts-all.js') }}"></script>

    <script src="{{ asset('https://code.highcharts.com/highcharts.js') }}"></script>
    <script src="{{ asset('https://code.highcharts.com/modules/exporting.js') }}"></script>
    <script src="{{ asset('https://code.highcharts.com/highcharts-3d.js') }}"></script>

    <!-- custom js -->
    <script type="text/javascript" src="{{ asset('assets/js/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/pages/dashboard.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/pages/elements.js') }}"></script>
    <script src="assets/js/menu.min.js"></script>

    <script>
        var $window = $(window);
        var nav = $('.fixed-button');
        $window.scroll(function() {
            if ($window.scrollTop() >= 200) {
                nav.addClass('active');
            } else {
                nav.removeClass('active');
            }
        });

        // Animation pour les compteurs
        $(document).ready(function() {
            // Simulation de données (remplacer par des appels AJAX réels)
            setTimeout(function() {
                animateCounter('#properties-count', 12);
                animateCounter('#tenants-count', 8);
                animateCounter('#rent-collected', 450000);
                animateCounter('#maintenance-count', 5);
            }, 1000);

            // Animation des cartes au chargement
            $('.stats-card').each(function(index) {
                $(this).css('animation-delay', (index * 0.2) + 's');
                $(this).addClass('animate__animated animate__fadeInUp');
            });

            // Animation des actions rapides
            $('.action-btn').each(function(index) {
                $(this).css('animation-delay', (index * 0.1) + 's');
                $(this).addClass('animate__animated animate__fadeInLeft');
            });
        });

        function animateCounter(elementId, target) {
            let current = 0;
            const increment = target / 50;
            const element = $(elementId);
            const timer = setInterval(function() {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }

                // Formatage selon le type de données
                if (target > 1000) {
                    element.text(Math.floor(current).toLocaleString('fr-FR'));
                } else {
                    element.text(Math.floor(current));
                }
            }, 30);
        }

        // Mettre à jour l'heure en temps réel
        function updateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };

            const timeString = now.toLocaleDateString('fr-FR', options);
            $('.greeting-time').text(timeString);
        }

        // Mettre à jour l'heure toutes les minutes
        setInterval(updateTime, 60000);
        updateTime(); // Appel initial
    </script>

</body>

</html>
