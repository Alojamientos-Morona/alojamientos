<!-- Modal Recuperar Contraseña -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="forgotPasswordForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Recuperar Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <label for="recovery_email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="recovery_email" name="email" required>
                <div id="recovery_message" class="mt-2 text-success d-none"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Enviar enlace</button>
            </div>
        </form>
    </div>
</div>
