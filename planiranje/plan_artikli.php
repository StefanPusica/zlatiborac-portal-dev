

<table class="table">
    <thead>
    <th width="20">

        <?
        if ($pravoUpravljanja) {
            ?>
            <button class="btn btn-xs btn-default pull-left btnGenerator" data-row="<?= $plan; ?>" style="padding: 2px 6px;" title="Generator naloga"><i class="icon-sitemap"></i></button>
        <? }
        ?>
    </th>
    <th width="" colspan="2">
        <?
        if ($pravoUpravljanja) {
            ?>
            <button class="btn btn-xs btn-default pull-left btnPPGenerator" data-row="<?= $plan; ?>" style="padding: 2px 6px;" title="Generator poluproizvoda"><b style="font-size:9px;">pp</b></button>

            <button class="btn btn-xs btn-default pull-right btnRemoveArtikle" data-row="<?= $plan; ?>" style="padding: 2px 6px;" title="Brisanje artikala"><i class="icon-trash2 text-danger"></i></button>
            <button class="btn btn-xs btn-default pull-right btnAddArtikal" data-row="<?= $plan; ?>" style="padding: 2px 6px; margin-right: 10px;" title="Dodavanje artikla"><i class="icon-plus-circle text-success"></i></button>
            <button class="btn btn-xs btn-default pull-right btnAddProizvodArtikal" data-row="<?= $plan; ?>" style="padding: 2px 6px; margin-right: 10px;" title="Dodavanje artikla na osnovu šifre sirovog proizvoda"><i class="icon-lightbulb-o text-success"></i></button>
            <button class="btn btn-xs btn-default pull-right btnAddSirovProizvodArtikal" data-row="<?= $plan; ?>" style="padding: 2px 6px; margin-right: 10px;" title="Dodavanje artikla na osnovu sirovog proizvoda"><i class="icon-flag-checkered text-success"></i></button>
        <? }
        ?>
    </th>
</thead>
<tbody>
    <?
    if (count($arr) == 0) {
        ?>
        <tr>
            <td colspan="3">
                <div class="alert alert-danger">Nemate ništa u planu?</div>
            </td>
        </tr>
        <?
        return;
    }
    ?>
    <?
    $n = 0;
    foreach ($arr as $key => $o) {
        $n++;
        $statusIco = "";
        $statusColor = "";
        ?>
        <tr class="" data-row="<?= UrlStr::text($key); ?>" style="background-color: #EEF6FD;">
            <td colspan="3" class="proizvodSelector" data-row="<?= $key; ?>">

                <?
                if ($pravoUpravljanja) {
                    ?>
                    <button class="btn btn-xs btn-default pull-left btnGeneratorProizvod" data-row="<?= $plan; ?>" data-proizvod="<?= $key; ?>" style="padding: 2px 6px;" title="Generator naloga proizvoda"><i class="icon-sitemap"></i></button>
                <? }
                ?>
                <span style="line-height: 20px; margin-left: 4px;"><?= $o->naziv; ?></span>
            </td>
        </tr>
        <?
        foreach ($o->artikli as $keyArt => $aArt) {
            ?>
            <tr data-plan="<?= $plan; ?>" data-artikal="<?= $aArt['artikal']; ?>">
                <td class=" pointer"><input class="chArtList" data-row="<?= $aArt['artikal']; ?>" type="checkbox" name="artikal[]" ></td>
                <td class="ePlanArtikal pointer"><?= "(" . $aArt['artikal'] . ") " . $aArt['artikal_naziv']; ?></td>
                <td class='ePlanArtikal pointer text-right'><?= kolicinaString($aArt['kolicina']); ?></td>
            </tr>
            <?
        }
    }
    ?>
</tbody>
</table>

<script>
    $(document).ready(function () {
    });
</script>
