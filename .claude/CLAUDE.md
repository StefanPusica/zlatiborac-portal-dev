# Zlatiborac Portal - Dev

## Kontekst projekta

Ovo je DEMO/DEV verzija Zlatiborac portala koja se izvrsava lokalno na Larogon serveru (`localhost`). Razvoj se radi direktno na fajlovima — nema git-a, nema build procesa, izmene su odmah vidljive u browseru.

Aktivni razvoj se odvija u `planiranje_procesa/` folderu.

## Arhitektura

- **Backend:** PHP, bez eksplicitnog framework-a — svaki fajl je view koji se ucitava dinamicki
- **Template sistem:** Views su PHP fajlovi sa izmesanim HTML/JS kodom; root `index.php` sluzi kao app shell
- **Frontend:** jQuery, jQuery UI (datepicker), Select2, Bootstrap 3 (glyphicons, grid)
- **AJAX pattern:** `urlContent(container, url, args, callback)` — globalna helper funkcija koja ucitava remote view u DOM element
- **Autorizacija:** `$login->getUserGroup()` + `UserNivo::$*` konstante; svaka stranica definise `$arrPrava` niz dozvoljenih rola

## Konvencije koda

- PHP short tags (`<?=`, `<?`) su standard u ovom projektu — koristiti ih
- HTML/PHP/JS je izmesano u istom fajlu — tako je dizajniran sistem
- Srpski jezik za UI labele i nazive promenljivih/klasa
- URL varijable dolaze iz parent context-a: `$proplaniranje_url`, `$public_url`, `$pro20_url`, `$img_url`
- Filter forma pattern: `mjsPopover` div + `mjsSearch()` jQuery plugin
- Sidebar pattern: `.mSideBar` div sa `ucitajSideBar(id)` funkcijom

## planiranje_procesa/ — struktura i tokovi

### Fajlovi

| Fajl | Opis |
|---|---|
| `index.php` | App shell: filter forma (period, proces, proizvod, lot), `.mSideBar`, JS funkcije |
| `pregled.php` | Flex wrapper + sve CSS klase za raspored; iterira datume, include-uje `pregled_datum.php` po danu |
| `pregled_datum.php` | Jedna kolona (datum); lista RN-ova kao `.processItem`, zatim 96 `.timeSlotRow` slotova (0:00–23:45 po 15min) |
| `pregled_process_item.php` | Jedan process item: flex row sa `btnArtikalInfo` (sidebar), količinom i `btnArtikalStatus` (modal) |
| `sidebar_nalog.php` | Sidebar panel: detalji naloga, tabela predajnice i trebovanja |

> `pregled.css` je uklonjen — svi stilovi su sada unutar `<style>` bloka u `pregled.php`.

### URL route-ovi (iz `index.php`)

- `planiranje_procesa_pregled` → učitava `pregled.php` u `.mContentBody`
- `planiranje_procesa_nalog/{id}` → učitava `sidebar_nalog.php` u `.mSideBar`
- `nadzor_pregled_dan` → učitava prikaz jednog dana (koristi `ucitajDan(datum)`)

### JS funkcije u `index.php`

- `loader()` — serijalizuje filter formu i poziva `urlContent` za pregled
- `ucitajSideBar(rowId)` — otvara `.mSideBar` i učitava nalog via `$.ajax`
- `ucitajDan(datum)` — osvežava jedan datum kolonu, override-uje start/kraj na isti datum
- `homeRowResize()` — prilagođava visine `.mFlexWrapper`, `.boxList`, `.mSideBar` prozoru
- `initDragDrop()` — jQuery UI draggable/droppable za premještanje process item-a
- `initResize()` — apsolutno pozicionira `.processItem` u koloni i dodaje resize handles (top/bottom)
- `buildSlotMap($list)` — gradi lookup `[{top, ts}]` iz `offsetTop` i `data-timestamp` svakih `.timeSlotRow`
- `pxToTimestamp(px, map)` — konvertuje piksel offset u Unix timestamp korišćenjem slot mape
- `updateItemTimes($item, map)` — setuje `data-start-time` i `data-end-time` na `.processItem`

### Process item pozicioniranje i vremena

`.processItem` elementi su **apsolutno pozicionirani** unutar `.boxList` (koje ima `position: relative`).  
`initResize()` ih slaže od `top: 0` naniže, u koracima od `slotH = 20px`.

`data-start-time` i `data-end-time` na svakom `.processItem` su **Unix timestamp** koji se setuju:
- pri inicijalnoj inicijalizaciji (`initResize`)
- nakon svakog resize-a (bottom i top handle, na `mouseup`)

Ove vrednosti korisnik kreira kroz UI (prevlačenje/resize) i šalju se na bekend u kasnijoj fazi.

Resize logika sprečava preklapanje: limit za bottom/top handle se računa skeniranjem **svih ostalih processItem-a po `top` vrednosti** (ne DOM redosled) unutar iste `.boxList`.

### Flex layout struktura

```
.mFlexWrapper
  .mFlexContent
    .mFlexContainer.linijaProcesi
      .mFlexBox (jedan po datumu) ← pregled_datum.php
        .boxTitle (naslov datuma)
        .boxList#statusList_{date}
          .processItem (po nalogu, abs. pozicioniran) ← pregled_process_item.php
            .resizeHandleTop / .resizeHandleBottom (dodaje JS)
          .timeSlotRow[data-timestamp] (96 slotova, 15min intervali)
            .timeLabel (vreme, HH:MM)
            .timeContent (drop zona)
```

### PHP kontekst u pregledima

- `$start`, `$kraj` — Unix timestamp ili datum string iz filter forme
- `$arr[$date]` — niz radnih naloga po datumu (key = `Y-m-d`)
- `$arrProces`, `$arrProizvod` — kolekcije za select dropdowne u filteru
- `$proces`, `$proizvod`, `$lot` — trenutno selektovane vrednosti filtera
- U `sidebar_nalog.php`: `$artikal`, `$artikal_naziv`, `$broj`, `$datum`, `$sifra`, `$arrPredajnica`, `$arrTrebovanje`
