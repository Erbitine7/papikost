<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="flex flex-row items-center mb-5 px-5">
    <h3 class="font-semibold text-slate-900 bg-slate-200 px-1 rounded-md mr-2">ADMIN</h3>
    <h1 class="text-2xl mx-1">Name</h1>
    <span class="text-sm text-slate-400 self-end">(email@mail.com)</span>
</div>

<hr class="text-slate-600 mb-3">

<div class="flex flex-row pr-6 gap-2">
    <a href="<?= base_url('rental') ?>" class="ml-5 text-xl text-cyan-300">Rentals</a>
    <h1 class="text-xl text-slate-600">/</h1>
    <h1 class="text-xl">Add a new rental session</h1>
</div>
<div class="w-full flex flex-row flex-nowrap gap-5 overflow-auto p-4">

    <div class="bg-slate-950 w-full shadow-lg rounded-2xl flex flex-col py-6 px-7">
       <form action="<?= base_url('rental/add') ?>" method="GET" class="flex flex-row w-full items-center mb-4">
    
    <label class="w-37">Search member by</label>

    <select name="search_by" class="bg-slate-900 p-2 rounded-md">
        <option value="name">Name</option>
        <option value="email">Email</option>
        <option value="phone_number">Phone</option>
    </select>

    <label class="mx-3">:</label>

    <input type="text" 
           name="keyword" 
           placeholder="Search Member" 
           class="grow bg-slate-900 p-2 rounded-md">

    <button type="submit" 
            class="bg-slate-700 hover:bg-slate-500 p-2 ml-2 rounded-md">
        Search
    </button>

</form>  

        
      <form action="<?= base_url('rental/store') ?>" method="POST">
    <?= csrf_field() ?>


            
            <div class="bg-slate-800/[50%] w-full flex flex-row flex-nowrap gap-5 overflow-x-auto overflow-y-hidden p-4 mb-4">
                <!-- echo search results here (keep guest as-is) -->


<?php foreach ($members as $m): ?>
<div class="flex px-4 border border-slate-600 bg-slate-800 rounded-xl">
    <input id="member<?= $m['id'] ?>" 
           type="radio" 
           name="member_id" 
           value="<?= $m['id'] ?>">
    <label for="member<?= $m['id'] ?>" class="w-full py-4 ms-2">
        <?= esc($m['name']) ?><br>
        <span><?= esc($m['phone_number']) ?> | <?= esc($m['email']) ?></span>
    </label>
</div>
<?php endforeach ?>

                
            </div>

            <div class="flex flex-row w-full items-center mb-4">
                <label for="pcno" class="w-37">PC # :</label>
                <select id="pcno" name="pcno" class="grow bg-slate-900 p-2 rounded-md" required>
    <?php if (!empty($pcs)) : ?>
        <?php foreach ($pcs as $pc) : ?>
            <option value="<?= $pc['id'] ?>">
                PC #<?= $pc['id'] ?> 
                (Rp <?= number_format($pc['tariff'], 0, ',', '.') ?>/hour)
            </option>
        <?php endforeach ?>
    <?php else : ?>
        <option disabled>No available PC</option>
    <?php endif ?>
</select>

            </div>

            <div class="flex flex-row w-full items-center mb-4">
                <label for="timestart" class="w-37">Start time :</label>
                <input type="time" name="timestart" id="timestart" placeholder="E.g. 10000" class="grow bg-slate-900 p-2 rounded-md">
            </div>
            
            <div class="flex flex-row w-full items-center mb-4">
                <label for="timeend" class="w-37">End time :</label>
                <input type="time" name="timeend" id="timeend" placeholder="E.g. 10000" class="grow bg-slate-900 p-2 rounded-md">
            </div>
            
            <input type="submit" value="Save" class="cursor-pointer bg-sky-600 hover:bg-sky-500 p-2 mt-2 mb-1 rounded-md">


        </form>
    </div>


</div>
<hr class="text-slate-600 mb-3">


<?= $this->endSection() ?>