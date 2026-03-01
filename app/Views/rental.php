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
                <th class="p-2">PC №</th>
                <th class="p-2">User</th>
                <th class="p-2">Time</th>
                <th class="p-2">Remaining Time</th>
                <th class="p-2 text-right px-4">Action</th>
            </tr>
        </thead>
        <tbody>

            <tr class="hover:bg-slate-800 border-b border-slate-700">
                <td class="p-4">1</td>
                <td class="p-4">Maria Anders</td>
                <td class="p-4">Germany</td>
                <td class="p-4">Germany</td>
                <td class="pt-2 px-3 font-semibold text-right flex justify-end text-center">
                    <a href="#" class="rounded-lg bg-lime-500 pt-1 pb-2 px-2 text-slate-900 hover:bg-lime-600 flex items-center"><ion-icon class="pt-1 text-2xl mr-1" name="add-outline"></ion-icon>Extend</a>
                    <a href="#" class="rounded-lg bg-red-500 pt-1 pb-2 px-2 ml-2 hover:bg-red-700 hover:text-gray-300 flex items-center"><ion-icon class="pt-1 text-2xl mr-1" name="checkmark-circle-outline"></ion-icon> Finish</a>
                </td>
            </tr>

            

        </tbody>
    </table>
            <dialog open class="fixed top-0 left-0 flex justify-center items-center w-screen h-screen bg-slate-950/[80%]">
               <form action="#" method="POST" class="bg-slate-800 w-75 shadow-lg rounded-2xl flex flex-col py-4 px-5">
                    <h1 class="text-center mb-4">Rent extension</h1>
                    <div class="flex flex-row w-full items-center justify-center">
                        <label for="email">PC # :</label>
                        <input type="number" name="pcno" id="pcno" class="w-12 bg-slate-900 p-2 rounded-md text-center ml-2 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                    </div>
                    <div class="flex flex-row w-full items-center justify-between">
                        <button type="button" class="cursor-pointer bg-slate-700 hover:bg-slate-500 p-2 mt-2 mb-1 rounded-md w-full"><ion-icon class="pt-1 text-2xl mr-1" name="remove-outline"></ion-icon></button>
                        <input type="number" name="extend" id="extend" value="1" class="w-12 bg-slate-900 p-2 rounded-md text-center ml-4 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        <h3 class="mr-4 ml-2">hour(s)</h3>
                        <button type="button" class="cursor-pointer bg-slate-700 hover:bg-slate-500 p-2 mt-2 mb-1 rounded-md w-full"><ion-icon class="pt-1 text-2xl mr-1" name="add-outline"></ion-icon></button>
                    </div>
                    <div class="flex flex-row w-full items-center justify-between gap-3 mt-4">
                        <button type="button" class="cursor-pointer bg-red-600 hover:bg-red-500 p-2 mt-2 mb-1 rounded-md w-full">Cancel</button>
                        <input type="submit" value="+ Extend" class="cursor-pointer bg-sky-600 hover:bg-sky-500 p-2 mt-2 mb-1 rounded-md w-full">
                    </div>
                </form>
            </dialog>
</div>
<hr class="text-slate-600 mb-3">


<?= $this->endSection() ?>