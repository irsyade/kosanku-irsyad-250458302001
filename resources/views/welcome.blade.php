@extends('layouts.nav')

@section('content')
<div>
<style>
    .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.8s ease-out;
    }

    .reveal.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<!-- HERO NEW MODERN STYLE -->
<section class="pt-28 pb-20 px-4 reveal">
    <div class="w-full grid md:grid-cols-2 gap-10 items-center">

        <!-- TEXT LEFT -->
        <div class="space-y-5">
            <h1 class="text-5xl font-bold text-[#3d2b1f] leading-tight">
                Atur kamar kos lebih mudah
                <span class="text-[#b68c65]">dengan KOSanKU</span>
            </h1>

            <p class="text-lg text-gray-700">
                Membantu mahasiswa IDN menemukan kos terbaik dengan cepat,
                mudah, dan nyaman. Mulai jelajahi sekarang!
            </p>

            <a href="#about"
                class="inline-block px-8 py-3 bg-[#3d2b1f] text-white rounded-xl text-lg font-semibold shadow-md
                hover:bg-[#543a2e] transition">
                Jelajahi Sekarang
            </a>
        </div>

        <!-- SLIDER RIGHT -->
        <div class="relative w-full h-[420px] rounded-2xl overflow-hidden shadow-2xl">
            <div id="slider" class="flex w-full h-full transition-transform duration-700 ease-in-out">
                @foreach ([
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b',
                    'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2',
                    'https://images.unsplash.com/photo-1505691938895-1758d7feb511'
                ] as $img)
                <img src="{{ $img }}" class="min-w-full h-full object-cover" />
                @endforeach
            </div>

            <!-- Dots -->
            <div id="dots" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-3"></div>
        </div>

    </div>
</section>


<!-- ABOUT -->
<section id="about" class="py-24 px-4 relative reveal">

    <!-- Decorative Icons -->
    <img src="https://cdn-icons-png.flaticon.com/512/869/869869.png"
         class="w-20 opacity-30 absolute top-10 left-10 rotate-12">
    <img src="https://cdn-icons-png.flaticon.com/512/1046/1046857.png"
         class="w-16 opacity-30 absolute bottom-10 right-10">

    <div class="w-full grid md:grid-cols-2 gap-10 items-center">

        <!-- IMAGE -->
        <div>
            <img src="https://casaindonesia.com/lkgallery/teaser/inspirasi-desain-rumah-33-meter-persegi_49_20181212155200.jpg"
                 class="rounded-xl shadow-xl w-full object-cover">
        </div>

        <!-- TEXT -->
        <div class="space-y-5">
            <h3 class="text-4xl font-bold">Tentang KOSanKU</h3>

            <p class="text-lg text-[#4a3c33] leading-relaxed">
                KOSanKU adalah platform pencarian kos terpercaya bagi mahasiswa Politeknik IDN.
                Kami menyediakan informasi lengkap mulai dari harga, fasilitas, foto kamar,
                jarak ke kampus, hingga kontak pemilik. Semuanya dirancang agar proses mencari
                kos menjadi lebih cepat, nyaman, dan akurat.
            </p>

            <p class="text-lg text-[#4a3c33] leading-relaxed">
                Dengan tampilan sederhana dan fitur yang lengkap,
                KOSanKU membantu kamu menemukan hunian terbaik yang mendukung aktivitas kuliah
                maupun kehidupan sehari-hari.
            </p>

        </div>

    </div>
</section>


<!-- GALLERY -->
<section id="gallery" class="py-24 relative reveal">

    <!-- Decorative icon -->
    <img src="https://cdn-icons-png.flaticon.com/512/2942/2942924.png"
         class="w-16 opacity-40 absolute top-6 right-10">

    <h3 class="text-4xl font-bold text-center mb-14">Galeri Kamar</h3>

    <div class="max-w-5xl mx-auto relative overflow-hidden rounded-2xl shadow-2xl">

        <!-- Slider -->
        <div id="gallerySlider"
             class="flex w-full transition-transform duration-700">

            @foreach ([
                'https://images.unsplash.com/photo-1600585154340-be6161a56a0c',
                'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b',
                'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2',
                'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde'
            ] as $img)
            <img src="{{ $img }}" class="min-w-full h-[300px] object-cover" />
            @endforeach

        </div>

        <!-- Dots -->
        <div id="galleryDots"
             class="absolute bottom-5 left-1/2 -translate-x-1/2 flex space-x-3">
        </div>

    </div>

</section>


<!-- REVIEW SECTION (SINGLE CARD) -->
<section id="testimoni" class="py-20 bg-[#f6ebd5] reveal">

    <h3 class="text-4xl font-bold text-center mb-10">Review Penghuni</h3>

    <div class="max-w-5xl mx-auto bg-white p-10 rounded-2xl shadow-xl border border-gray-200">

        <!-- LIST REVIEW -->

        <div id="reviewList" class="grid grid-cols-1 md:grid-cols-2 gap-5">

            @forelse ($reviews as $review)
            <div class="p-4 border-b rounded-md" style="background: linear-gradient(135deg, #d4b48c);">
                <div class="font-bold text-lg text-white">{{ $review->user->name }}</div>
                <br>
                <div class="font-bold text-white text-center">{{ $review->kos_name }}</div>
                <p class="text-white mt-1 text-center">" {{ $review->comment }} "</p>
                <br>
                <div class="text-gray-500 text-xs mt-2 text-end">{{ $review->created_at->diffForHumans() }}</div>
            </div>
            @empty
            <p class="text-center text-gray-600 italic">Belum ada review.</p>
            @endforelse

        </div>

        <!-- BUTTON ADD REVIEW -->
        <div class="text-center mt-8">
            <button onclick="openReviewModal()"
                class="px-8 py-3 bg-[#3d2b1f] text-white rounded-xl font-semibold hover:bg-[#52392d] transition">
                Tambah Review
            </button>
        </div>

    </div>
</section>

<!-- REVIEW MODAL -->
<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content shadow-lg border-0 rounded-3">

            <form action="{{ route('review.store') }}" method="POST">
                @csrf

                <div class="modal-header bg-[#d4b48c] text-white">
                    <h5 class="modal-title">Tambah Review</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label class="fw-bold mt-2">Nama Kos</label>
                    <input type="text" class="form-control mb-3" name="kos_name" required>

                    <label class="fw-bold">Komentar Anda</label>
                    <textarea class="form-control" name="comment" rows="4" required></textarea>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Kirim</button>
                </div>
            </form>

        </div>
    </div>
</div>



<!-- FOOTER -->
<footer class="bg-[#7b5e57] text-white py-10 px-6 w-full">
    <!-- Bottom -->
    <div class="text-center text-sm">
        &copy; 2025 <span class="font-semibold">KOSanKU</span> Created by Irsyadrama
    </div>
</footer>

<!-- SCRIPTS -->
<script>
/* SLIDER */
const slider = document.getElementById('slider');
const slides = slider.children;
const totalSlides = slides.length;
const dotsContainer = document.getElementById('dots');

let index = 0;

// Create indicator dots
for (let i = 0; i < totalSlides; i++) {
    const dot = document.createElement('span');
    dot.className =
        "w-3 h-3 bg-white/70 hover:bg-white rounded-full cursor-pointer transition";
    dot.addEventListener('click', () => showSlide(i));
    dotsContainer.appendChild(dot);
}

const dots = dotsContainer.querySelectorAll('span');
dots[0].classList.add('bg-white');

function updateDots() {
    dots.forEach(dot => dot.classList.remove('bg-white'));
    dots[index].classList.add('bg-white');
}

function showSlide(i) {
    index = (i + totalSlides) % totalSlides;
    slider.style.transform = `translateX(-${index * 100}%)`;
    updateDots();
}

// Auto-slide
setInterval(() => showSlide(index + 1), 3500);

/* REVIEW MODAL */
function openReviewModal() {
    const modal = new bootstrap.Modal(document.getElementById('reviewModal'));
    modal.show();
}

// GALLERY SLIDER
const gSlider = document.getElementById('gallerySlider');
const gSlides = gSlider.children;
const gTotal = gSlides.length;

const gDotsContainer = document.getElementById('galleryDots');

let gIndex = 0;

// Create dots
for (let i = 0; i < gTotal; i++) {
    const dot = document.createElement('span');
    dot.className = "w-3 h-3 bg-white/70 hover:bg-white rounded-full cursor-pointer transition";
    dot.addEventListener('click', () => gShowSlide(i));
    gDotsContainer.appendChild(dot);
}

const gDots = gDotsContainer.querySelectorAll("span");
gDots[0].classList.add("bg-white");

function gUpdateDots() {
    gDots.forEach(d => d.classList.remove("bg-white"));
    gDots[gIndex].classList.add("bg-white");
}

function gShowSlide(i) {
    gIndex = (i + gTotal) % gTotal;
    gSlider.style.transform = `translateX(-${gIndex * 100}%)`;
    gUpdateDots();
}

setInterval(() => gShowSlide(gIndex + 1), 3000);

// ANIMASI SCROLL REPEAT
const reveals = document.querySelectorAll('.reveal');

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {

        // Kalau elemen terlihat → tambahkan animasi
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
        } else {
            // Kalau elemen keluar → reset animasi lagi
            entry.target.classList.remove('show');
        }

    });
}, { threshold: 0.2 });

reveals.forEach(r => observer.observe(r));

</script>

@endsection
