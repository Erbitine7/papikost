<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="flex flex-row items-center mb-5 px-5">
    <h3 class="font-semibold text-slate-900 bg-slate-200 px-1 rounded-md mr-2">ADMIN</h3>
    <h1 class="text-2xl mx-1">Name</h1>
    <span class="text-sm text-slate-400 self-end">(email@mail.com)</span>
</div>

<hr class="text-slate-600 mb-3">

<div class="flex flex-row pr-6 gap-2">
    <a href="<?= base_url('staff') ?>" class="ml-5 text-xl text-cyan-300">Staffs</a>
    <h1 class="text-xl text-slate-600">/</h1>
    <h1 class="text-xl">Edit a staff</h1>
</div>
<div class="w-full flex flex-row flex-nowrap gap-5 overflow-auto p-4">

    <form action="#" method="POST" class="bg-slate-950 w-full shadow-lg rounded-2xl flex flex-col py-6 px-7">
        
        <div class="flex flex-row w-full items-center mb-4">
            <label for="name" class="w-37">Name :</label>
            <input type="text" name="name" id="name" placeholder="name" class="grow bg-slate-900 p-2 rounded-md">
        </div>
        
        <div class="flex flex-row w-full items-center mb-4">
            <label for="phone" class="w-37">Phone number :</label>
            <input type="number" name="phone" id="phone" placeholder="000000000000" class="grow bg-slate-900 p-2 rounded-md">
        </div>
        
        <div class="flex flex-row w-full items-center mb-4">
            <label for="email" class="w-37">Email :</label>
            <input type="email" name="email" id="email" placeholder="name@mail.com" class="grow bg-slate-900 p-2 rounded-md">
        </div>
        
        <input type="submit" value="Register" class="cursor-pointer bg-sky-600 hover:bg-sky-500 p-2 mt-2 mb-1 rounded-md">


    </form>

</div>
<hr class="text-slate-600 mb-3">


<?= $this->endSection() ?>