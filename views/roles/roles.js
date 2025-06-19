<script>
    $(function() {
    $('#createRoleForm').submit(function(e) {
        e.preventDefault();
        $.post('index.php?url=createRole', $(this).serialize(), function(res) {
            showToast('Rol creado correctamente');
            setTimeout(() => location.reload(), 1000);
        });
    });

    $('.edit-role-btn').click(function() {
    $('#edit_role_id').val($(this).data('role-id'));
    $('#edit_role_name').val($(this).data('role-nombre'));
    $('#edit_role_description').val($(this).data('role-descripcion'));
});

    $('#editRoleForm').submit(function(e) {
    e.preventDefault();
    $.post('index.php?url=updateRole', $(this).serialize(), function(res) {
    showToast('Rol actualizado');
    setTimeout(() => location.reload(), 1000);
});
});

    $('.delete-role-btn').click(function() {
    $('#delete_role_id').val($(this).data('role-id'));
    $('#delete_role_name').text($(this).data('role-nombre'));
});

    $('#confirmDeleteRoleBtn').click(function() {
    $.post('index.php?url=deleteRole', { role_id: $('#delete_role_id').val() }, function(res) {
    showToast('Rol eliminado');
    $('#deleteRoleModal').modal('hide');
    setTimeout(() => location.reload(), 1000);
});
});

    function showToast(msg) {
    $('#toastMsg .toast-body').text(msg);
    new bootstrap.Toast($('#toastMsg')).show();
}
});
</script>

<script>
    $(function() {
    $('.assign-permissions-btn').click(function() {
        const roleId = $(this).data('role-id');
        const roleName = $(this).data('role-nombre');
        $('#assign_role_id').val(roleId);
        $('#assign_role_name').text(roleName);

        $('.permiso-checkbox').prop('checked', false);

        $.getJSON('index.php?url=getPermisosPorRol', { role_id: roleId }, function(permisosActuales) {
            permisosActuales.forEach(id => {
                $('#permiso' + id).prop('checked', true);
            });
        });
    });

    $('#assignPermissionsForm').submit(function(e) {
    e.preventDefault();
    $.post('index.php?url=savePermisosPorRol', $(this).serialize(), function(res) {
    alert('Permisos actualizados');
    $('#assignPermissionsModal').modal('hide');
});
});
});
</script>