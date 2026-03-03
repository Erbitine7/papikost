<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<?php
  $role = (int) session()->get('staff_role');
  $roleLabel = ($role === 0) ? 'ADMIN' : 'OPERATOR';

  $name  = session()->get('staff_name') ?? '-';
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
    <h1 class="mx-5 text-xl">Active Rentals</h1>
    <a href="<?= base_url('rental/add') ?>" class="p-2 bg-cyan-500 font-bold text-slate-900 rounded-lg">+ Add new</a>
</div>
<div class="w-full flex flex-row flex-nowrap gap-5 overflow-auto p-4">

    <table class="outline outline-slate-700 rounded-sm w-full text-left">
        <thead class="border-b border-slate-700 bg-slate-950">
            <tr>
                <th class="p-2 pl-4">No.</th>
                <th class="p-2">PC Name</th>
                <th class="p-2">User</th>
                <th class="p-2">Start time</th>
                <!-- <th class="p-2">End time</th> -->
                <th class="p-2">Base Price</th>
                <th class="p-2 text-right px-4">Action</th>
            </tr>
        </thead>
        <tbody>

<?php if (!empty($active)) : ?>
    <?php $no = 1; ?>
    <?php foreach ($active as $row) : ?>
        <tr class="hover:bg-slate-800 border-b border-slate-700">
            <td class="p-4"><?= $no++ ?></td>
            <td class="p-4"><?= esc($row['computer_id']) ?></td>
            <td class="py-4 px-2">
    <?= $row['customer_id'] ? esc($row['member_name']) : 'Guest' ?>
</td>
            <td class="py-4 px-2"><?= esc($row['start_time']) ?></td>
            <!-- <td class="py-4 px-2"><?php //echo esc($row['end_time']) ?></td> -->
            <td class="py-4 px-2"> Rp <?= number_format($row['computer_tariff'], 0, ',', '.') ?>
</td>
            <td class="text-center font-semibold text-right flex justify-end py-2 px-3">
                 
                    <button onclick="openPayment(<?= $row['id'] ?>)" class="rounded-lg bg-red-600 pt-1 pb-2 px-2 ml-2 hover:bg-red-700 hover:text-gray-300 flex items-center"><ion-icon class="pt-1 text-2xl mr-1" name="checkmark-circle-outline"></ion-icon> Finish</button>
                
            </td>
        </tr>
    <?php endforeach ?>
<?php else : ?>
    <tr>
        <td colspan="7" class="text-center p-4 text-slate-400">
            No active rentals
        </td>
    </tr>
<?php endif ?>

            

        </tbody>
    </table>

</div>

<hr class="text-slate-600 mb-16 mt-12">

<div class="flex flex-row justify-between pr-6">
    <h1 class="mx-5 text-xl">Rental History</h1>
</div>
<div class="w-full flex flex-row flex-nowrap gap-5 overflow-auto p-4">

   <table class="outline outline-slate-700 rounded-sm w-full text-left">
    <thead class="border-b border-slate-700 bg-slate-950">
        <tr>
            <th class="p-2 pl-4">No.</th>
            <th class="p-2">PC Name</th>
            <th class="p-2">User</th>
            <th class="p-2">Start time</th>
            <th class="p-2">End time</th>
            <!-- <th class="p-2">Date</th> -->
            <th class="p-2">Total price</th>
            <th class="p-2">Payment method</th>
            <!-- <th class="p-2 text-right">Operator</th> -->
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($inactive)) : ?>
            <?php $no = 1; ?>
            <?php foreach ($inactive as $row) : ?>  
                <tr class="hover:bg-slate-800 border-b border-slate-700">
                    <td class="p-4"><?= $no++ ?></td>
                    <td class="py-4 px-2"><?= esc($row['computer_id']) ?></td>
                    <td class="py-4 px-2">
    <?= $row['customer_id'] ? esc($row['member_name']) : 'Guest' ?>
</td>
                    <td class="py-4 px-2"><?= esc($row['start_time']) ?></td>
                    <td class="py-4 px-2"><?= esc($row['end_time']) ?></td>
                    <!-- <td class="py-4 px-2"><?php //echo esc($row['date'] ?? '-'); ?></td>  -->
                    <td class="py-4 px-2">Rp <?= number_format($row['total_amount'], 0, ',', '.') ?></td>
                    <td class="py-4 px-2">
    <?php
        if (!isset($row['payment_method'])) {
            echo 'N/A';
        } else {
            switch ((int) $row['payment_method']) {
                case 0:
                    echo 'Cash';
                    break;
                case 1:
                    echo 'Bank transfer';
                    break;
                case 2:
                    echo 'E-wallet';
                    break;
                default:
                    echo 'Unknown';
            }
        }
    ?>
</td>
                    <!-- <td class="pt-2 px-3 text-right"><?php //echo esc($row['operator_name'] ?? 'System') ?></td> -->
                </tr>
            <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td colspan="9" class="text-center p-4 text-slate-400">
                    No inactive rentals
                </td>
            </tr>
        <?php endif ?>
    </tbody>
</table>

</div>
<hr class="text-slate-600 mb-3">

<dialog id="dialog-delete" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 open:flex backdrop:bg-slate-950/[80%]">
    <div action="#" method="POST" class="bg-slate-800 w-75 shadow-lg rounded-2xl flex flex-col py-4 px-5">
        <h1 class="text-center mb-4">Rent conclusion</h1>
        <div class="flex flex-row w-full items-center justify-center">
            <label for="del">PC Name :</label>
            <input readonly type="number" id="del" class="w-12 bg-slate-900 p-2 rounded-md text-center ml-2 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
        </div>
        <div class="flex flex-row w-full items-center justify-between text-center">
            <h3 class="mr-4 ml-2 mt-2">This will end the selected PC's session</h3>
        </div>
        <div class="flex flex-row w-full items-center justify-between gap-3 mt-4">
            <button onclick="closeDelete()" type="button" class="cursor-pointer bg-red-600 hover:bg-red-500 p-2 mt-2 mb-1 rounded-md w-full">Cancel</button>
            <a id="proceedLink"
            href="#"
            data-base-url="<?= base_url('payment/') ?>"
            class="cursor-pointer bg-sky-600 hover:bg-sky-500 p-2 mt-2 mb-1 rounded-md w-full text-center">
                Proceed
            </a>
        </div>
    </div>
</dialog>
<?= $this->endSection() ?>