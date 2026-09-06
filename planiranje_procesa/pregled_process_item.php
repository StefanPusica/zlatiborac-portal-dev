<div style="display:flex; align-items:center; width:100%; padding:3px 6px; box-sizing:border-box; gap:4px; min-width:0; overflow:hidden;">
    <div style="flex:1; min-width:0; cursor:pointer;" class="btnArtikalInfo" data-row="<?= $o->id; ?>">
        <div style="font-weight:600; font-size:11px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:<?= $status == 30 ? '#16a34a' : '#1e293b'; ?>;"><?= $o->artikal; ?> - <?= trim($o->artikal_naziv); ?></div>
        <div style="font-size:10px; color:#64748b; margin-top:1px;">kol: <b><?= $o->kolicina; ?></b></div>
    </div>
    <div style="flex-shrink:0;">
        <button class="btn btn-xs btn-mini <?= $btnColor; ?> btnArtikalStatus" data-row="<?= $o->id; ?>" data-plan="<?= $o->plan; ?>" data-artikal="<?= $o->artikal; ?>" style="padding:0 4px;"><i class="<?= $icoStatus; ?>"></i></button>
    </div>
</div>
