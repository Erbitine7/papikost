<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->include('layout/head') ?>
</head>
<body class="bg-slate-900 text-white flex-col flex justify-center items-center h-screen">
    
    <h1 class="text-center text-4xl py-4">Papikost staff login</h1>
    <form action="#" method="POST" class="bg-slate-950 w-135 shadow-lg rounded-2xl flex flex-col py-6 px-7">
        <div class="flex flex-row w-full items-center">
            <label for="email" class="w-37">Email :</label for="">
            <input type="text" name="email" id="email" placeholder="Email" class="grow bg-slate-900 p-2 rounded-md">
        </div>
        <div class="flex flex-row w-full py-3 items-center">
            <label for="password" class="w-37">Password :</label for="">
            <input type="password" name="password" id="password" placeholder="Password" class="grow bg-slate-900 p-2 rounded-md">
        </div>
        <input type="submit" value="Login" class="cursor-pointer bg-sky-600 p-2 mt-2 mb-1 rounded-md">
    </form>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>