
<?
if ($nalog > 0) {
    ?>

    <div class="text-info" style="line-height: 30px; padding-left: 4px;">Gledate podatke sa filterom
        <button class="btn btn-xs pull-right btnHideSirFilter btn-default" data-proces='<?= $proces; ?>' data-proizvod='<?= $proizvod; ?>' data-nalog='<?= $nalog; ?>' style="padding: 2px 4px 2px 4px;margin-top: 4px;margin-right: 2px;"><i class="icon-close"></i></button>
    </div>
    <?
}


$bgColor = isset($arrOdeljenjeProcesBoja[$proces]) ? $arrOdeljenjeProcesBoja[$proces]['boja'] : "52664d";
$color = isset($arrOdeljenjeProcesBoja[$proces]) ? $arrOdeljenjeProcesBoja[$proces]['text'] : "FFFFFF";

foreach ($arrProcesSirovina[$proces] as $keyNalog => $aNalog) {
    ?>
    <div class="boxCommandTitle" style="color: <?= "#" . $color; ?>;
         background-color: <?= "#" . $bgColor; ?>;" title=""># <?= trim($aNalog['broj']); ?>

        <?
        if ($pravoUpravljanja) {
            ?>
            <button class="btn btn-xs btn-warning btnVirtualniNalog" title="Formiranje radnog naloga" data-nalog="<?= $aNalog['sifra']; ?>" data-proces="<?= $proces; ?>"><i class="icon-quill"></i></button>  
            <button class="btn btn-xs btn-info btnConnector" data-nalog="<?= trim($aNalog['sifra']); ?>" data-proces="<?= $proces; ?>" title="Povezivanje sa radnim nalogom iz proizvodnje"><i class="icon-paperclip"></i></button>
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
    <? ?>

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
        # $arrProc = isset($arrStats[$proces]) ? $arrStats[$proces] : [];
        $arrProc = isset($arrStats[$proces][$aNalog['sifra']]) ? $arrStats[$proces][$aNalog['sifra']] : [];
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
                <td class="text-success eSirovina"><?= $key; ?></td>
                <td class="text-success eSirovina"><?= $aRow['naziv']; ?></td>
                <td class="text-success eSirovina text-right"><?= kolicinaString($aRow['kolicina']); ?><? ?></td>
            </tr>
            <?
        }


        foreach ($aNalog['sirovina'] as $keySir => $oSirovina) {
            $n++;
            $statusIco = "";
            $statusColor = "";

            # $rnKol = isset($arrStats[$proces][$oSirovina->artikal]) ? $arrStats[$proces][$oSirovina->artikal]['kolicina'] : 0;
            $rnKol = isset($arrStats[$proces][$aNalog['sifra']][$oSirovina->artikal]) ? $arrStats[$proces][$aNalog['sifra']][$oSirovina->artikal]['kolicina'] : 0;

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