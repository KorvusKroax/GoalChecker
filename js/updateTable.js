function updateCheckbox(id, row, day)
{
    updateDatabase(id, row, day);
    updateMedal(id, day);
    updateTrophy(id, row);
    updateStats(id);
}

function updateDatabase(id, row, day)
{
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'js/updateTable_day.php', false);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('id=' + id + '&row=' + row + '&day=' + day);
}

function updateMedal(id, day)
{
    table = document.querySelector('[data-id="' + id + '"]');
    if (table) {
        dayFull = true;
        table.querySelectorAll('[data-row][data-day="' + day + '"]').forEach((checkbox) => {
            if (!checkbox.checked) dayFull = false;
        });
        medal = table.querySelector('.medal[data-day="' + day + '"] span');
        if (dayFull) medal.removeAttribute('hidden');
        else medal.setAttribute('hidden', '');
    }
}

function updateTrophy(id, row)
{
    table = document.querySelector('[data-id="' + id + '"]');
    if (table) {
        rowFull = true;
        table.querySelectorAll('[data-row="' + row + '"][data-day]').forEach((checkbox) => {
            if (!checkbox.checked) rowFull = false;
        });
        trophy = table.querySelector('.trophy[data-row="' + row + '"] span');
        if (rowFull) trophy.removeAttribute('hidden');
        else trophy.setAttribute('hidden', '');
    }
}

function updateStats(id)
{
    table = document.querySelector('[data-id="' + id + '"]');
    if (table) {
        total = count = 0;
        table.querySelectorAll('[data-row][data-day]').forEach((checkbox) => {
            if (checkbox.checked) total++;
            count++;
        });
        table.querySelector('.stats h1').innerHTML = Math.floor(total / count * 100.0) + '%';

        // golden border
        if (total == count) table.classList.add('goldenBorder');
        else table.classList.remove('goldenBorder');
    }
}
