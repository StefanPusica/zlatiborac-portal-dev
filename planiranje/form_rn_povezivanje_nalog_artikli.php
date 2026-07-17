


<input type="hidden" name="nalog" value="<?= $nalog; ?>" />
<input type="hidden" name="plan_nalog" value="<?= $plan_nalog; ?>" />
<input type="hidden" name="proces" value="<?= $proces; ?>" />

<?
if (count($arrPredajnica) > 0) {
    ?>

    <div style="margin-bottom: 5px; border-bottom: 1px dotted #ddd;color: #000; text-align: left; font-size: 12px;">
        <i class="glyphicon icon-cube"></i> Proizvod
    </div>

    <table class="table table-hover table-condensed table-striped">
        <thead>
        <th width="20">#</th>
        <th width="30">Broj</th>
        <th width="50">Lot</th>
        <th width="">Artikal</th>
        <th width="70">Količina</th>
        <th width="60">Komora</th>
    </thead>
    <tbody>
        <?
        $n = 0;

        foreach ($arrPredajnica as $key => $o) {
            $n++;
            $statusIco = "";
            $statusColor = "";
            ?>
            <tr>
                <td width="20"><?= $n; ?>.</td>
                <td class="">M<?= $o->sif_mag; ?></td>
                <td class=""><?= $o->lot; ?></td>
                <td class=""><?= "({$o->sif_art}) " . $o->naz_art; ?></td>
                <td class="text-right"><?= kolicinaString($o->kolic); ?></td>
                <td>

                    <input type="hidden" name="nalogPred[]" value="<?= $o->id_dok; ?>" />
                    <input type="hidden" name="artikalPred[]" value="<?= $o->sif_art; ?>" />
                    <input type="hidden" name="lotPred[]" value="<?= trim($o->lot); ?>" />
                    <input type="hidden" name="kolicinaPred[]" value="<?= $o->kolic; ?>" />

                    <select id="komoraPred" name="komoraPred[]" class="" style="width:50px;" >
                        <option value='0'>Izbor komore</option>
                        <?
                        foreach ($arrKomora as $key => $oKom) {
                            $sel = ''; // $o->komora == $oKom->sifra ? "selected='selected'" : "";
                            echo "<option value='{$oKom->sifra}' $sel >{$oKom->sifra} - {$oKom->naziv}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <?
        }
        ?>
    </tbody>
    </table>

    <?
}
?>

<?
if (count($arrTrebovanje) > 0) {
    ?>

    <div style="margin-bottom: 5px; border-bottom: 1px dotted #ddd;color: #000; text-align: left; font-size: 12px; margin-top: 5px;">
        <i class="glyphicon icon-cart-arrow-down"></i> Trebovanje
    </div>

    <table class="table table-hover table-condensed table-striped">
        <thead>
        <th width="20">#</th>
        <th width="30">Mag.</th>
        <th width="50">Lot</th>
        <th width="">Artikal</th>
        <th width="70">Količina</th>
        <th width="60">Komora</th>
    </thead>
    <tbody>
        <?
        $n = 0;

        foreach ($arrTrebovanje as $key => $o) {
            $n++;
            $statusIco = "";
            $statusColor = "";
            ?>
            <tr class="<?= $o->komora != 0 ? "" : "danger"; ?>">
                <td width="20"><?= $n; ?>.</td>
                <td class="">M<?= $o->sif_mag; ?></td>
                <td class=""><?= $o->lot; ?></td>
                <td class=""><?= "({$o->sif_art}) " . $o->naz_art; ?></td>
                <td class="text-right"><?= kolicinaString($o->kolic); ?></td>
                <td>
                    <input type="hidden" name="nalogTreb[]" value="<?= $o->id_dok; ?>" />
                    <input type="hidden" name="artikalTreb[]" value="<?= $o->sif_art; ?>" />
                    <input type="hidden" name="lotTreb[]" value="<?= trim($o->lot); ?>" />
                    <input type="hidden" name="kolicinaTreb[]" value="<?= $o->kolic; ?>" />
                    <input type="hidden" name="komadTreb[]" value="<?= $o->komad; ?>" />
                    <select id="komoraTreb" name="komoraTreb[]" class="" style="width:50px;" >
                        <option value='0'>Izbor komore</option>
                        <?
                        foreach ($arrKomora as $key => $oKom) {
                            $sel = $o->komora == $oKom->sifra ? "selected='selected'" : "";
                            echo "<option value='{$oKom->sifra}' $sel >{$oKom->sifra}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <?
        }
        ?>
    </tbody>
    </table>

    <?
}
?>
