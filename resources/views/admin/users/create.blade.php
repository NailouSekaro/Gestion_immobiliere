@extends('layouts.template')
@section('content')
    <div class="container py-4">
        <div class="user-form-container">
            <div class="form-header">
                <h3><i class="fas fa-user-plus me-2"></i>Gestion des Utilisateurs</h3>
                <p>Création et modification des comptes utilisateurs</p>
            </div>

            <div class="form-icon">
                <i class="fas fa-user-cog"></i>
            </div>

            <div class="form-body">
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <strong>Le formulaire contient des erreurs :</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="userForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Nom -->
                        <div class="col-md-6">
                            <div class="form-group animate__animated animate__fadeIn animate-delay-1">
                                <label for="nom" class="form-label">
                                    <i class="fas fa-user-tag me-2 text-primary"></i>Nom
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                        id="nom" name="nom" value="{{ old('nom', $user->nom ?? '') }}" required>
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Prénom -->
                        <div class="col-md-6">
                            <div class="form-group animate__animated animate__fadeIn animate-delay-1">
                                <label for="prenom" class="form-label">
                                    <i class="fas fa-user me-2 text-primary"></i>Prénom
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                    <input type="text" class="form-control @error('prenom') is-invalid @enderror"
                                        id="prenom" name="prenom" value="{{ old('prenom', $user->prenom ?? '') }}"
                                        required>
                                    @error('prenom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group animate__animated animate__fadeIn animate-delay-2">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2 text-primary"></i>Email
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-at"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                                        required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Téléphone -->
                        <div class="col-md-6">
                            <div class="form-group animate__animated animate__fadeIn animate-delay-2">
                                <label for="telephone" class="form-label">
                                    <i class="fas fa-phone me-2 text-primary"></i>Téléphone
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                    <input type="tel" class="form-control @error('telephone') is-invalid @enderror"
                                        id="telephone" name="telephone"
                                        value="{{ old('telephone', $user->telephone ?? '') }}">
                                    @error('telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Rôle -->
                        <div class="col-md-6">
                            <div class="form-group animate__animated animate__fadeIn animate-delay-3">
                                <label for="role" class="form-label">
                                    <i class="fas fa-user-shield me-2 text-primary"></i>Rôle
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                                    <select class="form-control @error('role') is-invalid @enderror" id="role"
                                        name="role" required>
                                        <option value="">Sélectionner un rôle</option>
                                        <option value="admin"
                                            {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>
                                            Administrateur
                                        </option>
                                        <option value="locataire"
                                            {{ old('role', $user->role ?? '') == 'locataire' ? 'selected' : '' }}>
                                            Locataire
                                        </option>
                                        <option value="prestataire"
                                            {{ old('role', $user->role ?? '') == 'prestataire' ? 'selected' : '' }}>
                                            Prestataire
                                        </option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Champ spécialité (prestataire uniquement) -->
                        <div class="col-md-6" id="specialite-field" style="display: none;">
                            <div class="form-group animate__animated animate__fadeIn animate-delay-3">
                                <label for="specialite" class="form-label">
                                    <i class="fas fa-tools me-2 text-primary"></i>Spécialité
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-wrench"></i></span>
                                    <select class="form-control @error('specialite') is-invalid @enderror" id="specialite"
                                        name="specialite">
                                        <option value="">Sélectionner une spécialité</option>
                                        <option value="plombier"
                                            {{ old('specialite', $user->specialite ?? '') == 'plombier' ? 'selected' : '' }}>
                                            Plombier
                                        </option>
                                        <option value="electricien"
                                            {{ old('specialite', $user->specialite ?? '') == 'electricien' ? 'selected' : '' }}>
                                            Électricien
                                        </option>
                                        <option value="technicien"
                                            {{ old('specialite', $user->specialite ?? '') == 'technicien' ? 'selected' : '' }}>
                                            Technicien
                                        </option>
                                        {{-- <option value="peintre"
                                            {{ old('specialite', $user->specialite ?? '') == 'peintre' ? 'selected' : '' }}>
                                            Peintre
                                        </option> --}}
                                    </select>
                                    @error('specialite')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Champ propriété (locataire uniquement) -->
                        <div class="col-md-6" id="property-field" style="display: none;">
                            <div class="form-group animate__animated animate__fadeIn animate-delay-3">
                                <label for="property_id" class="form-label">
                                    <i class="fas fa-home me-2 text-primary"></i>Propriété assignée
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    <select class="form-control @error('property_id') is-invalid @enderror"
                                        id="property_id" name="property_id">
                                        <option value="">Sélectionner une propriété</option>
                                        @foreach (App\Models\Property::libres()->get() as $property)
                                            <option value="{{ $property->id }}"
                                                {{ old('property_id', $user->property_id ?? '') == $property->id ? 'selected' : '' }}>
                                                {{ $property->nom ?: 'Propriété #' . $property->id }} -
                                                {{ $property->adresse }} -
                                                {{ number_format((float) $property->loyer_mensuel, 0, ',', ' ') }} F
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('property_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Photo de profil -->
                    <div class="form-group animate__animated animate__fadeIn animate-delay-4">
                        <label class="form-label">
                            <i class="fas fa-camera me-2 text-primary"></i>Photo de profil
                        </label>
                        <div class="file-upload-container">
                            <label class="file-upload-label">
                                <div class="file-upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <div class="file-upload-text">Glissez-déposez votre image ou cliquez pour parcourir</div>
                                <div class="file-upload-hint">Formats acceptés: JPG, PNG, GIF (max 2MB)</div>
                                <input type="file" class="d-none" id="photo_profil" name="photo_profil"
                                    accept="image/jpeg,image/png,image/jpg,image/gif">
                            </label>
                        </div>
                        <img id="imagePreview" class="image-preview" src="#" alt="Aperçu de l'image">
                        @error('photo_profil')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Compte actif -->
                    <div class="form-check form-switch mb-4 animate__animated animate__fadeIn animate-delay-4">
                        <input class="form-check-input" type="checkbox" id="est_actif" name="est_actif" value="1"
                            {{ old('est_actif', $user->est_actif ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="est_actif">
                            <i class="fas fa-user-check me-2 text-success"></i>Compte actif
                        </label>
                    </div>

                    <!-- Boutons -->
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-save me-2"></i> Enregistrer
                        </button><br><br>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-arrow-left me-2"></i> Retour
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-blue: #3490dc;
            --secondary-blue: #1a6fc9;
            --light-blue: #e6f0fa;
            --white: #ffffff;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .user-form-container {
            background: var(--white);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(52, 144, 220, 0.15);
            overflow: hidden;
            transform: translateY(0);
            transition: var(--transition);
            margin-bottom: 2rem;
        }

        .user-form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(52, 144, 220, 0.2);
        }

        .form-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .form-header::before {
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

        .form-header h3 {
            font-weight: 700;
            margin-bottom: 5px;
            position: relative;
        }

        .form-header p {
            opacity: 0.9;
            font-size: 0.9rem;
            position: relative;
            margin-bottom: 0;
        }

        .form-body {
            padding: 25px;
        }

        .form-icon {
            width: 70px;
            height: 70px;
            background: var(--light-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -55px auto 20px;
            border: 5px solid var(--white);
            box-shadow: 0 5px 15px rgba(52, 144, 220, 0.2);
            animation: bounceIn 0.8s both;
        }

        .form-icon i {
            font-size: 2rem;
            color: var(--primary-blue);
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
            display: block;
        }

        .input-group {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            transition: var(--transition);
        }

        .input-group:hover {
            box-shadow: 0 0 0 3px rgba(52, 144, 220, 0.1);
        }

        .input-group-text {
            background: var(--light-blue);
            border: none;
            color: var(--primary-blue);
            padding: 0.75rem 1rem;
            transition: var(--transition);
        }

        .form-control {
            height: 50px;
            border: 2px solid #e2e8f0;
            border-left: none;
            padding-left: 15px;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: none;
        }

        .form-control:focus+.input-group-text {
            background: var(--primary-blue);
            color: white;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%233490dc' viewBox='0 0 16 16'%3E%3Cpath d='M8 12L2 6h12L8 12z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            padding-right: 40px;
        }

        .file-upload-container {
            border: 2px dashed #cbd5e0;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: var(--transition);
            background: #f8fafc;
        }

        .file-upload-container:hover {
            border-color: var(--primary-blue);
            background: var(--light-blue);
        }

        .file-upload-label {
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #4a5568;
        }

        .file-upload-icon {
            font-size: 2rem;
            color: var(--primary-blue);
            margin-bottom: 10px;
        }

        .file-upload-text {
            font-weight: 600;
        }

        .file-upload-hint {
            font-size: 0.85rem;
            color: #718096;
            margin-top: 5px;
        }

        .form-check-input {
            width: 50px;
            height: 25px;
            margin-right: 10px;
        }

        .form-check-input:checked {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            border: none;
            padding: 12px 25px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            color: white;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 144, 220, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(155, 61, 236, 0.1);
            transform: rotate(30deg);
            transition: all 0.3s;
        }

        .btn-submit:hover::after {
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
            animation-delay: 0.1s;
        }

        .animate-delay-2 {
            animation-delay: 0.2s;
        }

        .animate-delay-3 {
            animation-delay: 0.3s;
        }

        .animate-delay-4 {
            animation-delay: 0.4s;
        }

        /* Preview d'image */
        .image-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--light-blue);
            display: none;
            margin: 15px auto;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const specialiteField = document.getElementById('specialite-field');
            const specialiteSelect = document.getElementById('specialite');
            const propertyField = document.getElementById('property-field');
            const photoInput = document.getElementById('photo_profil');
            const imagePreview = document.getElementById('imagePreview');

            function toggleFields() {
                if (roleSelect.value === 'prestataire') {
                    specialiteField.style.display = 'block';
                    specialiteSelect.setAttribute('required', 'required');
                } else {
                    specialiteField.style.display = 'none';
                    specialiteSelect.removeAttribute('required');
                }

                if (roleSelect.value === 'locataire') {
                    propertyField.style.display = 'block';
                    document.getElementById('property_id').setAttribute('required', 'required');
                } else {
                    propertyField.style.display = 'none';
                    document.getElementById('property_id').removeAttribute('required');
                }
            }

            // Aperçu de l'image
            photoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });

            roleSelect.addEventListener('change', toggleFields);
            toggleFields(); // Initial state

            // Animation des éléments
            const animateElements = document.querySelectorAll('.animate__animated');
            animateElements.forEach((el, index) => {
                el.style.animationDelay = `${0.1 + index * 0.1}s`;
            });
        });
    </script>
@endsection
