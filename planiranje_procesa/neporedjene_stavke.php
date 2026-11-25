<?
$_demoStavke = [
    ['id' => 9410, 'artikal' => '2101', 'naziv' => 'NADEV ZA ČAJNU KOBASICU',   'kolicina' => 1000, 'kat' => 'kobasica', 'boja' => '#f97316', 'min' => 75,  'status' => 'Nacrt',    'statusKlasa' => 'nacrt',    'dan' => 1, 'warn' => false],
    ['id' => 9421, 'artikal' => '2205', 'naziv' => 'NADEV ZA DOMAĆU SALAMU',    'kolicina' => 800,  'kat' => 'salama',   'boja' => '#a855f7', 'min' => 90,  'status' => 'Odobreno', 'statusKlasa' => 'odobreno', 'dan' => 2, 'warn' => true],
    ['id' => 9433, 'artikal' => '2310', 'naziv' => 'NADEV ZA SLAVONSKI KULEN',  'kolicina' => 600,  'kat' => 'kulen',    'boja' => '#7c3aed', 'min' => 45,  'status' => 'Spremno',  'statusKlasa' => 'spremno',  'dan' => 3, 'warn' => false],
    ['id' => 9460, 'artikal' => '2900', 'naziv' => 'ZAČINSKA SMJESA – OSTALO',  'kolicina' => 150,  'kat' => 'ostalo',   'boja' => '#94a3b8', 'min' => 15,  'status' => 'Spremno',  'statusKlasa' => 'spremno',  'dan' => 5, 'warn' => false],
    ['id' => 9480, 'artikal' => '2410', 'naziv' => 'NADEV ZA SREMSKU KOBASICU', 'kolicina' => 500,  'kat' => 'kobasica', 'boja' => '#0ea5e9', 'min' => 30,  'status' => 'Spremno',  'statusKlasa' => 'spremno',  'dan' => 1, 'warn' => false],
    ['id' => 9481, 'artikal' => '2410', 'naziv' => 'NADEV ZA SREMSKU KOBASICU', 'kolicina' => 700,  'kat' => 'kobasica', 'boja' => '#0ea5e9', 'min' => 45,  'status' => 'Spremno',  'statusKlasa' => 'spremno',  'dan' => 1, 'warn' => false],
    ['id' => 9472, 'artikal' => '2104', 'naziv' => 'NADEV ZA LOVAČKU KOBASICU', 'kolicina' => 1200, 'kat' => 'kobasica', 'boja' => '#f97316', 'min' => 45,  'status' => 'Odobreno', 'statusKlasa' => 'odobreno', 'dan' => 4, 'warn' => false],
];
?>
<div class="neporedenePanel">

    <div class="neporedeneHeader">
        <div class="neporedeneHeaderLeft">
            <div class="neporedeneIkona">
                <span class="glyphicon glyphicon-inbox"></span>
            </div>
            <div>
                <div class="neporedeneNaslov">Nepoređene stavke</div>
                <div class="neporedeneOpis">Stavke bez definisanog vremena u danu</div>
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
            <span id="neporedeneCount">0</span> stavki
        </span>
        <span id="neporedeneUkupno"></span>
    </div>

    <div class="neporedeneLista" id="neporedeneLista">
    </div>

</div>

