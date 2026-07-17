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

## Fokus

Trenutni razvoj: `planiranje_procesa/` — planiranje procesa proizvodnje po periodu, sa filterom (period, proces, proizvod, lot).
