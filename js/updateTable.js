function updateCheckbox(id, row, day)
{
    updateDatabase_day(id, row, day);
    updateMedal(id, day);
    updateTrophy(id, row);
    updateStats(id);
}

function updateDatabase_day(id, row, day)
{
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'js/db_updateTable_day.php', false);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('id=' + id + '&row=' + row + '&day=' + day);
}

function updateMedal(id, day)
{
    table = document.querySelector('[data-id="' + id + '"] table');
    if (table) {
        total = count = 0;
        table.querySelectorAll('[data-row][data-day="' + day + '"]').forEach((checkbox) => {
            if (checkbox.checked) total++;
            count++;
        });

        dailyAward = table.querySelector('.medal[data-day="' + day + '"] .dailyAward');
        dailyStat = table.querySelector('.medal[data-day="' + day + '"] .dailyStat');
        if (total == count && count != 0) {
            dailyAward.removeAttribute('hidden');
            dailyStat.setAttribute('hidden', '');
        } else {
            dailyAward.setAttribute('hidden', '');
            dailyStat.removeAttribute('hidden');
            dailyStat.innerHTML = Math.floor(total / count * 100.0) + '%';
        }
    }
}

function updateTrophy(id, row)
{
    table = document.querySelector('[data-id="' + id + '"] table');
    if (table) {
        total = count = 0;
        table.querySelectorAll('[data-row="' + row + '"][data-day]').forEach((checkbox) => {
            if (checkbox.checked) total++;
            count++;
        });

        goalAward = table.querySelector('.trophy[data-row="' + row + '"] .goalAward');
        goalStat = table.querySelector('.trophy[data-row="' + row + '"] .goalStat');
        if (total == count && count != 0) {
            goalAward.removeAttribute('hidden');
            goalStat.setAttribute('hidden', '');
        } else {
            goalAward.setAttribute('hidden', '');
            goalStat.removeAttribute('hidden');
            goalStat.innerHTML = Math.floor(total / count * 100.0) + '%';
        }
    }
}

function updateStats(id)
{
    tableContainer = document.querySelector('[data-id="' + id + '"]');
    if (tableContainer) {
        total = count = 0;
        tableContainer.querySelectorAll('table [data-row][data-day]').forEach((checkbox) => {
            if (checkbox.checked) total++;
            count++;
        });
        tableContainer.querySelector('.stats h1').innerHTML = Math.floor(total / count * 100.0) + '%';

        // golden border
        if (total == count && count != 0) tableContainer.classList.add('goldenBorder');
        else tableContainer.classList.remove('goldenBorder');
    }
}
