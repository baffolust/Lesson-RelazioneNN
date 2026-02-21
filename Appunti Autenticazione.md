## FORTIFY ##

- E' una libreria first party di Laravel (sviluppata dirattamente dai progettisti di Laravel)
- Serve per gestire l'autenticazione:
        - registrazione e accessi al sito

- https://laravel.com/docs/12.x/fortify#main-content

- Installazione delle dipendenze di php

        composer require laravel/fortify

        - Installa la cartella fortify all'interno di vendor/laravel

- Rendere disponibili file di confiurazione e logiche di fortify (presenti e non modificabili nella cartella vendor), per poterle successivamente sovrascrivere

        php artisan fortify:install

        - Installa le classi Actions di Fortify
        - Installa le classi Providers di Fortify
        - Aggiunge il file fortify.php alla cartella config
        - Installa la migrazione add_two_factor_column_to_users_table


- Lanciare la migrazione installata con il comando precedente

        php artisan migrate

        - aggiunge le nuove colonne alla tabella users


**REGISTRAZIONE**

- Documentazione : https://laravel.com/docs/12.x/fortify#registration

- All'interno della funzione boot() del provider FortifyServiceProvider, copiare

        Fortify::registerView(function () {
        return view('auth.register');
        });

La funzione si aspetta di trovare una vista "register" all'interno della cartella "auth"

- Quando nella cartella fortify sono presenti delle rotte che non sono accessibili. Per visionare tutte le rotte si utilizza il comando 

        php artisan route:list

Si visualizzano tutte le rotte presenti nel progetto, incluso quelle create, quelle preconfigurate da laravel e quelle installate con fortify. Ne esistono due

GET|HEAD  register ........................ register › Laravel\Fortify › RegisteredUserController@create
POST      register ........................ register.store › Laravel\Fortify › RegisteredUserController@store

        - Si utilizza la rotta register (GET) per accedere alla vista per la registrazione
        - Si utilizza la rotta register (POST) per la action sul form con metodo POST

- La request del Register si aspetta 4 valori in input dal form

        - "name" di tipo string 
        - "email address / username" di tipo string 
        - "password" 
        - "password_confirmation" fields

- Dopo aver fatto la registrazione, fortify fa redirect a "/home", per cambiare questa impostazione si fa da config/fortify.php

- Registrandosi, si effettua automaticamente login ed apre una sessione, pertanto se provo ad accedere alla pagina di registrazione, vengo ridirezionato alla pagina di home. Per poter riaccedere alla pagina devo fare logout

- Di default Fortify chiede password lunga 8 caratteri

**LOGOUT**

Tra le rotte disponibili c'è 

 POST      logout .......................... logout › Laravel\Fortify › AuthenticatedSessionController@destroy

- Logout è una rotta di tipo POST, se lo associo ad un anchor <a> non può funzionare perché gli anchor ammettono solo il tipo GET. Va modificato il tipo di tag in un <form>

**LOGIN**

- Documentazione : https://laravel.com/docs/12.x/fortify#authentication

------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------

## MIDDLEWARE

- Sono delle logiche da interporre a determinate richieste GET o POST. 
        - ad esempio: poter accedere ad un URL solo se siamo loggati; senza nessuna logica di mezzo, anche se non trovo il link nella navbar, posso accedervi sono conoscendo l'URL.

        - Le richieste GET di un URL sono gestite dalle rotte, che richiamano metodi di specifici controller.

        - I middleware quindi vanno applicati a specifici controller tramite le rotte.

**auth**
- E' il middleware fornito da Fortify che effettua controlli di autenticazione.
        - si applica così
        Route::get('product/create', [ProductController::class, 'create'])->name('product.create')->middleware('auth);

        - middleware() accetta in ingresso una stringa o un array di stringhe (è quindi possibile applicare anche più middleware ad una rotta)

        - adesso se provo ad accedere a product/create senza essere loggato vengo reindirizzato alla pagina di login

- Il middleware 'auth' mantiene l'ultima rotta a cui l'utente ha provato ad accedere prima di essere autenticato

------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------

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