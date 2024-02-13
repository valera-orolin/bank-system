document.addEventListener('DOMContentLoaded', (event) => {
    var rows = document.querySelectorAll("tr.border-b.hidden");
    rows.forEach((row) => {
        row.style.display = 'none';
    });

    var buttons = document.querySelectorAll(".text-green-500");
    buttons.forEach((button) => {
        button.addEventListener('click', function() {
            var parentRow = this.parentNode.parentNode;
            var nextRow = parentRow.nextElementSibling;
            if (nextRow.style.display === 'none') {
                nextRow.style.display = 'table-row';
            } else {
                nextRow.style.display = 'none';
            }
        });
    });
});