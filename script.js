// Had function katjib lcheckboxes li selectionnaw m3a lclick.
const getSelectedCheckboxes = () => {
    return document.querySelectorAll('input[type="checkbox"]:checked');
};
//Hadi function kaydir redirect l'utilisateur l page "editer.php" b l'id dyal lrow li selectionnaha.
// Bach tkon ha function kat3awed fach utilisatuer ghadi idit row wahda b selection wahda.
const editRow = () => {
    const selectedCheckboxes = getSelectedCheckboxes();

    if (selectedCheckboxes.length !== 1) {
        alert("Please select one and only one row to edit.");
        return;
    }

    const index = selectedCheckboxes[0].getAttribute('data-index');

    window.location.href = `editer.php?id=${index}`;
};
// Had function t3awed selected IDs dyal lrows li selectionnaw 
//m3a lclick. Ghadi tb9a l id dyal kola row f url
function deleteRows() {
    var selectedIds = [];
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');

    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            var index = checkbox.getAttribute('data-index');
            selectedIds.push(index);
        }
    });

    const link = 'index.php?ids=' + selectedIds.join('-');

    window.location.href = link;
}
// Had function katjib 3adad dyal lcheckboxes li selectionnaw.
const getNumberOfSelectedLines = () => {
    return getSelectedCheckboxs().length;
};
//Had function ghadi t3awed fach kayna wahda row selectionnaw ola la.
const isOneLineSelected = () => {
    return getNumberOfSelectedLines() === 1;
};
// Had function kat3awed l rows li selectionnaw o tmas7o b confirmation mn l'utilisateur.
const deleteSelectedRows = () => {
    const selectedCheckboxes = getSelectedCheckboxs();
    if (selectedCheckboxes.length === 0) {
        alert("Please select at least one row to delete.");
        return;
    }

    const confirmation = confirm("Are you sure you want to delete the selected rows?");
    if (confirmation) {
        selectedCheckboxes.forEach((checkbox) => {
            checkbox.closest("tr").remove();
    });
}
};
