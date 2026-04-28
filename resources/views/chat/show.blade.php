@extends('layouts.app')

@section('title', 'Chat avec ' . $otherUser->prenom)

@section('content')
    <div class="chat-container">
        <div class="row g-0" style="height: calc(100vh - 100px);">
            <!-- Sidebar gauche -->
            <div class="col-md-4 col-lg-3 border-end d-none d-md-block">
                @include('chat.partials.sidebar', ['conversations' => $conversations])
            </div>

            <!-- Zone de chat principale -->
            <div class="col-md-8 col-lg-9 d-flex flex-column">
                <!-- Header du chat -->
                <div class="chat-header p-3 border-bottom bg-white d-flex align-items-center">
                    <!-- Bouton retour mobile -->
                    <a href="{{ route('chat.index') }}" class="btn btn-light btn-sm d-md-none me-2">
                        <i class="fas fa-arrow-left"></i>
                    </a>

                    <img src="{{ $otherUser->photo_profil ? asset('storage/' . $otherUser->photo_profil) : asset('images/default-avatar.jpg') }}"
                        class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">

                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-semibold">{{ $otherUser->prenom }} {{ $otherUser->nom }}</h6>
                        <small class="text-muted">
                            @if ($otherUser->isOnline())
                                <i class="fas fa-circle text-success" style="font-size: 8px;"></i> En ligne
                            @else
                                Hors ligne
                            @endif
                        </small>
                    </div>

                    <!-- Actions -->
                    <div class="dropdown">
                        <button class="btn btn-light" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Voir le profil</a>
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-search me-2"></i>Rechercher</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="#"><i
                                        class="fas fa-trash me-2"></i>Supprimer la conversation</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Zone des messages -->
                <div class="chat-messages flex-grow-1 overflow-auto p-3" id="chatMessages"
                    style="background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);">
                    @forelse($messages as $message)
                        @include('chat.partials.message', ['message' => $message])
                    @empty
                        <div class="text-center text-muted my-5">
                            <i class="fas fa-comments fa-3x mb-3 opacity-50"></i>
                            <p>Aucun message pour l'instant</p>
                            <p class="small">Envoyez le premier message pour démarrer la conversation</p>
                        </div>
                    @endforelse
                </div>

                <!-- Zone de saisie -->
                <div class="chat-input-area p-3 border-top bg-white">
                    <form id="chatForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="destinataire_id" value="{{ $otherUser->id }}">
                        <input type="hidden" name="audio_duration" id="audioDuration">

                        <div class="d-flex align-items-end gap-2">
                            <!-- Bouton pièce jointe -->
                            <div class="position-relative">
                                <input type="file" class="d-none" id="fileInput" name="piece_jointe"
                                    accept="image/*,.pdf,.doc,.docx">
                                <button type="button" class="btn btn-light rounded-circle"
                                    onclick="document.getElementById('fileInput').click()" title="Joindre un fichier">
                                    <i class="fas fa-paperclip"></i>
                                </button>
                            </div>

                            <!-- Zone de texte (cachée pendant l'enregistrement) -->
                            <div class="flex-grow-1" id="textInputContainer">
                                <textarea class="form-control border-0 bg-light" id="messageInput" name="contenu" rows="1"
                                    placeholder="Écrivez votre message..." style="resize: none; max-height: 120px;"></textarea>
                                <div id="filePreview" class="mt-2 d-none">
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-file me-1"></i>
                                        <span id="fileName"></span>
                                        <button type="button" class="btn-close btn-close-sm ms-2"
                                            onclick="removeFile()"></button>
                                    </span>
                                </div>
                            </div>

                            <!-- Zone d'enregistrement audio (cachée par défaut) -->
                            <div class="flex-grow-1 d-none" id="audioRecordingContainer">
                                <div class="d-flex align-items-center bg-light rounded p-2">
                                    <div class="recording-indicator me-2">
                                        <div class="recording-dot"></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="audio-waveform-recording d-flex align-items-center gap-1">
                                            <div class="recording-bar"></div>
                                            <div class="recording-bar"></div>
                                            <div class="recording-bar"></div>
                                            <div class="recording-bar"></div>
                                            <div class="recording-bar"></div>
                                        </div>
                                    </div>
                                    <span class="recording-time text-muted ms-2">0:00</span>
                                </div>
                            </div>

                            <!-- Bouton Emoji (optionnel) -->
                            <button type="button" class="btn btn-light rounded-circle" title="Emoji" id="emojiBtn">
                                <i class="fas fa-smile"></i>
                            </button>

                            <!-- Bouton Microphone (visible par défaut) -->
                            <button type="button" class="btn btn-primary rounded-circle" id="micBtn"
                                title="Enregistrer un message vocal">
                                <i class="fas fa-microphone"></i>
                            </button>

                            <!-- Bouton Envoyer texte (caché par défaut, visible quand il y a du texte) -->
                            <button type="submit" class="btn btn-primary rounded-circle d-none" id="sendBtn"
                                title="Envoyer">
                                <i class="fas fa-paper-plane"></i>
                            </button>

                            <!-- Bouton Annuler (pendant l'enregistrement) -->
                            <button type="button" class="btn btn-danger rounded-circle d-none" id="cancelRecordBtn"
                                title="Annuler l'enregistrement">
                                <i class="fas fa-times"></i>
                            </button>

                            <!-- Bouton Envoyer audio (après enregistrement) -->
                            <button type="button" class="btn btn-success rounded-circle d-none" id="sendAudioBtn"
                                title="Envoyer le message vocal">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .chat-messages {
            scroll-behavior: smooth;
        }

        .chat-input-area textarea:focus {
            outline: none;
            box-shadow: none;
        }

        .chat-input-area textarea {
            min-height: 40px;
            line-height: 1.5;
        }

        @keyframes slideInMessage {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-bubble {
            animation: slideInMessage 0.3s ease-out;
        }

        /* Styles pour l'enregistrement audio */
        .recording-indicator {
            width: 12px;
            height: 12px;
        }

        .recording-dot {
            width: 12px;
            height: 12px;
            background: #dc3545;
            border-radius: 50%;
            animation: pulse-recording 1.5s infinite;
        }

        @keyframes pulse-recording {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.2);
            }
        }

        .recording-bar {
            width: 3px;
            height: 20px;
            background: #0d6efd;
            border-radius: 2px;
            animation: wave 1s ease-in-out infinite;
        }

        .recording-bar:nth-child(1) {
            animation-delay: 0s;
        }

        .recording-bar:nth-child(2) {
            animation-delay: 0.1s;
        }

        .recording-bar:nth-child(3) {
            animation-delay: 0.2s;
        }

        .recording-bar:nth-child(4) {
            animation-delay: 0.3s;
        }

        .recording-bar:nth-child(5) {
            animation-delay: 0.4s;
        }

        @keyframes wave {

            0%,
            100% {
                height: 20px;
            }

            50% {
                height: 40px;
            }
        }

        .audio-message {
            min-width: 250px;
        }

        .audio-waveform {
            cursor: pointer;
        }

        .chat-input-area button {
            transition: all 0.2s ease;
        }

        .chat-input-area button:hover {
            transform: scale(1.05);
        }
    </style>

    <script>
        const conversationId = "{{ $conversationId }}";
        const currentUserId = {{ auth()->id() }};
        let lastMessageId = {{ $messages->last()->id ?? 0 }};

        // Variables pour l'enregistrement audio
        let mediaRecorder;
        let audioChunks = [];
        let recordingStartTime;
        let recordingInterval;
        let audioBlob = null;

        // Éléments du DOM
        const messageInput = document.getElementById('messageInput');
        const micBtn = document.getElementById('micBtn');
        const sendBtn = document.getElementById('sendBtn');
        const cancelRecordBtn = document.getElementById('cancelRecordBtn');
        const sendAudioBtn = document.getElementById('sendAudioBtn');
        const textInputContainer = document.getElementById('textInputContainer');
        const audioRecordingContainer = document.getElementById('audioRecordingContainer');
        const recordingTime = document.querySelector('.recording-time');

        // ========================================
        // GESTION DU TEXTAREA ET FICHIERS
        // ========================================

        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
            updateButtons();
        });

        messageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (this.value.trim() || document.getElementById('fileInput').files.length > 0) {
                    document.getElementById('chatForm').dispatchEvent(new Event('submit'));
                }
            }
        });

        document.getElementById('fileInput').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                if (file.size > 10 * 1024 * 1024) {
                    alert('Le fichier est trop volumineux. Maximum 10 MB.');
                    this.value = '';
                    return;
                }
                document.getElementById('fileName').textContent = file.name;
                document.getElementById('filePreview').classList.remove('d-none');
                updateButtons();
            }
        });

        function removeFile() {
            document.getElementById('fileInput').value = '';
            document.getElementById('filePreview').classList.add('d-none');
            updateButtons();
        }

        function updateButtons() {
            const hasText = messageInput.value.trim();
            const hasFile = document.getElementById('fileInput').files.length > 0;

            if (hasText || hasFile) {
                micBtn.classList.add('d-none');
                sendBtn.classList.remove('d-none');
            } else {
                micBtn.classList.remove('d-none');
                sendBtn.classList.add('d-none');
            }
        }

        // ========================================
        // ENVOI MESSAGE TEXTE/FICHIER
        // ========================================

        document.getElementById('chatForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const sendButton = sendBtn;
            const originalBtnContent = sendButton.innerHTML;

            sendButton.disabled = true;
            sendButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

            try {
                const response = await fetch("{{ route('chat.send') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    const chatMessages = document.getElementById('chatMessages');
                    chatMessages.insertAdjacentHTML('beforeend', data.html);
                    chatMessages.scrollTop = chatMessages.scrollHeight;

                    messageInput.value = '';
                    messageInput.style.height = 'auto';
                    removeFile();

                    lastMessageId = data.message.id;

                    // Initialiser les lecteurs audio pour les nouveaux messages
                    initAudioPlayers();
                } else {
                    alert(data.message || 'Erreur lors de l\'envoi du message');
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'envoi du message. Vérifiez votre connexion.');
            } finally {
                sendButton.disabled = false;
                sendButton.innerHTML = originalBtnContent;
            }
        });

        // ========================================
        // ENREGISTREMENT AUDIO
        // ========================================

        micBtn.addEventListener('click', async function() {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                alert('Votre navigateur ne supporte pas l\'enregistrement audio.');
                return;
            }

            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    audio: true
                });
                startRecording(stream);
            } catch (error) {
                console.error('Erreur accès microphone:', error);
                alert('Impossible d\'accéder au microphone. Vérifiez les permissions.');
            }
        });

        function startRecording(stream) {
            audioChunks = [];
            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = (event) => {
                audioChunks.push(event.data);
            };

            mediaRecorder.onstop = () => {
                audioBlob = new Blob(audioChunks, {
                    type: 'audio/webm'
                });
                stream.getTracks().forEach(track => track.stop());
            };

            mediaRecorder.start();
            recordingStartTime = Date.now();

            // UI
            textInputContainer.classList.add('d-none');
            audioRecordingContainer.classList.remove('d-none');
            micBtn.classList.add('d-none');
            sendBtn.classList.add('d-none');
            cancelRecordBtn.classList.remove('d-none');
            sendAudioBtn.classList.remove('d-none');

            recordingInterval = setInterval(updateRecordingTime, 100);
        }

        function updateRecordingTime() {
            const elapsed = Math.floor((Date.now() - recordingStartTime) / 1000);
            const minutes = Math.floor(elapsed / 60);
            const seconds = elapsed % 60;
            recordingTime.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

            if (elapsed >= 600) { // 10 minutes max
                stopRecording();
            }
        }

        sendAudioBtn.addEventListener('click', function() {
            stopRecording();
            sendAudioMessage();
        });

        cancelRecordBtn.addEventListener('click', function() {
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
                mediaRecorder.stream.getTracks().forEach(track => track.stop());
            }
            clearInterval(recordingInterval);
            resetAudioUI();
        });

        function stopRecording() {
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
            }
            clearInterval(recordingInterval);
        }

        function resetAudioUI() {
            textInputContainer.classList.remove('d-none');
            audioRecordingContainer.classList.add('d-none');
            cancelRecordBtn.classList.add('d-none');
            sendAudioBtn.classList.add('d-none');
            updateButtons();
            recordingTime.textContent = '0:00';
        }

        async function sendAudioMessage() {
            if (!audioBlob) return;

            const formData = new FormData();
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            formData.append('destinataire_id', '{{ $otherUser->id }}');
            formData.append('contenu', '🎤 Message vocal');

            const audioFile = new File([audioBlob], `audio_${Date.now()}.webm`, {
                type: 'audio/webm'
            });
            formData.append('audio', audioFile);

            const duration = Math.floor((Date.now() - recordingStartTime) / 1000);
            formData.append('audio_duration', duration);

            sendAudioBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
            sendAudioBtn.disabled = true;

            try {
                const response = await fetch("{{ route('chat.send') }}", {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    const chatMessages = document.getElementById('chatMessages');
                    chatMessages.insertAdjacentHTML('beforeend', data.html);
                    chatMessages.scrollTop = chatMessages.scrollHeight;

                    lastMessageId = data.message.id;
                    initAudioPlayers();
                } else {
                    alert(data.message || 'Erreur lors de l\'envoi');
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'envoi du message vocal');
            } finally {
                sendAudioBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
                sendAudioBtn.disabled = false;
                resetAudioUI();
                audioBlob = null;
            }
        }

        // ========================================
        // LECTEUR AUDIO
        // ========================================

        function initAudioPlayers() {
            document.querySelectorAll('.play-audio-btn').forEach(btn => {
                if (btn.dataset.initialized) return;
                btn.dataset.initialized = 'true';

                btn.addEventListener('click', function() {
                    const audioSrc = this.dataset.audioSrc;
                    const messageDiv = this.closest('.audio-message');
                    const progressBar = messageDiv.querySelector('.audio-progress');
                    const currentTimeSpan = messageDiv.querySelector('.current-time');

                    let audio = messageDiv.querySelector('audio');
                    if (!audio) {
                        audio = new Audio(audioSrc);
                        messageDiv.appendChild(audio);

                        audio.addEventListener('timeupdate', function() {
                            const progress = (audio.currentTime / audio.duration) * 100;
                            progressBar.style.width = progress + '%';
                            currentTimeSpan.textContent = formatTime(audio.currentTime);
                        });

                        audio.addEventListener('ended', function() {
                            btn.classList.remove('playing');
                            btn.querySelector('i').className = 'fas fa-play';
                            progressBar.style.width = '0%';
                        });
                    }

                    if (audio.paused) {
                        document.querySelectorAll('.audio-message audio').forEach(a => {
                            if (a !== audio) {
                                a.pause();
                                a.currentTime = 0;
                            }
                        });
                        document.querySelectorAll('.play-audio-btn').forEach(b => {
                            if (b !== btn) {
                                b.classList.remove('playing');
                                b.querySelector('i').className = 'fas fa-play';
                            }
                        });

                        audio.play();
                        this.classList.add('playing');
                        this.querySelector('i').className = 'fas fa-pause';
                    } else {
                        audio.pause();
                        this.classList.remove('playing');
                        this.querySelector('i').className = 'fas fa-play';
                    }
                });
            });
        }

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }

        // ========================================
        // POLLING NOUVEAUX MESSAGES
        // ========================================

        function checkNewMessages() {
            fetch(`/chat/${conversationId}/messages/${lastMessageId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.messages.length > 0) {
                        const chatMessages = document.getElementById('chatMessages');
                        const isAtBottom = chatMessages.scrollHeight - chatMessages.clientHeight <= chatMessages
                            .scrollTop + 100;

                        chatMessages.insertAdjacentHTML('beforeend', data.html);

                        if (isAtBottom) {
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                        }

                        lastMessageId = data.messages[data.messages.length - 1].id;
                        initAudioPlayers();
                    }
                })
                .catch(error => console.error('Erreur polling:', error));
        }

        setInterval(checkNewMessages, 3000);

        // ========================================
        // INITIALISATION
        // ========================================

        window.addEventListener('load', function() {
            const chatMessages = document.getElementById('chatMessages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
            initAudioPlayers();
        });
    </script>
@endsection
