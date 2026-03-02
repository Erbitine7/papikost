<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="flex flex-row items-center mb-5 px-5">
    <h3 class="font-semibold text-slate-900 bg-slate-200 px-1 rounded-md mr-2">ADMIN</h3>
    <h1 class="text-2xl mx-1">Name</h1>
    <span class="text-sm text-slate-400 self-end">(email@mail.com)</span>
</div>

<hr class="text-slate-600 mb-3">

<div class="flex flex-row justify-between pr-6">
    <h1 class="mx-5 text-xl">Active Rentals</h1>
    <a href="#" class="p-2 bg-cyan-500 font-bold text-slate-900 rounded-lg">+ Add new</a>
</div>
<div class="w-full flex flex-row flex-nowrap gap-5 overflow-auto p-4">

    <table class="outline outline-slate-700 rounded-sm w-full text-left">
        <thead class="border-b border-slate-700 bg-slate-950">
            <tr>
                <th class="p-2">№</th>
                <th class="p-2">PC #</th>
                <th class="p-2">User</th>
                <th class="p-2">Start time</th>
                <th class="p-2">End time</th>
                <th class="p-2">Total Price</th>
                <th class="p-2 text-right px-4">Action</th>
            </tr>
        </thead>
        <tbody>

            <tr class="hover:bg-slate-800 border-b border-slate-700">
                <td class="p-4">1</td>
                <td class="p-4">1</td>
                <td class="py-4 px-2">Penguinistrator</td>
                <td class="py-4 px-2">12:00</td>
                <td class="py-4 px-2">13:00</td>
                <td class="py-4 px-2">Rp 10.000</td>
                <td class="pt-2 px-3 font-semibold text-right flex justify-end text-center">
                    <button onclick="openExtend(1)" class="rounded-lg bg-lime-500 pt-1 pb-2 px-2 text-slate-900 hover:bg-lime-600 flex items-center"><ion-icon class="pt-1 text-2xl mr-1" name="add-outline"></ion-icon>Extend</button>
                    <button onclick="openDelete(1)" class="rounded-lg bg-red-600 pt-1 pb-2 px-2 ml-2 hover:bg-red-700 hover:text-gray-300 flex items-center"><ion-icon class="pt-1 text-2xl mr-1" name="checkmark-circle-outline"></ion-icon> Finish</button>
                </td>
            </tr>

            

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
                <th class="p-2">№</th>
                <th class="p-2">PC #</th>
                <th class="p-2">User</th>
                <th class="p-2">Start time</th>
                <th class="p-2">End time</th>
                <th class="p-2">Date</th>
                <th class="p-2 text-right">Total Price</th>
            </tr>
        </thead>
        <tbody>

            <tr class="hover:bg-slate-800 border-b border-slate-700">
                <td class="p-4">1</td>
                <td class="py-4 px-2">1</td>
                <td class="py-4 px-2">John Umamusume</td>
                <td class="py-4 px-2">14:00</td>
                <td class="py-4 px-2">16:00</td>
                <td class="py-4 px-2">23/02/2026</td>
                <td class="py-4 px-2 text-right">Rp 20.000</td>
            </tr>

            

        </tbody>
    </table>

</div>
<hr class="text-slate-600 mb-3">

<dialog id="hrextend" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 open:flex backdrop:bg-slate-950/[80%]">
    <form id="hrexform" action="#" method="POST" class="bg-slate-800 w-75 shadow-lg rounded-2xl flex flex-col py-4 px-5">
        <h1 class="text-center mb-4">Rent extension</h1>
        <div class="flex flex-row w-full items-center justify-center">
            <label for="pcnoex">PC # :</label>
            <input type="number" name="pcno" id="pcnoex" class="w-12 bg-slate-900 p-2 rounded-md text-center ml-2 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
        </div>
        <div class="flex flex-row w-full items-center justify-between">
            <button onclick="hrExtend(0)" type="button" id="minus" class="cursor-pointer bg-slate-700 hover:bg-slate-500 p-2 mt-2 mb-1 rounded-md w-full"><ion-icon class="pt-1 text-2xl mr-1" name="remove-outline"></ion-icon></button>
            <input type="number" name="extend" id="extend" value="1" class="w-12 bg-slate-900 p-2 rounded-md text-center ml-4 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
            <h3 class="mr-4 ml-2">hour(s)</h3>
            <button onclick="hrExtend(1)" type="button" id="plus" class="cursor-pointer bg-slate-700 hover:bg-slate-500 p-2 mt-2 mb-1 rounded-md w-full"><ion-icon class="pt-1 text-2xl mr-1" name="add-outline"></ion-icon></button>
        </div>
        <div class="flex flex-row w-full items-center justify-between gap-3 mt-4">
            <button onclick="closeExtend()" type="button" class="cursor-pointer bg-red-600 hover:bg-red-500 p-2 mt-2 mb-1 rounded-md w-full">Cancel</button>
            <input type="submit" value="+ Extend" class="cursor-pointer bg-sky-600 hover:bg-sky-500 p-2 mt-2 mb-1 rounded-md w-full">
        </div>
    </form>
</dialog>

<dialog id="dialog-delete" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 open:flex backdrop:bg-slate-950/[80%]">
    <form action="#" method="POST" class="bg-slate-800 w-75 shadow-lg rounded-2xl flex flex-col py-4 px-5">
        <h1 class="text-center mb-4">Rent conclusion</h1>
        <div class="flex flex-row w-full items-center justify-center">
            <label for="pcnodel">PC # :</label>
            <input type="number" name="pcno" id="del" class="w-12 bg-slate-900 p-2 rounded-md text-center ml-2 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
        </div>
        <div class="flex flex-row w-full items-center justify-between">
            <h3 class="mr-4 ml-2">This will end the selected PC's rental session</h3>
        </div>
        <div class="flex flex-row w-full items-center justify-between gap-3 mt-4">
            <button onclick="closeDelete()" type="button" class="cursor-pointer bg-red-600 hover:bg-red-500 p-2 mt-2 mb-1 rounded-md w-full">No</button>
            <input type="submit" value="Yes" class="cursor-pointer bg-sky-600 hover:bg-sky-500 p-2 mt-2 mb-1 rounded-md w-full">
        </div>
    </form>
</dialog>
<?= $this->endSection() ?>