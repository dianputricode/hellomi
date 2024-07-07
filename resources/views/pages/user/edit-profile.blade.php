@extends('main-layout')

@section('title', 'Edit Profil')

@section('content')
    @auth
    <div class="edit-profile-container">
        <h2>Edit Profile</h2>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="email">Username</label>
                {{-- <input id="username" type="text" name="username" value="{{ Auth::user()->username }}" required> --}}
                <input id="username" type="text" name="username" value="{{ old('username', $user->username) }}" required>
                @error('username')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                {{-- <input id="phone" type="text" name="phone" value="{{ Auth::user()->phone }}" required> --}}
                <input id="phone" type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required>
                @error('phone_number')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="foto_profil">Profile Picture</label>
                <input id="foto_profil" type="file" name="foto_profil">
                @error('foto_profil')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="width: 100%">
                <button type="submit">Update Profile</button>
            </div>
        </form>
    </div>
    @else
        <script>
            window.location.replace("{{ route('login') }}");
        </script>
    @endauth

    <style>
        .edit-profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 120px 100px 100px 100px;
        }

        .edit-profile-container h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #4848A4;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-family: Poppins, sans-serif;
            font-weight: 500;
            margin-top: 20px;
        }

        .form-group button:hover {
            background-color: #333333;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // AJAX form submission for seamless experience
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = this;
            var formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    // Handle response
                    console.log(data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Profil berhasil diperbarui.'
                    }).then((result) => {
                        // Redirect or handle further actions if needed
                        window.location.href = "{{ url('/profile') }}";
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Handle error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat memperbarui profil.'
                    });
                });
        });
    </script>
@endsection
