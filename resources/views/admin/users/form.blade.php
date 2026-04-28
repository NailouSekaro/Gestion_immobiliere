<div class="form-body">
                    <div class="row">
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
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

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
                                    </select>
                                    @error('specialite')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

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

                    <div class="form-check form-switch mb-4 animate__animated animate__fadeIn animate-delay-4">
                        <input class="form-check-input" type="checkbox" id="est_actif" name="est_actif" value="1"
                            {{ old('est_actif', $user->est_actif ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="est_actif">
                            <i class="fas fa-user-check me-2 text-success"></i>Compte actif
                        </label>
                    </div>

                    <!-- <div class="form-group mt-4">
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-save me-2"></i> Enregistrer
                        </button><br><br>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-arrow-left me-2"></i> Retour
                        </a>
                    </div> -->
</div>
