<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<?php
$role = (int) session()->get('staff_role');
$roleLabel = ($role === 0) ? 'ADMIN' : 'OPERATOR';

$name = session()->get('staff_name') ?? '-';
$email = session()->get('staff_email') ?? '-';
?>

<div class="flex flex-row items-center mb-5 px-5">
    <h3 class="font-semibold text-slate-900 bg-slate-200 px-1 rounded-md mr-2">
        <?= esc($roleLabel) ?>
    </h3>

    <h1 class="text-2xl mx-1">Hello, <?= esc($name) ?></h1>

    <span class="text-sm text-slate-400 self-end">(<?= esc($email) ?>)</span>
</div>

<hr class="text-slate-600 mb-3">

<div class="flex flex-row pr-6 gap-2">
    <a href="<?= base_url('computer') ?>" class="ml-5 text-xl text-cyan-300">Computers</a>
    <input type="hidden" name="id" value="<?= $computer['id'] ?>">
    <h1 class="text-xl text-slate-600">/</h1>
    <h1 class="text-xl">PC- <?= $computer['id'] ?> Details</h1>
</div>
<div class="w-full flex flex-row flex-nowrap gap-5 overflow-auto p-4">

    <div class="bg-slate-950 w-full shadow-lg rounded-2xl flex flex-col py-6 px-7 flex flex-col gap-5">

        <div class="flex w-full">
            <h3 class="w-60">PC #:</h3>
            <h3 class=""><?= $computer['id'] ?></h3>
        </div>

        <div class="flex w-full">
            <h3 class="w-60">Hourly price:</h3>
            <h3 class="">Rp <?= number_format($computer['tariff'], 0, ',', '.') ?>,00/hr</h3>
        </div>

        <div class="flex w-full">
            <h3 class="w-60">Specifications:</h3>
            <h3 class="text-wrap"><?= $computer['spec'] ?></h3>
        </div>

        <div class="flex w-full">
            <h3 class="w-60">Added at:</h3>
            <h3 class=""><?= $computer['created_at'] ?></h3>
        </div>

        <div class="flex w-full">
            <h3 class="w-60">Updated at:</h3>
            <h3 class=""><?= $computer['updated_at'] ?></h3>
        </div>

        <div class="flex w-full">
            <h3 class="w-60">Status:</h3>
            <h3 class=""><?= ($computer['status'] == 1) ? 'Occupied' : ($computer['status'] == 0 ? 'Active' : 'Under Maintenance') ?></h3>
        </div>

    </div>

</div>
<hr class="text-slate-600 mb-3">

<?= $this->endSection() ?>