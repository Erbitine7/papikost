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

<div class="flex flex-row pr-6 gap-2">
    <a href="<?= base_url('staff') ?>" class="ml-5 text-xl text-cyan-300">Staffs</a>
    <h1 class="text-xl text-slate-600">/</h1>
    <h1 class="text-xl">Edit a staff</h1>
</div>
<div class="w-full flex flex-row flex-nowrap gap-5 overflow-auto p-4">

    <form action="<?= base_url('/staff/update') ?>" method="POST" class="bg-slate-950 w-full shadow-lg rounded-2xl flex flex-col py-6 px-7">
        <input type="hidden" name="id" value="<?= $operator['id'] ?>">
        
        <div class="flex flex-row w-full items-center mb-4">
            <label for="username" class="w-37">Username :</label>
            <input type="text" name="username" id="username" placeholder="username" value="<?= $operator['username'] ?>" readonly class="grow bg-slate-900 p-2 rounded-md text-cyan-400">
        </div>
        
        <div class="flex flex-row w-full items-center mb-4">
            <label for="password" class="w-37">Password :</label>
            <input type="password" name="password" id="password" placeholder="Leave empty to keep current" class="grow bg-slate-900 p-2 rounded-md">
        </div>
        
        <div class="flex flex-row w-full items-center mb-4">
            <label for="full_name" class="w-37">Full Name :</label>
            <input type="text" name="full_name" id="full_name" placeholder="Full name" value="<?= $operator['full_name'] ?>" class="grow bg-slate-900 p-2 rounded-md" required>
        </div>
        
        <div class="flex flex-row w-full items-center mb-4">
            <label for="email" class="w-37">Email :</label>
            <input type="email" name="email" id="email" placeholder="name@mail.com" value="<?= $operator['email'] ?? '' ?>" class="grow bg-slate-900 p-2 rounded-md">
        </div>
        
        <div class="flex flex-row w-full items-center mb-4">
            <label for="role" class="w-37">Role :</label>
            <select name="role" id="role" class="grow bg-slate-900 p-2 rounded-md" required>
                <option value="0" <?= ($operator['role'] == 0) ? 'selected' : '' ?>>Admin</option>
                <option value="1" <?= ($operator['role'] == 1) ? 'selected' : '' ?>>Operator</option>
            </select>
        </div>
        
        <input type="submit" value="Update" class="cursor-pointer bg-sky-600 hover:bg-sky-500 p-2 mt-2 mb-1 rounded-md">


    </form>

</div>
<hr class="text-slate-600 mb-3">


<?= $this->endSection() ?>