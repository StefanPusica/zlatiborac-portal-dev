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
