let editRow = -1;

function editGoal(id, row)
{
    if (editRow == row) return;

    if (editRow != -1) {
        updateGoal(id, editRow);
    }

    editRow = row;

    table = document.querySelector('[data-id="' + id + '"]');
    if (table) {
        td = table.querySelector('tr[data-row="' + row + '"] .goal');
        goalSpan = td.querySelector('span');
        goalInput = td.querySelector('input');
        goalInput.addEventListener('keypress', function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                updateGoal(id, row);
              }
        });

        goalInput.value = goalSpan.innerHTML;

        goalSpan.setAttribute('hidden', '');
        goalInput.removeAttribute('hidden');

        const end = goalInput.value.length;
        goalInput.setSelectionRange(end, end);
        goalInput.focus();
    }
}

function updateGoal(id, row)
{
    table = document.querySelector('[data-id="' + id + '"]');
    if (table) {
        td = table.querySelector('tr[data-row="' + row + '"] .goal');
        goalSpan = td.querySelector('span');
        goalInput = td.querySelector('input');

        goalSpan.innerHTML = goalInput.value;

        goalSpan.removeAttribute('hidden');
        goalInput.setAttribute('hidden', '');
    }

    editRow = -1;
}

function checkEnterOnUpdateGoal(id, row)
{
    table = document.querySelector('[data-id="' + id + '"]');
    if (table) {
        td = table.querySelector('tr[data-row="' + row + '"] .goal');
        goalSpan = td.querySelector('span');
        goalInput = td.querySelector('input');

        goalSpan.innerHTML = goalInput.value;

        goalSpan.removeAttribute('hidden');
        goalInput.setAttribute('hidden', '');
    }

    editRow = -1;
}
