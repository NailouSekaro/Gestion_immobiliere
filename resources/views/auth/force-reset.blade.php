<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changement de mot de passe obligatoire</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-blue: #3490dc;
            --secondary-blue: #1a6fc9;
            --light-blue: #e6f0fa;
            --white: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            height: 100vh;
            display: flex;
            align-items: center;
        }

        .password-container {
            max-width: 500px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(52, 144, 220, 0.2);
            overflow: hidden;
            transform: translateY(0);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .password-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(52, 144, 220, 0.3);
        }

        .password-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white;
            padding: 25px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .password-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            transform: rotate(30deg);
            animation: shine 8s infinite linear;
        }

        @keyframes shine {
            0% {
                transform: rotate(30deg) translate(-10%, -10%);
            }

            100% {
                transform: rotate(30deg) translate(10%, 10%);
            }
        }

        .password-header h3 {
            font-weight: 700;
            margin-bottom: 5px;
            position: relative;
        }

        .password-header p {
            opacity: 0.9;
            font-size: 0.9rem;
            position: relative;
        }

        .password-body {
            padding: 30px;
        }

        .password-icon {
            width: 80px;
            height: 80px;
            background: var(--light-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -65px auto 20px;
            border: 5px solid var(--white);
            box-shadow: 0 5px 15px rgba(52, 144, 220, 0.2);
            animation: bounceIn 0.8s both;
        }

        .password-icon i {
            font-size: 2.5rem;
            color: var(--primary-blue);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            height: 50px;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            padding-left: 45px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(52, 144, 220, 0.2);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-blue);
        }

        .password-strength {
            height: 5px;
            background: #e2e8f0;
            border-radius: 5px;
            margin-top: 5px;
            overflow: hidden;
            position: relative;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            background: #e53e3e;
            border-radius: 5px;
            transition: width 0.4s, background 0.4s;
        }

        .password-requirements {
            margin-top: 1rem;
            font-size: 0.85rem;
        }

        .password-requirements ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        .password-requirements li {
            margin-bottom: 0.3rem;
            position: relative;
            padding-left: 25px;
            color: #718096;
            transition: color 0.3s;
        }

        .password-requirements li::before {
            content: '\f00d';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: 0;
            color: #e53e3e;
        }

        .password-requirements li.valid {
            color: #38a169;
        }

        .password-requirements li.valid::before {
            content: '\f00c';
            color: #38a169;
        }

        .btn-primary {
            background: var(--primary-blue);
            border: none;
            padding: 12px 25px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            background: var(--secondary-blue);
            transform: translateY(-2px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(30deg);
            transition: all 0.3s;
        }

        .btn-primary:hover::after {
            animation: shine 1.5s infinite;
        }

        /* Animations */
        @keyframes bounceIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-delay-1 {
            animation-delay: 0.2s;
        }

        .animate-delay-2 {
            animation-delay: 0.4s;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="password-container animate__animated animate__fadeInUp">
            <div class="password-header">
                <h3>Changement de mot de passe obligatoire</h3>
                <p>Pour votre sécurité, vous devez définir un nouveau mot de passe</p>
            </div>

            <div class="password-icon animate__animated animate__bounceIn">
                <i class="fas fa-lock"></i>
            </div>

            <div class="password-body">
                <form id="passwordChangeForm" method="POST" action="{{ route('password.reset') }}">
                    @csrf
                    @method('POST')
                    <div class="form-group animate__animated animate__fadeIn animate-delay-1">
                        <label for="currentPassword">Mot de passe actuel</label>
                        <div class="position-relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                id="currentPassword" required>
                        </div>
                    </div>
                    @error('current_password')
                        <div style="color:rgba(255, 0, 0, 0.858)"> {{ $message }}</div>
                    @enderror

                    {{-- @error('current_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror --}}

                    <div class="form-group animate__animated animate__fadeIn animate-delay-1">
                        <label for="newPassword">Nouveau mot de passe</label>
                        <div class="position-relative">
                            <i class="fas fa-key input-icon"></i>
                            <input type="password" name="new_password"
                                class="form-control @error('new_password') is-invalid @enderror" id="newPassword"
                                required>
                        </div>

                        @error('new_password')
                            <div style="color:rgba(255, 0, 0, 0.858)"> {{ $message }}</div>
                        @enderror

                        {{-- @error('new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror --}}
                        <div class="password-strength">
                            <div class="password-strength-bar" id="passwordStrengthBar"></div>
                        </div>
                        <div class="password-requirements">
                            <ul>
                                <li id="reqLength">Minimum 12 caractères</li>
                                <li id="reqUpper">Au moins une majuscule</li>
                                <li id="reqNumber">Au moins un chiffre</li>
                                <li id="reqSpecial">Au moins un caractère spécial</li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group animate__animated animate__fadeIn animate-delay-2">
                        <label for="confirmPassword">Confirmer le nouveau mot de passe</label>
                        <div class="position-relative">
                            <i class="fas fa-check-circle input-icon"></i>
                            <input type="password" name="new_password_confirmation"
                                class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                id="confirmPassword" required>
                        </div>
                        <div class="invalid-feedback" id="passwordMatchError">Les mots de passe ne correspondent pas
                        </div>
                    </div>

                    @error('new_password_confirmation')
                        <div style="color:rgba(255, 0, 0, 0.858)"> {{ $message }}</div>
                    @enderror

                    {{-- @error('new_password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror --}}
                    <div class="form-group mt-4 animate__animated animate__fadeIn animate-delay-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Enregistrer le nouveau mot de passe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const newPasswordInput = document.getElementById('newPassword');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const strengthBar = document.getElementById('passwordStrengthBar');
            const reqLength = document.getElementById('reqLength');
            const reqUpper = document.getElementById('reqUpper');
            const reqNumber = document.getElementById('reqNumber');
            const reqSpecial = document.getElementById('reqSpecial');
            const passwordMatchError = document.getElementById('passwordMatchError');

            // Animation de validation du mot de passe
            newPasswordInput.addEventListener('input', function() {
                const password = this.value;
                const strength = calculatePasswordStrength(password);

                // Mise à jour de la barre de force
                strengthBar.style.width = strength.percentage + '%';

                // Changement de couleur selon la force
                if (strength.score < 2) {
                    strengthBar.style.backgroundColor = '#e53e3e'; // Rouge
                } else if (strength.score < 4) {
                    strengthBar.style.backgroundColor = '#dd6b20'; // Orange
                } else {
                    strengthBar.style.backgroundColor = '#38a169'; // Vert
                }

                // Validation des exigences
                reqLength.classList.toggle('valid', password.length >= 12);
                reqUpper.classList.toggle('valid', /[A-Z]/.test(password));
                reqNumber.classList.toggle('valid', /\d/.test(password));
                reqSpecial.classList.toggle('valid', /[^A-Za-z0-9]/.test(password));
            });

            // Vérification de la correspondance des mots de passe
            confirmPasswordInput.addEventListener('input', function() {
                const match = newPasswordInput.value === this.value;
                if (this.value.length > 0) {
                    if (!match) {
                        this.classList.add('is-invalid');
                        passwordMatchError.style.display = 'block';
                    } else {
                        this.classList.remove('is-invalid');
                        passwordMatchError.style.display = 'none';
                    }
                } else {
                    this.classList.remove('is-invalid');
                    passwordMatchError.style.display = 'none';
                }
            });

            // Fonction pour calculer la force du mot de passe
            function calculatePasswordStrength(password) {
                let score = 0;
                let messages = [];

                // Longueur minimale
                if (password.length >= 12) score += 2;
                else if (password.length >= 8) score += 1;

                // Majuscules
                if (/[A-Z]/.test(password)) score += 1;

                // Chiffres
                if (/\d/.test(password)) score += 1;

                // Caractères spéciaux
                if (/[^A-Za-z0-9]/.test(password)) score += 1;

                // Calcul du pourcentage
                const percentage = Math.min(100, (score / 5) * 100);

                return {
                    score,
                    percentage
                };
            }

            // Animation de soumission du formulaire
            // const form = document.getElementById('passwordChangeForm');
            // form.addEventListener('submit', function(e) {
            //     e.preventDefault();

            // Simulation de succès - À remplacer par votre logique backend
            // const submitBtn = this.querySelector('button[type="submit"]');
            // submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Enregistrement...';
            // submitBtn.disabled = true;

            // setTimeout(function() {
            //     submitBtn.innerHTML =
            //         '<i class="fas fa-check me-2"></i> Mot de passe changé avec succès!';

            //     // Redirection après 1.5 secondes
            //     setTimeout(function() {
            //         window.location.href =
            //             '/dashboard'; // Remplacez par votre URL de dashboard
            //     }, 1500);
            // }, 2000);
            // });
        });
    </script>
</body>

</html>
