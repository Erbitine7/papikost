<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->include('guest/head') ?>
</head>
<body class="bg-slate-900 text-white">
    <!-- SIDEBAR -->
    <?= $this->include('guest/header') ?>

    <!-- CONTENT -->
    <?= $this->renderSection('content') ?>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>