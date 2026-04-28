@extends('messages.layout')

@section('title', isset($replyTo) ? 'Répondre à un message' : 'Nouveau message')

@section('content')
    <div class="card shadow-sm animate__animated animate__fadeInUp">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0">
                <i class="fas fa-edit me-2 text-primary"></i>
                {{ isset($replyTo) ? 'Répondre à un message' : 'Nouveau message' }}
            </h5>
        </div>

        <div class="card-body">
            <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data" id="messageForm">
                @csrf

                @if (isset($replyTo))
                    <input type="hidden" name="reply_to" value="{{ $replyTo->id }}">
                @endif

                <div class="row">
                    <div class="col-md-6">
                        @if (isset($replyTo))
                            <input type="hidden" name="destinataire_id" id="destinataire_id" value="{{ $replyTo->id }}">
                            <div class="mb-3">
                                <label class="form-label">Destinataire</label>
                                <input type="text" class="form-control"
                                    value="{{ $replyTo->prenom }} {{ $replyTo->nom }}" disabled>
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="destinataire_id" class="form-label">Choisir un destinataire</label>
                                <select name="destinataire_id" id="destinataire_id"
                                    class="form-select @error('destinataire_id') is-invalid @enderror">
                                    <option value="">-- Sélectionner --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('destinataire_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->prenom }} {{ $user->nom }} {{ $user->role }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('destinataire_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="sujet" class="form-label fw-medium">
                                <i class="fas fa-tag me-2 text-primary"></i>Sujet (optionnel)
                            </label>
                            <input type="text" class="form-control @error('sujet') is-invalid @enderror" id="sujet"
                                name="sujet" value="{{ old('sujet', $sujet ?? '') }}"
                                placeholder="Objet de votre message">
                            @error('sujet')
                                <div class="invalid-feedback animate__animated animate__fadeIn">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="contenu" class="form-label fw-medium">
                        <i class="fas fa-comment me-2 text-primary"></i>Message
                    </label>
                    <textarea class="form-control @error('contenu') is-invalid @enderror" id="contenu" name="contenu" rows="8"
                        required placeholder="Écrivez votre message ici...">{{ old('contenu') }}</textarea>
                    @error('contenu')
                        <div class="invalid-feedback animate__animated animate__fadeIn">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="piece_jointe" class="form-label fw-medium">
                        <i class="fas fa-paperclip me-2 text-primary"></i>Pièce jointe (optionnel)
                    </label>
                    <div class="file-upload-area">
                        <input type="file" class="form-control @error('piece_jointe') is-invalid @enderror"
                            id="piece_jointe" name="piece_jointe" onchange="updateFileName(this)">
                        <div class="form-text">Types autorisés: JPG, PNG, GIF, PDF, DOC - Max: 10MB</div>
                        <div id="file-name" class="mt-2 small text-muted"></div>
                    </div>
                    @error('piece_jointe')
                        <div class="invalid-feedback animate__animated animate__fadeIn">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2">
                    <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary btn-hover">
                        <i class="fas fa-arrow-left me-1"></i> Annuler
                    </a>
                    <button type="submit" class="btn btn-primary btn-hover" id="submitBtn">
                        <i class="fas fa-paper-plane me-1"></i> <span id="btnText">Envoyer</span>
                        <span id="btnLoading" class="d-none">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Envoi...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .file-upload-area {
            position: relative;
        }

        .btn-hover {
            transition: all 0.3s ease;
            transform: translateY(0);
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }
    </style>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pré-remplir le message si on répond
            @if (isset($message))
                const textarea = document.getElementById('contenu');
                const originalContent =
                    // "\n{{ $message->contenu }}";

                // Focus et place le curseur au début
                textarea.value = originalContent;
                textarea.focus();
                textarea.setSelectionRange(0, 0);
            @endif


            // Animation des erreurs de validation
            @if ($errors->any())
                const firstError = document.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstError.classList.add('animate__animated', 'animate__headShake');
                    setTimeout(() => {
                        firstError.classList.remove('animate__animated', 'animate__headShake');
                    }, 1000);
                }
            @endif

            // Empêcher le double envoi du formulaire
            const form = document.getElementById('messageForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');

            form.addEventListener('submit', function(e) {
                // Validation basique avant soumission
                const destinataire = document.getElementById('destinataire_id');
                const contenu = document.getElementById('contenu');

                if (!destinataire.value || !contenu.value.trim()) {
                    e.preventDefault();
                    if (!destinataire.value) {
                        shakeElement(destinataire);
                    }
                    if (!contenu.value.trim()) {
                        shakeElement(contenu);
                    }
                    return;
                }

                // Afficher l'état de chargement
                btnText.classList.add('d-none');
                btnLoading.classList.remove('d-none');
                submitBtn.disabled = true;
            });
        });

        function updateFileName(input) {
            const fileNameDisplay = document.getElementById('file-name');
            if (input.files.length > 0) {
                fileNameDisplay.textContent = 'Fichier sélectionné : ' + input.files[0].name;
                fileNameDisplay.classList.add('text-success', 'fw-medium');
            } else {
                fileNameDisplay.textContent = '';
            }
        }

        function shakeElement(element) {
            element.classList.add('animate__animated', 'animate__headShake');
            element.focus();
            setTimeout(() => {
                element.classList.remove('animate__animated', 'animate__headShake');
            }, 1000);
        }
    </script>
@endsection
@endsection
