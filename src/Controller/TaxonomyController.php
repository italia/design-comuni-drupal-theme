<?php

namespace Drupal\comuni_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\taxonomy\Entity\Term;

class TaxonomyController extends ControllerBase {

  public static function importTaxonomyTerms() {
    //non presenti: luogo, documento
    $argomentiVocab = 'argomenti';
    $eventiVitaPersoneVocab = 'eventi_della_vita_delle_persone';
    $eventiVitaImpresaVocab = 'eventi_della_vita_di_un_impresa';
    $tipiUnitaOrganizzativaVocab = 'tipi_unita_organizzativa';
    $tipiDiIncaricoVocab = 'tipi_di_incarico';
    $tipiDiNotiziaVocab = 'tipi_di_notizia';
    $tipiDiLuogoVocab = 'tipi_di_luogo';
    $tipiDiEventoVocab = 'tipi_di_evento';
    $categorieDeiServiziVocab = 'categorie_dei_servizi';
    $tipiDiDocumentoVocab = 'tipi_di_documento';
    $tipiPuntoDiContattoVocab = 'tipi_punto_di_contatto';
    $documentiAlboPretorioVocab = 'documenti_albo_pretorio';
    $temiDiUnDatasetVocab = 'temi_di_un_dataset';
    $licenzeVocab = 'licenze';
    $frequenzeDiAggiornamentoVocab = 'frequenze_di_aggiornamento';
    $statiDiUnaPraticaVocab = 'stati_di_una_pratica';

    $argomentiItems = [
      'Accesso all\'informazione',
      'Acqua',
      'Agricoltura',
      'Animale domestico',
      'Aria',
      'Assistenza agli invalidi',
      'Assistenza sociale',
      'Associazioni',
      'Bilancio',
      'Commercio all\'ingrosso',
      'Commercio al minuto',
      'Commercio ambulante',
      'Comunicazione istituzionale',
      'Comunicazione politica',
      'Concorsi',
      'Covid-19',
      'Elezioni',
      'Estero',
      'Energie rinnovabili',
      'Foreste',
      'Formazione professionale',
      'Gemellaggi',
      'Gestione rifiuti',
      'Giustizia',
      'Igiene pubblica',
      'Immigrazione',
      'Sport',
      'Imposte',
      'Imprese',
      'Inquinamento',
      'Integrazione sociale',
      'Isolamento termico',
      'Istruzione',
      'Lavoro',
      'Matrimonio',
      'Mercato',
      'Mobilità sostenibile',
      'Morte',
      'Nascita',
      'Parcheggi',
      'Patrimonio culturale',
      'Pesca',
      'Piano di sviluppo',
      'Pista ciclabile',
      'Politica commerciale',
      'Polizia',
      'Prodotti alimentari',
      'Protezione civile',
      'Residenza',
      'Risposta alle emergenze',
      'Sistema giuridico',
      'Spazio Verde',
      'Sviluppo sostenibile',
      'Tassa sui servizi',
      'Tempo libero',
      'Trasparenza amministrativa',
      'Trasporto pubblico',
      'Turismo',
      'Urbanizzazione',
      'Viaggi',
      'Zone pedonali',
      'ZTL',
    ];

    $eventiVitaPersoneItems = [
      'Iscrizione Scuola/Università e/o richiesta borsa di studio',
      'Invalidità',
      'Ricerca di lavoro, avvio nuovo lavoro, disoccupazione',
      'Pensionamento',
      'Richiesta o rinnovo patente',
      'Registrazione o possesso veicolo',
      'Accesso al trasporto pubblico',
      'Compravendita/affitto casa/edifici/terreni, costruzione o ristrutturazione casa/edificio',
      'Cambio di residenza o domicilio',
      'Espatri oper lavoro, studio o pensionamento',
      'Richiesta passaporto, visto e assistenza viaggi internazionali',
      'Nascita di un bambino, richiesta adozioni',
      'Matrimonio e/o cambio stato civile',
      'Morte ed eredità',
      'Prenotazione e disdetta visite/esami',
      'Denuncia crimini',
      'Dichiarazione dei redditi, versamento e riscossione tributi/imposte e contributi',
      'Accesso ai luoghi della cultura',
      'Possesso, cura, smarrimento animale da compagnia'
    ];

    $eventiVitaImpresaItems = [
      'Avvio impresa',
      'Avvio nuova attività professionale',
      'Richiesta licenze, permessi e certificati',
      'Registrazione impresa transfrontaliera',
      'Avviso e registrazione filiale',
      'Finanziamento impresa',
      'Gestione personale',
      'Pagamento iva, tasse e dogane',
      'Notifiche autorità',
      'Chiusura impresa e attività professionale',
      'Chiusura filiale',
      'Ristrutturazione impresa',
      'Vendita impresa',
      'Bancarotta',
      'Partecipazione ad appalti pubblici nazionali e transfrontalieri'
    ];

    $tipiUnitaOrganizzativaItems = [
      'struttura amministrativa' => [
        'area',
        'ufficio'
      ],
      'struttura politica' => [
        'giunta comunale',
        'consiglio comunale',
        'commissione'
      ],
      'altra struttura' => [
        'biblioteca',
        'museo',
        'azienda municipalizzata',
        'ente',
        'fondazione',
        'scuola',
        'centro culturale',
      ]
    ];

    $tipiDiIncaricoItems = [
      'politico',
      'amministrativo',
      'altro'
    ];

    $tipiDiNotiziaItems = [
      'news',
      'comunicato stampa',
      'avviso'
    ];

    $tipiDiLuogoItems = [
      'Architettura Militare e fortificata' => [
        'Castello',
        'Fortezza',
        'Mura',
        'Roccaforte',
        'Torre'
      ],
      'Architettura Residenziale' => [
        'Trullo',
        'Villa',
        'Palazzo'
      ],
      'Area archeologica' => [
        'Sito archeologico',
        'Parco archeologico'
      ],
      'Centro per la cultura' => [
        'Acquario',
        'Anfiteatro',
        'Archivio',
        'Auditorium',
        'Biblioteca',
        'Cinema',
        'Galleria',
        'Museo',
        'Osservatorio',
        'Pinacoteca',
        'Planetario',
        'Scuola',
        'Teatro',
        'Università/Facoltà',
        'Parco Archeologico',
      ],
      'Edificio di culto' => [
        'Abbazia',
        'Chiesa',
        'Campanile',
        'Battistero',
        'Convento',
        'Duomo',
        'Edicola',
        'Eremo',
        'Mausoleo',
        'Monastero',
        'Santuario',
        'Sinagoga',
        'Tempio',
        'Sepolcro',
        'Basilica',
        'Cappella',
        'Catacomba',
        'Cattedrale',
        'Cimitero'
      ],
      'Monumento o complesso monumentale' => [
        'Archi',
        'Colonna',
        'Complesso monumentale',
        'Monumento',
        'Obelisco'
      ],
      'Parco e giardino' => [
        'Belvedere',
        'Parco',
        'Giardino',
        'Viale'
      ],
      'Bellezza naturale' => [
        'Costa marittima',
        'Lago',
        'Corso d’acqua',
        'Montagna',
        'Ghiacciaio',
        'Riserva Naturale',
        'Foresta e bosco',
        'Vulcano',
      ],
      'Luogo per lo sport e il tempo libero' => [
        'Campo sportivo',
        'Piscina',
        'Stadio',
        'Terme',
        'Casinò',
        'Circolo sportivo',
        'Piazza'
      ],
      'Architettura commerciale' => [
        'Mercati',
        'farmacie'
      ],
      'Centro per l\'assistenza e la tutela sociale' => [
        'Casa di riposo',
        'Centro di accoglienza',
        'Ospedale'
      ],
      'Infrastruttura e impianto' => [
        'Centro di raccolta',
        'Acquedotto',
        'Aeroporto',
        'Porto'
      ],
      'Struttura ricettiva' => [
        'Albergo',
        'Foresteria',
        'Rifugio',
        'Rifugio per animali'
      ],
    ];

    $tipiDiEventoItems = [
      'Evento culturale' => [
        'Manifestazione artistica' => [
          'Festival',
          'Mostra',
          'Spettacolo teatrale',
          'Spettacolo di danza',
          'Manifestazione musicale',
          'Visita guidata',
          'Lettura (pubblica)',
          'Proiezione cinematografica',
          'Visita libera',
        ],
        'Evento di formazione' => [
          'Scuola estiva/invernale',
          'Webinar',
          'Seminario',
          'Laboratorio',
          'Presentazione libro',
          'Corso'
        ],
        'Conferenza e Summit' => [
          'Convegno',
          'Vertice',
          'Congresso'
        ],
        'Giornata Informativa' => [
          'Giornata aperta'
        ]
      ],
      'Evento sociale' => [
        'Concorso e cerimonia' => [
          'Cerimonia',
          'Concorso/competizione'
        ],
        'Dibattito pubblico' => [
          'Dibattito/dialogo pubblico',
          'Forum'
        ],
        'Incontro con esperti' => [
          'Riunione esperti',
          'Hackathon / Datathon'
        ],
        'Raduno di comunità' => [
          'Sfilata',
          'Sagra',
          'Torneo storico o Palio',
          'Festa Patronale o dei santi',
          'Mercatino',
          'Commemorazione',
        ],
        'Evento religioso' => [
          'Giubileo',
          'Udienza giubiliare',
          'Processione',
          'Celebrazione religiosa',
          'Lettura religiosa',
          'Raduno religioso',
          'Santificazione',
        ]
      ],
      'Evento politico' => [
        'Incontro pubblico' => [
          'Congresso o riunione di partito',
          'Corteo o sciopero',
          'Comizio elettorale'
        ]
      ],
      'Evento di affari o commerciale' => [
        'Fiera o Salone' => [
          'Fiera o Salone',
          'Esposizione o Esposizione globale'
        ],
        'Riunione d\'affari' => [
          'Riunione d’affari',
          'Convention',
          'Tavola rotonda'
        ],
        'Evento stagionale commerciale' => [
          'Vendita di fine stagione'
        ]
      ],
      'Evento Sportivo' => [
        'Manifestazione sportiva' => [
          'Partita',
          'Gara o Torneo o Competizione',
          'Escursione',
          'Galà sportivo',
          'Corsa',
          'Raduno sportivo',
        ]
      ]
    ];

    $categorieDeiServiziItems = [
      'Anagrafe e stato civile',
      'Cultura e tempo libero',
      'Vita lavorativa',
      'Attività produttive e commercio',
      'Appalti pubblici',
      'Catasto e urbanistica',
      'Turismo',
      'Mobilità e trasporti',
      'Educazione e formazione',
      'Giustizia e sicurezza pubblica',
      'Tributi, finanze e contravvenzioni',
      'Ambiente',
      'Salute, benessere e assistenza',
      'Autorizzazioni',
      'Agricoltura e pesca',
      'Imprese e commercio'
    ];

    $tipiDiDocumentoItems = [
      'Documento albo Pretorio',
      'Modulistica',
      'Documento funzionamento interno',
      'Atto normativo',
      'Accordo tra enti',
      'Documento attività politica',
      'Documento (tecnico) di supporto',
      'Istanza',
      'Documento di programmazione e rendicontazione',
      'Dataset'
    ];

    $tipiPuntoDiContattoItems = [
      'Email',
      'Telefono',
      'URL',
      'PEC',
      'Account' => [
        'Whatsapp',
        'Telegram',
        'Skype',
        'Linkedin',
        'Twitter',
      ]
    ];

    $documentiAlboPretorioItems = [
      'Atto amministrativo' => [
        'Decreto' => [
          'Decreto del Dirigente',
          'Decreto del Sindaco'
        ],
        'Deliberazione' => [
          'Deliberazione del Consiglio comunale',
          'Deliberazione della Giunta comunale',
          'Deliberazione del Commissario ad acta',
          'Deliberazione del Consiglio circoscrizionale',
          'Deliberazione dell\'Esecutivo circoscrizionale',
          'Deliberazione di altri Organi'
        ],
        'Determinazione' => [
          'Determinazione del Sindaco',
          'Determinazione del Dirigente'
        ],
        'Ordinanza' => [
          'Ordinanza del Dirigente',
          'Ordinanza del Sindaco'
        ]
      ],
      'Atto autorizzativo' => [
        'Permesso a costruire' => [
          'Permesso a costruire'
        ]
      ],
      'Atto dello stato civile' => [
        'Provvedimento di cancellazione per irreperibilità' => [
          'Provvedimento di cancellazione per irreperibilità'
        ],
        'Pubblicazione cambio nome' => [
          'Pubblicazione cambio nome'
        ],
        'Pubbicazione di matrimonio' => [
          'Pubbicazione di matrimonio'
        ]
      ],
      'Atto generico' => [
        'Avviso' => [
          'Avviso di deposito in casa comunale',
          'Avviso/Manifesto'
        ],
        'Bando' => [
          'Bando di concorso',
          'Bando di gara',
          'Bando di contributi e vantaggi economici'
        ]
      ],
      'Pubblicazione esterna' => [
        'Atto di terzi' => [
          'Atto di terzi'
        ]
      ],
    ];

    $temiDiUnDatasetItems = [
      'agricoltura, pesca, silvicoltura e prodotti alimentari',
      'economia e Finanze',
      'istruzione, cultura e sport',
      'energia',
      'ambiente',
      'governo e settore pubblico',
      'salute',
      'tematiche internazionali',
      'giustizia, sistema giuridico e sicurezza pubblica',
      'popolazione e società',
      'regioni e città',
      'scienza e tecnologia',
      'trasporti',
    ];

    $licenzeItems = [
      'licenza aperta' => [
        'pubblico dominio',
        'attribuzione',
        'effetto virale',
        'condivisione allo stesso modo - copyleft non compatibile',
      ],
      'non aperta' => [
        'solo uso non commerciale',
        'non opere derivate'
      ],
      'licenza sconosciuta',
    ];

    $frequenzeDiAggiornamentoItems = [
      'altro',
      'annuale',
      'bidecennale',
      'biennale',
      'bimensile',
      'bimestrale',
      'bisettimanale',
      'continuo',
      'decennale',
      'due volte al giorno',
      'in continuo aggiornamento',
      'irregolare',
      'mai',
      'mensile',
      'ogni cinque anni',
      'ogni due ore',
      'ogni ora',
      'ogni quattro anni',
      'ogni tre ore',
      'quindicinale',
      'quotidiano',
      'sconosciuto',
      'semestrale',
      'settimanale',
      'tre volte a settimana',
      'tre volte al mese',
      'tre volte all\'anno',
      'tridecennale',
      'triennale',
      'trimestrale'
    ];

    $statiDiUnaPraticaItems = [
      'Processo non avviato' => [
        'In bozza'
      ],
      'Processo in corso',
      'Processo sospeso' => [
        'Si richiede un’azione da parte dell\'utente',
        'Si richiede un\'azione da parte della Pubblica Amministrazione'
      ],
      'Processo concluso' => [
        'Esito positivo',
        'Esito negativo'
      ]
    ];

    self::recursiveInsertTaxonomyTerms($argomentiItems, $argomentiVocab);
    self::recursiveInsertTaxonomyTerms($eventiVitaPersoneItems, $eventiVitaPersoneVocab);
    self::recursiveInsertTaxonomyTerms($eventiVitaImpresaItems, $eventiVitaImpresaVocab);
    self::recursiveInsertTaxonomyTerms($tipiUnitaOrganizzativaItems, $tipiUnitaOrganizzativaVocab);
    self::recursiveInsertTaxonomyTerms($tipiDiIncaricoItems, $tipiDiIncaricoVocab);
    self::recursiveInsertTaxonomyTerms($tipiDiNotiziaItems, $tipiDiNotiziaVocab);
    self::recursiveInsertTaxonomyTerms($tipiDiLuogoItems, $tipiDiLuogoVocab);
    self::recursiveInsertTaxonomyTerms($tipiDiEventoItems, $tipiDiEventoVocab);
    self::recursiveInsertTaxonomyTerms($categorieDeiServiziItems, $categorieDeiServiziVocab);
    self::recursiveInsertTaxonomyTerms($tipiDiDocumentoItems, $tipiDiDocumentoVocab);
    self::recursiveInsertTaxonomyTerms($tipiPuntoDiContattoItems, $tipiPuntoDiContattoVocab);
    self::recursiveInsertTaxonomyTerms($documentiAlboPretorioItems, $documentiAlboPretorioVocab);
    self::recursiveInsertTaxonomyTerms($temiDiUnDatasetItems, $temiDiUnDatasetVocab);
    self::recursiveInsertTaxonomyTerms($licenzeItems, $licenzeVocab);
    self::recursiveInsertTaxonomyTerms($frequenzeDiAggiornamentoItems, $frequenzeDiAggiornamentoVocab);
    self::recursiveInsertTaxonomyTerms($statiDiUnaPraticaItems, $statiDiUnaPraticaVocab);
  }

