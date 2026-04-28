<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Messagerie')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css for smooth animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Our custom styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        /* Custom smooth scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Optional subtle background */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Main container animation */
        .container.py-4 {
            animation: fadeIn 0.8s ease-out;
        }

        /* Keyframes for fade-in */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <!-- Fixed Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold">
                <i class="fas fa-comments me-2"></i>Messagerie
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-home me-1"></i>
                            Dashboard</a>
                    </li>
                    <!-- Add other navigation items here -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content - with padding to avoid being hidden under the fixed nav -->
    <div class="container py-4" style="margin-top: 80px;">
        @yield('content')
    </div>

    <!-- Optional Footer -->
    <footer class="bg-light text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0 text-muted">&copy; {{ date('Y') }} Messagerie. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Bootstrap & Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- Space for page-specific scripts -->
    @yield('scripts')

</body>

</html>
<script>
    // Mise à jour du compteur de messages non lus
    function updateUnreadCount() {
        fetch('/api/unread-messages-count')
            .then(response => response.json())
            .then(data => {
                const counter = document.getElementById('nav-unread-count');
                if (counter) {
                    counter.textContent = data.count;
                }
            })
            .catch(error => console.error('Erreur:', error));
    }

    // Mettre à jour toutes les 30 secondes
    setInterval(updateUnreadCount, 30000);

    // Mettre à jour au chargement de la page
    document.addEventListener('DOMContentLoaded', updateUnreadCount);
</script>
