<!DOCTYPE html>
<html lang="fr">

<head>
    @stack('meta')
    <title>{{ $title ?? 'Résidences Élégantes - Logements premium' }}</title>
    <meta name="description"
        content="{{ $description ?? 'Découvrez nos résidences haut de gamme à Parakou. Sécurité, confort et services premium.' }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résidences Élégantes - Trouvez votre logement idéal</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (icônes) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #3490dc;
            --secondary-blue: #1a6fc9;
            --light-gray: #f8f9fa;
            --dark-gray: #343a40;
            --transition: all 0.4s cubic-bezier(0.645, 0.045, 0.355, 1);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            padding: 15px 0;
            transition: var(--transition);
        }

        .navbar.scrolled {
            background-color: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .nav-link {
            font-weight: 500;
            margin: 0 8px;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--primary-blue);
            transition: var(--transition);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            padding: 150px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, transparent 0%, rgba(0, 0, 0, 0.5) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-weight: 800;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
        }

        .hero-subtitle {
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background-color: var(--secondary-blue);
            border-color: var(--secondary-blue);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Logements Disponibles */
        .section-title {
            position: relative;
            display: inline-block;
            margin-bottom: 50px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            background: var(--primary-blue);
            bottom: -10px;
            left: 25%;
            border-radius: 3px;
        }

        .card-hover {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
            margin-bottom: 30px;
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .carousel-item img {
            height: 250px;
            object-fit: cover;
            transition: var(--transition);
        }

        .card-body {
            padding: 25px;
        }

        .card-title {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .property-features {
            list-style: none;
            padding: 0;
            margin: 15px 0;
        }

        .property-features li {
            margin-bottom: 8px;
        }

        .property-features i {
            color: var(--primary-blue);
            width: 20px;
            text-align: center;
            margin-right: 5px;
        }

        .price-tag {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-blue);
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
            background-color: #f9f9f9;
        }

        .feature-box {
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            height: 100%;
        }

        .feature-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-blue);
            margin-bottom: 20px;
        }

        /* Testimonials */
        .testimonial-section {
            padding: 80px 0;
            background: linear-gradient(rgba(52, 144, 220, 0.9), rgba(26, 111, 201, 0.9)), url('https://images.unsplash.com/photo-1560448204-603b3fc33ddc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-attachment: fixed;
            color: white;
        }

        .testimonial-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 30px;
            margin: 15px;
            transition: var(--transition);
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.2);
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
        }

        .client-info {
            display: flex;
            align-items: center;
        }

        .client-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        /* Contact Form */
        .contact-form {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            height: 50px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding-left: 20px;
            transition: var(--transition);
        }

        .form-control:focus {
            box-shadow: none;
            border-color: var(--primary-blue);
        }

        textarea.form-control {
            height: auto;
            padding-top: 15px;
        }

        /* Footer */
        .footer {
            background-color: var(--dark-gray);
            color: white;
            padding: 60px 0 20px;
        }

        .footer-links h5 {
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .footer-links h5::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 2px;
            background: var(--primary-blue);
            bottom: -8px;
            left: 0;
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #adb5bd;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }

        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            margin-right: 10px;
            transition: var(--transition);
        }

        .social-icons a:hover {
            background: var(--primary-blue);
            transform: translateY(-5px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            margin-top: 40px;
        }

        /* Login Modal */
        .login-modal .modal-content {
            border-radius: 15px;
            overflow: hidden;
            border: none;
        }

        .login-modal .modal-header {
            background: var(--primary-blue);
            color: white;
            border-bottom: none;
        }

        .login-modal .modal-body {
            padding: 30px;
        }

        .login-modal .form-control {
            padding-left: 45px;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-blue);
        }

        .login-btn {
            background: var(--primary-blue);
            border: none;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: var(--transition);
        }

        .login-btn:hover {
            background: var(--secondary-blue);
        }

        /* Floating elements */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section {
                padding: 100px 0;
                background-attachment: scroll;
            }

            .hero-title {
                font-size: 2rem;
            }

            .section-title::after {
                width: 30%;
                left: 35%;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand text-primary" href="#">
                <i class="fas fa-home me-2"></i>Résidences Élégantes
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#logements">Logements</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Avantages</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Témoignages</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item ms-lg-3 my-2 my-lg-0">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fas fa-sign-in-alt me-1"></i> Espace utilisateur
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container hero-content">
            <h1 class="hero-title display-4 fw-bold mb-4 animate__animated animate__fadeInDown">Votre logement idéal à
                portée de clic</h1>
            <p class="hero-subtitle lead mb-4 animate__animated animate__fadeIn animate__delay-1s">Découvrez des
                chambres et appartements modernes dans les meilleurs quartiers de Parakou.</p>
            <a href="#logements"
                class="btn btn-primary btn-lg px-4 animate__animated animate__fadeInUp animate__delay-1s">
                <i class="fas fa-search me-1"></i> Voir les disponibilités

            </a>
            {{-- {{ Hash::make('azerty') }} --}}
        </div>
    </section>

    <!-- Logements Disponibles -->
    <section id="logements" class="py-5 bg-light">
        <div class="container py-5">
            <h2 class="text-center mb-5 section-title" data-aos="fade-up">Nos logements disponibles</h2>
            <div class="row g-4">
                <!-- Logement 1 -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card card-hover h-100">
                        <div id="carousel1" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                                        class="d-block w-100" alt="Appartement moderne">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://images.unsplash.com/photo-1493809842364-78817add7ffb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                                        class="d-block w-100" alt="Cuisine équipée">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel1"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel1"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Appartement Moderne 3 pièces</h5>
                            <p class="text-muted">
                                <i class="fas fa-map-marker-alt text-primary me-1"></i> Quartier résidentiel, Parakou
                            </p>
                            <ul class="property-features">
                                <li><i class="fas fa-ruler-combined"></i> 85 m²</li>
                                <li><i class="fas fa-bed"></i> 2 chambres</li>
                                <li><i class="fas fa-bath"></i> 2 salles de bain</li>
                                <li><i class="fas fa-wifi"></i> Internet haut débit</li>
                            </ul>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">75,000 FCFA/mois</span>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#contactModal" data-chambre="Appartement Moderne 3 pièces">
                                    <i class="fas fa-envelope me-1"></i> Contacter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logement 2 -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card card-hover h-100">
                        <div id="carousel2" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://images.unsplash.com/photo-1513694203232-719a280e022f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                                        class="d-block w-100" alt="Chambre confortable">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                                        class="d-block w-100" alt="Salle de bain">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel2"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel2"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Chambre Confortable</h5>
                            <p class="text-muted">
                                <i class="fas fa-map-marker-alt text-primary me-1"></i> Centre-ville, Parakou
                            </p>
                            <ul class="property-features">
                                <li><i class="fas fa-ruler-combined"></i> 25 m²</li>
                                <li><i class="fas fa-bed"></i> 1 lit double</li>
                                <li><i class="fas fa-bath"></i> Salle de bain partagée</li>
                                <li><i class="fas fa-utensils"></i> Cuisine commune</li>
                            </ul>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">35,000 FCFA/mois</span>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#contactModal" data-chambre="Chambre Confortable">
                                    <i class="fas fa-envelope me-1"></i> Contacter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logement 3 -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card card-hover h-100">
                        <div id="carousel3" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                                        class="d-block w-100" alt="Studio meublé">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://images.unsplash.com/photo-1556911220-bff31c812dba?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                                        class="d-block w-100" alt="Espace cuisine">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel3"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel3"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Studio Meublé</h5>
                            <p class="text-muted">
                                <i class="fas fa-map-marker-alt text-primary me-1"></i> Quartier calme, Parakou
                            </p>
                            <ul class="property-features">
                                <li><i class="fas fa-ruler-combined"></i> 40 m²</li>
                                <li><i class="fas fa-bed"></i> 1 lit queen size</li>
                                <li><i class="fas fa-bath"></i> 1 salle de bain</li>
                                <li><i class="fas fa-tv"></i> TV câblée incluse</li>
                            </ul>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">50,000 FCFA/mois</span>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#contactModal" data-chambre="Studio Meublé">
                                    <i class="fas fa-envelope me-1"></i> Contacter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="#" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-list me-1"></i> Voir tous les logements
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container py-5">
            <h2 class="text-center mb-5 section-title" data-aos="fade-up">Pourquoi choisir nos résidences ?</h2>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Sécurité 24/7</h4>
                        <p>Nos résidences sont équipées de systèmes de sécurité avancés et surveillées 24 heures sur 24
                            pour votre tranquillité d'esprit.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-wifi"></i>
                        </div>
                        <h4>Internet Haut Débit</h4>
                        <p>Connexion internet fibre optique incluse dans tous nos logements pour travailler et vous
                            divertir sans interruption.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-concierge-bell"></i>
                        </div>
                        <h4>Services Premium</h4>
                        <p>Ménage régulier, maintenance rapide et service client dédié pour répondre à tous vos besoins.
                        </p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-parking"></i>
                        </div>
                        <h4>Parking Sécurisé</h4>
                        <p>Place de parking privée ou en sous-sol incluse avec chaque logement pour protéger votre
                            véhicule.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-solar-panel"></i>
                        </div>
                        <h4>Économie d'Énergie</h4>
                        <p>Installations modernes et économiques pour réduire votre consommation et vos factures.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <h4>Flexibilité</h4>
                        <p>Contrats flexibles adaptés à vos besoins, avec possibilité de renouvellement simplifié.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonial-section py-5">
        <div class="container py-5">
            <h2 class="text-center mb-5 section-title text-white" data-aos="fade-up">Ce que disent nos locataires</h2>
            <div class="row">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "Je vis dans une de leurs résidences depuis 2 ans et je n'ai jamais été aussi satisfait. Le
                            service client est exceptionnel et les appartements sont très bien entretenus."
                        </div>
                        <div class="client-info">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Client"
                                class="client-img">
                            <div>
                                <h5 class="mb-0">Jean D.</h5>
                                <small>Locataire depuis 2021</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "La transition vers mon nouvel appartement a été incroyablement fluide grâce à l'équipe de
                            Résidences Élégantes. Tout est fait pour que les locataires se sentent chez eux."
                        </div>
                        <div class="client-info">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client"
                                class="client-img">
                            <div>
                                <h5 class="mb-0">Amina K.</h5>
                                <small>Locataire depuis 2022</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "En tant qu'expatrié, trouver un logement de qualité était ma priorité. Résidences Élégantes
                            a dépassé mes attentes avec des services adaptés aux professionnels internationaux."
                        </div>
                        <div class="client-info">
                            <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Client"
                                class="client-img">
                            <div>
                                <h5 class="mb-0">Thomas L.</h5>
                                <small>Locataire depuis 2020</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-white">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                    <h2 class="section-title mb-4">Contactez-nous</h2>
                    <p class="mb-4">Vous avez des questions sur nos logements ou souhaitez organiser une visite ?
                        Notre équipe est à votre disposition pour vous accompagner.</p>

                    <div class="d-flex align-items-start mb-4">
                        <div class="me-3 text-primary">
                            <i class="fas fa-map-marker-alt fa-2x"></i>
                        </div>
                        <div>
                            <h5>Adresse</h5>
                            <p class="mb-0">123 Avenue des Résidences, Parakou, Bénin</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="me-3 text-primary">
                            <i class="fas fa-phone-alt fa-2x"></i>
                        </div>
                        <div>
                            <h5>Téléphone</h5>
                            <p class="mb-0">+229 12 34 56 78</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="me-3 text-primary">
                            <i class="fas fa-envelope fa-2x"></i>
                        </div>
                        <div>
                            <h5>Email</h5>
                            <p class="mb-0">contact@residences-elegantes.bj</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="me-3 text-primary">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <div>
                            <h5>Heures d'ouverture</h5>
                            <p class="mb-0">Lundi - Vendredi: 8h - 18h<br>Samedi: 9h - 13h</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <div class="contact-form">
                        <h4 class="mb-4">Envoyez-nous un message</h4>
                        <form>
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Votre nom complet" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Votre email" required>
                            </div>
                            <div class="mb-3">
                                <input type="tel" class="form-control" placeholder="Votre téléphone" required>
                            </div>
                            <div class="mb-3">
                                <select class="form-select">
                                    <option selected disabled>Sujet de votre message</option>
                                    <option>Demande de visite</option>
                                    <option>Question sur un logement</option>
                                    <option>Autre demande</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" rows="4" placeholder="Votre message" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-paper-plane me-1"></i> Envoyer le message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal de Contact -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Contacter le propriétaire</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="chambre" id="chambreField">
                        <div class="mb-3">
                            <label class="form-label">Nom complet</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" name="telephone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> Envoyer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade login-modal" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Connexion à votre espace</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        @method('POST')
                        <div class="mb-3 position-relative">
                            <label for="email" class="form-label">Email</label>
                            <i class="fas fa-envelope input-icon"></i>
                            <input id="email" type="email"
                                class="form-control ps-4 @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="Votre email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Mot de passe</label>
                            <i class="fas fa-lock input-icon"></i>
                            <input id="password" type="password"
                                class="form-control ps-4 @error('password') is-invalid @enderror" name="password"
                                required autocomplete="current-password" placeholder="Votre mot de passe">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Se souvenir de moi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="float-end text-decoration-none">
                                    Mot de passe oublié ?
                                </a>
                            @endif
                        </div> --}}

                        <button type="submit" class="btn btn-primary login-btn w-100 mb-3">
                            <i class="fas fa-sign-in-alt me-1"></i> Se connecter
                        </button>

                        {{-- <div class="text-center">
                        <p class="mb-0">Nouveau locataire ?
                            <a href="#" class="text-primary text-decoration-none">Créer un compte</a>
                        </p>
                    </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-links">
                        <h5><i class="fas fa-home me-2"></i>Résidences Élégantes</h5>
                        <p class="mt-3">Votre partenaire immobilier de confiance au Bénin. Nous offrons des logements
                            haut de gamme avec des services premium pour votre confort et sécurité.</p>
                        <div class="social-icons mt-3">
                            <a href="https://www.facebook.com/nailou.sekaro" target="_blank"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a href="https://wa.me/22961581258" target="_blank"><i class="fab fa-whatsapp"></i></a>
                            <a href="https://instagram.com/votrecompte" target="_blank"><i
                                    class="fab fa-instagram"></i></a>
                            <a href="https://twitter.com/votrecompte" target="_blank"><i
                                    class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-links">
                        <h5>Liens rapides</h5>
                        <ul>
                            <li><a href="#logements">Nos logements</a></li>
                            <li><a href="#features">Nos avantages</a></li>
                            <li><a href="#testimonials">Témoignages</a></li>
                            <li><a href="#contact">Contact</a></li>
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Espace
                                    locataire</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-links">
                        <h5>Contact</h5>
                        <ul>
                            <li><i class="fas fa-map-marker-alt me-2"></i> 123 Avenue des Résidences, Parakou, Bénin
                            </li>
                            <li><i class="fas fa-phone-alt me-2"></i> +229 61 58 12 58</li>
                            <li><i class="fas fa-envelope me-2"></i> contact@residences-elegantes.bj</li>
                            <li><i class="fas fa-clock me-2"></i> Lun-Ven: 8h-18h / Sam: 9h-13h</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-links">
                        <h5>Newsletter</h5>
                        <p>Abonnez-vous pour recevoir nos offres spéciales et nouveautés.</p>
                        <form class="mt-3">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Votre email" required>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <p class="mb-0">&copy; 2025 Résidences Élégantes. Tous droits réservés. | <a href="#"
                        class="text-white text-decoration-none">Politique de confidentialité</a> | <a href="#"
                        class="text-white text-decoration-none">Conditions d'utilisation</a></p>
            </div>
        </div>

        {{-- <div class="language-switcher mt-3">
            <span class="me-2">Langue:</span>
            <a href="{{ route('language', 'fr') }}" class="text-white me-2">
                <img src="{{ asset('images/flags/fr.png') }}" alt="Français" width="20"> Français
            </a>
            <a href="{{ route('language', 'en') }}" class="text-white me-2">
                <img src="{{ asset('images/flags/en.png') }}" alt="English" width="20"> English
            </a>
            <a href="{{ route('language', 'es') }}" class="text-white me-2">
                <img src="{{ asset('images/flags/es.png') }}" alt="Español" width="20"> Español
            </a>
            <a href="{{ route('language', 'de') }}" class="text-white">
                <img src="{{ asset('images/flags/de.png') }}" alt="Deutsch" width="20"> Deutsch
            </a>
        </div> --}}


    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="btn btn-primary btn-lg back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS (Animate On Scroll) -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Back to top button
        const backToTopButton = document.getElementById('backToTop');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopButton.style.display = 'block';
                backToTopButton.classList.add('animate__animated', 'animate__fadeIn');
                backToTopButton.classList.remove('animate__fadeOut');
            } else {
                backToTopButton.classList.add('animate__fadeOut');
                backToTopButton.classList.remove('animate__fadeIn');
            }
        });

        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Remplir le champ "chambre" dans le modal
        document.getElementById('contactModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const chambre = button.getAttribute('data-chambre');
            document.getElementById('chambreField').value = chambre;
        });

        // Floating animation for elements
        function addFloatingAnimation() {
            const elements = document.querySelectorAll('.floating');
            elements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.2}s`;
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            addFloatingAnimation();
        });
    </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Vérifier s'il y a des erreurs de validation
            @if ($errors->has('email') || $errors->has('password'))
                // Ouvrir automatiquement le modal s'il y a des erreurs
                var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
            @endif

            // Gérer la soumission du formulaire via AJAX pour une meilleure UX
            const loginForm = document.querySelector('#loginModal form');
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(loginForm);

                    fetch(loginForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            if (response.redirected) {
                                window.location.href = response.url;
                            } else {
                                return response.json();
                            }
                        })
                        .then(data => {
                            if (data.errors) {
                                // Gérer les erreurs de validation
                                const errorElements = loginForm.querySelectorAll('.is-invalid');
                                errorElements.forEach(el => el.classList.remove('is-invalid'));

                                const feedbackElements = loginForm.querySelectorAll(
                                    '.invalid-feedback');
                                feedbackElements.forEach(el => el.remove());

                                for (const [field, messages] of Object.entries(data.errors)) {
                                    const input = loginForm.querySelector(`[name="${field}"]`);
                                    if (input) {
                                        input.classList.add('is-invalid');

                                        const feedback = document.createElement('div');
                                        feedback.classList.add('invalid-feedback');
                                        feedback.innerHTML = `<strong>${messages[0]}</strong>`;

                                        input.parentNode.appendChild(feedback);
                                    }
                                }
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            }
        });
    </script> --}}
</body>

</html>
