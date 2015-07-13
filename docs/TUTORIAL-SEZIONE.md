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

Più in dettaglio, con la seguente riga stiamo selezionando una query *SELECT* sulla tabella *vista_affissioni_dichiazioni_completa*:

````
$affissioni = \DB::table("vista_affissioni_dichiazioni_completa")
```

gli associamo la clausola *WHERE*:

```
->where("vista_affissioni_dichiazioni_completa.idtco_utente", "=", $id)
```

ed infine la eseguiamo e restituiamo il risultato:

```
->get();
    return $affissioni
```

In maniera del tutto analoga implementiamo anche il metodo per il dettaglio:

```
public function dettaglio($id)
{
    $affissioni = \DB::table("vista_affissioni_dichiazioni_completa")
        ->where("vista_affissioni_dichiazioni_completa.idtaffissione_dichiarazione", "=", $id)
        ->get();
    return $affissioni;
}
```

l'unica differenza è chiaramente nella clausola *WHERE*.

Per approfondire le route ed i controller di Laravel si raccomanda di leggere la [documentazione](http://laravel.com/docs).


## 3) Front-end AngularJS

### Route

Anche lato front end occorre innanzitutto creare le nuove route, per far ciò va modificato il file **/portale/js/portale/config.js** ed inserite le apposite route utilizzando il metodo ```.state()``` sull'oggetto ```$stateProvider```.

Nel nostro caso, aggiungiamo due nuove route per le view Affissioni e relativo dettaglio:

```
.state('panel.affissioni', {
  url: 'affissioni/',
  views: {
    '': {
      controller: 'AffissioniCtrl',
      templateUrl: "partials/panel.affissioni.html"
    }
  }
})
.state('panel.affissioni-dettaglio', {
  url: 'affissioni/:id',
  views: {
    '': {
      controller: 'AffissioniDettaglioCtrl',
      templateUrl: "partials/panel.affissioni-dettaglio.html"
    }
  }
});
```

Il metodo .state() prende in input una stringa che rappresenta il nome della route:

```
panel.affissioni
```

```
panel.affissioni-dettaglio
```

(il prefisso ```panel.``` indica che tali route fanno parte delle route del pannello utente)

seguita da un oggetto avente i seguenti parametri:

```url```: indirizzo della view, è possibile specificare eventuali parametri del tipo *:id*
```controller```: nome del controller assegnato alla view
```templateUrl```: file html della view

per maggiori informazioni riguardo il sistema di routing in uso, fare riferimento [alla documentazione](http://angular-ui.github.io/ui-router/site/#/api/ui.router).


### Controller

I controller per il pannello vanno dichiarati all'interno del file **/portale/js/portale/panel.js**.

- Controller per la view Affissioni:

```
app.controller("AffissioniCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

  $http.get( "oauth/client.php?action=p&path=api/public/affissioni/" + $rootScope.$storage.token_.ID )
    .success(function(data, status, header, config) {
    $scope.affissioni = data;
  })
    .error(function(data, status, header, config) {
    console.log("Error in $http.get() of AffissioniCtrl");
  });

});
```

Il nome del controller ```AffissioniCtrl``` definito subito dopo ```app.controller(``` dev'essere chiaramente lo stesso che abbiamo definito nella configurazione della route con il parametro ```controller```.

All'interno del corpo della funzione controller, effettuiamo una chiamata ```$http.get``` al seguente indirizzo:

```"oauth/client.php?action=p&path=api/public/affissioni/" + $rootScope.$storage.token_.ID````

il parametro ```path``` dev'essere la corrispondente route di Laravel che fornisce la risorsa desiderata, in questo caso tale parametro prende il valore di:

```api/public/affissioni/``` concatenato al valore numerico ```$rootScope.$storage.token_.ID``` che corrisponde all'ID dell'utente corrente.

La chiamata ```$http.get``` permette di definire due funzioni, una in caso di successo ed un'altra in caso di errore.

La funzione passata al metodo ```.success()``` permette di gestire il caso in cui la chiamata ```$http.get``` vada a buon fine:

```
.success(function(data, status, header, config) {
  $scope.affissioni = data;
})
```

in questo caso viene ritornato un array ```data``` di oggetti JSON che noi associamo alla variabile ```$scope.affissioni```  per renderlo disponibile alla view e mostrare i dati all'utente.

La funzione passata al metodo ```.error()``` permette di gestire il caso in cui la chiamata ```$http.get``` fallisca, nel nostro caso la utilizziamo per stampare un errore di console tramite la funzione ```console.log()```.


- Controller la view dettaglio di Affissioni:

Analogamente a quanto descritto per il controller di Affissioni, occorre definire un controller per il dettaglio della stessa view:

```
app.controller("AffissioniDettaglioCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

  $http.get( "oauth/client.php?action=p&path=api/public/affissioni/dettaglio/" + $stateParams.id )
    .success(function(data, status, header, config) {
    if (data.length > 0) {
      $scope.affissioni = data[0];
    } else {
      console.log("Affissione " + $stateParams.id + " non esistente");
    }
  })
    .error(function(data, status, header, config) {
    console.log("Error in $http.get() of AffissioniDettaglioCtrl");
  });

});
```

Ci un paio di differenze, rispetto al controller precedente, che necessitano di una spiegazione.

Una è l'utilizzo della varibile ```$stateParams.id``` passato alla chiamata alla route Laravel, che corrisponde all'id della route di AngularJS ```affissioni/:id```.

L'altra è l'implementazione della funzione di successo:

```
if (data.length > 0) {
  $scope.affissioni = data[0];
} else {
  console.log("Affissione " + $stateParams.id + " non esistente");
}
```

in questo caso ci aspettiamo che l'array ```data``` contenga un elemento (nel caso in cui esiste la riga corrispondente nel database) o zero elementi.

Per questo motivo effetuiamo un controllo sulla lunghezza dell'array ```data```. Se tale valore è maggiore di zero, associamo il primo (e presumibilmente unico) elemento dell'array alla variabile ```$scope.affissioni```, rendendo tale oggetto disponibile alla view. Se l'array ```data``` è vuoto, stampiamo un messaggio nella console per segnalare l'assenza di tale riga.


### Template HTML

TODO

## 4) Menu Wordpress

TODO
