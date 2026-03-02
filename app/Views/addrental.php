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
        <form action="#" method="POST">
            <div class="flex flex-row w-full items-center mb-4">
                <label for="pcno" class="w-37">Search member by</label>
                <select id="pcno" name="pcno" class="bg-slate-900 p-2 rounded-md">
                    <option value="name" selected>name</option>
                    <option value="email">email</option>
                    <option value="phone">phone number</option>
                </select>

                <label for="memsearch" class="mx-3"> : </label>
                <input type="text" name="memsearch" id="memsearch" placeholder="Search Member" class="grow bg-slate-900 p-2 rounded-md" value="">

                <button type="submit" value="Save" class="cursor-pointer bg-slate-700 hover:bg-slate-500 p-1 pl-2 rounded-md w-10 ml-2"><ion-icon class="pt-1 text-2xl mr-1" name="search-outline"></ion-icon></button>
            </div>
        </form>
        
        <form action="#" method="POST" class="w-full flex flex-col">
            
            <div class="bg-slate-800/[50%] w-full flex flex-row flex-nowrap gap-5 overflow-x-auto overflow-y-hidden p-4 mb-4">
                <!-- echo search results here (keep guest as-is) -->

                <div class="flex px-4 border border-slate-600 bg-slate-800 rounded-xl peer-checked:bg-slate-700">
                    <div class="flex items-cente">
                        <input id="guest" type="radio" name="bordered-radio" value="">
                        <label for="guest" class="w-full py-4 select-none ms-2 text-md">Guest</label>
                    </div>
                </div>

                <div class="flex px-4 border border-slate-600 bg-slate-800 rounded-xl peer-checked:bg-slate-700">
                        <input id="0" type="radio" name="bordered-radio" value="">
                        <label for="0" class="w-full py-4 select-none ms-2 text-md">User Name
                        <br>
                        <span class="text-nowrap">0808-0808-0808 | useremail@mail.com</span></label>
                </div>
                
                <div class="flex px-4 border border-slate-600 bg-slate-800 rounded-xl peer-checked:bg-slate-700">
                        <input id="1" type="radio" name="bordered-radio" value="">
                        <label for="1" class="w-full py-4 select-none ms-2 text-md">User Name
                        <br>
                        <span class="text-nowrap">0808-0808-0808 | useremail@mail.com</span></label>
                </div>
                
                <div class="flex px-4 border border-slate-600 bg-slate-800 rounded-xl peer-checked:bg-slate-700">
                        <input id="2" type="radio" name="bordered-radio" value="">
                        <label for="2" class="w-full py-4 select-none ms-2 text-md">User Name
                        <br>
                        <span class="text-nowrap">0808-0808-0808 | useremail@mail.com</span></label>
                </div>
                
                <div class="flex px-4 border border-slate-600 bg-slate-800 rounded-xl peer-checked:bg-slate-700">
                        <input id="3" type="radio" name="bordered-radio" value="">
                        <label for="3" class="w-full py-4 select-none ms-2 text-md">User Name
                        <br>
                        <span class="text-nowrap">0808-0808-0808 | useremail@mail.com</span></label>
                </div>
                
                <div class="flex px-4 border border-slate-600 bg-slate-800 rounded-xl peer-checked:bg-slate-700">
                        <input id="4" type="radio" name="bordered-radio" value="">
                        <label for="4" class="w-full py-4 select-none ms-2 text-md">User Name
                        <br>
                        <span class="text-nowrap">0808-0808-0808 | useremail@mail.com</span></label>
                </div>
                
                <div class="flex px-4 border border-slate-600 bg-slate-800 rounded-xl peer-checked:bg-slate-700">
                        <input id="5" type="radio" name="bordered-radio" value="">
                        <label for="5" class="w-full py-4 select-none ms-2 text-md">User Name
                        <br>
                        <span class="text-nowrap">0808-0808-0808 | useremail@mail.com</span></label>
                </div>
                
            </div>

            <div class="flex flex-row w-full items-center mb-4">
                <label for="pcno" class="w-37">PC # :</label>
                <select id="pcno" name="pcno" class="grow bg-slate-900 p-2 rounded-md">
                    <option value="1" selected>PC #1 (Rp 10.000/hour)</option>
                    <option value="2">PC #2 (Rp 10.000/hour)</option>
                    <option value="3">PC #3 (Rp 4.000/hour)</option>
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