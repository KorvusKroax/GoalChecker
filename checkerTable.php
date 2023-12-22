<?php
    $totalChecked = $checkboxCount = 0;
    foreach ($checkerTable['goals'] as $goal) {
        foreach ($goal['days'] as $day) {
            if ($day) $totalChecked++;
            $checkboxCount++;
        }
    }
    $getGoldenBorder = $totalChecked == $checkboxCount && $checkboxCount != 0;

    foreach ($weekDays as $day => $translation) {
        $getMedal[$day] = $checkboxCount != 0;
    }

    $caption = explode('/', $checkerTable['caption']);
?>



<div class="tableContainer <?= $getGoldenBorder ? 'goldenBorder' : '' ?> <?= $editable ? 'editable' : '' ?>" data-id="<?= $checkerTable['id'] ?>">
    <table>
        <caption>
            <div>
                <span><?= $caption[0] ?></span><span><?= $caption[1] . '. hét' ?></span>
            </div>
        </caption>

        <thead>
            <th></th>
            <?php foreach ($weekDays as $day => $translation)  {
                echo '<th'.($today == $day ? ' class="today"' : '').'>'.$translation.'</th>';
            } ?>
            <th></th>
        </thead>

        <tbody>
            <?php foreach ($checkerTable['goals'] as $row => $goal) : ?>
                <tr data-row="<?= $row ?>">
                    <td class="goal" onClick="editGoal(<?= $checkerTable['id'] ?>, <?= $row ?>)">
                        <span><?= $goal['goal'] ?></span>
                        <input hidden type="text" value="<?= $goal['goal'] ?>" onChange="updateGoal(<?= $checkerTable['id'] ?>, <?= $row ?>)">
                    </td>

                    <?php $getTrophy = true; ?>
                    <?php foreach ($goal['days'] as $day => $checked) : ?>
                        <td class="checkbox <?= $today == $day ? 'today' : '' ?>">
                            <label>
                                <input type="checkbox" <?= $checked ? 'checked' : '' ?>
                                    data-row="<?= $row ?>"
                                    data-day="<?= $day ?>"
                                    onChange="updateCheckbox(<?= $checkerTable['id'] ?>, <?= $row ?>, '<?= $day ?>')">
                                <span class="checkmark" style="--color: <?= $colors[$goal['colorIndex']] ?>"></span>
                            </label>
                        </td>

                        <?php
                            $getTrophy = $getTrophy && $checked;
                            $getMedal[$day] = $getMedal[$day] && $checked;
                        ?>
                    <?php endforeach; ?>

                    <td class="trophy" data-row="<?= $row ?>">
                        <span <?= !$getTrophy ? 'hidden' : '' ?>><img src="img/trophy.svg" alt="trophy"></span>
                    </td>
                </tr>
            <?php endforeach; ?>

            <tr>
                <td class="newGoal">
                    <button <?= !$editable ? 'hidden' : '' ?> class="full" onClick="newGoal(<?= $checkerTable['id'] ?>)">Új cél</button>
                    <input hidden type="text" onChange="addGoal(<?= $checkerTable['id'] ?>)">
                </td>
                <?php foreach ($weekDays as $day => $translation) : ?>
                    <td class="medal <?= $today == $day ? 'today' : '' ?>" data-day="<?= $day ?>">
                        <span <?= !$getMedal[$day] ? 'hidden' : '' ?>><img src="img/medal.svg" alt="medal"></span>
                    </td>
                <?php endforeach; ?>
                <td></td>
            </tr>
        </tbody>
    </table>

    <hr>
    <div class="stats">
        Teljesítmény:<h1><?= $checkboxCount ? floor(($totalChecked / $checkboxCount) * 100) : 0 ?>%</h1>
    </div>
</div>
