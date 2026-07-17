

<table class="table table-hover table-condensed table-striped">
    <thead>
    <th width="20">#</th>
    <th width="">Artikal</th>
    <th width="70">Količina</th>
    <th width="60">Komora</th>
    <th width="80">Lot</th>
</thead>
<tbody>
    <?
    $n = 0;

    foreach ($arrTrebovanje as $key => $a) {
        $n++;
        $statusIco = "";
        $statusColor = "";

        $lot = "";
        $komora = 0;

        $kolicina = $a['kolicina'];
        $lagerKolicina = $kolicina;

        $delimicno = false;

        if (isset($arrKartica[$a['artikal']])) {
            $lot = trim($arrKartica[$a['artikal']]['lot']);
            $komora = $arrKartica[$a['artikal']]['komora'];
            # $delimicno = $arrKartica[$a['artikal']]['delimicno'];
            # $lagerKolicina = $arrKartica[$a['artikal']]['lager'];
        }
        ?>
        <tr class="">
            <td width="20"><?= $n; ?>.</td>
            <td class=""><?= "({$a['artikal']}) " . $a['artikal_naziv']; ?></td>
            <td class="text-right"><?
                if ($delimicno) {
                    ?>
                    <div class="badge badge-mini badge-error">!</div> <b style="color:red"><?= $kolicina; ?></b> <b><?= $lagerKolicina; ?></b>
                    <?
                } else {
                    ?><?= kolicinaString($kolicina); ?>
                    <?
                }
                ?>
            </td>
            <td>

                <input type="hidden" name="artikalTreb[]" value="<?= $a['artikal']; ?>" />
                <input type="hidden" name="kolicinaTreb[]" value="<?= $lagerKolicina; ?>" />

                <select id="komoraTreb_<?= $a['artikal']; ?>" name="komoraTreb[]" class="" style="width:50px;" >
                    <option value='0'>Izbor komore</option>
                    <?
                    foreach ($arrKomora as $key => $oKom) {
                        $sel = $komora == $oKom->sifra ? "selected='selected'" : "";
                        echo "<option value='{$oKom->sifra}' $sel >{$oKom->sifra} - {$oKom->naziv}</option>";
                    }
                    ?>
                </select>
            </td>
            <td>
                <input type="text" name="lotTreb[]" class="form-control input-sm lotChanger" data-artikal="<?= $a['artikal']; ?>" style="height: 20px !important;font-size: 11px !important;" value="<?= $lot; ?>" >
            </td>
        </tr>
        <?
    }
    ?>
</tbody>
</table>