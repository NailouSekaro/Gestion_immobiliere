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

        .container {
            max-width: 1000px;
            padding: 2rem;
            margin: 0 auto;
        }

        .profile-container {
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

        .alert-success {
            background: linear-gradient(135deg, rgba(76, 201, 240, 0.1) 0%, rgba(76, 201, 240, 0.2) 100%);
            border: 2px solid rgba(76, 201, 240, 0.3);
            border-left: 4px solid var(--success);
            color: var(--success-dark);
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
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
            padding: 2rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--primary-light);
            animation: fadeInLeft 0.5s ease forwards;
            opacity: 0;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .section-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .section-icon i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .form-group {
            margin-bottom: 1.8rem;
            animation: fadeInRight 0.5s ease forwards;
            opacity: 0;
        }

        .form-label {
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
        }

        .form-label i {
            margin-right: 0.5rem;
            color: var(--primary);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.9rem 1.2rem;
            border: 2px solid #e2e8f0;
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
            transform: translateY(-2px);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.05) 0%, rgba(220, 38, 38, 0.1) 100%);
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.2);
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 0.5rem;
            padding-left: 0.5rem;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        /* Photo Upload */
        .photo-upload-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .profile-photo-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .profile-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transition: var(--transition);
        }

        .profile-photo:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        .photo-upload-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
        }

        .photo-upload-btn:hover {
            transform: scale(1.1) rotate(15deg);
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        }

        .file-input-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-input {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-label {
            display: block;
            padding: 1rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border: 2px dashed #e2e8f0;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .file-label:hover {
            border-color: var(--primary);
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(67, 97, 238, 0.1) 100%);
            transform: translateY(-2px);
        }

        /* Divider */
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            margin: 2.5rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--primary);
            content: '👤';
            font-size: 1.2rem;
        }

        /* Buttons */
        .btn {
            padding: 0.9rem 2.5rem;
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
            font-size: 1rem;
            position: relative;
            overflow: hidden;
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .btn:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            20% {
                transform: scale(25, 25);
                opacity: 0.3;
            }
            100% {
                opacity: 0;
                transform: scale(40, 40);
            }
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

        .form-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 2px solid #e2e8f0;
        }

        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
        .animate-delay-4 { animation-delay: 0.4s; }
        .animate-delay-5 { animation-delay: 0.5s; }

        /* User Info Display */
        .user-info-display {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-row {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .info-icon i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .info-content h6 {
            margin: 0;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .info-content p {
            margin: 0;
            color: var(--gray);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .profile-photo {
                width: 120px;
                height: 120px;
            }

            .form-footer {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="profile-container">
        <!-- En-tête -->
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-user-circle me-2"></i>Mon Profil
                </h1>
                <p class="page-subtitle">Gérez vos informations personnelles et votre mot de passe</p>
            </div>
        </div>

        <!-- Messages de succès -->
        @if(session('success'))
            <div class="alert-success animate-delay-1">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Succès !</h5>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulaire principal -->
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profileForm">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-body">
                    <!-- Section Photo -->
                    <div class="section-header animate-delay-1">
                        <div class="section-icon">
                            <i class="fas fa-camera"></i>
                        </div>
                        <h3 class="section-title">Photo de profil</h3>
                    </div>

                    <div class="photo-upload-container">
                        <div class="profile-photo-wrapper">
                            @if($user->photo_profil)
                                <img src="{{ asset('storage/'.$user->photo_profil) }}"
                                     class="profile-photo"
                                     id="profilePhoto"
                                     alt="Photo de profil">
                            @else
                                <div class="profile-photo d-flex align-items-center justify-content-center"
                                     style="background: linear-gradient(135deg, var(--primary-light) 0%, rgba(67, 97, 238, 0.3) 100%);"
                                     id="profilePhoto">
                                    <i class="fas fa-user fa-3x" style="color: var(--primary);"></i>
                                </div>
                            @endif

                            <button type="button" class="photo-upload-btn" onclick="document.getElementById('photoInput').click()">
                                <i class="fas fa-camera"></i>
                            </button>

                            <input type="file"
                                   name="photo_profil"
                                   id="photoInput"
                                   class="d-none"
                                   accept="image/*"
                                   onchange="previewImage(this)">
                        </div>

                        <div class="file-input-wrapper">
                            <input type="file"
                                   name="photo_profil"
                                   id="photo_profil"
                                   class="file-input"
                                   accept="image/*"
                                   onchange="previewImage(this)">
                            <label for="photo_profil" class="file-label">
                                <i class="fas fa-cloud-upload-alt me-2"></i>
                                <span id="fileLabelText">Cliquez pour sélectionner une photo</span>
                                <br>
                                <small class="text-muted">JPG, PNG ou GIF • Max 2MB</small>
                            </label>
                        </div>

                        @error('photo_profil')
                            <div class="invalid-feedback d-block">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="divider"></div>

                    <!-- Informations personnelles -->
                    <div class="section-header animate-delay-2">
                        <div class="section-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <h3 class="section-title">Informations personnelles</h3>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-id-card"></i>Nom
                                </label>
                                <input type="text"
                                       name="nom"
                                       value="{{ old('nom', $user->nom) }}"
                                       class="form-control @error('nom') is-invalid @enderror"
                                       placeholder="Votre nom">
                                @error('nom')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-id-card"></i>Prénom
                                </label>
                                <input type="text"
                                       name="prenom"
                                       value="{{ old('prenom', $user->prenom) }}"
                                       class="form-control @error('prenom') is-invalid @enderror"
                                       placeholder="Votre prénom">
                                @error('prenom')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group animate-delay-3">
                        <label class="form-label">
                            <i class="fas fa-phone"></i>Téléphone
                        </label>
                        <input type="text"
                               name="telephone"
                               value="{{ old('telephone', $user->telephone) }}"
                               class="form-control"
                               placeholder="Votre numéro de téléphone">
                    </div>

                    <div class="divider"></div>

                    <!-- Changement de mot de passe -->
                    <div class="section-header animate-delay-4">
                        <div class="section-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h3 class="section-title">Changement de mot de passe</h3>
                    </div>

                    <div class="user-info-display mb-4">
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Laissez ces champs vides si vous ne souhaitez pas changer votre mot de passe
                        </p>
                    </div>

                    <div class="form-group animate-delay-5">
                        <label class="form-label">
                            <i class="fas fa-key"></i>Mot de passe actuel
                        </label>
                        <div class="input-group">
                            <input type="password"
                                   name="current_password"
                                   id="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   placeholder="Entrez votre mot de passe actuel">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('current_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group animate-delay-5">
                        <label class="form-label">
                            <i class="fas fa-key"></i>Nouveau mot de passe
                        </label>
                        <div class="input-group">
                            <input type="password"
                                   name="new_password"
                                   id="new_password"
                                   class="form-control @error('new_password') is-invalid @enderror"
                                   placeholder="Entrez votre nouveau mot de passe">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('new_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('new_password')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group animate-delay-5">
                        <label class="form-label">
                            <i class="fas fa-key"></i>Confirmer le mot de passe
                        </label>
                        <div class="input-group">
                            <input type="password"
                                   name="new_password_confirmation"
                                   id="confirm_password"
                                   class="form-control"
                                   placeholder="Confirmez votre nouveau mot de passe">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirm_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Pied de formulaire -->
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            <span>Mettre à jour le profil</span>
                            <span class="btn-spinner ms-2" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profileForm');
    const submitBtn = form.querySelector('.btn-primary');
    const btnSpinner = submitBtn.querySelector('.btn-spinner');

    // Animation des éléments
    const animatedElements = document.querySelectorAll('.form-group, .section-header, .user-info-display');
    animatedElements.forEach((element, index) => {
        element.style.animationDelay = `${(index * 0.1) + 0.3}s`;
        element.classList.add('animate__animated');

        if (element.classList.contains('form-group')) {
            element.classList.add('animate__fadeInRight');
        } else if (element.classList.contains('section-header')) {
            element.classList.add('animate__fadeInLeft');
        } else {
            element.classList.add('animate__fadeInUp');
        }
    });

    // Preview de l'image
    window.previewImage = function(input) {
        const fileLabel = document.getElementById('fileLabelText');
        const profilePhoto = document.getElementById('profilePhoto');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            fileLabel.textContent = file.name;

            // Vérifier la taille du fichier (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Le fichier est trop volumineux (max 2MB)');
                input.value = '';
                fileLabel.textContent = 'Cliquez pour sélectionner une photo';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                if (profilePhoto.tagName === 'IMG') {
                    profilePhoto.src = e.target.result;
                } else {
                    // Si c'est un div, on le remplace par une image
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'profile-photo';
                    img.id = 'profilePhoto';
                    img.alt = 'Photo de profil';
                    profilePhoto.parentNode.replaceChild(img, profilePhoto);
                }

                // Animation
                profilePhoto.classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    profilePhoto.classList.remove('animate__animated', 'animate__pulse');
                }, 500);
            };
            reader.readAsDataURL(file);
        }
    };

    // Toggle password visibility
    window.togglePassword = function(inputId) {
        const input = document.getElementById(inputId);
        const button = input.nextElementSibling.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            button.classList.remove('fa-eye');
            button.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            button.classList.remove('fa-eye-slash');
            button.classList.add('fa-eye');
        }

        // Animation
        input.classList.add('animate__animated', 'animate__pulse');
        setTimeout(() => {
            input.classList.remove('animate__animated', 'animate__pulse');
        }, 500);
    };

    // Validation du formulaire
    form.addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        // Vérifier si les mots de passe correspondent
        if (newPassword && newPassword !== confirmPassword) {
            e.preventDefault();
            showError('Les mots de passe ne correspondent pas');
            return;
        }

        // Vérifier la force du mot de passe
        if (newPassword && newPassword.length < 8) {
            e.preventDefault();
            showError('Le mot de passe doit contenir au moins 8 caractères');
            return;
        }

        // Afficher le spinner
        btnSpinner.style.display = 'inline-block';
        submitBtn.disabled = true;
        submitBtn.classList.add('animate__animated', 'animate__pulse');

        // Confirmation
        if (!confirm('Confirmez-vous la mise à jour de votre profil ?')) {
            e.preventDefault();
            btnSpinner.style.display = 'none';
            submitBtn.disabled = false;
            submitBtn.classList.remove('animate__animated', 'animate__pulse');
        }
    });

    // Animation sur les inputs
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                this.classList.remove('animate__animated', 'animate__pulse');
            }, 500);
        });
    });

    function showError(message) {
        // Créer une alerte temporaire
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-circle me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Insérer après l'en-tête
        const header = document.querySelector('.page-header');
        header.parentNode.insertBefore(alertDiv, header.nextSibling);

        // Supprimer après 5 secondes
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.classList.remove('show');
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.parentNode.removeChild(alertDiv);
                    }
                }, 300);
            }
        }, 5000);
    }
});
</script>
@endpush
