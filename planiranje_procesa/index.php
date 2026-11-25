
<link href="<?= $public_url; ?>/css/mjsFlexPool.css" rel="stylesheet">
<style><?php include __DIR__ . '/planiranje_procesa.css'; ?></style>

<div class="mSideBar" style="">
    <div id="sideBarClose" class="btn btn-xs btn-default btn-mini pull-right" style="margin-right:4px;">X</div>
    <div style="width:100%;border: 1px solid #ddd;padding: 1px;">Naslov</div>
</div>

<div id="blenda" class="blenda" style="display: none;">
    <img class="blendaLoader" width="128" src="<?= $public_url; ?>/img/loader3.gif">
</div>

<div class="mContentHeader">
    <ol class="breadcrumb mjsBreadcrumb">
        <li><a href="<?= $pro20_url; ?>">Pro20</a></li>
        <li><a href="<?= $proplaniranje_url; ?>">Planiranje</a></li>
        <li class="active"><span id="periodInfo"><?= Datum::stamp2date($start) . " - " . Datum::stamp2date($kraj); ?></span></li>
        <li class="active">Planiranje procesa</li>
        <li class="pull-right">
            <button type="button" id="btnSave" class="btn btn-success btn-xs" style="padding: 4px 10px;margin-top: -5px; margin-right: 4px;" title="Sačuvaj raspored">
                <span class="glyphicon glyphicon-floppy-disk"></span> Sačuvaj
            </button>
            <button type="button" id="btnGlobalLock" class="btn btn-warning btn-xs locked" style="padding: 4px 10px;margin-top: -5px; margin-right: 4px;" title="Otključaj sve">
                <span class="glyphicon glyphicon-lock"></span>
            </button>
            <button type="button" id="btnFilterForm" class="btn btn-info btn-xs" style="padding: 4px 10px;margin-top: -5px; margin-right: -12px;"><span class="glyphicon glyphicon-search"></span> Filter</button>
        </li>
    </ol>
</div>

