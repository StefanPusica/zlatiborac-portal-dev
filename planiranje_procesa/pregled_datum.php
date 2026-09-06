<div class="mFlexBox status locked" style="<?= $isWeekend ? "min-width: 160px;max-width: 160px;" : ''; ?>">
    <div class="boxTitle" style="background-color: <?= $color; ?>;">
        <span><?= Datum::stamp2date($date); ?></span>
        <button class="btnLock">
            <i class="glyphicon glyphicon-lock ico-lock"></i>
            <i class="glyphicon glyphicon-pencil ico-unlock"></i>
        </button>
    </div>

    <div class="boxList" id="statusList_<?= $date; ?>" style="position:relative; overflow-y: scroll;" data-datum="<?= $date; ?>">
        <?
        $arrRN = isset($arr[$date]) ? $arr[$date] : [];
        foreach ($arrRN as $keyRN => $o) {
            $status = 0;
            $icoStatus = "";
            $btnColor = "";
        ?>
            <div class="processItem">
                <? include 'pregled_process_item.php'; ?>
            </div>
            <?
        }

        for ($h = 0; $h < 24; $h++) {
            for ($m = 0; $m < 60; $m += 15) {
                $timeStr = sprintf('%02d:%02d', $h, $m);
                $slotTs = strtotime($date . ' ' . $timeStr . ':00');
            ?>
                <div class="timeSlotRow<?= $m === 0 ? ' timeSlotHour' : ''; ?>" data-timestamp="<?= $slotTs; ?>">
                    <div class="timeLabel"><?= $timeStr; ?></div>
                    <div class="timeContent"></div>
                </div>
        <?
            }
        }
        ?>
    </div>

</div>