<?
$_demoStavke = [
    ['id' => 9410, 'naziv' => 'NADEV ZA ČAJNU KOBASICU',   'kat' => 'kobasica', 'boja' => '#f97316', 'min' => 75,  'status' => 'Nacrt',    'statusKlasa' => 'nacrt',    'dan' => 1, 'warn' => false],
    ['id' => 9421, 'naziv' => 'NADEV ZA DOMAĆU SALAMU',    'kat' => 'salama',   'boja' => '#a855f7', 'min' => 90,  'status' => 'Odobreno', 'statusKlasa' => 'odobreno', 'dan' => 2, 'warn' => true],
    ['id' => 9433, 'naziv' => 'NADEV ZA SLAVONSKI KULEN',  'kat' => 'kulen',    'boja' => '#7c3aed', 'min' => 45,  'status' => 'Spremno',  'statusKlasa' => 'spremno',  'dan' => 3, 'warn' => false],
    ['id' => 9460, 'naziv' => 'ZAČINSKA SMJESA – OSTALO',  'kat' => 'ostalo',   'boja' => '#94a3b8', 'min' => 15,  'status' => 'Spremno',  'statusKlasa' => 'spremno',  'dan' => 5, 'warn' => false],
    ['id' => 9472, 'naziv' => 'NADEV ZA LOVAČKU KOBASICU', 'kat' => 'kobasica', 'boja' => '#f97316', 'min' => 45,  'status' => 'Odobreno', 'statusKlasa' => 'odobreno', 'dan' => 4, 'warn' => false],
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
        <div class="neporedenaStavka" data-dan="<?= $_s['dan']; ?>" data-id="<?= $_s['id']; ?>">
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

    var daniNazivi = ['Pon', 'Uto', 'Sre', 'Čet', 'Pet', 'Sub', 'Ned'];

    function pad(n) { return String(n).padStart(2, '0'); }

    window.neporedeneSetNedelja = function (monday) {
        var html = '<button class="neporedeneTab active" data-dan="">Sve</button>';
        for (var i = 0; i < 7; i++) {
            var d = new Date(monday.getFullYear(), monday.getMonth(), monday.getDate() + i);
            html += '<button class="neporedeneTab" data-dan="' + (i + 1) + '" data-datum="' +
                d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()) + '">' +
                '<span class="neporedeneTabDan">' + daniNazivi[i] + '</span>' +
                '<span class="neporedeneTabDatum">' + pad(d.getDate()) + '.' + pad(d.getMonth() + 1) + '.</span>' +
                '</button>';
        }
        panel.querySelector('.neporedeneTabovi').innerHTML = html;
        filterStavke(null, panel.querySelector('#neporedenePretraga').value);
    };

    panel.addEventListener('click', function (e) {
        var tab = e.target.closest('.neporedeneTab');
        if (!tab) return;
        panel.querySelectorAll('.neporedeneTab').forEach(function (t) { t.classList.remove('active'); });
        tab.classList.add('active');
        filterStavke(tab.dataset.dan, panel.querySelector('#neporedenePretraga').value);
    });

    panel.querySelector('#neporedenePretraga').addEventListener('input', function () {
        var active = panel.querySelector('.neporedeneTab.active');
        filterStavke(active ? active.dataset.dan : null, this.value);
    });

    function filterStavke(dan, query) {
        var q = (query || '').toLowerCase();
        var visible = 0;
        panel.querySelectorAll('.neporedenaStavka').forEach(function (el) {
            var matchDan = !dan || el.dataset.dan === dan;
            var matchQuery = !q || el.querySelector('.stavkaBroj').textContent.toLowerCase().indexOf(q) !== -1
                              || el.querySelector('.stavkaNaziv').textContent.toLowerCase().indexOf(q) !== -1;
            var show = matchDan && matchQuery;
            el.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        var cnt = panel.querySelector('#neporedeneCount');
        if (cnt) cnt.textContent = visible;
    }
})();
</script>
