<script>
    $('#forgotPasswordForm').submit(function(e) {
    e.preventDefault();

    $.ajax({
    url: 'index.php?url=sendResetLink',
    type: 'POST',
    data: $(this).serialize(),
    success: function(response) {
    $('#recovery_message').removeClass('d-none').text(response);
},
    error: function() {
    $('#recovery_message').removeClass('d-none text-success').addClass('text-danger').text('Error al enviar el correo.');
}
});
});
</script>
