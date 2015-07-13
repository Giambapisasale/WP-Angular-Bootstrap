# Tutorial creazione sezione portale

Questo documento serve come riferimento per creare una nuova sezione all'interno del pannello utente del portale. A questo scopo viene di seguito spiegata in dettaglio la creazione della sezione *Affissioni* del pannello.


1) Premessa e DataBase

All'interno del database abbiamo una tabella ````vista_affissioni_dichiazioni_completa```` avente la seguente struttura:

```
`idtaffissione_dichiarazione` int(11) NOT NULL DEFAULT '0'
`idgen_ente` int(11) DEFAULT NULL
`numero_dichiarazione` int(11) DEFAULT NULL
`data_dichiarazione` date DEFAULT NULL
`idtco_presentante` int(11) DEFAULT NULL
`idtco_utente` int(11) DEFAULT NULL
`titolo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci
`descrizione` text CHARACTER SET utf8 COLLATE utf8_unicode_ci
`tipo_riduzione` text CHARACTER SET utf8 COLLATE utf8_unicode_ci
`data_esposizione` date DEFAULT NULL
`numero_giorni` int(11) DEFAULT NULL
`importo_totale` double DEFAULT '0'
`importo_arrotondamento` double DEFAULT '0'
`flag_periodo_stag` int(11) DEFAULT NULL
`flag_diritto_urgenza` int(11) DEFAULT NULL
`stato` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
`contribuente` varchar(131) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
`presentante` varchar(131) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL

```

L'obiettivo è creare una view contenenti la lista di affissioni per l'utente corrente, identificato dal campo ```idtco_utente```, che mostra pochi campi per ogni riga, con la possibilità di selezionare una riga ed accedere ad una seconda view contenente tutti i campi della riga selezionata.


2) Back-end Laravel

TODO

3) Front-end AngularJS

TODO

4) Menu Wordpress

TODO
