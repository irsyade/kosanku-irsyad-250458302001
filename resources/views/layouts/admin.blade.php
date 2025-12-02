<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin KOSanKU | Dashboard</title>

   <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @livewireStyles

    <style>
        body {
            font-family: 'Poppins';
            background-color: #f4e7d2;
            color: #3b2f2f;
        }

        .bg-vintage-dark { background-color: #5a3e2b; }
        .bg-vintage-cream { background-color: #f5e6cc; }
        .text-vintage-light { color: #f8f1e9; }
        .text-vintage-dark { color: #3b2f2f; }
        .btn-vintage { background-color: #a67c52; color: white; border: none; }
        .btn-vintage:hover { background-color: #8c6239; }

        #sidebar-wrapper {
            min-height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        #page-content-wrapper {
            margin-left: 250px;
            transition: all 0.3s ease;
            padding: 20px;
        }

        /* Sidebar tertutup */
        #wrapper.toggled #sidebar-wrapper {
            margin-left: -250px;
        }
        #wrapper.toggled #page-content-wrapper {
            margin-left: 0;
        }

        .list-group-item-action.active {
            background-color: #a67c52 !important;
            border: none;
        }

        @media (max-width: 768px) {
            #sidebar-wrapper { margin-left: -250px; }
            #wrapper.toggled #sidebar-wrapper { margin-left: 0; }
            #page-content-wrapper { margin-left: 0; }
        }
    </style>
</head>

<body>

    
    {{-- SIDEBAR --}}
    @include('layouts.components.navsi')

        {{-- SLOT LIVEWIRE --}}
        <div class="content-area">
        {{ $slot }}
    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
    document.getElementById("menu-toggle").onclick = function () {
    document.getElementById("wrapper").classList.toggle("toggled");
    };

    document.addEventListener('livewire:init', () => {

    Livewire.on('showDeleteConfirmation', (data) => {

        Swal.fire({
            title: "Hapus Kamar?",
            text: `Yakin ingin menghapus kamar: ${data.room_name}?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {

                Livewire.dispatch('confirmedDelete', {
                    id: data.room_id
                });

            }
        });

    });

});
</script>

@livewireScripts

@stack('scripts') 


</body>
</html>