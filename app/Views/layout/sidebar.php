<div class="fixed top-0 left-0 bg-gray-950 h-screen w-67 m-0 pt-1 gap-1 flex flex-col shadow-lg">

<?php $role = (int) session()->get('staff_role'); ?>    
<a href="#" class="my-4 text-2xl font-semibold px-5">Papikost</a>    
    <div class="flex flex-col flex-grow">
        <a href="<?= base_url('dashboard') ?>" class="py-2 px-6 hover:pl-7 flex items-center <?= ($page === 'Dashboard') ? "pl-7 bg-gray-800" : "hover:bg-gray-900 hover:pl-7" ?>"><ion-icon class="text-xl mr-2" name="home-outline"></ion-icon>Home</a>
        <a href="<?= base_url('computer') ?>" class="py-2 px-6 flex items-center <?= ($page === 'Computer') ? "pl-7 bg-gray-800" : "hover:bg-gray-900 hover:pl-7" ?>"><ion-icon class="text-xl mr-2" name="desktop-outline"></ion-icon>Computer</a>
        <a href="<?= base_url('rental') ?>" class="py-2 px-6 flex items-center <?= ($page === 'Rental') ? "pl-7 bg-gray-800" : "hover:bg-gray-900 hover:pl-7" ?>"><ion-icon class="text-xl mr-2" name="browsers-outline"></ion-icon>Rental</a>
        <hr class="text-slate-500">
        <a href="<?= base_url('member') ?>" class="py-2 px-6 flex items-center <?= ($page === 'Member') ? "pl-7 bg-gray-800" : "hover:bg-gray-900 hover:pl-7" ?>"><ion-icon class="text-xl mr-2" name="person-circle-outline"></ion-icon>Member</a>
       
        <?php if ($role === 0): ?> 
        <a href="<?= base_url('staff') ?>" class="py-2 px-6 flex items-center <?= ($page === 'Staff') ? "pl-7 bg-gray-800" : "hover:bg-gray-900 hover:pl-7" ?>"><ion-icon class="text-xl mr-2" name="person-outline"></ion-icon>Staff</a>
        <?php endif; ?>
  
    </div>
    <a href="<?= base_url('staff-logout') ?>" class="text-red-400 flex m-2 p-2 hover:bg-red-950 rounded-sm">
  <ion-icon class="text-2xl mr-2" name="exit-outline"></ion-icon>Logout
</a>
</div>
