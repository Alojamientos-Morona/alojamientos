<!-- Modal Crear Rol -->
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createRoleModalLabel">Crear Rol</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="createRoleForm">
          <div class="mb-3">
            <label for="role_name" class="form-label">Nombre del Rol</label>
            <input type="text" class="form-control" name="nombre" id="role_name" required>
          </div>
          <div class="mb-3">
            <label for="role_description" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" id="role_description" required></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Crear Rol</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Rol -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editRoleModalLabel">Editar Rol</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="editRoleForm">
          <input type="hidden" name="role_id" id="edit_role_id">
          <div class="mb-3">
            <label for="edit_role_name" class="form-label">Nombre del Rol</label>
            <input type="text" class="form-control" name="nombre" id="edit_role_name" required>
          </div>
          <div class="mb-3">
            <label for="edit_role_description" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" id="edit_role_description" required></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Eliminar Rol -->
<div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteRoleModalLabel">Eliminar Rol</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Está seguro que desea eliminar el rol <strong id="delete_role_name"></strong>?
      </div>
      <div class="modal-footer">
        <input type="hidden" id="delete_role_id">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteRoleBtn">Eliminar</button>
      </div>
    </div>
  </div>
</div>
