function openDialog(id) {
    const dialog = document.getElementById(id);
    dialog.show();
}

function openDelete(data) {
    const dialog = document.getElementById('dialog-delete');
    const deleted = document.getElementById('del');
    dialog.showModal();
    deleted.value = data;
}

function closeDelete() {
    const dialog = document.getElementById('dialog-delete');
    const deleted = document.getElementById('del');
    dialog.close();
    deleted.value = null;
}

function openExtend(data) {
    const dialog = document.getElementById('hrextend');
    const pcno = document.getElementById('pcnoex');
    dialog.showModal();
    pcno.value = data;
}

function closeExtend() {
    const dialog = document.getElementById('hrextend');
    const pcno = document.getElementById('pcnoex');
    dialog.close();
    pcno.value = null;
}

function hrExtend(btn) {
    const input = document.getElementById('extend');
    var value = input.value;
    btn == 1 ? value++ : value--;
    value < 1 ? value = 1 : value
    input.value = value;
}