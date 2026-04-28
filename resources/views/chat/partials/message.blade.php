@php
    $isOwn = $message->expediteur_id === auth()->id();
@endphp

<div class="mb-3 d-flex {{ $isOwn ? 'justify-content-end' : 'justify-content-start' }}">
    <div class="message-bubble {{ $isOwn ? 'own-message' : 'other-message' }}" style="max-width: 70%;">
        @if(!$isOwn)
            <div class="d-flex align-items-center mb-1">
                <img src="{{ $message->expediteur->photo_profil ? asset('storage/' . $message->expediteur->photo_profil) : asset('images/default-avatar.jpg') }}"
                     class="rounded-circle me-2"
                     width="24"
                     height="24"
                     style="object-fit: cover;">
                <small class="text-muted fw-semibold">{{ $message->expediteur->prenom }}</small>
            </div>
        @endif

        <div class="message-content p-3 rounded-3 {{ $isOwn ? 'bg-primary text-white' : 'bg-light' }}">
            {{-- Message Audio --}}
            @if($message->type === 'audio' && $message->piece_jointe)
                <div class="audio-message mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-sm {{ $isOwn ? 'btn-light' : 'btn-primary' }} rounded-circle play-audio-btn"
                                data-audio-src="{{ asset('storage/' . $message->piece_jointe) }}"
                                style="width: 40px; height: 40px; padding: 0;">
                            <i class="fas fa-play"></i>
                        </button>

                        <div class="flex-grow-1">
                            <div class="audio-waveform position-relative" style="height: 30px;">
                                {{-- Waveform visuelle simple --}}
                                <div class="d-flex align-items-center h-100 gap-1">
                                    @for($i = 0; $i < 20; $i++)
                                        <div class="audio-bar {{ $isOwn ? 'bg-light' : 'bg-primary' }}"
                                             style="width: 3px; height: {{ rand(30, 100) }}%; border-radius: 2px; opacity: 0.6;"></div>
                                    @endfor
                                </div>
                                <div class="audio-progress position-absolute top-0 start-0 h-100" style="width: 0%; overflow: hidden;">
                                    <div class="d-flex align-items-center h-100 gap-1">
                                        @for($i = 0; $i < 20; $i++)
                                            <div class="audio-bar {{ $isOwn ? 'bg-white' : 'bg-success' }}"
                                                 style="width: 3px; height: {{ rand(30, 100) }}%; border-radius: 2px;"></div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <small class="audio-time {{ $isOwn ? 'text-white' : 'text-muted' }}">
                                    <span class="current-time">0:00</span> /
                                    <span class="total-time">{{ gmdate('i:s', $message->audio_duration ?? 0) }}</span>
                                </small>
                                <small class="{{ $isOwn ? 'text-white' : 'text-muted' }}">
                                    <i class="fas fa-microphone me-1"></i>Audio
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Message Image --}}
            @if($message->type === 'image' && $message->piece_jointe)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $message->piece_jointe) }}"
                         class="img-fluid rounded mb-2"
                         style="max-width: 300px; cursor: pointer;"
                         onclick="window.open(this.src)">
                </div>
            @endif

            {{-- Message Fichier --}}
            @if($message->type === 'file' && $message->piece_jointe)
                <div class="mb-2">
                    <a href="{{ asset('storage/' . $message->piece_jointe) }}"
                       class="d-flex align-items-center text-decoration-none {{ $isOwn ? 'text-white' : 'text-dark' }}"
                       download>
                        <i class="fas fa-file me-2"></i>
                        <span>{{ basename($message->piece_jointe) }}</span>
                    </a>
                </div>
            @endif

            {{-- Contenu texte --}}
            @if($message->contenu && $message->type !== 'audio')
                <div style="white-space: pre-wrap; word-break: break-word;">{{ $message->contenu }}</div>
            @endif
        </div>

        <div class="mt-1 px-2 d-flex align-items-center {{ $isOwn ? 'justify-content-end' : 'justify-content-start' }}">
            <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
            @if($isOwn)
                <i class="fas fa-check{{ $message->lu ? '-double text-primary' : ' text-muted' }} ms-1"
                   style="font-size: 10px;"></i>
            @endif
        </div>
    </div>
</div>

<style>
.own-message .message-content {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    box-shadow: 0 2px 8px rgba(13, 110, 253, 0.2);
}

.other-message .message-content {
    background-color: #f8f9fa;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.message-bubble {
    transition: transform 0.2s;
}

.message-bubble:hover {
    transform: translateY(-2px);
}

.audio-waveform {
    position: relative;
}

.audio-progress {
    transition: width 0.1s linear;
}

.play-audio-btn {
    transition: all 0.2s;
}

.play-audio-btn:hover {
    transform: scale(1.1);
}

.play-audio-btn.playing i::before {
    content: "\f04c"; /* Icône pause */
}
</style>
