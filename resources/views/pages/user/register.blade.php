<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class="register-container">
    <h2>Daftar</h2>
    <form id="registerForm" method="POST" action="{{ route('register.post') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Kata Sandi</label>
            <div class="input-pwd">
                <input type="password" id="password" name="password" required>
                <i class="fa fa-eye" aria-hidden="true"></i>
            </div>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
            <div class="input-pwd-confirm">
                <input type="password" id="password_confirmation" name="password_confirmation" required>
                <i class="fa fa-eye" aria-hidden="true"></i>
            </div>
        </div>
        <div class="btn-register">
            <button type="submit" class="btn">Daftar</button>
        </div>
    </form>
    <div class="login">
        <span>Sudah memiliki akun?</span>
        <a href="{{ route('login') }}" class="login-link">Login</a>
    </div>
</div>

{{-- SCRIPT FOR FUNCTIONALITY --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const eyeIcon = document.querySelector('.input-pwd i.fa-eye');
        const passwordInput = document.getElementById('password');

        eyeIcon.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });

        const eyeIconConfirm = document.querySelector('.input-pwd-confirm i.fa-eye');
        const passwordInputConfirm = document.getElementById('password_confirmation');

        eyeIconConfirm.addEventListener('click', function () {
            const type = passwordInputConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInputConfirm.setAttribute('type', type);
            eyeIconConfirm.classList.toggle('fa-eye');
            eyeIconConfirm.classList.toggle('fa-eye-slash');
        });

        // AJAX form submission
        $('#registerForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('register.post') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Pendaftaran berhasil. Silakan login.',
                        }).then(() => {
                            window.location.href = "{{ route('login') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message,
                        });
                    }
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    for (let error in errors) {
                        errorMessage += errors[error][0] + '<br>';
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        html: errorMessage,
                    });
                }
            });
        });
    });
</script>

</body>
</html>
