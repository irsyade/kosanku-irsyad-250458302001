<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login • KOSanKU</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: 'Poppins';
      background: url("https://i.ibb.co/3Rm6Q9v/vintage-paper-texture.jpg") center/cover no-repeat;
      background-attachment: fixed;
      color: #3b2f2f;
    }

    .bg-overlay {
      background: rgba(246, 235, 213, 0.75);
      backdrop-filter: blur(2px);
    }

    /* CARD LOGIN */
    .card {
      background: #fffaf3;
      border-radius: 18px;
      padding: 2rem;
      width: 380px;
      max-width: 100%;
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
      border: 1px solid rgba(160, 123, 82, 0.15);
    }

    /* Mobile adjustments */
    @media (max-width: 480px) {
      .card {
        padding: 1.5rem;
        width: 100%;
      }

      h2.text-3xl {
        font-size: 1.8rem;
      }

      .highlight-card {
        padding: 1.5rem !important;
      }
    }

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

    /* Left highlight */
    .highlight-card {
      background: linear-gradient(135deg, #4b3226, #5c4033);
      border-radius: 18px;
      color: #f6ebd5;
      padding: 2rem;
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.2);
    }

    /* Hilangkan padding default grid agar tidak ada celah mepet */
    .grid-container {
      padding-top: 1rem;
      padding-bottom: 1rem;
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 bg-overlay">

  <div class="max-w-5xl w-full grid grid-cols-1 md:grid-cols-2 gap-10 items-center grid-container">

    <!-- LEFT (hidden di HP untuk hemat ruang) -->
    <div class="hidden md:flex flex-col justify-center pl-6">

      <h1 class="text-5xl font-bold text-[#4b3226] drop-shadow-sm">KOSanKU</h1>
      <p class="mt-2 text-sm text-[#6a584f]">Penyewaan kamar nyaman, aman, dan terasa seperti rumah.</p>

      <div class="highlight-card mt-8">
        <h2 class="text-xl font-semibold mb-3">Keunggulan</h2>

        <ul class="text-sm space-y-2 opacity-90">
          <li><i class="fa fa-check-circle mr-2"></i> Desain kamar estetik & nyaman</li>
          <li><i class="fa fa-check-circle mr-2"></i> Lingkungan bersih dan tenang</li>
          <li><i class="fa fa-check-circle mr-2"></i> Proses reservasi cepat</li>
        </ul>

        <a href="{{ url('/') }}"
          class="mt-5 inline-flex items-center gap-2 px-4 py-3 w-full rounded-lg bg-[#f6ebd5] 
          text-[#4b3226] font-semibold hover:bg-[#e9dabf] transition">
          <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
      </div>
    </div>

    <!-- LOGIN FORM -->
    <div class="card mx-auto">

      <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-[#4b3226]">Masuk</h2>
        <p class="text-sm text-[#6a584f] mt-1">Silakan login untuk melanjutkan</p>
      </div>

      <form action="/login" method="POST" class="space-y-5">
        @csrf

        <!-- EMAIL -->
        <label class="block">
          <span class="text-sm text-[#5c4033]">Email</span>
          <input name="email" type="email" required autocomplete="email"
            class="mt-2 w-full px-4 py-3 rounded-lg border border-[#d8c3a5] bg-[#fff9f2]
             focus:ring-2 focus:ring-[#a67c52] outline-none"
            placeholder="Masukkan email anda" />

          @error('email')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </label>

        <!-- PASSWORD -->
        <div>
          <label class="block text-sm text-[#5c4033]">Password</label>

          <div class="relative mt-2">
            <input id="password" name="password" type="password"
              class="w-full px-4 py-3 pr-12 rounded-lg border border-[#d8c3a5] bg-[#fff9f2]
               focus:ring-[#a67c52] focus:ring-2 outline-none"
              placeholder="Masukkan password anda" />

            <button type="button" id="togglePassword"
              class="absolute right-3 top-1/2 -translate-y-1/2 bg-[#fffaf3] hover:bg-[#f6ebd5] 
              rounded-full p-2 transition shadow-sm">

              <i id="iconEyeClosed" class="fa fa-eye-slash text-[#5c4033]"></i>
              <i id="iconEyeOpen" class="fa fa-eye text-[#5c4033] hidden"></i>
            </button>
          </div>
        </div>

        <!-- SUBMIT BUTTON -->
        <button type="submit" class="w-full btn-accent px-4 py-3 rounded-lg text-lg">
          Masuk
        </button>

        <!-- Divider -->
        <div class="flex items-center gap-3 my-4">
          <div class="flex-1 h-px bg-[#eadfc7]"></div>
          <p class="text-xs text-[#7b5e57]">atau</p>
          <div class="flex-1 h-px bg-[#eadfc7]"></div>
        </div>

        <!-- REGISTER -->
        <a href="/register"
          class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-lg border
           border-[#d8c3a5] bg-[#fff9f2] hover:bg-[#f2e6d6] text-[#4b3226] font-semibold
            transition">
          Daftar Akun
        </a>

      </form>
    </div>

  </div>

  <script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const iconEyeClosed = document.getElementById('iconEyeClosed');
    const iconEyeOpen = document.getElementById('iconEyeOpen');

    togglePassword.addEventListener('click', () => {
      const isHidden = passwordInput.type === 'password';
      passwordInput.type = isHidden ? 'text' : 'password';
      iconEyeClosed.classList.toggle('hidden');
      iconEyeOpen.classList.toggle('hidden');
    });
  </script>

</body>
</html>
