<?php
    $getGoldenBorder = true;
    foreach ($checkerTable['goals'] as $goal) {
        foreach ($goal['days'] as $day) {
            if (!$day) {
                $getGoldenBorder = false;
                break;
            }
        }
        if (!$getGoldenBorder) break;
    }

    $getMedal = [];
    foreach ($checkerTable['goals'][0]['days'] as $day => $checked) {
        $getMedal[$day] = true;
    }

    $caption = explode('/', $checkerTable['caption']);
?>

<div class="tableContainer <?= $getGoldenBorder ? 'goldenBorder' : '' ?>" data-id="<?= $checkerTable['id'] ?>">
    <table>
        <caption>
            <div>
                <span><?= $caption[0] ?></span><span><?= $caption[1] . '. hét' ?></span>
            </div>
        </caption>

        <thead>
            <th></th>
            <?php foreach ($checkerTable['goals'][0]['days'] as $day => $checked)  {
                echo '<th'.(($date == $checkerTable['caption'] && $today == $day) ? ' class="today"' : '').'>'.$weekDays[$day].'</th>';
            } ?>
            <th></th>
        </thead>

        <tbody>
            <?php foreach ($checkerTable['goals'] as $row => $goal) : ?>
                <tr>
                    <td class="goal"><?= $goal['goal'] ?></th>

                    <?php $getTrophy = true; ?>
                    <?php foreach ($goal['days'] as $day => $checked) : ?>
                        <td class="checkbox <?= ($date == $checkerTable['caption'] && $today == $day) ? 'today' : '' ?>">
                            <label>
                                <input type="checkbox" <?= $checked ? 'checked' : '' ?>
                                    data-row="<?= $row ?>"
                                    data-day="<?= $day ?>"
                                    onChange="updateCheckbox(<?= $checkerTable['id'] ?>, <?= $row ?>, '<?= $day ?>')">
                                <span class="checkmark" style="--color: <?= $goal['color'] ?>"></span>
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
                <td></td>
                <?php foreach ($checkerTable['goals'][0]['days'] as $day => $checked) : ?>
                    <td class="medal" data-day="<?= $day ?>">
                        <span <?= !$getMedal[$day] ? 'hidden' : '' ?>><img src="img/medal.svg" alt="medal"></span>
                    </td>
                <?php endforeach; ?>
                <td></td>
            </tr>
        </tbody>
    </table>

    <hr>
    <div class="stats">
        Teljesítmény:<h1>100%</h1>
    </div>
</div>
