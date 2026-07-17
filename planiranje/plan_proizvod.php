<style>

    .flex-container {
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        flex-flow:row;
        height:100%;
        position:absolute;
        width:100%;
        /*flex-wrap:wrap;*/
    }
    .box {
        padding: 5px;
        color:white;
        font-size:14px;
        /*  background-color: crimson; */
        /* border: 1px solid white; */
        border-top: 1px solid #ddd;
        flex:1;
        -webkit-flex:1;
        text-align:center;
        min-width:300px;
        max-width: 300px;
        border-left: 1px solid #ddd;
    }
    /*
    .box:first-child {
        border-left: 1px solid #FFF;
    }
    */

    .zWrapper {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .zWrapper>.z-content {
        position: absolute;
        overflow: scroll;
        overflow-x: scroll;
        overflow-y: hidden;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0px;
    }
    .boxTitle {
        height: 24px;
        word-wrap: break-word;
        overflow: hidden;
    }
    .boxList {
        overflow: hidden;
        overflow-y: hidden;
        height: 100%;
        padding-bottom: 124px;
        color: #000;
        text-align: left;
    }

    .boxSideBar {
        padding: 5px;
        color: #000;
        font-size:14px;
        /*  background-color: crimson; */
        border:1px solid white;
        flex:1;
        -webkit-flex:1;
        min-width:280px;
        max-width: 280px;
        /* border-left: 1px solid #ddd; */
        border-right: 1px solid #ddd;
    }

    .sideBar {
        width: 280px;
        height: 100%;
        border-right: 1px solid #ddd;
    }

    .eProizvod {
        width: 289px;
        height: 20px;
        background-color: #ddd;
        position: absolute;
        top: 40px;
        left: 6px;
        font-size: 10px;
        overflow: hidden;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: left;
        /* vertical-align: middle; */
        line-height: 20px;
        padding: 0px;
        padding-left: 2px;
        border-radius: 10px;
    }

    .eProizvod:hover {
        background-color: #baf7ba;
        cursor: pointer;
    }
    .eProizvod:active {
        background-color: #89f54f;
    }
    .eProizvod.active {
        background-color: #89f54f;
    }
    .eProizvod.parent {
        background-color: #b4d5fd;
    }

    .svgLine{
        position: absolute;
        top: 0;
        left: 0;
        width: 25px;
        height: 25px;
    }

    .svgLine.line{
        stroke-width:2px;
        stroke:rgb(0,0,0);
    }
</style>

<!--
<script src="<?= $js_url; ?>/leader-line.min.js"></script>
-->

<?
if (count($arr) == 0) {
    ?>

    <div class="text-center">
        <img src="<?= $public_url; ?>/img/teleskop.png"><br>
        <span style="font-size: 14px; font-weight: bold">Potrebno je da izaberete proizvod</span>
    </div>
    <?
}
?>

<div class="zWrapper">

    <div class="z-content scrollSync">
        <div class="flex-container">
            <?
            $lastProizvod = null;
            $n = 0;
            $left = 6;
            foreach ($arr as $key => $aProces) {
                $n++;
                #  #52664d;
                $bgColor = '52664d'; // isset($arrOdeljenjeProcesBoja[$o->proces]) ? $arrOdeljenjeProcesBoja[$o->proces]['boja'] : "52664d";
                $color = 'FFFFFF'; //  isset($arrOdeljenjeProcesBoja[$o->proces]) ? $arrOdeljenjeProcesBoja[$o->proces]['text'] : "FFFFFF";

                $bgColor = isset($arrOdeljenjeProcesBoja[$aProces['proces']]) ? $arrOdeljenjeProcesBoja[$aProces['proces']]['boja'] : "52664d";
                $color = isset($arrOdeljenjeProcesBoja[$aProces['proces']]) ? $arrOdeljenjeProcesBoja[$aProces['proces']]['text'] : "FFFFFF";
                ?>
                <div class="box status">
                    <div class="boxTitle" style="color: <?= "#" . $color; ?>;
                         background-color: <?= "#" . $bgColor; ?>; position: relative;" title="<?= trim($aProces['proces_naziv']); ?>"><?= trim($aProces['proces_naziv']); ?>
                         <?
                         if ($aProces['kalo'] > 0) {
                             ?>
                            <div class="badge badge-mini badge-info pull-right" style="position: absolute; right: 2px; top: 3px; border: 1px solid #ddd;" title="Kalo procesa"><?= $aProces['kalo']; ?>%</div>
                        <? }
                        ?>
                    </div>

                    <div class="boxList" id="procesList_<?= $aProces['proces']; ?>" style="overflow-y: hidden;">

                        <?
                        # echo "proces: " . PHP_EOL;
                        if (!isset($arrProcesProizvod[$aProces['proces']]))
                            continue;

                        $top = 40;
                        foreach ($arrProcesProizvod[$aProces['proces']] as $keyNalog => $aNalog) {
                            ?>

                            <?
                            $n = 0;
                            foreach ($aNalog['proizvod'] as $keyPro => $oProizvod) {
                                $n++;
                                $statusIco = "";
                                $statusColor = "";

                                if ($oProizvod->parent > 0) {
                                    /*
                                      ?>
                                      <svg class="svgLine" id="svg_<?= $oProizvod->id; ?>">
                                      <line class="line"/>
                                      </svg>
                                      <?
                                     * 
                                     */
                                }
                                ?>
                                <div class="eProizvod" id="pro_<?= $oProizvod->id; ?>" parent="<?= $oProizvod->parent_artikal; ?>" data-nalog="<?= $oProizvod->nalog; ?>" data-proizvod="<?= $oProizvod->proizvod; ?>" data-proces="<?= $oProizvod->proces; ?>" data-nalog-broj="<?= $oProizvod->nalog_broj; ?>" data-nalog-parent="<?= $oProizvod->nalog_parent; ?>" style="left: <?= $left; ?>px ; top: <?= $top; ?>px ;">
                                    <span style="padding-left:2px;">#<?= $oProizvod->nalog_broj; ?> (<b><?= $oProizvod->artikal; ?></b>) <?= $oProizvod->nusproizvod == 1 ? '<i class="text-danger" title="Nusproizvod">#</i> ' : ''; ?><?= $oProizvod->artikal_naziv; ?></span>
                                    <div style="position: absolute; width:48px; top:0px; right: 2px; text-align: right;">
                                        <div class="badge badge-mini"><?= kolicinaString($oProizvod->kolicina); ?></div>
                                    </div>
                                    <?
                                    if (isset($arrStatsPredajnice[$oProizvod->proces][$oProizvod->artikal])) {

                                        $kolRn = $arrStatsPredajnice[$oProizvod->proces][$oProizvod->artikal];
                                        $proc = procenat($kolRn, $oProizvod->kolicina, 0);
                                        $procOrigin = $proc;
                                        $proc = $proc > 100 ? 100 : $proc;

                                        if ($proc == 100) {
                                            $procCls = "progress-bar-success";
                                        } else if ($proc < 20) {
                                            $procCls = "progress-bar-danger";
                                        } else {
                                            $procCls = "progress-bar-warning";
                                        }

                                        # error_log("# stats: kolRn: $kolRn kolPl: " . $oProizvod->kolicina . " proc: $proc");
                                        ?>

                                        <div class="progress" style="height: 12px;margin-bottom: 5px;width: 98%;position: absolute;bottom: -14px;" title="<?= "Količina naloga: " . kolicinaString($kolRn) . " Ostvarenje: $procOrigin%"; ?>">
                                            <div class="progress-bar <?= $procCls; ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $proc; ?>%; text-align: left; padding-left: 4px; font-size: 8px;">
                                            </div>
                                        </div>
                                        <?
                                    }
                                    ?>
                                    <!--
                                    -->
                                </div>
                                <?
                                $top += 40;
                            }
                            ?>
                            <?
                        }
                        ?>

                    </div>

                </div>
                <?
                $left += 300;
            }
            ?>
        </div>

    </div>
</div>


<script>

    var lines = [];

    (function ($) {
<?
/*
  foreach ($arr as $key => $aProces) {
  if (!isset($arrProcesProizvod[$aProces['proces']]))
  continue;

  foreach ($arrProcesProizvod[$aProces['proces']] as $keyNalog => $aNalog) {
  $n = 0;
  foreach ($aNalog['proizvod'] as $keyPro => $oProizvod) {
  $n++;
  $startSocket = $n == 1 ? "right" : "bottom";
  if ($oProizvod->parent > 0) {
  ?>
  lines.push(new LeaderLine(
  LeaderLine.mouseHoverAnchor(document.getElementById('pro_<?= $oProizvod->id; ?>'), 'draw', {style: {backgroundImage: null}}),
  document.getElementById('pro_<?= $oProizvod->parent; ?>')
  ));

  <?
  }
  }
  }
  } */
?>
        zWrapperResize();

        $(window).resize(function () {
            zWrapperResize();
        });
        /*
         document.addEventListener('scroll', function (event) {
         lines.forEach(function (line) {
         line.position()
         })
         }, true);
         */
    })(jQuery);

    function zWrapperResize() {
        // var ot = $(".zWrapper").offset();
        // var top = ot === undefined ? 0 : ot.top;
        // $(".zWrapper").height($(".topHolder").height() - top);
        $(".zWrapper").height($(".topHolder").height());


        var vh = $(".topHolder").height();// - (parseFloat($(".boxList").offset().top) + 35);
        $(".boxList").css({"height": vh})
    }
</script>