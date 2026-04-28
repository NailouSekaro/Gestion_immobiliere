<!-- Button pour ouvrir le chat -->
<button id="chatToggle" class="btn btn-primary rounded-circle p-3 position-fixed" style="bottom: 20px; right: 20px;">
    <i class="fas fa-comments fa-lg"></i>
</button>

<!-- Fenêtre de Chat (cachée par défaut) -->
<div id="chatWindow" class="position-fixed bg-white shadow-lg rounded-top" style="width: 350px; height: 500px; bottom: -520px; right: 20px; transition: all 0.3s ease; z-index: 1000;">
    <div class="card h-100 border-0">
        <!-- Header du Chat -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="fas fa-comment-dots me-2"></i> Messagerie</h6>
            <button id="closeChat" class="btn btn-sm btn-light">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Corps du Chat -->
        <div class="card-body p-0 d-flex flex-column">
            <!-- Liste des conversations -->
            <div class="border-bottom p-3" style="flex: 1; overflow-y: auto;">
                <div class="list-group list-group-flush">

                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex align-items-center">
                            <img src="" class="rounded-circle me-3" width="40" height="40">
                            <div>
                                <h6 class="mb-0"></h6>
                                <small class="text-muted"></small>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

            <!-- Zone d'envoi de message -->
            <div class="p-3 border-top">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Écrire un message...">
                    <button class="btn btn-primary" type="button"> 
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Gestion de l'ouverture/fermeture du chat
    document.getElementById('chatToggle').addEventListener('click', function() {
        const chatWindow = document.getElementById('chatWindow');
        chatWindow.style.bottom = chatWindow.style.bottom === '0px' ? '-520px' : '0px';
    });

    document.getElementById('closeChat').addEventListener('click', function() {
        document.getElementById('chatWindow').style.bottom = '-520px';
    });
</script>
