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
        }
        .wrapper {
            flex: 1;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            padding: 20px;
            border-right: 1px solid #dee2e6;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px 0;
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
            <h5 class="mb-3">Navigation</h5>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('books'); ?>">Books</a>
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

    <?= $this->renderSection('scripts'); ?>

</body>
</html>
