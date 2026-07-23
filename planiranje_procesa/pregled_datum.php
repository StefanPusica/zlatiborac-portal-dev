<div class="mFlexBox status" style="<?= $isWeekend ? "min-width: 160px;max-width: 160px;" : ''; ?>">
    <div class="boxTitle" style="background-color: <?= $color; ?> ;" title=""><?= Datum::stamp2date($date); ?></div>

    <div style="margin-bottom: 5px; border-bottom: 1px dotted #ddd;color: #000; text-align: left; font-size: 12px;">
        <!-- <i class="glyphicon glyphicon-cog"></i> Podešavanja -->
    </div>

    <div class="boxList" id="statusList_<?= $date; ?>" style="position:relative; overflow-y: scroll;" data-datum="<?= $date; ?>">
        <?
        $arrRN = isset($arr[$date]) ? $arr[$date] : [];

        foreach ($arrRN as $keyRN => $o) {

            $status = 0;
            $icoStatus = "";
            $btnColor = "";

            include 'pregled_process_item.php';
        }
        ?>
    </div>

</div>
