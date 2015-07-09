## Installazione del portale tramite Docker

E' possibile installare ed utilizzare il portale tramite Docker in qualsiasi sistema operativo di tipo Linux, oppure in sistemi operativi differenti da Linux utilizzando boot2docker.

In entrambi i casi è sufficiente far riferimento alla documentazione ufficiale per installare correttamente Docker:

- [docs.docker.com/installation](https://docs.docker.com/installation/)

Una volta installato Docker, è possibile reperire il Dockerfile del portale dalla cartella /docker.

Per avviare l'installazione tramite Docker, aprire un terminale e spostarsi nella posizione in cui risiede il dockerfile, ad esempio:

```cd ~/sources/WP-Angular-Bootstrap/docker```

se (**e solo se**) siamo in un ambiente non-Linux (Windows o Mac OS X) è necessario avviare la macchina virtuale boot2docker, digitando:

```boot2docker start```

a questo punto possiamo lanciare il build del portale digitando:

```docker build -t portale .```
 
al termine del build verrà creata un'immagine docker di nome portale, che possiamo avviare digitando:

```docker run -i -t -p 5000:80 portale bin/bash```

tale comando, oltre ad avviare il container con l'immagine del portale, aprirà direttamente una shell bash su di essa.

Il parametro -p 5000:80 serve a mappare la porta 80 del container sulla porta 5000 della macchina.

Adesso avviamo apache2 e mysql digitando:

```service apache2 start```

```service mysql start```

Da questo momento in poi è possibile avviare lo script **installer.php* tramite browser, digitando il seguente indirizzo:

```
http://localhost:5000/WP-Angular-Bootstrap/installer.php
```

**NOTA**: nel caso in cui si sta utilizzando docker con boot2docker, è necessario sostituire a “localhost” l'indirizzo della macchina virtuale boot2docker, che si può reperire semplicemente digitando da terminale:

```boot2docker ip```
