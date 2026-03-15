## AGGIUNTA DI UNA COLONNA AD UNA TABLE ESISTENTE ##
- Si crea la migrazione, non di tipo "create", ma di tipo "add" con la sintassi

        php artisan make:migration add_img_column_to_products_table
        dove:
        - "img" è il nome della colonna
        _ "products" è il nome della tabella

## STORAGE ##
- E' la memoria utilizzata per salvataggio dei media
- Può essere Locale (interna al framework) o Esterna (servizi di storage esterni come S3 di AWS)

**VIEW (FORM)**
- Cambiare tipo di dato dell'input in type="file"
- Cambiare tipo di dato accettato dal form tramite attributo enctype="multipart/form-data"

**VIEW (CARD)**
- Per salvare in locale, l'unica cartella visibile al browser è quella "public"; "storage" non è visibile. va creato un link simbolico alla cartella storage con il comando 
        php artisan storage:link // è sufficiente lanciare il comando una volta sola

- Nel DB il link è salvato come img/JHw4oCWxwpbXEeqjz5V4eRKdvk3S4fMzcZggBMuX.jpg, ma il percorso nella cartella public è img/storage. Nella card va utilizzata il metodo statico Storage::url() che ricostruisce il percorso della file nella cartella storage locale


**CONTROLLER (ProductController)**
- Aggiungere la logica per catturare il dato nuovo 
        $img = $request->file('img')->store('public/img');
        e
        'img' => $img

- [UPDATE]
        Aggiunta la logica per gestire insieme default (immagine di default se utente non carica immagini) e nullable() che permette all'utente di poter non caricare l'immagine senza incappare nell'errore storage(null)
        Vedi ArticleController

**MODEL (Product)**
- Aggiungere il nuovo parametro al modello

## VALIDATION ##
Se provo ad inserire un prodotto vuoto incappo nei seguenti errori

**CONTROLLER (ProductController)**

- Errore "Call to a member function store() on null" 
Il metodo $request->file('img')->store('img') non accetta valore null, anche se il DB può accettare valore NULL. Va quindi definito un controllo sul valore di $request->file('img') prima di lanciare la funzione $request->file('img')->store('img')

**Classe Request (ProductRequest)**

- Errore "SQLSTATE[2300]:integrity constraint violation 1048 column 'xxx' cannot be null 
Errore generato dal DB, una colonna non è definita come nullable e non accetta pertanto il valore NULL.
E' necessario fare un controllo di validazione PRIMA di eseguire il metodo store() della classe Product
        - Creare una nuova classe di tipo request - chiamata in esempio "ProductRequest" - con la command line
        php artisan make:request ProductRequest
        
        La classe ProductRequest estende FormRequest che estende a sua volta Request
        All'interno di request si fanno i controlli di validazione

        - Variare il tipo di classe della variabile $request passata al metodo store() in PublicRequest


- Riscrivere (override) del metodo "messages()" della request

- Available Validation Rules
        https://laravel.com/docs/12.x/validation#available-validation-rules
        Qui ci sono le regole di validazione già disponibili in laravel

**VIEW (Create)**

- Display Validation Errors
        https://laravel.com/docs/12.x/validation#quick-displaying-the-validation-errors
        Qui c'è il template dello snippet per gli errori di validazione
        Da inserire nella vista in cui è presente una validazione dei dati


- Memorizzare l'ultimo valore inserito in caso di errore di validazione
        Nei vari input del form inserire l'attributo value="{{old(nomedell'attributo)}}"

- Display FlashData
        https://laravel.com/docs/12.x/responses#redirecting-with-flashed-session-data
        Qui c'è il template dello snippet per i messaggi di flash data di redirect
        Da inserire nella vista in cui è presente una validazione dei dati


## CRUD ##

- **Create, Read, Update, Delete**
Sono le 4 operazioni base che si possono fare in un Database

        - Create: Già vista nel ProductController con il metodo Product::create()

        - *Read: Già vista nel ProductController con il metodo Product::all()
                - Product::all() restituisce un oggetto di tipo collection. Le collection hanno dei metodi
                Documentazione collection: https://laravel.com/docs/12.x/collections

- E' possibile creare una migrazione, il controller e un set di istruzioni CRUD al momento della creazione di un modello con la command line

*php artistan make:model NomeModello -mcr*

        m => migration
        c => controller
        r => resources (del controller)

NB: posso utilizzare anche solo -m -c -r per creare uno dei 3 strumenti. 

Ad esempio con la command line " php artistan make:model Article -mcr "

        - la migrazione " create_articles_table "
        - il controller " ArticleController "
        - i metodi     
                - index() - Display a listing of the resource.
                - create() - Show the form for creating a new resource.
                - store() - Store a newly created resource in storage.
                - show() - Display the specified resource.
                - edit() - Show the form for editing the specified resource.
                - update() - Update the specified resource in storage.
                - destroy() - Remove the specified resource from storage.


- **UPDATE**
Ci sono 2 operazioni che devono essere eseguite
        - Creare un form pre-compilato con i dati con i dati dell'articolo che vogliamo aggiornare (VIEW)
        - Creare un metodo che aggiorni l'articolo nel DB (Controller)

 *VIEW*
 - Per rotta e funzioni che mostrano la vista in cui modificare un oggetto si utilizza la nomenclatura EDIT, fornita già nella crezione dell'article 

        edit() - Show the form for editing the specified resource.

rotta: Route::get('/article/edit', [ArticleController::class, 'edit'])->name('article.edit');

- Il form HTML base ammette 2 metodi: GET e POST. L'update è una scrittura su DB, di tipo "new" (o "crezione"). Per indicare al server che stiamo facendo un'operazione di tipo "update" di un record è necessario utilizzare il metodo PUT, che però non è supportato da HTML base. Per portelo fare si utilizza la direttiva di Laravel

        @method('PUT')
        Questa operazione si chiama spoofing

*CONTROLLER*
- Si modifica la classe update del controller, che richiede in ingresso $request (dal form) e $article che deve essere passato nel form 

        route('article.update', compact('article'))

Nel controller si utilizza il metodo update() dell'oggetto $article, che funziona come il create della classe Article

        $article->update([
                #parametri
        ]);


**DELETE**
- Si modifica la classe destroy del controller che richiede in ingresso $article che deve essere passato nel form 

        route('article.update', compact('article'))

Nel controller si utilizza il metodo destroy() dell'oggetto $article


## SEEDER ##


Se ad esempio voglio creare una tabella con dei record prefedefiniti, non editabili dall'esterno, non mi interessa neanche creare un crud. Posso creare solo un modello e la migrazione che crea contestualmente dei valori. 

+ In fase di sviluppo è utile creare DB già popolati. In questo caso si utilizzano i seeder

        php artisan make:seeder nometabellaSeeder

Laravel crea il file nometabellaSeeder.php nella cartella database/seeders, in cui scrivere la logica per popolare la tabella.
Va poi aggiunta

        $this->call([TagSeeder::class]);

al metodo run() di database/seeders/DatabaseSeeder.php. Infine va fatto partire i seed

        php artisan db:seed (oppure php artisan db:seed --class=TagSeeder, per utilizzare solo il seeder TagSeeder)