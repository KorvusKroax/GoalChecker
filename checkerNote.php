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



<div class="checkerNote">
    <div class="noteCaption">
        <span><?= $caption[0] ?></span>
        <span><?= $caption[1] . '. hét' ?></span>
    </div>
    <div class="noteGrid">

        <span></span>
        <?php foreach ($weekDays as $day => $translation)  {
            echo '<span class="weekDay'.($today == $day ? ' today' : '').'">'.$translation.'</span>';
        } ?>
        <span></span>


        <span class="dailyGoals">első napi cél</span>
        <span class="checkbox rotated"></span>
        <span class="checkbox"></span>
        <span class="checkbox rotated"></span>
        <span class="checkbox rotated"></span>
        <span class="checkbox"></span>
        <span class="checkbox rotated"></span>
        <span class="checkbox"></span>
        <span class="dailyPercent">
            10%
        </span>

        <span class="dailyGoals">második napi cél</span>
        <span class="checkbox"></span>
        <span class="checkbox rotated"></span>
        <span class="checkbox"></span>
        <span class="checkbox rotated"></span>
        <span class="checkbox"></span>
        <span class="checkbox rotated"></span>
        <span class="checkbox"></span>
        <span class="dailyPercent">
            99%
        </span>

        <span class="dailyGoals">sokadik napi cél</span>
        <span class="checkbox"></span>
        <span class="checkbox"></span>
        <span class="checkbox rotated"></span>
        <span class="checkbox"></span>
        <span class="checkbox rotated"></span>
        <span class="checkbox"></span>
        <span class="checkbox rotated"></span>
        <span class="dailyPercent">
            0%
        </span>

    </div>

</div>