<script>
(function () {
    var panel = document.querySelector('.neporedenePanel');
    if (!panel) return;

    var lista = panel.querySelector('#neporedeneLista');
    var stavke = <?= json_encode($_demoStavke); ?>;
    var monday = null;
    var daniNazivi = ['Pon', 'Uto', 'Sre', 'Čet', 'Pet', 'Sub', 'Ned'];

    function pad(n) { return String(n).padStart(2, '0'); }

    window.neporedeneDanLabel = function (dan) {
        if (!monday || !dan) return '';
        var d = new Date(monday.getFullYear(), monday.getMonth(), monday.getDate() + dan - 1);
        return daniNazivi[dan - 1] + ' ' + pad(d.getDate()) + '.' + pad(d.getMonth() + 1) + '.';
    };

    window.neporedeneRender = function (s, el) {
        el = el || document.createElement('div');
        el.className = 'neporedenaStavka';
        piSetData(el, s);
        el.innerHTML =
            '<div class="stavkaLevaBoja" style="background-color:' + piEsc(s.boja || '#94a3b8') + ';"></div>' +
            '<button type="button" class="btnPiMenu" title="Opcije"><span class="caret"></span></button>' +
            '<div class="stavkaSadrzaj">' +
                '<div class="stavkaGornji">' +
                    '<span class="stavkaBroj">' + piEsc(s.id) + '</span>' +
                    '<span class="stavkaDan">' + neporedeneDanLabel(s.dan) + '</span>' +
                    (String(s.warn) === 'true' ? '<span class="glyphicon glyphicon-exclamation-sign stavkaWarn" title="Upozorenje"></span>' : '') +
                    (s.status ? '<span class="stavkaStatus ' + piEsc(s.statusKlasa) + '">' + piEsc(s.status) + '</span>' : '') +
                '</div>' +
                '<div class="stavkaNaziv">' + piEsc(s.naziv) + '</div>' +
                '<div class="stavkaDonjiRed">' +
                    '<span class="stavkaKat">' + (s.kat ? '<span class="stavkaKatDot" style="background-color:' + piEsc(s.boja) + ';"></span>' + piEsc(s.kat) : '') + '</span>' +
                    '<span class="stavkaKolicina">' + piKg(s.kolicina) + '</span>' +
                    '<span class="stavkaTrajanje"><span class="glyphicon glyphicon-time"></span> ' + s.min + ' min</span>' +
                '</div>' +
            '</div>' +
            '<div class="stavkaDrag" title="Prevuci na raspored">⠿</div>';
        return el;
    };

    window.neporedeneDodaj = function (s, posle) {
        var el = neporedeneRender(s);
        if (posle && posle.parentNode === lista) posle.after(el);
        else lista.appendChild(el);
        initNeporedenaDrag($(el));
        neporedeneOsvezi();
        return el;
    };

    window.neporedeneOsvezi = function () {
        var active = panel.querySelector('.neporedeneTab.active');
        filterStavke(active ? active.dataset.dan : null, panel.querySelector('#neporedenePretraga').value);
    };

    window.neporedeneSetNedelja = function (m) {
        monday = m;
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

        if (stavke) {
            stavke.forEach(function (s) { lista.appendChild(neporedeneRender(s)); });
            stavke = null;
        }
        lista.querySelectorAll('.neporedenaStavka').forEach(function (el) {
            el.querySelector('.stavkaDan').textContent = neporedeneDanLabel(parseInt(el.dataset.dan, 10));
        });
        neporedeneOsvezi();
    };

    panel.addEventListener('click', function (e) {
        var tab = e.target.closest('.neporedeneTab');
        if (!tab) return;
        panel.querySelectorAll('.neporedeneTab').forEach(function (t) { t.classList.remove('active'); });
        tab.classList.add('active');
        neporedeneOsvezi();
    });

    panel.querySelector('#neporedenePretraga').addEventListener('input', neporedeneOsvezi);

    function filterStavke(dan, query) {
        var q = (query || '').toLowerCase();
        var visible = 0;
        var ukupnoMin = 0;
        panel.querySelectorAll('.neporedenaStavka').forEach(function (el) {
            var matchDan = !dan || el.dataset.dan === dan;
            var matchQuery = !q || el.querySelector('.stavkaBroj').textContent.toLowerCase().indexOf(q) !== -1
                              || el.querySelector('.stavkaNaziv').textContent.toLowerCase().indexOf(q) !== -1;
            var show = matchDan && matchQuery;
            el.style.display = show ? '' : 'none';
            if (show) {
                visible++;
                ukupnoMin += parseInt(el.dataset.min, 10) || 0;
            }
        });
        panel.querySelector('#neporedeneCount').textContent = visible;
        panel.querySelector('#neporedeneUkupno').textContent = 'Ukupno ' + Math.floor(ukupnoMin / 60) + 'h ' + (ukupnoMin % 60) + 'm';
    }
})();
</script>
