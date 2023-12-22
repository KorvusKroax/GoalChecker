let editRow = -1;

function editGoal(id, row)
{
    if (editRow == row) return;
    if (editRow != -1) {
        updateGoal(id, editRow);
    }

    editRow = row;

    table = document.querySelector('[data-id="' + id + '"] table');
    if (table) {
        td = table.querySelector('tr[data-row="' + row + '"] .goal');
        goalSpan = td.querySelector('span');
        goalSpan.setAttribute('hidden', '');
        goalInput = td.querySelector('input');
        goalInput.removeAttribute('hidden');

        goalInput.value = goalSpan.innerHTML;

        const end = goalInput.value.length;
        goalInput.setSelectionRange(end, end);
        goalInput.focus();

        goalInput.addEventListener('keypress', function(event) {
            if (goalInput.value == '' && event.key === 'Enter') {
                event.preventDefault();
                updateGoal(id, row);
            }
        });
    }
}

function updateGoal(id, row)
{
    table = document.querySelector('[data-id="' + id + '"] table');
    if (table) {
        td = table.querySelector('tr[data-row="' + row + '"] .goal');
        goalSpan = td.querySelector('span');
        goalSpan.removeAttribute('hidden');
        goalInput = td.querySelector('input');
        goalInput.setAttribute('hidden', '');

        if (goalInput.value != '') {
            goalSpan.innerHTML = goalInput.value;
            updateDatabase_goal(id, row, goalInput.value);
        } else {
            tr = table.querySelector('tr[data-row="' + row + '"]');
            if (tr != null) {
                table.deleteRow(tr.rowIndex);
                updateDatabase_delete(id, row);
                updateAllMedals(id);
                updateStats(id);
            }
        }
    }

    editRow = -1;
}

function updateDatabase_goal(id, row, goal)
{
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'js/db_updateTable_goal.php', false);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('id=' + id + '&row=' + row + '&goal=' + goal);
}

function updateDatabase_delete(id, row)
{
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'js/db_updateTable_delete.php', false);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('id=' + id + '&row=' + row);
}

function newGoal(id)
{
    table = document.querySelector('[data-id="' + id + '"] table');
    if (table) {
        td = table.querySelector('.tableContainer.editable .newGoal');
        goalButton = td.querySelector('button');
        goalButton.setAttribute('hidden', '');
        goalInput = td.querySelector('input');
        goalInput.removeAttribute('hidden');

        goalInput.value = ''

        goalInput.focus();

        goalInput.addEventListener('keypress', function(event) {
            if (goalInput.value == '' && event.key === 'Enter') {
                event.preventDefault();
                addGoal(id);
            }
        });
    }
}

function addGoal(id)
{
    table = document.querySelector('[data-id="' + id + '"] table');
    if (table) {
        td = table.querySelector('.tableContainer.editable .newGoal');
        goalButton = td.querySelector('button');
        goalButton.removeAttribute('hidden');
        goalInput = td.querySelector('input');
        goalInput.setAttribute('hidden', '');

        if (goalInput.value != '') {

            // insert new goal to the table

            updateDatabase_newGoal(id, goalInput.value);
            updateAllMedals(id);
            updateStats(id);
        }
    }
}

function updateDatabase_newGoal(id, goal)
{
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'js/db_updateTable_newGoal.php', false);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('id=' + id + '&goal=' + goal);
}