<div id='filterForm' class="mjsPopover lefttop" style="display: none; width: 240px;">
    <div id="blenda" class="blenda" style="display:none;">
        <img class="blendaLoader" width="16" src="<?= $img_url ?>/loader.gif" />
    </div>
    <form class="form-horizontal" role="form" name="frmFilter" id="frmFilter">
        <div class="arrow"></div>
        <div class="mjsPopover-content">

            <div class="row ">
                <div class="col-sm-12">Period</div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <input type="hidden" name="start" id="start" value="<?= $start; ?>">
                    <input type="hidden" name="kraj" id="kraj" value="<?= $kraj; ?>">
                    <div class="weekPickerWrap" id="weekPickerWrap">
                        <div class="weekPicker" id="weekPicker" tabindex="0" title="Strelice levo/desno menjaju nedelju, Enter otvara listu">
                            <button type="button" class="weekPickerBtn" id="weekPrev" title="Prethodna nedelja" aria-label="Prethodna nedelja">&lsaquo;</button>
                            <div class="weekPickerPeriod" id="weekPeriod" aria-live="polite" title="Izbor nedelje"></div>
                            <button type="button" class="weekPickerBtn" id="weekNext" title="Naredna nedelja" aria-label="Naredna nedelja">&rsaquo;</button>
                        </div>
                        <div class="weekDropdown" id="weekDropdown" style="display: none;">
                            <div class="weekDropdownHeader">
                                <button type="button" class="weekDropdownNav" id="weekMonthPrev" aria-label="Prethodni mesec">&lsaquo;</button>
                                <span id="weekMonthTitle"></span>
                                <button type="button" class="weekDropdownNav" id="weekMonthNext" aria-label="Naredni mesec">&rsaquo;</button>
                            </div>
                            <div class="weekDropdownRow weekDropdownHead">
                                <span class="weekDropdownBroj">Nedelja</span>
                                <span class="weekDropdownPeriod">Period</span>
                            </div>
                            <div id="weekDropdownList"></div>
                        </div>
                    </div>
                    <div class="weekPickerInfo">
                        <span id="weekBroj"></span>
                        <a href="#" id="weekTrenutna">Trenutna nedelja</a>
                    </div>
                </div>
            </div>

            <div class="row rowDistance">
                <div class="col-sm-12">Proces</div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <select id="proces" name="proces" class="form-control input-sm" >
                        <option value='0'>Izbor procesa</option>
                        <?
                        foreach ($arrProces as $key => $o) {
                            ?>
                            <option value='<?= $o->sifra; ?>' <?= $proces == $o->sifra ? "selected='selected'" : ''; ?>><?= $o->naziv; ?></option>
                            <?
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row rowDistance">
                <div class="col-sm-12">Proizvod</div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <select id="proizvodSel" name="proizvod" class="form-control input-sm" >
                        <option value='-1'>Izbor proizvoda</option>
                        <?
                        foreach ($arrProizvod as $key => $o) {
                            ?>
                            <option value='<?= $o->id; ?>' <?= $proizvod == $o->id ? "selected='selected'" : ''; ?>><?= $o->naziv; ?></option>
                            <?
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row rowDistance">
                <div class="col-sm-12">Lot</div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <input type="text" name="lot" class="form-control input-sm" id="lot" placeholder="Pojava lota" value="<?= $lot; ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12" style="margin-top:10px;">
                    <button type="button" id="btnFilter" class="btn btn-primary btn-sm pull-right"><span class="glyphicon glyphicon-search"></span></button>
                    <button type="button" class="btn btn-sm pull-left" id="btnFilterClose" title="Zatvori"><span class="glyphicon glyphicon-remove"></span></button>
                </div>
            </div>

        </div>
    </form>
</div>

<div id="planningRow" style="display:flex; flex-direction:row; overflow:hidden;">
    <? include __DIR__ . '/neporedjene_stavke.php'; ?>
    <div class="mContentBody" style="flex:1; min-width:0; overflow:hidden;">
    </div>
</div>

<div id="piHost">
    <div id="piMenu" class="piMenu" style="display:none;">
        <a href="#" data-akcija="split">
            <svg class="piMenuIkona" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="6" cy="6" r="3"></circle>
                <circle cx="6" cy="18" r="3"></circle>
                <line x1="20" y1="4" x2="8.12" y2="15.88"></line>
                <line x1="14.47" y1="14.48" x2="20" y2="20"></line>
                <line x1="8.12" y1="8.12" x2="12" y2="12"></line>
            </svg>
            Split
        </a>
        <a href="#" data-akcija="merge"><span class="glyphicon glyphicon-resize-small"></span> Merge</a>
    </div>

    <div class="modal fade" id="piSplitModal" tabindex="-1" role="dialog"></div>
    <template id="tplPiSplit">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Split stavke</h4>
                </div>
                <div class="modal-body">
                    <div class="piModalNaziv" id="piSplitNaziv"></div>
                    <div class="piModalInfo">Ukupna količina: <b id="piSplitUkupno"></b></div>
                    <label for="piSplitKol" style="font-size:12px;">Količina novog splita (kg)</label>
                    <input type="number" class="form-control input-sm" id="piSplitKol" min="0" step="any">
                    <div class="piModalInfo">Ostatak: <b id="piSplitOstatak"></b></div>
                    <div class="piModalInfo" id="piSplitOpis"></div>
                    <div class="text-danger" id="piSplitGreska" style="font-size:11px;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Odustani</button>
                    <button type="button" class="btn btn-primary btn-sm" id="piSplitOk"><span class="glyphicon glyphicon-scissors"></span> Split</button>
                </div>
            </div>
        </div>
    </template>

    <div class="modal fade" id="piMergeModal" tabindex="-1" role="dialog"></div>
    <template id="tplPiMerge">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Merge stavke</h4>
                </div>
                <div class="modal-body">
                    <div class="piModalNaziv" id="piMergeNaziv"></div>
                    <div class="piModalInfo">Količina: <b id="piMergeKol"></b></div>
                    <label for="piMergeSel" style="font-size:12px;">Spoji sa</label>
                    <select class="form-control input-sm" id="piMergeSel"></select>
                    <div class="piModalInfo" id="piMergePrazno">Nema stavki istog artikla za isti dan sa kojima se može spojiti.</div>
                    <div class="piModalInfo">Nova količina: <b id="piMergeRez"></b></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Odustani</button>
                    <button type="button" class="btn btn-primary btn-sm" id="piMergeOk"><span class="glyphicon glyphicon-resize-small"></span> Merge</button>
                </div>
            </div>
        </div>
    </template>
</div>

<script>

    var PI_SLOT_H = 28;
    var PI_POLJA = ['id', 'artikal', 'naziv', 'kolicina', 'min', 'boja', 'kat', 'status', 'statusKlasa', 'warn', 'dan'];

    function piEsc(s) {
        return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c];
        });
    }

    function piKg(n) { return (Math.round(n * 100) / 100) + ' kg'; }

    function piVreme(ts) {
        var d = new Date(parseInt(ts, 10) * 1000);
        return String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
    }

    function piDan(datum) {
        var p = datum.split('-');
        return (new Date(+p[0], +p[1] - 1, +p[2]).getDay() + 6) % 7 + 1;
    }

    function piSetData(el, d) {
        PI_POLJA.forEach(function (k) {
            if (d[k] !== undefined && d[k] !== null) el.dataset[k] = d[k];
        });
    }

    // Isti oblik podataka za nerasporedjenu stavku i processItem na timeline-u;
    // na timeline-u dan dolazi iz kolone, a trajanje iz visine
    function piData(el) {
        var d = {};
        PI_POLJA.forEach(function (k) { d[k] = el.dataset[k]; });
        var list = el.closest('.boxList');
        if (list) {
            d.dan = piDan(list.dataset.datum);
            d.min = Math.round(el.offsetHeight / PI_SLOT_H) * 15;
        }
        d.kolicina = parseFloat(d.kolicina) || 0;
        d.min = parseInt(d.min, 10) || 15;
        d.dan = parseInt(d.dan, 10);
        return d;
    }

    function piSkaliraj(min, kol, ukupno) {
        return Math.max(15, Math.round(min * kol / ukupno / 15) * 15);
    }

    // select2, mjsSearch, datepicker ostaju jQuery — zahtijevaju plugin
    $("#proizvodSel").select2();
    $("#kreirao").select2();
    $("#proces").select2();

    $('#btnFilterForm').mjsSearch({
        divForm: $("#filterForm"),
        btnClose: $("#btnFilterClose"),
        btnFind: $("#btnFilter"),
        onFind: function (e) { loader(); }
    });

    (function () {
        var monday;

        function pad(n) { return String(n).padStart(2, '0'); }
        function fmt(d) { return pad(d.getDate()) + '.' + pad(d.getMonth() + 1) + '.' + d.getFullYear(); }

        function parse(v) {
            v = (v || '').trim();
            var m = v.match(/^(\d{1,2})\.(\d{1,2})\.(\d{4})\.?$/);
            if (m) return new Date(+m[3], +m[2] - 1, +m[1]);
            if (/^\d{9,}$/.test(v)) return new Date(parseInt(v, 10) * 1000);
            return null;
        }

        function toMonday(d) {
            var r = new Date(d.getFullYear(), d.getMonth(), d.getDate());
            r.setDate(r.getDate() - (r.getDay() + 6) % 7);
            return r;
        }

        // ISO 8601: nedelja kojoj pripada četvrtak
        function isoWeek(mon) {
            var thu = new Date(mon.getFullYear(), mon.getMonth(), mon.getDate() + 3);
            var jan4 = new Date(thu.getFullYear(), 0, 4);
            return 1 + Math.round((thu - toMonday(jan4)) / 604800000);
        }

        function render() {
            var sunday = new Date(monday.getFullYear(), monday.getMonth(), monday.getDate() + 6);
            document.getElementById('start').value = fmt(monday);
            document.getElementById('kraj').value = fmt(sunday);
            document.getElementById('weekPeriod').textContent =
                pad(monday.getDate()) + '.' + pad(monday.getMonth() + 1) + '. – ' + fmt(sunday);
            document.getElementById('weekBroj').textContent = 'Nedelja ' + isoWeek(monday);
            document.getElementById('weekTrenutna').style.visibility =
                monday.getTime() === toMonday(new Date()).getTime() ? 'hidden' : 'visible';
            neporedeneSetNedelja(monday);
        }

        function setWeek(d) {
            monday = toMonday(d);
            render();
        }

        function shift(days) {
            setWeek(new Date(monday.getFullYear(), monday.getMonth(), monday.getDate() + days));
            closeDropdown();
            loader();
        }

        var meseci = ['Januar', 'Februar', 'Mart', 'April', 'Maj', 'Jun', 'Jul', 'Avgust', 'Septembar', 'Oktobar', 'Novembar', 'Decembar'];
        var dropdown = document.getElementById('weekDropdown');
        var viewYear, viewMonth;

        // Prikazuju se nedelje čiji ponedeljak pada u izabrani mesec
        function renderDropdown() {
            document.getElementById('weekMonthTitle').textContent = meseci[viewMonth] + ' ' + viewYear;
            var d = toMonday(new Date(viewYear, viewMonth, 1));
            if (d.getMonth() !== viewMonth) d.setDate(d.getDate() + 7);
            var html = '';
            while (d.getMonth() === viewMonth) {
                var sun = new Date(d.getFullYear(), d.getMonth(), d.getDate() + 6);
                var sel = d.getTime() === monday.getTime();
                html += '<div class="weekDropdownRow weekDropdownItem' + (sel ? ' selected' : '') + '" tabindex="0" data-ts="' + d.getTime() + '">' +
                    '<span class="weekDropdownBroj">' + isoWeek(d) + '</span>' +
                    '<span class="weekDropdownPeriod">' + pad(d.getDate()) + '.' + pad(d.getMonth() + 1) + '. – ' + fmt(sun) + '</span>' +
                    (sel ? '<span class="glyphicon glyphicon-ok"></span>' : '') +
                    '</div>';
                d.setDate(d.getDate() + 7);
            }
            document.getElementById('weekDropdownList').innerHTML = html;
        }

        function openDropdown() {
            viewYear = monday.getFullYear();
            viewMonth = monday.getMonth();
            renderDropdown();
            dropdown.style.display = 'block';
            var s = dropdown.querySelector('.weekDropdownItem.selected');
            if (s) s.focus();
        }

        function closeDropdown(focusPicker) {
            dropdown.style.display = 'none';
            if (focusPicker) document.getElementById('weekPicker').focus();
        }

        function shiftMonth(n) {
            var d = new Date(viewYear, viewMonth + n, 1);
            viewYear = d.getFullYear();
            viewMonth = d.getMonth();
            renderDropdown();
        }

        function selectItem(row) {
            setWeek(new Date(parseInt(row.dataset.ts, 10)));
            closeDropdown(true);
            loader();
        }

        setWeek(parse(document.getElementById('start').value) || new Date());

        document.getElementById('weekPrev').addEventListener('click', function () { shift(-7); });
        document.getElementById('weekNext').addEventListener('click', function () { shift(7); });
        document.getElementById('weekPeriod').addEventListener('click', function () {
            dropdown.style.display === 'none' ? openDropdown() : closeDropdown();
        });
        document.getElementById('weekMonthPrev').addEventListener('click', function () { shiftMonth(-1); });
        document.getElementById('weekMonthNext').addEventListener('click', function () { shiftMonth(1); });
        document.getElementById('weekTrenutna').addEventListener('click', function (e) {
            e.preventDefault();
            setWeek(new Date());
            closeDropdown();
            loader();
        });
        document.getElementById('weekPicker').addEventListener('keydown', function (e) {
            if (e.target !== this) return;
            if (e.key === 'ArrowLeft') { e.preventDefault(); shift(-7); }
            else if (e.key === 'ArrowRight') { e.preventDefault(); shift(7); }
            else if (e.key === 'Enter' || e.key === ' ' || e.key === 'ArrowDown') { e.preventDefault(); openDropdown(); }
        });

        document.getElementById('weekDropdownList').addEventListener('click', function (e) {
            var row = e.target.closest('.weekDropdownItem');
            if (row) selectItem(row);
        });

        dropdown.addEventListener('keydown', function (e) {
            var row = e.target.closest('.weekDropdownItem');
            if (e.key === 'Escape') { e.preventDefault(); closeDropdown(true); }
            else if (row && (e.key === 'Enter' || e.key === ' ')) { e.preventDefault(); selectItem(row); }
            else if (row && e.key === 'ArrowDown' && row.nextElementSibling) { e.preventDefault(); row.nextElementSibling.focus(); }
            else if (row && e.key === 'ArrowUp' && row.previousElementSibling) { e.preventDefault(); row.previousElementSibling.focus(); }
            else if (e.key === 'PageUp') { e.preventDefault(); shiftMonth(-1); }
            else if (e.key === 'PageDown') { e.preventDefault(); shiftMonth(1); }
        });

        document.addEventListener('mousedown', function (e) {
            if (dropdown.style.display !== 'none' && !document.getElementById('weekPickerWrap').contains(e.target)) {
                closeDropdown();
            }
        });
    })();

    document.getElementById('btnSave').addEventListener('click', function () {
        document.querySelectorAll('.processItem').forEach(function (item) {
            var rowEl = item.querySelector('[data-row]');
            if (!rowEl) return;
            console.log({
                id: rowEl.dataset.row,
                start_time: item.dataset.startTime || null,
                end_time: item.dataset.endTime || null
            });
        });
    });

    document.getElementById('btnGlobalLock').addEventListener('click', function () {
        setGlobalLock(this.classList.contains('locked') ? false : true);
    });

    function setGlobalLock(locked) {
        var btn = document.getElementById('btnGlobalLock');
        document.querySelectorAll('.mFlexBox').forEach(function (box) {
            box.classList.toggle('locked', locked);
        });
        btn.classList.toggle('locked', locked);
        btn.classList.toggle('btn-warning', locked);
        btn.classList.toggle('btn-default', !locked);
        btn.querySelector('.glyphicon').className = 'glyphicon glyphicon-' + (locked ? 'lock' : 'pencil');
        btn.title = locked ? 'Otključaj sve' : 'Zaključaj sve';

        var panel = document.querySelector('.neporedenePanel');
        if (panel) {
            panel.classList.toggle('locked', locked);
            $(panel).find('.neporedenaStavka').each(function () {
                if ($(this).data('ui-draggable')) {
                    $(this).draggable(locked ? 'disable' : 'enable');
                }
            });
        }
    }

    loader();
    homeRowResize();
    window.addEventListener('resize', homeRowResize);

    document.addEventListener('click', function (e) {
        if (e.target.closest('#sideBarClose')) {
            document.querySelector('.mSideBar').classList.remove('active');
        }

        var btnStatus = e.target.closest('.btnArtikalStatus');
        if (btnStatus) {
            $("#myModal").modal({ remote: '<?= "$proplaniranje_url/status/"; ?>' + btnStatus.dataset.row, backdrop: "static" });
        }

        var btnInfo = e.target.closest('.btnArtikalInfo');
        if (btnInfo) {
            ucitajSideBar(btnInfo.dataset.row);
        }

        var btnMeni = e.target.closest('.btnPiMenu');
        if (btnMeni) {
            piOtvoriMeni(btnMeni);
        }

        var akcija = e.target.closest('#piMenu [data-akcija]');
        if (akcija) {
            e.preventDefault();
            piZatvoriMeni();
            if (akcija.dataset.akcija === 'split') piOtvoriSplit(piCilj);
            else piOtvoriMerge(piCilj);
        }

        var slot = e.target.closest('.timeSlotRow');
        if (slot) {
            var ts = parseInt(slot.dataset.timestamp, 10);
            var d = new Date(ts * 1000);
            console.log('Dan: ' + String(d.getDate()).padStart(2, '0') + ' | Sat: ' + String(d.getHours()).padStart(2, '0') + ' | Minut: ' + String(d.getMinutes()).padStart(2, '0'));
        }
    });

    function loader() {
        document.getElementById('periodInfo').innerHTML =
            document.getElementById('start').value + " - " + document.getElementById('kraj').value;

        var args = new URLSearchParams(new FormData(document.getElementById('frmFilter'))).toString();
        var b = document.getElementById('blenda');
        b.style.display = 'block';
        urlContent($('.mContentBody'), "<?= "$proplaniranje_url/planiranje_procesa_pregled/"; ?>", args, function () {
            homeRowResize();
            initDragDrop();
            initResize();
            setGlobalLock(true);
            b.style.display = 'none';
        });
    }

    function ucitajDan(datum) {
        var o = document.querySelector('[data-datum="' + datum + '"]');
        var formData = new FormData(document.getElementById('frmFilter'));
        formData.set('start', datum);
        formData.set('kraj', datum);
        var args = new URLSearchParams(formData).toString();

        var b = document.getElementById('blenda');
        b.style.display = 'block';
        urlContent($(o), "<?= "$proplaniranje_url/nadzor_pregled_dan/"; ?>", args, function () {
            b.style.display = 'none';
        });
    }

    function ucitajSideBar(rowId) {
        document.getElementById('btnFilterClose').click();
        var sidebar = document.querySelector('.mSideBar');
        sidebar.classList.add('active');
        sidebar.innerHTML = '<div id="blendaBar" class="blenda" style="display: block;"><img class="blendaLoader" width="128" src="<?= $public_url; ?>/img/loader4.gif"></div>';

        fetch("<?= $proplaniranje_url; ?>/planiranje_procesa_nalog/" + rowId, { method: 'POST' })
            .then(function (r) { return r.text(); })
            .then(function (data) { sidebar.innerHTML = data; });
    }

    function homeRowResize() {
        var wrapper = document.querySelector('.mFlexWrapper');
        if (wrapper) {
            wrapper.style.height = (window.innerHeight - wrapper.getBoundingClientRect().top - 20) + 'px';
        }

        var firstBoxList = document.querySelector('.boxList');
        var boxOffsetTop = firstBoxList ? firstBoxList.getBoundingClientRect().top : 0;
        var vh = window.innerHeight - (boxOffsetTop + 38);
        document.querySelectorAll('.boxList').forEach(function (el) {
            el.style.height = vh + 'px';
        });

        var contentBody = document.querySelector('.mContentBody');
        var sidebar = document.querySelector('.mSideBar');
        if (contentBody && sidebar) {
            sidebar.style.height = (window.innerHeight - contentBody.getBoundingClientRect().top - 20 + 80) + 'px';
        }

        var panel = document.querySelector('.neporedenePanel');
        if (contentBody && panel) {
            panel.style.height = (window.innerHeight - contentBody.getBoundingClientRect().top - 20) + 'px';
        }
    }

    function initProcessItemDrag($el) {
        $el.draggable({
            cancel: ".resizeHandleTop, .resizeHandleBottom, .btnPiMenu",
            helper: "clone",
            revert: "invalid",
            zIndex: 1000,
            scroll: false,
            opacity: 0.9,
            start: function () { $(this).addClass('dragging'); },
            stop: function () { $(this).removeClass('dragging'); }
        });
    }

    function initNeporedenaDrag($el) {
        $el.draggable({
            helper: "clone",
            revert: "invalid",
            appendTo: "body",
            zIndex: 1000,
            scroll: false,
            opacity: 0.75,
            cursor: "grabbing"
        });
    }

    function processItemHtml(d) {
        return '<div class="resizeHandleTop"></div>' +
            '<div class="piRed">' +
            '<button type="button" class="btnPiMenu" title="Opcije"><span class="caret"></span></button>' +
            '<div class="piInfo btnArtikalInfo" data-row="' + piEsc(d.id) + '"><span class="piNaziv">' + piEsc(d.naziv) + '</span></div>' +
            '<span class="piKol">' + piKg(d.kolicina) + '</span>' +
            '</div>' +
            '<div class="resizeHandleBottom"></div>';
    }

    function postaviNaTimeline(list, d, top) {
        var h = Math.max(PI_SLOT_H, Math.round(d.min / 15) * PI_SLOT_H);
        var el = document.createElement('div');
        el.className = 'processItem';
        el.style.cssText = 'position:absolute; top:' + top + 'px; left:36px; right:0; height:' + h + 'px;';
        if (d.boja) el.style.borderLeftColor = d.boja;
        piSetData(el, d);
        el.innerHTML = processItemHtml(d);
        el.dataset.resizeInit = '1';
        list.appendChild(el);
        updateItemTimes(el, buildSlotMap(list));
        pushDisplacedItems(list, el, top, h);
        initProcessItemDrag($(el));
        return el;
    }

    var piCilj = null;
    var piKandidati = [];

    function piOtvoriMeni(btn) {
        piCilj = btn.closest('.processItem, .neporedenaStavka');
        var m = document.getElementById('piMenu');
        var r = btn.getBoundingClientRect();
        m.style.left = r.left + 'px';
        m.style.top = (r.bottom + 2) + 'px';
        m.style.display = 'block';
    }

    function piZatvoriMeni() {
        document.getElementById('piMenu').style.display = 'none';
    }

    // Sadržaj modala se gradi iz <template> pri svakom otvaranju, jer ga zatvaranje modala može isprazniti
    function piPripremiModal(id, tplId) {
        document.getElementById(id).innerHTML = document.getElementById(tplId).innerHTML;
    }

    function piOtvoriSplit(el) {
        piPripremiModal('piSplitModal', 'tplPiSplit');
        var d = piData(el);
        document.getElementById('piSplitNaziv').textContent = d.id + ' – ' + d.naziv;
        document.getElementById('piSplitUkupno').textContent = piKg(d.kolicina);
        document.getElementById('piSplitOpis').textContent = el.classList.contains('processItem')
            ? 'Split ostaje na timeline-u, ostatak odlazi u nepoređene stavke.'
            : 'Split postaje nova nepoređena stavka, ostatak ostaje u postojećoj.';
        document.getElementById('piSplitKol').value = '';
        document.getElementById('piSplitGreska').textContent = '';
        piSplitOstatak();
        $('#piSplitModal').modal('show');
    }

    function piSplitOstatak() {
        var d = piData(piCilj);
        var x = parseFloat(document.getElementById('piSplitKol').value) || 0;
        document.getElementById('piSplitOstatak').textContent = piKg(Math.max(0, d.kolicina - x));
    }

    function piSplit(el, x) {
        var d = piData(el);
        var ostatak = Math.round((d.kolicina - x) * 100) / 100;
        var split = Object.assign({}, d, { kolicina: x, min: piSkaliraj(d.min, x, d.kolicina) });
        var rest = Object.assign({}, d, { kolicina: ostatak, min: piSkaliraj(d.min, ostatak, d.kolicina) });

        if (el.classList.contains('processItem')) {
            el.dataset.kolicina = x;
            el.querySelector('.piKol').textContent = piKg(x);
            el.style.height = (split.min / 15 * PI_SLOT_H) + 'px';
            updateItemTimes(el, buildSlotMap(el.closest('.boxList')));
            neporedeneDodaj(rest);
        } else {
            neporedeneRender(rest, el);
            neporedeneDodaj(split, el);
        }
    }

    // Merge je moguć samo između stavki istog artikla za isti dan
    function piOtvoriMerge(el) {
        piPripremiModal('piMergeModal', 'tplPiMerge');
        var d = piData(el);
        piKandidati = Array.from(document.querySelectorAll('.neporedenaStavka, .processItem')).filter(function (o) {
            if (o === el || o.classList.contains('ui-draggable-dragging')) return false;
            var od = piData(o);
            return od.artikal === d.artikal && od.dan === d.dan;
        });

        var nep = '', tl = '';
        piKandidati.forEach(function (o, i) {
            var od = piData(o);
            if (o.classList.contains('processItem')) {
                tl += '<option value="' + i + '">' + piVreme(o.dataset.startTime) + ' – ' + piVreme(o.dataset.endTime) + ' · ' + piKg(od.kolicina) + '</option>';
            } else {
                nep += '<option value="' + i + '">' + piEsc(od.id) + ' · ' + piKg(od.kolicina) + ' · ' + od.min + ' min</option>';
            }
        });

        var sel = document.getElementById('piMergeSel');
        sel.innerHTML = (nep ? '<optgroup label="Nepoređene stavke">' + nep + '</optgroup>' : '') +
            (tl ? '<optgroup label="Na timeline-u">' + tl + '</optgroup>' : '');
        sel.style.display = piKandidati.length ? '' : 'none';
        document.getElementById('piMergePrazno').style.display = piKandidati.length ? 'none' : '';
        document.getElementById('piMergeOk').disabled = !piKandidati.length;
        document.getElementById('piMergeNaziv').textContent = d.id + ' – ' + d.naziv;
        document.getElementById('piMergeKol').textContent = piKg(d.kolicina);
        piMergeRezultat();
        $('#piMergeModal').modal('show');
    }

    function piMergeRezultat() {
        var o = piKandidati[document.getElementById('piMergeSel').value];
        document.getElementById('piMergeRez').textContent = o ? piKg(piData(piCilj).kolicina + piData(o).kolicina) : '–';
    }

    // Od dve stavke nastaje nova; ako je bar jedna na timeline-u, nova zauzima raniju poziciju
    function piMerge(a, b) {
        var da = piData(a), db = piData(b);
        var d = Object.assign({}, da, {
            kolicina: Math.round((da.kolicina + db.kolicina) * 100) / 100,
            min: da.min + db.min
        });
        var t = [a, b].filter(function (o) { return o.classList.contains('processItem'); })
            .sort(function (x, y) { return parseInt(x.style.top, 10) - parseInt(y.style.top, 10); })[0];

        if (t) {
            var list = t.closest('.boxList');
            var top = parseInt(t.style.top, 10);
            $(a).remove();
            $(b).remove();
            postaviNaTimeline(list, d, top);
        } else {
            neporedeneDodaj(d, a);
            $(a).remove();
            $(b).remove();
        }
        neporedeneOsvezi();
    }

    $('body > .piHost').remove();
    $('#piHost').addClass('piHost').appendTo('body');

    $('#piSplitModal').on('shown.bs.modal', function () { $('#piSplitKol').trigger('focus'); });

    $(document).on('input', '#piSplitKol', piSplitOstatak);
    $(document).on('keydown', '#piSplitKol', function (e) {
        if (e.key === 'Enter') $('#piSplitOk').trigger('click');
    });

    $(document).on('click', '#piSplitOk', function () {
        var d = piData(piCilj);
        var x = parseFloat(document.getElementById('piSplitKol').value);
        if (!(x > 0 && x < d.kolicina)) {
            document.getElementById('piSplitGreska').textContent = 'Količina mora biti veća od 0 i manja od ' + piKg(d.kolicina) + '.';
            return;
        }
        piSplit(piCilj, x);
        $('#piSplitModal').modal('hide');
    });

    $(document).on('change', '#piMergeSel', piMergeRezultat);
    $(document).on('click', '#piMergeOk', function () {
        var o = piKandidati[document.getElementById('piMergeSel').value];
        if (!o) return;
        piMerge(piCilj, o);
        $('#piMergeModal').modal('hide');
    });

    document.addEventListener('mousedown', function (e) {
        if (!e.target.closest('#piMenu, .btnPiMenu')) piZatvoriMeni();
    });
    document.addEventListener('scroll', piZatvoriMeni, true);

    function initDragDrop() {
        initProcessItemDrag($(".processItem"));
        initNeporedenaDrag($(".neporedenaStavka"));

        $(".timeContent").droppable({
            accept: ".processItem, .neporedenaStavka",
            hoverClass: "drop-hover",
            drop: function (event, ui) {
                var $item = ui.draggable;
                var list = $(this).closest('.boxList')[0];
                var slotRow = $(this).closest('.timeSlotRow')[0];
                var newTop = slotRow.offsetTop;
                var slotH = 28;

                if ($item.hasClass('neporedenaStavka')) {
                    postaviNaTimeline(list, piData($item[0]), newTop);
                    $item.remove();
                    neporedeneOsvezi();
                } else {
                    var currentH = $item[0].offsetHeight || slotH;
                    $item.detach().appendTo(list).css({
                        position: 'absolute',
                        top: newTop + 'px',
                        left: '36px',
                        right: '0',
                        width: '',
                        height: currentH + 'px'
                    });
                    updateItemTimes($item[0], buildSlotMap(list));
                    pushDisplacedItems(list, $item[0], newTop, currentH);
                }
            }
        });
    }

    function buildSlotMap(list) {
        var map = [];
        list.querySelectorAll('.timeSlotRow').forEach(function (row) {
            map.push({ top: row.offsetTop, ts: parseInt(row.dataset.timestamp, 10) });
        });
        return map;
    }

    function pxToTimestamp(px, map) {
        for (var i = map.length - 1; i >= 0; i--) {
            if (px >= map[i].top) return map[i].ts;
        }
        return map.length ? map[0].ts : 0;
    }

    function updateItemTimes(item, map) {
        var top = parseInt(item.style.top, 10);
        item.setAttribute('data-start-time', pxToTimestamp(top, map));
        item.setAttribute('data-end-time', pxToTimestamp(top + item.offsetHeight, map));
    }

    function pushDisplacedItems(list, droppedItem, newTop, newH) {
        var slotH = 28;
        var dropBottom = newTop + newH;

        var itemsBelow = [];
        var itemsAbove = [];

        Array.from(list.querySelectorAll('.processItem')).forEach(function (other) {
            if (other === droppedItem) return;
            var t = parseInt(other.style.top, 10);
            if (t >= newTop) {
                itemsBelow.push({ el: other, origTop: t });
            } else {
                itemsAbove.push({ el: other, origTop: t });
            }
        });

        itemsBelow.sort(function (a, b) { return a.origTop - b.origTop; });
        itemsAbove.sort(function (a, b) { return b.origTop - a.origTop; });

        var boundary = dropBottom;
        itemsBelow.forEach(function (o) {
            if (o.origTop < boundary) {
                var pushed = Math.ceil(boundary / slotH) * slotH;
                o.el.style.top = pushed + 'px';
                boundary = pushed + o.el.offsetHeight;
            }
        });

        boundary = newTop;
        itemsAbove.forEach(function (o) {
            var h = o.el.offsetHeight;
            if (o.origTop + h > boundary) {
                var pushed = Math.max(Math.floor((boundary - h) / slotH) * slotH, 0);
                o.el.style.top = pushed + 'px';
                boundary = pushed;
            }
        });

        var map = buildSlotMap(list);
        itemsBelow.forEach(function (o) { updateItemTimes(o.el, map); });
        itemsAbove.forEach(function (o) { updateItemTimes(o.el, map); });
    }

    var _resizeBottomHandler = null;
    var _resizeTopHandler = null;

    function initResize() {
        var slotH = 28;
        var slotVH = 28;

        if (!document.getElementById('ppSchedulerStyle')) {
            var styleEl = document.createElement('style');
            styleEl.id = 'ppSchedulerStyle';
            styleEl.textContent =
                '.timeSlotRow { min-height: ' + slotVH + 'px !important; height: ' + slotVH + 'px !important; }' +
                '.timeContent { min-height: ' + slotVH + 'px !important; height: ' + slotVH + 'px !important; }';
            document.head.appendChild(styleEl);
        }

        document.querySelectorAll('.boxList').forEach(function (list) {
            var cursor = 0;
            var map = buildSlotMap(list);

            list.querySelectorAll('.processItem').forEach(function (item) {
                if (item.dataset.resizeInit) {
                    cursor = parseInt(item.style.top, 10) + item.offsetHeight;
                    return;
                }

                var h = slotVH;

                item.style.position = 'absolute';
                item.style.top = cursor + 'px';
                item.style.height = h + 'px';
                item.style.left = '36px';
                item.style.right = '0';
                item.style.width = '';

                item.insertAdjacentHTML('afterbegin', '<div class="resizeHandleTop"></div>');
                item.insertAdjacentHTML('beforeend', '<div class="resizeHandleBottom"></div>');
                item.dataset.resizeInit = '1';
                updateItemTimes(item, map);

                cursor += h;
            });
        });

        if (_resizeBottomHandler) document.removeEventListener('mousedown', _resizeBottomHandler);
        if (_resizeTopHandler) document.removeEventListener('mousedown', _resizeTopHandler);

        _resizeBottomHandler = function (e) {
            var handle = e.target.closest('.resizeHandleBottom');
            if (!handle) return;
            e.preventDefault();
            e.stopPropagation();

            var item = handle.closest('.processItem');
            var list = item.closest('.boxList');

            var startY = e.pageY;
            var startH = item.offsetHeight;
            var startTop = parseInt(item.style.top, 10);

            var allSlots = list.querySelectorAll('.timeSlotRow');
            var lastSlot = allSlots[allSlots.length - 1];
            var listMax = lastSlot ? lastSlot.offsetTop + slotH : list.scrollHeight;
            var maxH = listMax - startTop;

            var itemsBelow = [];
            Array.from(list.querySelectorAll('.processItem')).forEach(function (other) {
                if (other === item) return;
                var t = parseInt(other.style.top, 10);
                if (t >= startTop) itemsBelow.push({ el: other, origTop: t });
            });
            itemsBelow.sort(function (a, b) { return a.origTop - b.origTop; });

            item.classList.add('resizing');

            function onMoveBottom(e) {
                var dy = e.pageY - startY;
                var rawH = Math.round(Math.max(slotH, startH + dy) / slotH) * slotH;
                var newH = Math.min(rawH, maxH);
                item.style.height = newH + 'px';

                var boundary = startTop + newH;
                itemsBelow.forEach(function (o) {
                    if (o.origTop < boundary) {
                        var pushed = Math.ceil(boundary / slotH) * slotH;
                        o.el.style.top = pushed + 'px';
                        boundary = pushed + o.el.offsetHeight;
                    } else {
                        o.el.style.top = o.origTop + 'px';
                    }
                });
            }

            function onUpBottom() {
                document.removeEventListener('mousemove', onMoveBottom);
                document.removeEventListener('mouseup', onUpBottom);
                item.classList.remove('resizing');
                var map = buildSlotMap(list);
                updateItemTimes(item, map);
                itemsBelow.forEach(function (o) { updateItemTimes(o.el, map); });
            }

            document.addEventListener('mousemove', onMoveBottom);
            document.addEventListener('mouseup', onUpBottom);
        };

        _resizeTopHandler = function (e) {
            var handle = e.target.closest('.resizeHandleTop');
            if (!handle) return;
            e.preventDefault();
            e.stopPropagation();

            var item = handle.closest('.processItem');
            var list = item.closest('.boxList');

            var startY = e.pageY;
            var startTop = parseInt(item.style.top, 10);
            var startH = item.offsetHeight;
            var bottom = startTop + startH;

            var itemsAbove = [];
            Array.from(list.querySelectorAll('.processItem')).forEach(function (other) {
                if (other === item) return;
                var t = parseInt(other.style.top, 10);
                if (t < startTop) itemsAbove.push({ el: other, origTop: t });
            });
            itemsAbove.sort(function (a, b) { return b.origTop - a.origTop; });

            item.classList.add('resizing');

            function onMoveTop(e) {
                var dy = e.pageY - startY;
                var rawH = bottom - (startTop + dy);
                var newH = Math.round(Math.max(slotH, rawH) / slotH) * slotH;
                var newTop = bottom - newH;

                if (newTop < 0) { newTop = 0; newH = bottom; }
                item.style.top = newTop + 'px';
                item.style.height = newH + 'px';

                var boundary = newTop;
                itemsAbove.forEach(function (o) {
                    var itemH = o.el.offsetHeight;
                    if (o.origTop + itemH > boundary) {
                        var pushed = Math.max(Math.floor((boundary - itemH) / slotH) * slotH, 0);
                        o.el.style.top = pushed + 'px';
                        boundary = pushed;
                    } else {
                        o.el.style.top = o.origTop + 'px';
                    }
                });
            }

            function onUpTop() {
                document.removeEventListener('mousemove', onMoveTop);
                document.removeEventListener('mouseup', onUpTop);
                item.classList.remove('resizing');
                var map = buildSlotMap(list);
                updateItemTimes(item, map);
                itemsAbove.forEach(function (o) { updateItemTimes(o.el, map); });
            }

            document.addEventListener('mousemove', onMoveTop);
            document.addEventListener('mouseup', onUpTop);
        };

        document.addEventListener('mousedown', _resizeBottomHandler);
        document.addEventListener('mousedown', _resizeTopHandler);
    }

</script>
