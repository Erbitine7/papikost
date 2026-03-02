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

<div class="flex flex-row justify-between pr-6">
    <h1 class="mx-5 text-xl">Computers</h1>
    <a href="<?= base_url('computer/add') ?>" class="p-2 bg-cyan-500 font-bold text-slate-900 rounded-lg">+ Add new</a>
</div>
<div class="w-full flex flex-row flex-nowrap gap-5 overflow-auto p-4">

    <table class="outline outline-slate-700 rounded-sm w-full text-left">
        <thead class="border-b border-slate-700 bg-slate-950">
            <tr class="border-b border-slate-700 bg-slate-950">
                <th class="p-2 pl-4">No.</th>
                <th class="p-2">PC ID</th>
                <th class="p-2">Specification</th>
                <th class="p-2">Hourly price</th>
                <th class="p-2">Status</th>
                <th class="p-2">Added at:</th>
                <th class="p-2">Last updated at:</th>
                <th class="p-2 text-right px-4">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($computers) && is_array($computers)): ?>
                <?php $no = 1; ?>
                <?php foreach ($computers as $computer): ?>
                    <tr class="hover:bg-slate-800 border-b border-slate-700">
                        <td class="p-4"><?= $no++ ?></td>
                        <td class="p-4">PC-<?= $computer['id'] ?></td>
                        <td class="py-4 px-2"><?= esc($computer['spec']) ?></td>
                        <td class="py-4 px-2">Rp <?= number_format($computer['tariff'] ?? 0, 0, ',', '.') ?></td>
                        <td class="py-4 px-2">
                            <?= ($computer['status'] == 1) ? 'Under Maintenance' : ($computer['status'] == 0 ? 'Active' : 'Deactive') ?>
                        </td>
                        <td class="py-4 px-2"><?= date('d/m/Y', strtotime($computer['created_at'] ?? 'now')) ?></td>
                        <td class="py-4 px-2">
                            <?= date('d/m/Y', strtotime($computer['updated_at'] ?? $computer['created_at'] ?? 'now')) ?></td>
                        <td class="pt-2 px-3 font-semibold text-right flex justify-end">
                            <a href="<?= base_url('computer/detail?id=' . $computer['id']) ?>"
                                class="rounded-lg bg-lime-500 pt-1 pb-2 px-2 ml-2 text-slate-900 hover:bg-lime-600 flex"><ion-icon
                                    class="pt-1 text-2xl" name="eye-outline"></ion-icon></a>
                            <a href="<?= base_url('computer/edit?id=' . $computer['id']) ?>"
                                class="rounded-lg bg-yellow-400 pt-1 pb-2 px-2 ml-2 text-slate-900 hover:bg-yellow-600 flex"><ion-icon
                                    class="pt-1 text-2xl" name="pencil-outline"></ion-icon></a>
                            <a onclick="openComputerDelete(<?= $computer['id'] ?>)"
                                class="rounded-lg bg-red-500 pt-1 pb-2 px-2 ml-2 hover:bg-red-700 hover:text-gray-300 flex">
                                <ion-icon class="pt-1 text-2xl" name="trash-outline"></ion-icon>
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="p-4 text-center">No computers found.</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>

</div>
<hr class="text-slate-600 mb-3">


<dialog id="dialog-delete"
    class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 open:flex backdrop:bg-slate-950/[80%]">
    <form action="<?= base_url('/computer/delete') ?>" method="POST"
        class="bg-slate-800 w-75 shadow-lg rounded-2xl flex flex-col py-4 px-5">
        <h1 class="text-center mb-4">WARNING</h1>
        <div class="flex flex-row w-full items-center justify-center">
            <label for="pcnodel">This PC:</label>
            <input readonly type="text" id="del-pc" value="PC-<?= $computer['id'] ?>"
                class="w-20 bg-slate-900 p-2 rounded-md text-center ml-2 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
            <input type="hidden" name="id" id="del-id" value="">
        </div>
        <div class="flex flex-row w-full items-center justify-between">
            <h3 class="mx-2 mt-4 text-center">This will delete the selected PC</h3>
        </div>
        <div class="flex flex-row w-full items-center justify-between gap-3 mt-4">
            <button onclick="closeDelete()" type="button"
                class="cursor-pointer bg-sky-600 hover:bg-sky-500 p-2 mt-2 mb-1 rounded-md w-full">Cancel</button>
            <input type="submit" value="Proceed"
                class="cursor-pointer bg-red-600 hover:bg-red-500 p-2 mt-2 mb-1 rounded-md w-full">
        </div>
    </form>
</dialog>


<script>
    function openComputerDelete(id) {
        document.getElementById('del-id').value = id;
        document.getElementById('del-pc').value = 'PC-' + id;
        document.getElementById('dialog-delete').showModal();
    }

    function closeDelete() {
        document.getElementById('dialog-delete').close();
    }
</script>

<?= $this->endSection() ?>