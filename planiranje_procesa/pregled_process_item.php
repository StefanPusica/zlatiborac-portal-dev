<div class="piRed">
    <button type="button" class="btnPiMenu" title="Opcije"><span class="caret"></span></button>
    <div class="piInfo btnArtikalInfo" data-row="<?= $o->id; ?>">
        <span class="piNaziv" style="color:<?= $status == 30 ? '#16a34a' : '#1e293b'; ?>;"><?= $o->artikal; ?> - <?= trim($o->artikal_naziv); ?></span>
    </div>
    <span class="piKol"><?= (float) $o->kolicina; ?> kg</span>
    <button class="btn btn-xs btn-mini <?= $btnColor; ?> btnArtikalStatus" data-row="<?= $o->id; ?>" data-plan="<?= $o->plan; ?>" data-artikal="<?= $o->artikal; ?>" style="padding:0 4px; flex-shrink:0;"><i class="<?= $icoStatus; ?>"></i></button>
</div>
