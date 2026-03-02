<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->include('layout/head') ?>
</head>
<body class="bg-slate-900 text-white">
    
    <div class="py-6">

        <div class="flex flex-row items-center mb-5 px-5">
            <h3 class="font-semibold text-slate-900 bg-slate-200 px-1 rounded-md mr-2">ADMIN</h3>
            <h1 class="text-2xl mx-1">Name</h1>
            <span class="text-sm text-slate-400 self-end">(email@mail.com)</span>
        </div>

        <hr class="text-slate-600 mb-3">

        <div class="flex flex-row pr-6 gap-2">
            <h1 class="text-xl ml-6">Finalize payment</h1>
        </div>
        <div class="w-full flex flex-row flex-nowrap gap-5 overflow-auto p-4">

            <form action="<?= base_url('payment/complete/'.$session['id']) ?>" method="POST" class="bg-slate-950 w-full shadow-lg rounded-2xl flex flex-col py-6 px-7">
            <?= csrf_field() ?>    
            <input type="hidden" name="operator" value="admint">
                
                <div class="flex flex-row w-full items-center mb-4">
                    <label for="pcno" class="w-37">PC # :</label>
                    <input type="number" name="pcno" id="pcno" placeholder="pcno" readonly value="<?= esc($computer['id']) ?>"
 class="grow bg-slate-900 p-2 rounded-md text-cyan-400">
                </div>

                <div class="flex flex-row w-full items-center mb-4">
                    <label for="membername" class="w-37">Member :</label>
                    <input type="text" name="membername" id="membername" placeholder="membername" readonly value="<?= $member ? esc($member['name']) : 'Guest' ?>"
 class="grow bg-slate-900 p-2 rounded-md text-cyan-400">
                </div>

                <div class="flex flex-row w-full items-center mb-4">
                    <label for="payment" class="w-37">Payment amount :</label>
                    <input type="number" name="payment" id="payment" placeholder="payment" readonly value="<?= esc($total) ?>"
 class="grow bg-slate-900 p-2 rounded-md text-cyan-400">
                </div>
                
                <div class="flex flex-row w-full items-center mb-4">
                    <label for="hourly" class="w-37">Payment Method :</label>
                    
                    <select id="countries" class="grow bg-slate-900 p-2 rounded-md">
                        <option value="0" selected>Cash</option>
                        <option value="1">Bank Transfer</option>
                        <option value="2">E-wallet</option>
                    </select>

                </div>
                
                <form action="<?= base_url('payment/complete/'.$session['id']) ?>" method="POST">
<?= csrf_field() ?>



            </form>

        </div>
        <hr class="text-slate-600 mb-3">

    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="<?= base_url('js/script.js') ?>"></script>
</body>
</html>