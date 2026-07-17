<style>

    tr.aktivan td {
        background-color: #dcebfd;
    }
    .rowRn {
        cursor: pointer;
    }
</style>

<table class="table table-hover table-condensed ">
    <thead>
    <th width="20">#</th>
    <th width="30">Broj</th>
    <th width="70">Datum</th>
    <th width="">Artikal</th>
</thead>
<tbody>
    <?
    $n = 0;

    foreach ($arr as $key => $o) {
        $n++;
        $statusIco = "";
        $statusColor = "";
        ?>
        <tr class="rowRnTr" data-row="<?= $o->id; ?>" data-plan-nalog="<?= $plan_nalog; ?>" data-proces="<?= $proces; ?>">
            <td width="20"><?= $n; ?>.</td>
            <td class="rowRn"><?= $o->broj; ?></td>
            <td class="rowRn"><?= Datum::stamp2date($o->datum); ?></td>
            <td class="rowRn"><?= "({$o->artikal}) " . $o->artikal_naziv; ?></td>
        </tr>
        <?
    }
    ?>
</tbody>
</table>