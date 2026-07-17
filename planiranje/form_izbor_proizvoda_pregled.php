
<input type="hidden" name="plan" value="<?= $plan; ?>" />

<?
if (count($arr) > 0) {
    ?>

    <div style="margin-bottom: 5px; border-bottom: 1px dotted #ddd;color: #000; text-align: left; font-size: 12px;">
    </div>

    <table class="table table-hover table-condensed table-striped">
        <thead>
        <th width="20">#</th>
        <th width="">Artikal</th>
        <th width="70">Količina</th>
    </thead>
    <tbody>
        <?
        $n = 0;

        foreach ($arr as $key => $o) {
            $n++;
            $statusIco = "";
            $statusColor = "";
            ?>
            <tr>
                <td width="20"><?= $n; ?>.</td>
                <td class=""><?= "({$o->artikal}) " . $o->artikal_naziv; ?></td>
                <td class="text-right">
                    <input type="hidden" name="artikalProizvod[]" value="<?= $o->artikal; ?>" />
                    <input type="hidden" name="receptProizvod[]" value="<?= $o->id; ?>" />
                    <input type="text" name="kolicinaProizvod[]" class="form-control input-sm" style="height: 20px !important;font-size: 11px !important;" value="<? ?>" >
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

