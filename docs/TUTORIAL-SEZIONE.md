# Tutorial creazione sezione portale

Questo documento serve come riferimento per creare una nuova sezione all'interno del pannello utente del portale. A questo scopo viene di seguito spiegata in dettaglio la creazione della sezione *Affissioni* del pannello.


## 1) Premessa e DataBase

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


## 2) Back-end Laravel

Per poter leggere dal database i dati necessari e fornirli ad AngularJS in formato JSON, è necessario realizzare un nuovo controller Laravel.

Per prima cosa aggiungiamo le route necessarie nel file **api/app/Http/routes.php** come segue:

```
Route::resource('affissioni', 'AffissioniController');

Route::group(array('prefix'=>'affissioni'),function(){
	Route::get('dettaglio/{id}',array('uses'=>'AffissioniController@dettaglio'));
});
```

In questo modo stiamo aggiungendo una nuova route **/affissioni** e la stiamo associando al controller **AffissioniController** e stiamo inoltre creando una sottoroute **/affissioni/dettaglio/**.

La prima servirà a recuperare tutte le Affissioni di un determinato utente ```idtco_utente```, mentre con la sottoroute **dettaglio** abbiamo la possibilità di recuperare una determinata affissione, il tutto in formato JSON.

Per far questo dobbiamo quindi creare il controller **AffissioniController**, piazzandolo in un nuovo file **/api/app/Http/Controllers/AffissioniController.php**.

Il codice dell'intero file è reperibile [qui](https://github.com/Giambapisasale/WP-Angular-Bootstrap/blob/master/api/app/Http/Controllers/AffissioniController.php), focalizziamo l'attenzione sulle parti più importanti:

```
public function show($id)
{
    $affissioni = \DB::table("vista_affissioni_dichiazioni_completa")
        ->where("vista_affissioni_dichiazioni_completa.idtco_utente", "=", $id)
        ->get();
    return $affissioni;
}
```

con questo metodo stiamo implementando la route principale **/affissioni/id** che dato un valore numerico **id**, restituisce tutte le affissioni di un determinato utente **id**.

Più in dettaglio, con la seguente riga stiamo selezionando una query SELECT sulla tabella *vista_affissioni_dichiazioni_completa*:

````
$affissioni = \DB::table("vista_affissioni_dichiazioni_completa")
```

gli associamo la clausola WHERE:

```
->where("vista_affissioni_dichiazioni_completa.idtco_utente", "=", $id)
```

ed infine la eseguiamo e restituiamo il risultato:

```
->get();
    return $affissioni
```


## 3) Front-end AngularJS

TODO

## 4) Menu Wordpress

TODO