  public static function termAlreadyExists($term, $tax_name) {
    $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['name' => $term, 'vid' => $tax_name]);
    $term = reset($term);

    if ($term) {
      return $term;
    }

    return false;
  }

  public static function recursiveInsertTaxonomyTerms($array, $tax_name, $parent_id = null) {
    foreach ($array as $key => $value) {
      if (!is_numeric($key)) { //se NON è numerico, ha dei figli
        $term = self::termAlreadyExists($key, $tax_name);
        if (!$term) { //se non esiste già lo crea
          if ($parent_id !== null) {
            //inserisci col parent id
            $term = Term::create([
              'parent' => ['target_id' => $parent_id],
              'name' => $key,
              'vid' => $tax_name,
            ]);

            $term->save();
          } else {
            $term = Term::create([
              'parent' => [],
              'name' => $key,
              'vid' => $tax_name,
            ]);

            $term->save();
          }
        }

        $parentId = $term->id(); //iod di 'licenza aperta'

        self::recursiveInsertTaxonomyTerms($value, $tax_name, $parentId);
      } else {
        $term = self::termAlreadyExists($value, $tax_name);
        if (!$term) { //se non esiste già lo crea
          if ($parent_id !== null) {
            $term = Term::create([
              'parent' => ['target_id' => $parent_id],
              'name' => $value,
              'vid' => $tax_name,
            ])->save();
          } else {
            $term = Term::create([
              'parent' => [],
              'name' => $value,
              'vid' => $tax_name,
            ])->save();
          }
        }
      }
    }
  }
}
