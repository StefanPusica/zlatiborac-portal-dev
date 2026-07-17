<style>

    ul.mUl {

        list-style: none;
        display: flex;
        justify-content: space-around;
        margin: 0px;
        padding: 0px;
    }

    ul.mUl > li {
        list-style-type: none;
        font-size: small;
    }

    ul.mUl > li:before {
        margin-right:     0.5em;
        width:            0.7em;
        height:           0.7em;
        display:          inline-block;
        vertical-align:   middle;
        border-radius: 50%;
        background-color: orange;
        content:          ' '
    }
</style>

<div class="mFlexWrapper">
    <div class="mFlexContent">
        <div class="mFlexContainer linijaProcesi">

            <?
            $mcolor = "#536a7d"; //: "#3e5083";
            $arrDates = Datum::dateRange($start, $kraj, "+1 day", "Y-m-d");
            foreach ($arrDates as $key => $date) {

                $isWeekend = Datum::isWeekend($date, false);
                $color = $isWeekend ? "#7d5353" : $mcolor;
                ?>

                <div class="mFlexBox status" style="<?= $isWeekend ? "min-width: 160px;max-width: 160px;" : ''; ?>">
                    <div class="boxTitle" style="background-color: <?= $color; ?> ;" title=""><?= Datum::stamp2date($date); ?></div>

                    <div style="margin-bottom: 5px; border-bottom: 1px dotted #ddd;color: #000; text-align: left; font-size: 12px;">
                        <!-- <i class="glyphicon glyphicon-cog"></i> Podešavanja -->
                    </div>

                    <div class="boxList" id="statusList_<?= $date; ?>" style="position:relative; overflow-y: scroll;" data-datum="<?= $date; ?>">
                        <?
                        $arrRN = isset($arr[$date]) ? $arr[$date] : [];

                        foreach ($arrRN as $keyRN => $o) {

                            #$mContent = trim($o->sadrzaj);
                            #$aContent = empty($mContent) ? [] : json_decode($mContent, true);

                            $status = 0; // $o->status;

                            $icoStatus = ""; // $o->status == 0 ? "icon-cogs2" : "";
                            $icoStatus = ""; // $o->status == 30 ? "icon-check-circle" : $icoStatus;

                            $btnColor = ""; // $o->status == 0 ? "btn-default" : "";
                            $btnColor = ""; // $o->status == 30 ? "btn-success" : $btnColor;
                            ?>
                            <div class="text-info" style="font-size:10px; padding-bottom: 10px;">
                                <table class="table table-hover table-condensed table-striped" style="">
                                    <tr>
                                        <td class="" style="font-size: 10px;padding-bottom: 1px; <?= $status == 30 ? 'border-top-color: #20c720;' : ''; ?>">
                                            <div style="margin-bottom: 4px; height: auto; display: flex;">
                                                <div style="flex: 1 1 266px; cursor: pointer;" class="btnArtikalInfo" data-row="<?= $o->id; ?>"><b><?= $o->artikal; ?></b> - <?= trim($o->artikal_naziv); ?></div>
                                                <div style="flex: 1 1 20px;text-align: right;">
                                                    <button class="btn btn-xs btn-mini <?= $btnColor; ?> btnArtikalStatus" data-row="<?= $o->id; ?>" data-plan="<?= $o->plan; ?>" data-artikal="<?= $o->artikal; ?>" style="padding: 0px 4px;"><i class="<?= $icoStatus; ?>"></i></button>
                                                </div>
                                            </div>
                                            <div style="flex: 1 1 266px; cursor: pointer;" data-row="<?= $o->id; ?>">količina: <b><?= $o->kolicina; ?></b></div>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                            <?
                        }
                        ?>
                    </div>

                </div>

                <?
            }
            ?>

        </div>
    </div>
</div>