<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' | Library Management' : 'Library Management'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.min.css"/>

    <?= $this->renderSection('styles'); ?>


      <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            background-color: #f4f7f6; /* Warna latar belakang umum */
        }
        .wrapper {
            flex: 1;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #ffffff; /* Latar belakang sidebar putih */
            padding: 20px;
            border-right: 1px solid #e0e0e0; /* Border lebih soft */
            box-shadow: 2px 0 5px rgba(0,0,0,0.05); /* Sedikit shadow */
            transition: width 0.3s ease; /* Transisi untuk lebar sidebar jika nanti ada toggle */
        }
        .sidebar-header {
            padding-bottom: 15px;
            margin-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
            color: #343a40;
            font-weight: bold;
        }
        .sidebar .nav-link {
            color: #495057; /* Warna teks link default */
            padding: 10px 15px;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .sidebar .nav-link:hover {
            background-color: #e9ecef; /* Warna hover */
            color: #212529;
        }
        /* Styling untuk link aktif */
        .sidebar .nav-link.active-page { /* Menggunakan kelas baru 'active-page' */
            background-color: #007bff; /* Warna latar belakang aktif */
            color: white; /* Warna teks aktif */
            font-weight: bold;
        }
        .sidebar .nav-link.active-page:hover {
            background-color: #0056b3; /* Warna hover untuk aktif */
            color: white;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f4f7f6; /* Latar belakang konten */
        }
        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: auto; /* Memastikan footer selalu di bawah */
        }
    </style>
</head>
<body>

    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">Library Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </header>

    <div class="wrapper">
        <nav class="sidebar">
            <h5 class="sidebar-header">Navigation</h5> <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>">Books</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('publishers'); ?>">Publishers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('members'); ?>">Members</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('authors'); ?>">Authors</a>
                </li>
            </ul>
        </nav>

        <?= $this->renderSection('content'); ?>

    </div>

    <footer class="footer">
        <div class="container">
            <span>&copy; <?php echo date('Y'); ?> Library Management. All rights reserved.</span>
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>


    <script>
        $(document).ready(function() {
            const currentPath = window.location.pathname;
            const baseUrl = '<?= base_url(); ?>';

            function normalizePath(path) {
                let normalized = path.replace(baseUrl, '/'); // Ganti base_url dengan '/'
                if (normalized.endsWith('/') && normalized.length > 1) {
                    normalized = normalized.slice(0, -1); // Hapus trailing slash jika bukan hanya '/'
                }
                return normalized;
            }

            const normalizedCurrentPath = normalizePath(currentPath);
            console.log("Normalized Current Path:", normalizedCurrentPath);

            $('.sidebar .nav-link').each(function() {
                const linkHref = $(this).attr('href');
                const normalizedLinkHref = normalizePath(linkHref);
                if (normalizedLinkHref === '/' && normalizedCurrentPath === '/') {
                    $(this).addClass('active-page');
                } 
                else if (normalizedLinkHref !== '/' && normalizedCurrentPath.startsWith(normalizedLinkHref)) {
                    $(this).addClass('active-page');
                }
            });
        });
    </script>

    <?= $this->renderSection('scripts'); ?>

</body>
</html>
