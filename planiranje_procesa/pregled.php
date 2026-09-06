<div class="mFlexWrapper">
    <div class="mFlexContent">
        <div class="mFlexContainer linijaProcesi">

            <?
            $mcolor = "#536a7d"; //: "#3e5083";
            $arrDates = Datum::dateRange($start, $kraj, "+1 day", "Y-m-d");
            foreach ($arrDates as $key => $date) {

                $isWeekend = Datum::isWeekend($date, false);
                $color = $isWeekend ? "#7d5353" : $mcolor;

                include 'pregled_datum.php';
            }
            ?>

        </div>
    </div>
</div>