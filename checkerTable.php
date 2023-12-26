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
        $dailyTotalChecked[$day] = 0;
    }
    $goalCount = count($checkerTable['goals']);
    $dayCount = count($weekDays);

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
                    <td class="goal">
                        <?php if ($editable) : ?>
                            <span onClick="editGoal(<?= $checkerTable['id'] ?>, <?= $row ?>)"><?= $goal['goal'] ?></span>
                            <input hidden type="text" value="<?= $goal['goal'] ?>" onChange="updateGoal(<?= $checkerTable['id'] ?>, <?= $row ?>)">
                        <?php else : ?>
                            <span><?= $goal['goal'] ?></span>
                        <?php endif; ?>
                    </td>

                    <?php $goalTotalChecked = 0; ?>
                    <?php foreach ($weekDays as $day => $translation) : ?>
                        <td class="checkbox <?= $today == $day ? 'today' : '' ?>">
                            <label>
                                <input type="checkbox" <?= $goal['days'][$day] ? 'checked' : '' ?>
                                    data-row="<?= $row ?>"
                                    data-day="<?= $day ?>"
                                    onChange="updateCheckbox(<?= $checkerTable['id'] ?>, <?= $row ?>, '<?= $day ?>')">
                                <span class="checkmark" style="--color: <?= $colors[$goal['colorIndex']] ?>"></span>
                            </label>
                        </td>

                        <?php
                            if ($goal['days'][$day])  {
                                $goalTotalChecked++;
                                $dailyTotalChecked[$day]++;
                            }
                        ?>
                    <?php endforeach; ?>

                    <td class="trophy" data-row="<?= $row ?>">
                        <span <?= $goalTotalChecked != $dayCount ? 'hidden' : '' ?> class="goalAward">
                            <img src="img/trophy.svg" alt="trophy">
                        </span>
                        <span <?= $goalTotalChecked == $dayCount ? 'hidden' : '' ?> class="goalStat">
                            <?= floor(($goalTotalChecked / $dayCount) * 100) . '%' ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>

            <tr>
                <td class="newGoal">
                    <?php if ($editable) : ?>
                        <button class="full" onClick="newGoal(<?= $checkerTable['id'] ?>)">Új cél</button>
                        <input hidden type="text" onChange="addGoal(<?= $checkerTable['id'] ?>)">
                    <?php endif; ?>
                </td>
                <?php foreach ($weekDays as $day => $translation) : ?>
                    <td class="medal <?= $today == $day ? 'today' : '' ?>" data-day="<?= $day ?>">
                        <span <?= $dailyTotalChecked[$day] != $goalCount || $goalCount == 0 ? 'hidden' : '' ?> class="dailyAward">
                            <img src="img/medal.svg" alt="medal">
                        </span>
                        <span <?= $dailyTotalChecked[$day] == $goalCount && $goalCount != 0 ? 'hidden' : '' ?> class="dailyStat">
                            <?= $goalCount ? floor(($dailyTotalChecked[$day] / $goalCount) * 100) . '%' : '' ?>
                        </span>
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
