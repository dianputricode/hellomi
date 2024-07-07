<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kode Autentikasi</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.1.5/sweetalert2.min.css">
</head>
<body>
<div class="verification-container">
    <h2>Verifikasi Kode Autentikasi</h2>
    <form id="verificationForm" action="{{ route('register.verify') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="verification_code">Kode Autentikasi</label>
            <input type="text" id="verification_code" name="verification_code" required>
        </div>
        <div class="btn-register">
            <button type="submit" class="btn">Verifikasi</button>
        </div>
        <div class="resend-code">
            <button type="button" id="resendButton" class="btn btn-resend">Kirim Ulang Kode Autentikasi</button>
        </div>
    </form>
</div>

<!-- SweetAlert Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.1.5/sweetalert2.min.js"></script>
<script>
    let resendCount = 0;
    const MAX_RESEND = 3;
    const RESEND_INTERVAL = 30000; // 30 seconds in milliseconds

    function resendVerificationCode() {
        if (resendCount < MAX_RESEND) {
            // Simulate sending code (replace with actual logic)
            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Kode dikirim ulang!',
                    text: 'Silakan periksa email Anda.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Redirect to login page after successful verification
                    window.location.href = "{{ route('login') }}";
                });
            }, 1000);

            // Update resend count and disable button temporarily
            resendCount++;
            document.getElementById('resendButton').disabled = true;

            // Enable button again after interval
            setTimeout(() => {
                document.getElementById('resendButton').disabled = false;
            }, RESEND_INTERVAL);
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Batas maksimal tercapai',
                text: 'Anda telah mencoba mengirim ulang kode sebanyak 3 kali.',
                confirmButtonText: 'OK'
            });
        }
    }

    // Add event listener to resend button
    document.getElementById('resendButton').addEventListener('click', resendVerificationCode);
</script>
</body>
</html>
