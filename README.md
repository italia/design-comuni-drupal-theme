# ![developers.italia](https://avatars1.githubusercontent.com/u/15377824?s=36&v=4 "developers.italia") Design Comuni Italia
[![Join the #design siti scuole channel](https://img.shields.io/badge/Slack%20channel-%23design_siti_comuni-blue.svg)](https://developersitalia.slack.com/messages/design-siti-comuni/)

## **Un sito per i Comuni italiani**
### I primi passi con il tema Dupal (v1.7.1)

**Design Comuni Italia** è il tema Drupal che permette di aderire al [modello di sito istituzionale dei Comuni](https://designers.italia.it/modello/comuni/), progettato dal Dipartimento per la trasformazione digitale.

## **Installazione e supporto**
#### **Come installare il tema**

Prepara un'installazione in locale di Drupal con il seguente comando composer:

~~~
composer create-project drupal/recommended-project:^9 my_site_name_dir
~~~

Procedi con il normale processo di installazione di Drupal in lingua italiana caricando il sito e seguendo le istruzioni nel browser

All'interno della cartella *modules* crea la cartella *custom*, poi al suo interno scarica il progetto con il seguente comando git:

~~~
git clone https://github.com/italia/design-comuni-drupal-theme.git
~~~

Nel file *settings.php* che puoi trovare in */web/sites/default/settings.php* modifica la riga che contiene la chiave `$settings['config_sync_directory']` in questo modo:

~~~
$settings['config_sync_directory'] = 'modules/custom/design-comuni-drupal-theme/comuni_theme/config/sync';
~~~

Nello stesso file cerca la riga che contiene la chiave `$settings['file_private_path']` e modificala assegnandole una path a una cartella con permssi di scrittura al di fuori della cartella di Drupal:

~~~
$settings['file_private_path'] = 'path/to/your/folder';
~~~

Nella cartella principale di drupal che si è selezionata durante l'installazione con composer esegui il seguente comando:

~~~
composer require drupal/views_field_view:^1.0@beta drupal/csv_serialization:^2.1  cweagans/composer-patches drupal/menu_trail_by_path drupal/better_exposed_filters drupal/better_social_sharing_buttons drupal/color_field drupal/content_synchronizer drupal/devel drupal/fontawesome drupal/jquery_ui_touch_punch drupal/node_read_time drupal/paragraphs drupal/pathauto drupal/quick_node_clone drupal/restui drupal/search_api drupal/site_settings drupal/twig_tweak  drupal/views_show_more drush/drush drupal/menu_export:^1.3 drupal/chosen:^3.0 drupal/force_password_change:^2.0 drupal/smtp:^1.2 drupal/field_group:~3.4 drupal/time_field:^2.1 drupal/mix:^1.2 drupal/metatag:^1.23 drupal/textarea_widget_for_text:^1.2
~~~

Nel file *composer.json* inserire la seguente patch all'interno della chiave `extra`:

~~~
"enable-patching": true,
    "patches": {
      "drupal/views_show_more": {
        "<After update to Drupal 9.3.0 on second click on Show more button page reloads and shows 404 error>": "https://www.drupal.org/files/issues/2021-12-17/views_show_more-3254931_4.patch"
    }
},
~~~

Sempre nella cartella principale di Drupal esegui l'installazione delle dipendenze di composer con il seguente comando:

~~~
composer install
~~~

Spostati alla pagina di admin del sito e attiva il modulo *Design Comuni Italia*, poi verifica che il modulo *Update Manager* sia disabilitato e nel caso contrario disinstallalo, quindi attiva il tema *Comuni Theme*

Rimuovi gli shortcut nell'admin con il seguente comando drush:

~~~
drush entity:delete shortcut_set -y
~~~

Imposta l'*uuid* del sito con il seguente comando drush:

~~~
drush cset system.site uuid 94d95421-24ae-4514-bfd3-7b52524a23cd -y
~~~

Prepara la configurazione per la lingua italiana:

~~~
drush cdel language.entity.it
~~~

Abilita il modulo "chosen" e scarica la libreria necessaria al modulo:

~~~
drush pm:enable chosen
drush chosenplugin
~~~

Abilita modulo media_library:

~~~
drush pm:enable media_library
~~~

Importa i file di configurazione del sito con il seguentecomando drush (se necessario il comando può essere ripetuto più volte):

~~~
drush cim --partial --source=modules/custom/design-comuni-drupal-theme/comuni_theme/config/sync -y
~~~

Dalla cartella *comuni-theme* lancia il comando 

~~~
npm install
~~~

per installare Bootstrap Italia

Nella sezione contenuti dall'admin di Drupal selezionare la tab *Content Synchronizer* ed importare i quattro bundle di contenuti, presenti nella cartella *content* della cartella del tema Design Comuni Drupal nel seguente ordine (se necessario aumentare il valore della dimensione massima consentita per gli upload in php.ini):

- Taxonomy
- Block 
- SiteSetting
- Pages

Per importare i menu, nella sezione struttura dall'admin di Drupal selezionare *Menu Export*, successivamente *Importa* e infine Import Menu Links.

Ripulire la cache corrente con il seguente comando drush:

~~~
drush cr
~~~

Importa il logo svg del comune spostando il file svg nella cartella */web/sites/default/files*, poi dalla sezione *site settings* dei contenuti modifica l'entry *Info Comune* e inserisci la path al file svg nella sezione *Logo svg*

Se necessario ripulire la cache di drupal un'ultima volta.

#### Per categorizzare "Esplora" nelle pagine di secondo livello
In modifica della pagina Servizi, nel componente Esplora, al campo "Esplora - Vocabolario", selezionare il vocabolario "Categorie dei servizi".
In modifica della pagina Novità, nel componente Esplora, al campo "Esplora - Vocabolario", selezionare il vocabolario "Tipi di notizia".
In modifica della pagina Amministrazione, nel componente "Container contenuti in evidenza - Esplora l'amministrazione", selezionare il tipo di visualizzazione "Amministrazione (con Data Element)".
In modifica della pagina Documenti e dati, nel componente Esplora, al campo "Esplora - Vocabolario", selezionare il vocabolario "Tipi di documento".
In modifica della pagina Tutti gli argomenti, nel componente Esplora, al campo "Esplora - Vocabolario", selezionare il vocabolario "Argomenti".

#### **Supporto tecnico ed editoriale**
Sul [canale Slack #design-siti-comuni](http://developersitalia.slack.com/messages/design-siti-comuni) puoi confrontarti sulle risorse e trovare le risposte a tutte le domande riguardo problemi tecnici o l’architettura dei contenuti.

È necessario avere un’utenza Slack di Developers Italia. [Attivala adesso](https://slack.developers.italia.it/).


## **Indice**

- [Cos'è e cosa fa](#cosè)
- [Da dove iniziare](#da-dove-iniziare)
- [Relazioni tra i contenuti](#relazioni-tra-i-contenuti)
- [Riscrivere o importare i contenuti del vecchio sito](#riscrivere-o-importare-i-contenuti-del-vecchio-sito)
- [Personalizzazione](#personalizzazione)
- [Servizi esterni](#servizi-esterni)
- [La community di riferimento](#la-community-di-riferimento)
- [FAQ](#faq)
- [Licenze software dei componenti di terze parti](#licenze-software-dei-componenti-di-terze-parti)
- [Segnalazione bug](#segnalazione-bug)
- [Come contribuire](#come-contribuire)

#### **Cos'è e cosa fa**
Il tema Design Comuni Italia è un’applicazione di Drupal, il sistema di gestione di contenuti (CMS), che consente di creare un sito web comunale sulla base del [modello Comuni](https://designers.italia.it/modello/comuni/), creato nell’ambito del progetto Designers Italia dal Dipartimento per la trasformazione digitale.

Il tema Drupal è stato progettato per aderire rapidamente al modello di sito comunale. Il tema, infatti, imposta automaticamente lo stile grafico del sito, le aree del sito, i layout delle pagine e il menu di navigazione. Il compito dei redattori rimane, quindi, quello di curare i contenuti delle pagine, risparmiando così tempo e risorse nella progettazione e realizzazione del sito.


#### **Da dove iniziare**

I siti Drupal presentano una serie di tipologie di contenuto (content type) che sono in relazione tra loro. Ogni tipologia di contenuto viene creata attraverso una “scheda” nel backend di Drupal, che presenta i vari campi dove aggiungere i contenuti per creare la pagina.

Consigliamo di cominciare a creare i diversi contenuti in questo ordine:

- punti di contatto;
- persone pubbliche;
- luoghi;
- unita organizzative;

Una volta iniziato il lavoro sulle prime 4 tipologie di contenuto suggerite, si può continuare con:

- documenti pubblici;
- dataset;
- eventi;
- notizie;
- fasi;
- servizi;


#### **Relazioni tra i contenuti**

L'impostazione per tipologie di contenuto (content type) permette di combinare i vari elementi per la creazione delle pagine, così che i contenuti vengano creati soltanto una volta e poi riutilizzati, se necessario, in varie parti del sito. Una volta comprese le relazioni tra le tipologie di contenuti, sarà facile creare le pagine del sito.

Alcune relazioni tra tipologie di contenuti, sono:

Unità Organizzative - Servizi
Incarichi - Persone Pubbliche
Unità Organizzative - Luoghi
Servizi - Documenti Pubblici

Questo significa, ad esempio, che ogni pagina di un'unità organizzativa può presentare una relazione con contenuti come i luoghi e i servizi.

**Attenzione!** Dal punto di vista pratico, è necessario che i contenuti che si vuole collegare vengano creati in un ordine preciso: prima i content type che fungono da contenuti di dettaglio e poi il content type contenitore (es. prima le persone, il luogo e punti di contatto e solo dopo l'evento che raggruppa persone, luogo e punti di contatto creati in precedenza).

Per collegare tra loro diverse tipologie di contenuto, quindi:

1.	crea la scheda o le schede dei contenuti di dettaglio (ad esempio, il luogo “Palazzo Baldini” che verrà associato ad un'unità organizzativa);
2.	crea la scheda del contenuto contenitore (ad esempio, la scheda della unità organizzativa “Assessorato al Turismo”);
3.	Associa, tramite l’apposito campo, le schede contenuto di dettaglio alla scheda contenuto (ad esempio, il luogo “Palazzo Baldini” all'unità organizzativa “Assessorato al Turismo”).

Per associare nuovi contenuti di dettaglio ad altri già esistenti:

1.	Crea la nuova scheda di contenuto di dettaglio (ad esempio, la scheda servizio “Iscrizione alla Scuola dell’infanzia” da associare alla scheda del contenuto contenitore “Assessorato all'Educazione”).
2.	Entra nella scheda del contenuto contenitore e, tramite l’apposito campo, associa la scheda del contenuto di dettaglio (la scheda servizio “Iscrizione alla Scuola dell’infanzia” alla scheda “Assessorato all'Educazione”).


Nella maggior parte dei casi questa correlazione è bidirezionale e automatica. Quando si crea, ad esempio, una relazione tra un luogo e una struttura, questa verrà mostrata sia nel dettaglio del luogo che in quello della struttura.


#### **Riscrivere o importare i contenuti del vecchio sito**

L’aggiornamento di un sito è un’ottima opportunità per riscrivere, riorganizzare ed aggiornare tutti i contenuti relativi a (elenco content type principali).

Notizie ed eventi passati, non essendo più attuali, non vanno migrati sul nuovo sito.

Per importare documenti e dataset dal vecchio al nuovo sito, si può utilizzare lo strumento di import/export incluso nel sito sotto la tab contenuti. La resa di questi contenuti, una volta migrati, andrà verificata manualmente e dipenderà molto dalla qualità degli stessi nel sito precedente. 


#### **Personalizzazione**

Nell’area di configurazione è possibile (e talvolta necessario) personalizzare alcuni caratteristiche del sito, come i testi di presentazione o le notizie da mostrare in evidenza o nella pagina di presentazione del comune.

L’area di configurazione è divisa in tab per le diverse aree del sito.

Cliccando su “Configurazione,  è possibile definire:

-	**opzione 1**: descrizione;
-	**opzione 2**: descrizione.


#### **Servizi esterni**

Il tema Drupal è realizzato per supportare il collegamento a API esterne per quel che concerne le funzionalità di valutazione, prenotazione appuntamento e richiesta di assistenza. Ogni amministrazione comunale dovrà quindi provvedere ad integrare i form forniti con il modulo con un servizio esterno realizzato a propria discrezione andando a modificare i file che andremo ad elencare di seguito. Per l'effettivo inserimento dei file all'interno del progetto si può agire in due modi

- se vogliamo che i file siano minificati per un incremento delle performance del sito è necessario avviare un processo di build tramite `npm` dopo la modifica del file, come verrà descritto in seguito. Assicurarsi di aver installato [Node.js](https://nodejs.org/it/download/) almeno della versione 16.x e installato le dipendenze con il comando

```sh
npm install
```

successivamente occorre lanciare il comando per minificare e rendere disponibile il file

```sh
npm run build
```

- se non abbiamo modo di minificare il file (scelta sconsigliata) possiamo copiare e incollare i file da `assets-src` verso `js` così come sono e modificarli.

**_Valutazione_**
Al termine del processo di valutazione viene inoltrato all'endpoint `/api/v1/create/valutazione` un payload con il seguente formato:
```json
{
  "freeText": "Ho creato piu' contenuti con lo stesso titolo",
  "page": "http://localhost:8085/homepage",
  "radioResponse": "Non capivo se quello che facevo era corretto",
  "star": 4,
  "title": "Homepage | Nome del comune"
}
```
**_Prenotazione appuntamento_**
Per funzionare correttamente, senza dover intervenire sul codice, la chiamata che restituisce le date disponibili, dovrà rispettare il seguente formato:
```json
[
  {
    "startDate": "2022-07-04T09:00",
    "endDate": "2022-07-04T09:45"
  },
  {
    "startDate": "2022-07-04T09:45",
    "endDate": "2022-07-04T10:30"
  },
  {
    "startDate": "2022-07-05T09:45",
    "endDate": "2022-07-05T10:30"
  }
]
```
Al termine della procedura per la prenotazione viene inviato all'endpoint `/api/v1/create/appuntamento` un payload nel seguente formato:
```json
{
  "office":"Assessorato all'educazione",
  "place": {
    "nome":"Palazzina A. Volta",
    "indirizzo":"Piazza dell'Aia, 38",
    "apertura":"",
    "id":"20"
  },
  "appointment": {
    "startDate":"2022-07-05T09:45",
    "endDate":"2022-07-05T10:30"
  },
  "service":"Distribuzione gratuita depliant parchi nazionali",
  "moreDetails":"Abbiamo ricevuto uno scatolone in piu'",
  "name":"Piero",
  "surname":"Bianchi",
  "email":"piero.bianchi@istituto-einstein.it"
}
```
**_Richiesta di assistenza_**
Al termine della richiesta assistenza viene creato un payload nel seguente formato:
```json
{
  "title": "ticket_2022-07-15T12:47:02.560Z",
  "nome": "Mario",
  "cognome": "Rossi",
  "email": "mario@rossi.it",
  "categoria": "Attività produttive e commercio",
  "servizio": "Pagamento multa",
  "descrizione": "ho ricevuto la comunicazione",
}
```


#### **La community di riferimento**

Scopri i canali della community dove confrontarti sulle risorse del modello:

-	[Forum Italia](https://forum.italia.it/) - unisciti alla discussione sul design dei servizi digitali con gli esperti del settore;
-	[Canale Slack](http://developersitalia.slack.com/messages/design-siti-comuni) - dialoga e collabora in tempo reale con la community di Designers Italia;
-	[GitHub](https://github.com/italia/design-comuni-drupal-theme/) - il repository GitHub del tema Drupal “Design Comuni Italia”.

#### **F.A.Q**
➔	**Chi gestisce il sito?**

L’uso del tema non impatta le modalità con cui viene abitualmente gestito il sito comunale e rimane una responsabilità dei Comuni. Molti Comuni fanno affidamento su fornitori esterni per hosting e manutenzione.

➔	**Perché esistono temi pronti solo per Drupal e WordPress?**

Drupal e WordPress sono i CMS più usati dai Comuni. Puoi usare l’apposito [kit per creare temi per altri CMS](https://github.com/italia/design-comuni-pagine-statiche/).

➔	**Non ho Drupal. Cosa devo fare?**

Puoi passare a[ Drupal](https://www.drupal.it/) in qualunque momento, oppure usare le [altre risorse per la creazione del sito comunale](https://designers.italia.it/modello/comuni/). 


➔	**Quali sono i benefici dell’uso del tema Drupal?**

L’adozione del tema Drupal, pronto all’uso, ti permette di:
- usare configurazioni preimpostate, risparmiando tempo sugli aspetti più tecnici della creazione di un sito;
- dedicare più tempo alla cura dei contenuti e alla loro organizzazione, puntando sulla qualità. 

**➔	Posso fare dei cambiamenti al sito?**

Drupal è un ambiente pensato per modificare con semplicità ogni aspetto del sito. 

➔	**È consigliato fare cambiamenti al sito?**

Il tema Drupal copre già tutte le esigenze di base, emerse da una lunga ricerca con con il personale amministrativo e i cittadini. 

Drupal permette di aggiungere innumerevoli funzionalità, per far fronte alle esigenze dei singoli comuni (come, ad esempio, creare un’area condivisa di documenti o dataset). Quando si sviluppa una nuova funzionalità, è opportuno condividerla con il resto della comunità tramite [Forum Italia](https://forum.italia.it/), [GitHub](https://github.com/italia/design-comuni-drupal-theme/) o il [progetto Porte Aperte sul Web](https://www.porteapertesulweb.it/).

È sconsigliato apportare modifiche strutturali al sito, come modificare la classificazione delle informazioni o la struttura di navigazione. Modifiche di questo tipo possono impedire di beneficiare di evoluzioni future del prodotto, a cause di problematiche di aggiornamento del tema. Puoi segnalare necessità di questo tipo direttamente alla community di Designers Italia tramite i vari canali di contatto. I feedback ricevuti verranno raccolti e considerati per le successive evoluzioni del modello.

#### **Bootstrap Italia**
Design Comuni Italia rispetta le nuove linee guida di design dell’Agenzia per l’Italia digitale rilasciate dal [**Team per la Trasformazione Digitale**](https://teamdigitale.governo.it/) e le caratteristiche per i servizi web della Pubblica Amministrazione contenute nel Piano triennale per [destinazione e triennio]. 

Nel tema vengono integrate le componenti di [**Bootstrap Italia**](https://italia.github.io/bootstrap-italia/).

---

## Licenze software dei componenti di terze parti

### Componenti distribuiti con i template
Di seguito elencati i componenti distribuiti con il tema Drupal:

- [Better exposed filters](https://www.drupal.org/project/better_exposed_filters), licenza GNU GPL v2.0;
- [Better social sharing buttons](https://www.drupal.org/project/better_social_sharing_buttons), licenza GNU GPL v2.0;
- [Color field](https://www.drupal.org/project/color_field), licenza GNU GPL v2.0;
- [Composer patches](https://github.com/cweagans/composer-patches) © Cameron Eagans, licenza BSD 3
- [Content synchronizer](https://www.drupal.org/project/content_synchronizer), licenza GNU GPL v2.0;
- [CSV serialization](https://www.drupal.org/project/csv_serialization), licenza GNU GPL v2.0;
- [Devel](https://www.drupal.org/project/devel), licenza GNU GPL v2.0;
- [Drush](https://github.com/drush-ops/drush) © Moshe Weitzman, licenza GNU GPL v3.0
- [Fontawesome](https://www.drupal.org/project/fontawesome), licenza GNU GPL v2.0;
- [jQuery UI TouchPunch](https://www.drupal.org/project/jquery_ui_touch_punch), licenza GNU GPL v2.0;
- [Menu trail by path](https://www.drupal.org/project/menu_trail_by_path), licenza GNU GPL v2.0;
- [Node read time](https://www.drupal.org/project/node_read_time), licenza GNU GPL v2.0;
- [Paragraphs](https://www.drupal.org/project/paragraphs), licenza GNU GPL v2.0;
- [Pathauto](https://www.drupal.org/project/pathauto), licenza GNU GPL v2.0;
- [Quick Node Clone](https://www.drupal.org/project/quick_node_clone), licenza GNU GPL v2.0;
- [REST UI](https://www.drupal.org/project/restui), licenza GNU GPL v2.0;
- [Search API](https://www.drupal.org/project/search_api), licenza GNU GPL v2.0;
- [Site Settings and Labels](https://www.drupal.org/project/site_settings), licenza GNU GPL v2.0;
- [Views field view](https://www.drupal.org/project/views_field_view), licenza GNU GPL v2.0;
- [Views Show More](https://www.drupal.org/project/views_show_more), licenza GNU GPL v2.0;
- [Twig Tweak](https://www.drupal.org/project/twig_tweak), licenza GNU GPL v2.0;

Di seguito elencati i componenti distribuiti (derivati dal template html utilizzato per realizzare il tema: https://github.com/italia/design-comuni-drupal-theme/), che hanno una propria licenza diversa da CC0:

- [Package Name](repository url) © Author, License;


## Segnalazione bug
Vuoi segnalare un bug o fare una richiesta?

Prima di tutto assicurati che sia un problema relativo al tema Drupal e non a plugin installati o impostazioni del CMS, poi dai un'occhiata a come creare una [issue](https://github.com/italia/bootstrap-italia/blob/master/CONTRIBUTING.md#creare-una-issue) ed infine, se lo ritieni necessario, apri la issue [in questo repository](https://github.com/italia/design-comuni-drupal-theme/issues).

## Come contribuire
Vorresti dare una mano su Bootstrap Italia? Sei nel posto giusto!

Se non l'hai già fatto, inizia spendendo qualche minuto per approfondire la tua conoscenza sulle [linee guida di design per i servizi web della PA](https://design-italia.readthedocs.io/it/stable/index.html), e fai riferimento alle [indicazioni su come contribuire a Bootstrap Italia](https://github.com/italia/bootstrap-italia/blob/master/CONTRIBUTING.md).

A questo punto, è necessario impostare il tuo ambiente locale per la compilazione dei file sorgente e la generazione della documentazione. Alla [pagina relativa agli strumenti di compilazione](https://italia.github.io/bootstrap-italia/docs/come-iniziare/strumenti-di-compilazione/) è possibile avere tutte le informazioni necessarie a questo scopo.

---

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as published
by the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>
