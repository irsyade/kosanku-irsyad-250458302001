<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun • KOSanKU</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;
  0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" 
  rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: 'Poppins';
      background: url("https://i.ibb.co/3Rm6Q9v/vintage-paper-texture.jpg") center/cover no-repeat;
      background-attachment: fixed;
      color: #3b2f2f;
    }

    /* Overlay mengikuti Login */
    .bg-overlay {
      background: rgba(246, 235, 213, 0.75);
      backdrop-filter: blur(2px);
    }

    /* Card sama seperti login */
    .card {
      background: #fffaf3;
      border-radius: 18px;
      padding: 2rem;
      width: 380px;
      max-width: 100%;
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
      border: 1px solid rgba(160, 123, 82, 0.15);
    }

    /* Input sama login */
    .input-vintage {
      border: 1px solid #d8c3a5;
      background: #fff9f2;
    }

    .input-vintage:focus {
      border-color: #a67c52;
      box-shadow: 0 0 0 2px rgba(166, 124, 82, 0.25);
    }

    /* Button sama login */
    .btn-accent {
      background: linear-gradient(135deg, #b8926a, #a17449);
      color: #fff;
      font-weight: 600;
      box-shadow: 0 5px 16px rgba(0, 0, 0, 0.18);
      transition: 0.2s;
    }

    .btn-accent:hover {
      background: linear-gradient(135deg, #a67c52, #8a6038);
      transform: translateY(-2px);
    }

    /* Mobile */
    @media (max-width: 480px) {
      .card {
        padding: 1.5rem;
        width: 100%;
      }
      h2.text-3xl {
        font-size: 1.8rem;
      }
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 bg-overlay">

  <div class="card">

    <div class="mb-6 text-center">
      <h2 class="text-3xl font-bold text-[#4b3226]">Daftar Akun Baru</h2>
      <p class="text-sm text-[#6a584f] mt-1">Buat akun kamu untuk melanjutkan</p>
    </div>

    <form action="{{ route('register.proses') }}" method="POST" class="space-y-5">
      @csrf

      <!-- NAMA -->
      <label class="block">
        <span class="text-sm text-[#5c4033]">Nama Lengkap</span>
        <input type="text" name="name" value="{{ old('name') }}"
          class="mt-2 w-full p-3 rounded-lg input-vintage outline-none" placeholder="Masukkan nama kamu"
           required>
        @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
      </label>

      <!-- PHONE -->
      <label class="block">
        <span class="text-sm text-[#5c4033]">Nomor Telepon</span>
        <input type="text" name="phone" value="{{ old('phone') }}"
          class="mt-2 w-full p-3 rounded-lg input-vintage outline-none" placeholder="08xxxxxxxxxx"
           required>
        @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
      </label>

      <!-- EMAIL -->
      <label class="block">
        <span class="text-sm text-[#5c4033]">Email</span>
        <input type="email" name="email" value="{{ old('email') }}"
          class="mt-2 w-full p-3 rounded-lg input-vintage outline-none" placeholder="contoh@email.com"
           required>
        @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
      </label>

      <!-- PASSWORD -->
      <div>
        <label class="block text-sm text-[#5c4033]">Kata Sandi</label>

        <div class="relative mt-2">
          <input id="password" type="password" name="password"
            class="w-full p-3 pr-12 rounded-lg input-vintage outline-none" 
            placeholder="Minimal 8 karakter" required>

          <button type="button" id="togglePassword"
            class="absolute right-3 top-1/2 -translate-y-1/2 bg-[#fffaf3] hover:bg-[#f6ebd5]
             rounded-full p-2 transition shadow-sm">
            <i id="iconEyeClosed" class="fa fa-eye-slash text-[#5c4033]"></i>
            <i id="iconEyeOpen" class="fa fa-eye text-[#5c4033] hidden"></i>
          </button>
        </div>

        @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- CONFIRM -->
      <label class="block">
        <span class="text-sm text-[#5c4033]">Konfirmasi Kata Sandi</span>
        <input type="password" name="password_confirmation"
          class="mt-2 w-full p-3 rounded-lg input-vintage outline-none" placeholder="Ulangi kata sandi"
           required>
        @error('password_confirmation') <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
         @enderror
      </label>

      <!-- SUBMIT -->
      <button type="submit" class="btn-accent w-full py-3 rounded-lg text-lg">Daftar Sekarang</button>

      <!-- LOGIN LINK -->
      <p class="text-center text-sm pt-2 text-[#6a584f]">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="underline hover:text-[#8a6038] font-semibold">
          Masuk di sini</a>
      </p>

    </form>
  </div>

  <script>
    const pass = document.getElementById('password');
    const toggle = document.getElementById('togglePassword');
    const iconOpen = document.getElementById('iconEyeOpen');
    const iconClose = document.getElementById('iconEyeClosed');

    toggle.addEventListener('click', () => {
      const hidden = pass.type === 'password';
      pass.type = hidden ? 'text' : 'password';
      iconOpen.classList.toggle('hidden');
      iconClose.classList.toggle('hidden');
    });
  </script>

</body>
</html>
