<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->include('layout/head') ?>
</head>
<body class="bg-slate-900 text-white">
    <!-- SIDEBAR -->
    <?= $this->include('layout/sidebar') ?>
    
    <div class="p-4 pl-72">
        <!-- CONTENT -->
        <?= $this->renderSection('content') ?>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>