<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="flex flex-row items-center mb-5 px-5">
    <h3 class="font-semibold text-slate-900 bg-slate-200 px-1 rounded-md mr-2">ADMIN</h3>
    <h1 class="text-2xl mx-1">Name</h1>
    <span class="text-sm text-slate-400 self-end">(email@mail.com)</span>
</div>

<hr class="text-slate-600 mb-3">

<div class="flex flex-row justify-between pr-6">
    <h1 class="mx-5 text-xl">Computers</h1>
    <a href="#" class="p-2 bg-cyan-500 font-bold text-slate-900 rounded-lg">+ Add new</a>
</div>
<div class="w-full flex flex-row flex-nowrap gap-5 overflow-auto p-4">

    <table class="outline outline-slate-700 rounded-sm w-full text-left">
        <thead class="border-b border-slate-700 bg-slate-950">
            <tr>
                <th class="p-2">PC №</th>
                <th class="p-2">Price/hour</th>
                <th class="p-2">Spec</th>
                <th class="p-2 text-right px-4">Action</th>
            </tr>
        </thead>
        <tbody>

            <tr class="hover:bg-slate-800 border-b border-slate-700">
                <td class="p-4">1</td>
                <td class="p-4">Maria Anders</td>
                <td class="p-4">Germany</td>
                <td class="pt-2 px-3 font-semibold text-right flex justify-end">
                    <a href="#" class="rounded-lg bg-lime-500 pt-1 pb-2 px-2 text-slate-900 hover:bg-lime-600 flex"><ion-icon class="pt-1 text-2xl" name="eye-outline"></ion-icon></a>
                    <a href="#" class="rounded-lg bg-yellow-400 pt-1 pb-2 px-2 ml-2 text-slate-900 hover:bg-yellow-600 flex"><ion-icon class="pt-1 text-2xl" name="pencil-outline"></ion-icon></a>
                    <a href="#" class="rounded-lg bg-red-500 pt-1 pb-2 px-2 ml-2 hover:bg-red-700 hover:text-gray-300 flex"><ion-icon class="pt-1 text-2xl" name="trash-outline"></ion-icon></a>
                </td>
            </tr>

        </tbody>
    </table>

</div>
<hr class="text-slate-600 mb-3">


<?= $this->endSection() ?>