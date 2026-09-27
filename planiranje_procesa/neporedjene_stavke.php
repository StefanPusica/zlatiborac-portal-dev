<?
$_demoStavke = [
    ['id' => 9410, 'naziv' => 'NADEV ZA ČAJNU KOBASICU',   'kat' => 'kobasica', 'boja' => '#f97316', 'min' => 75,  'status' => 'Nacrt',    'statusKlasa' => 'nacrt',    'warn' => false],
    ['id' => 9421, 'naziv' => 'NADEV ZA DOMAĆU SALAMU',    'kat' => 'salama',   'boja' => '#a855f7', 'min' => 90,  'status' => 'Odobreno', 'statusKlasa' => 'odobreno', 'warn' => true],
    ['id' => 9433, 'naziv' => 'NADEV ZA SLAVONSKI KULEN',  'kat' => 'kulen',    'boja' => '#7c3aed', 'min' => 45,  'status' => 'Spremno',  'statusKlasa' => 'spremno',  'warn' => false],
    ['id' => 9460, 'naziv' => 'ZAČINSKA SMJESA – OSTALO',  'kat' => 'ostalo',   'boja' => '#94a3b8', 'min' => 15,  'status' => 'Spremno',  'statusKlasa' => 'spremno',  'warn' => false],
    ['id' => 9472, 'naziv' => 'NADEV ZA LOVAČKU KOBASICU', 'kat' => 'kobasica', 'boja' => '#f97316', 'min' => 45,  'status' => 'Odobreno', 'statusKlasa' => 'odobreno', 'warn' => false],
];
$_ukupnoMin = array_sum(array_column($_demoStavke, 'min'));
?>
<div class="neporedenePanel">

    <div class="neporedeneHeader">
        <div class="neporedeneHeaderLeft">
            <div class="neporedeneIkona">
                <span class="glyphicon glyphicon-inbox"></span>
            </div>
            <div>
                <div class="neporedeneNaslov">Nepoređene stavke</div>
                <div class="neporedeneOpis">Backlog procesa prije rasporeda</div>
            </div>
        </div>
        <button class="btn btn-xs btn-default neporedeneAddBtn" title="Dodaj stavku" style="font-size:16px; line-height:1; padding:1px 7px;">+</button>
    </div>

    <div class="neporedenePretraga">
        <input type="text" class="form-control input-sm" placeholder="Pretraži šifru ili naziv..." id="neporedenePretraga">
    </div>

    <div class="neporedeneTabovi">
        <button class="neporedeneTab active" data-filter="sve">Sve</button>
        <button class="neporedeneTab" data-filter="spremno">Spremno</button>
        <button class="neporedeneTab" data-filter="nacrt">Nacrti</button>
        <button class="neporedeneTab" data-filter="odobreno">Odobreno</button>
    </div>

    <div class="neporedeneInfo">
        <span>
            <span class="glyphicon glyphicon-filter" style="margin-right:3px; color:#94a3b8;"></span>
            <span id="neporedeneCount"><?= count($_demoStavke); ?></span> stavki
        </span>
        <span>Ukupno <?= floor($_ukupnoMin / 60); ?>h <?= $_ukupnoMin % 60; ?>m</span>
    </div>

    <div class="neporedeneListа" id="neporedeneListа">
        <? foreach ($_demoStavke as $_s): ?>
        <div class="neporedenaStavka" data-status="<?= $_s['statusKlasa']; ?>" data-id="<?= $_s['id']; ?>">
            <div class="stavkaLevaBoja" style="background-color:<?= $_s['boja']; ?>;"></div>
            <div class="stavkaSadrzaj">
                <div class="stavkaGornji">
                    <span class="stavkaBroj"><?= $_s['id']; ?></span>
                    <? if ($_s['warn']): ?>
                        <span class="glyphicon glyphicon-exclamation-sign stavkaWarn" title="Upozorenje"></span>
                    <? endif; ?>
                    <span class="stavkaStatus <?= $_s['statusKlasa']; ?>"><?= $_s['status']; ?></span>
                </div>
                <div class="stavkaNaziv"><?= $_s['naziv']; ?></div>
                <div class="stavkaDonjiRed">
                    <span class="stavkaKat">
                        <span class="stavkaKatDot" style="background-color:<?= $_s['boja']; ?>;"></span>
                        <?= $_s['kat']; ?>
                    </span>
                    <span class="stavkaTrajanje">
                        <span class="glyphicon glyphicon-time"></span> <?= $_s['min']; ?> min
                    </span>
                </div>
            </div>
            <div class="stavkaDrag" title="Prevuci na raspored">⠿</div>
        </div>
        <? endforeach; ?>
    </div>

</div>

<script>
(function () {
    var panel = document.querySelector('.neporedenePanel');
    if (!panel) return;

    panel.addEventListener('click', function (e) {
        var tab = e.target.closest('.neporedeneTab');
        if (!tab) return;
        panel.querySelectorAll('.neporedeneTab').forEach(function (t) { t.classList.remove('active'); });
        tab.classList.add('active');
        filterStavke(tab.dataset.filter, panel.querySelector('#neporedenePretraga').value);
    });

    panel.querySelector('#neporedenePretraga').addEventListener('input', function () {
        var activeFilter = (panel.querySelector('.neporedeneTab.active') || {}).dataset.filter || 'sve';
        filterStavke(activeFilter, this.value);
    });

    function filterStavke(status, query) {
        var q = (query || '').toLowerCase();
        var visible = 0;
        panel.querySelectorAll('.neporedenaStavka').forEach(function (el) {
            var matchStatus = status === 'sve' || el.dataset.status === status;
            var matchQuery = !q || el.querySelector('.stavkaBroj').textContent.toLowerCase().indexOf(q) !== -1
                              || el.querySelector('.stavkaNaziv').textContent.toLowerCase().indexOf(q) !== -1;
            var show = matchStatus && matchQuery;
            el.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        var cnt = panel.querySelector('#neporedeneCount');
        if (cnt) cnt.textContent = visible;
    }
})();
</script>
