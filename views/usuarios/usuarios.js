<script>
$(document).ready(function() {
    $('.edit-user-btn').on('click', function() {
        var userId = $(this).data('user-id');
        var userEmail = $(this).data('user-email');
        var userRole = $(this).data('user-role');

        $('#edit_user_id').val(userId);
        $('#edit_email').val(userEmail);
        $('#edit_role_id').val(userRole);
    });


    $('#editUserForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: 'index.php?url=updateUserAndRole',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                showToast('Usuario actualizado correctamente');
                setTimeout(() => location.reload(), 1000);
            },
            error: function() {
                showToast('Error al actualizar el usuario');
            }
        });
    });

    $('#createUserForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: 'index.php?url=createUser',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.includes('duplicate')) {
                    showToast('Error: Email ya registrado');
                } else {
                    showToast('Usuario creado correctamente');
                    setTimeout(() => location.reload(), 1000);
                }
            },
            error: function() {
                showToast('Error al crear el usuario');
            }
        });
    });

    var deleteUserId = null;
    $('.delete-user-btn').on('click', function() {
        deleteUserId = $(this).data('user-id');
        var userEmail = $(this).data('user-email');
        $('#deleteUserEmail').text(userEmail);
        $('#confirmDeleteModal').modal('show');
    });

    $('#confirmDeleteBtn').on('click', function() {
        $.ajax({
            url: 'index.php?url=deleteUser',
            method: 'POST',
            data: { user_id: deleteUserId },
            success: function(response) {
                showToast('Usuario eliminado correctamente');
                $('#confirmDeleteModal').modal('hide');
                setTimeout(() => location.reload(), 1000);
            },
            error: function() {
                showToast('Error al eliminar el usuario');
            }
        });
    });

    function showToast(message) {
        $('#toastMsg .toast-body').text(message);
        var toast = new bootstrap.Toast(document.getElementById('toastMsg'));
        toast.show();
    }

    // Filtro
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#usuariosTable tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Pagination simple
    var rowsPerPage = 5;
    var rows = $('#usuariosTable tbody tr');
    var rowsCount = rows.length;
    var pageCount = Math.ceil(rowsCount / rowsPerPage);
    var numbers = $('.pagination');

    for (var i = 0; i < pageCount; i++) {
        numbers.append('<li class="page-item"><a href="#" class="page-link">' + (i+1) + '</a></li>');
    }

    $('#usuariosTable tbody tr').hide();
    $('#usuariosTable tbody tr').slice(0, rowsPerPage).show();
    $('.pagination li:first').addClass('active');

    $('.pagination li').on('click', function(){
        var index = $(this).index();
        $('.pagination li').removeClass('active');
        $(this).addClass('active');
        var start = index * rowsPerPage;
        var end = start + rowsPerPage;
        $('#usuariosTable tbody tr').hide().slice(start, end).show();
    });





    $('.change-password-btn').on('click', function () {
    const userId = $(this).data('user-id');
    const userEmail = $(this).data('user-email');

    $('#changePasswordUserId').val(userId);
    $('#changePasswordUserEmail').text(userEmail);
    $('#new_password2').val('');
    $('#confirm_password').val('');
});

    $('#changePasswordForm').submit(function (e) {
    e.preventDefault();

    const password = $('#new_password2').val();
    const confirmPassword = $('#confirm_password').val();

    if (password !== confirmPassword) {
    alert(`Las contraseñas no coincidenss.\nPassword: ${password}\nConfirmación: ${confirmPassword}`);
    return;
}


    $.ajax({
    url: 'index.php?url=changeUserPassword',
    method: 'POST',
    data: $(this).serialize(),
    success: function (response) {
    showToast('Contraseña actualizada correctamente');
    $('#changePasswordModal').modal('hide');
},
    error: function () {
    showToast('Error al actualizar la contraseña');
}
});
});








});
</script>