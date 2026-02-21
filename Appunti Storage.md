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


