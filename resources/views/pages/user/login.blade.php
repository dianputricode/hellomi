<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Kata Sandi</label>
            <div class="input-pwd">
                <input type="password" id="password" name="password" required>
                <i class="fa fa-eye" aria-hidden="true"></i>
            </div>
        </div>
        <div class="btn-login">
            <button type="submit" class="btn">Login</button>
        </div>
        @if(session('error'))
            <script>
                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: 'error',
                    title: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            </script>
        @endif
    </form>
    <div class="register">
        <span>Belum memiliki akun?</span>
        <a href="{{ route('register') }}" class="register-link">Daftar</a>
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
    });
</script>

</body>
</html>
