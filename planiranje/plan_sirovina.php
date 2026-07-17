<style>

    .zSirWrapper {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .zSirWrapper>.z-content-sir {
        position: absolute;
        overflow-x: hidden;
        overflow-y: hidden;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0px;
    }
    .boxCommand {
        padding: 0px;
        color:white;
        font-size:11px;
        /*  background-color: crimson; */
        border:1px solid white;
        flex:1;
        -webkit-flex:1;
        text-align:center;
        min-width:300px;
        max-width: 300px;
        border-left: 1px solid #ddd;
    }

    .boxCommand:first-child {
        border-left: 1px solid #FFF;
    }

    .boxCommandList {
        overflow: hidden;
        overflow-y: hidden;
        height: 100%;
        padding-bottom: 1px;
        color: #000;
        text-align: left;
    }
    .boxCommandTitle {
        height: 20px;
        word-wrap: break-word;
        overflow: hidden;
        line-height: 20px;
        padding-left: 4px;
    }


    .btnConnector {
        padding: 0px 4px 0px 4px;
        float: right;
        margin: 1px 1px 0px 0px;
    }

    .btnVezaNalog {
        padding: 0px 4px 0px 4px;
        float: right;
        margin: 1px 1px 0px 0px;
    }


    .btnVirtualniNalog {
        padding: 0px 4px 0px 4px;
        float: right;
        margin: 1px 1px 0px 0px;
    }
</style>

<?
if (count($arr) == 0) {
    ?>

    <div class="text-center" style="background-image: url(<?= $public_url; ?>/img/patern-1.png);
         background-size: contain;
         height: 100%;">
    </div>
    <?
}
?>

<div class="zSirWrapper">

    <div class="z-content-sir scrollSync">
        <div class="flex-container">
            <?
            $lastProizvod = null;
            $n = 0;
            foreach ($arr as $key => $aProces) {
                $n++;
                #  #52664d;
                $bgColor = '52664d'; // isset($arrOdeljenjeProcesBoja[$o->proces]) ? $arrOdeljenjeProcesBoja[$o->proces]['boja'] : "52664d";
                $color = 'FFFFFF'; //  isset($arrOdeljenjeProcesBoja[$o->proces]) ? $arrOdeljenjeProcesBoja[$o->proces]['text'] : "FFFFFF";


                $bgColor = isset($arrOdeljenjeProcesBoja[$aProces['proces']]) ? $arrOdeljenjeProcesBoja[$aProces['proces']]['boja'] : "52664d";
                $color = isset($arrOdeljenjeProcesBoja[$aProces['proces']]) ? $arrOdeljenjeProcesBoja[$aProces['proces']]['text'] : "FFFFFF";
                ?>
                <div class="boxCommand status">

                    <div class="boxCommandList" id="commandProces_<?= $aProces['proces']; ?>" style="overflow-y: scroll;">

                        <?
                        # echo "proces: " . PHP_EOL;
                        if (!isset($arrProcesSirovina[$aProces['proces']]))
                            continue;

                        foreach ($arrProcesSirovina[$aProces['proces']] as $keyNalog => $aNalog) {
                            ?>
                            <div class="boxCommandTitle" style="color: <?= "#" . $color; ?>;
                                 background-color: <?= "#" . $bgColor; ?>;" title=""># <?= trim($aNalog['broj']); ?>

                                <?
                                if ($pravoUpravljanja) {
                                    ?>
                                    <button class="btn btn-xs btn-warning btnVirtualniNalog" title="Formiranje radnog naloga" data-nalog="<?= $aNalog['sifra']; ?>" data-proces="<?= $aProces['proces']; ?>"><i class="icon-quill"></i></button>  

                                    <button class="btn btn-xs btn-info btnConnector" data-nalog="<?= $aNalog['sifra']; ?>" data-proces="<?= $aProces['proces']; ?>" title="Povezivanje sa radnim nalogom iz proizvodnje"><i class="icon-paperclip"></i></button>
                                    <?
                                }
                                ?>
                                <?
                                if (isset($arrVeza[$aNalog['sifra']])) {
                                    $vezaNalog = $arrVeza[$aNalog['sifra']];
                                    ?>
                                    <button class="btn btn-xs btn-success btnVezaNalog" data-nalog="<?= $vezaNalog; ?>" data-nalog-sifra="<?= $aNalog['sifra']; ?>" title="Povezani radni nalog"><i class="icon-cogs"></i></button>
                                    <?
                                }
                                ?>
                            </div>

                            <table class="table table-hover table-condensed table-striped">
                                <thead>
                                <th width="30">Artikal</th>
                                <th width="">Naziv</th>
                                <th width="60">Količina</th>
                                </thead>
                                <tbody>
                                    <?
                                    $n = 0;

                                    $aNotExist = [];
                                    $arrProc = isset($arrStats[$aProces['proces']][$aNalog['sifra']]) ? $arrStats[$aProces['proces']][$aNalog['sifra']] : [];
                                    foreach ($arrProc as $keyArt => $aRow) {
                                        # if(!isset($aNalog['sirovina']))
                                        $llFound = false;
                                        foreach ($aNalog['sirovina'] as $keySir => $oSirovina) {
                                            if ($keyArt == $oSirovina->artikal) {
                                                $llFound = true;
                                                continue;
                                            }
                                        }
                                        if (!$llFound)
                                            $aNotExist[$keyArt] = $aRow;
                                    }

                                    foreach ($aNotExist as $key => $aRow) {
                                        ?>
                                        <tr class="">
                                            <td class="text-danger eSirovina"><?= $key; ?></td>
                                            <td class="text-danger eSirovina"><?= $aRow['naziv']; ?></td>
                                            <td class="text-danger eSirovina text-right"><?= kolicinaString($aRow['kolicina']); ?><? ?></td>
                                        </tr>
                                        <?
                                    }

                                    foreach ($aNalog['sirovina'] as $keySir => $oSirovina) {
                                        $n++;
                                        $statusIco = "";
                                        $statusColor = "";

                                        $rnKol = isset($arrStats[$aProces['proces']][$aNalog['sifra']][$oSirovina->artikal]) ? $arrStats[$aProces['proces']][$aNalog['sifra']][$oSirovina->artikal]['kolicina'] : 0;

                                        $badge = $rnKol == $oSirovina->kolicina ? "badge-success" : "";
                                        $badge = $rnKol > $oSirovina->kolicina ? "badge-error" : $badge;
                                        $badge = $rnKol < $oSirovina->kolicina ? "badge-warning" : $badge;
                                        ?>
                                        <tr class="" data-row="<?= ($oSirovina->id); ?>" data-nalog="<?= $oSirovina->zakljucan == 1 ? 0 : $oSirovina->nalog; ?>">
                                            <td class="pointer rowClick eSirovina eArtSirovina <?= $oSirovina->zakljucan == 1 ? "font-bold text-info" : ""; ?>"><?= $oSirovina->artikal; ?></td>
                                            <td class="pointer rowClick eSirovina <?= $oSirovina->zakljucan == 1 ? "font-bold text-info" : ""; ?>"><?= $oSirovina->artikal_naziv; ?></td>
                                            <td class="pointer rowClick eSirovina text-right"><?= kolicinaString($oSirovina->kolicina); ?><?= $rnKol == 0 ? " <i class='icon-warning text-danger'></i>" : ""; ?><?
                                                if ($rnKol > 0) {
                                                    ?>
                                                    <div class="badge badge-mini <?= $badge; ?>"><?= kolicinaString($rnKol); ?></div>                                                   
                                                    <?
                                                }
                                                ?></td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <br/>
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


<script>


    (function ($) {

        zSirWrapperResize();

        $(window).resize(function () {
            zSirWrapperResize();
        });

    })(jQuery);

    function zSirWrapperResize() {
        // var ot = $(".zSirWrapper").offset();
        // var top = ot === undefined ? 0 : ot.top;
        // $(".zWrapper").height($(".topHolder").height() - top);
        $(".zSirWrapper").height($(".commandHolder").height());


        // var vh = $(".commandHolder").height();// - (parseFloat($(".boxList").offset().top) + 35);
        // $(".boxList").css({"height": vh})
    }
</script>