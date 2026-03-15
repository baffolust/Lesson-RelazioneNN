# RELAZIONI 

- 3 Tipoologie di relazioni tra tabelle: 1-1 [ONE-TO-ONE], 1-N [ONE-TO-MANY], N-N [MANY-TO-MANY] 

**ONE-TO-ONE**

- La tabella A ha una relazione "one to one" con la tabella B quando ogni record della tabella A ha un ed un solo record relazionato con la tabella B.
        
        esempio: tabella "utenti" e tabella "dashboard"

- Documentazione: https://laravel.com/docs/12.x/eloquent-relationships#one-to-one

**ONE-TO-MANY**

- La tabella A ha una relazione "one to many" con la tabella B quando un record della tabella A ha più record in relazione con la tabella B, ma un record della tabella B ha un solo record in relazione con la tabella A.
        
        esempio: tabella "utenti" e tabella "articoli inseriti"

- La tabella A è la tabella <Parent> la tabella B è la tabella <Child>

- In laravel, nella tabella Child va indicato una colonna-chiave del record della tabella Parent, tipicamente l'ID, con la nomencaltura key_ID.

        esempio: user_ID

Questo tipo di chiave è detta "Foreign KEY"

- Documentazione: https://laravel.com/docs/12.x/eloquent-relationships#one-to-many


**MANY-TO-MANY**

- La tabella A ha una relazione "many to many" con la tabella B quando un record della tabella A ha più record in relazione con la tabella B e un record della tabella B ha più record in relazione con la tabella A.
        
        esempio: tabella "prodotti" e tabella "tag"

- Per gestire questa complessità, si utilizza una *tabella Pivot* con la seguente logica

        Tabella A <- Relazione 1-N -> Tabella Pivot 
        Tabella B <- Relazione 1-N -> Tabella Pivot 

- La tabella pivot avrà 2 foreign key per gestire le 2 relazioni 1-N
- Sarà la tabella a mantenere i vincoli, nelle tabelle A e B non sono presenti relazioni

**---------------------------------------------------------------------------------------**
**---------------------------------------------------------------------------------------**

# ONE TO MANY

**MIGRAZIONE**

- E' necessario definire una migrazione che aggiunga la Foregin Key nella tabella Child (tabella che definisce la parte "many" nella relazione)

`       php artisan make:migration add_user_id_column_to_products_table. `

- metodo up() della migrazione. 2 Operazioni:

      + Aggiungere la foreign key
        il tipo di dato che andremo ad aggiungere non è di tipo id(), perché il tipo id() è già definito per la tabella products (id del prodotto) ed ogni tabella può averne soltanto uno. Verrà definito come tipo unsignedBigInteger()

        `$table->unsignedBigInteger('user_id')`

        *Nota* in una tabella già inizializzata, potrebbero esserci dei record che non hanno un user_id. 
        Quando si lancia la migrazione questo genera un errore. si risolve con nullable() o default(1)

                $table->unsignedBigInteger('user_id')->nullable()
                $table->unsignedBigInteger('user_id')->default(1)

      + Dichiarare il vincolo referenziale 
        va esplicitato il dato esterno con cui la colonna è in relazione. Si indica concatenando i metodi foreign(), references() e on()

        `$table->foreign('user_id)->references('id')->on('users')`

        user_id = FK della tabella <child>
        id = Key della tabella <parent>
        users = nome della tabella <parent>

- metodo down() della migrazione. 2 Operazioni:

      + Eliminare il vincolo relazionale
        si utilizza il metodo dropForeign, che accetta in ingresso un array (perché la chiave può essere una serie di dati?):
        
        `$table->dropForeign(['user_id])`

        user_id = FK della tabella <child>
         
      + Eliminare la colonna
        utilizzo il solito metodo dropColumn()

        `$table->dropColumn('user_id)`
       

- Documentazione: https://laravel.com/docs/12.x/migrations#foreign-key-constraints


**MODEL**

Eloquent fornisce un set per istruire i modelli per One-to-Many e Many-to-One

- One-to-Many

Il modello A (user) ha una relazione di tipo One-to-Many con il modello B (product)
per partire dall'utente ed arrivare ad un prodotto

        public function products()
        {
        return $this->hasMany(Product::class); 
        } 


- Many-to-One

Il modello B (product) ha una relazione di tipo Many-to-One con il modello A (user)
per partire da un prodotto ed arrivare all'utente

        public function user()
        {
        return $this->belongsTo(User::class);
        }

Devo poi aggiornare il fillable aggiungendo user_id


**CONTOLLER**

- 'user_id' => Auth::user()->id

**VIEW**

- La funzione belongsTo() restituisce un oggetto di tipo belongsTo (vedi dd(product->user()) per capire la complessità)
Eloquent, attraverso la nomenclatura indicata nella creazione delle tabelle e nelle relazioni, fornisce anche la proprietà user. Così è possibile riferirsi al modello user direttamente. Questo è chiamato traversal-model


**---------------------------------------------------------------------------------------**
**---------------------------------------------------------------------------------------**

# ONE TO MANY

**MIGRAZIONE**

+ Per creare una tabella pivot tra due tabelle è necessario utilizzare una sintassi specifica di laravel

`       php artisan make:migration create_modelA_modelB_table `

in cui:
- modelA e modelB sono i nomi dei modelli, **in minuscolo**, le cui tabelle sono da mettere in relazione N-N
- modelA e modelB vanno scritti **in ordine alfabetico**

+ Inserire nella migrazione della pivot le due foreign_key

**MODELLO**

+ E' necessario istruire i modelli A e B alla relazione Many-to-Many

documentazione: https://laravel.com/docs/12.x/eloquent-relationships#many-to-many

+ Inserire nei modelli lo stesso metodo BelongsToMany

  public function roles() {
        return $this->belongsToMany(Role::class);
    }

**CONTROLLER**

+ *create*: Alle viste degli articoli possono essere resi disponibile i Tag
        - Per modificare qualcosa in una tabella, bisogna usare sempre il metodo, non il traversal model.

+ *store*: Metodo attach() che crea una relazione one-to-many nella tabella pivot. Se parto da article, creerà tanti record quanti sono i tag selezionati.

+ *update*: Metodo sync() che aggiorna aggiungendo e/o rimuovendo relazioni dalla tabella pivot

+ *destroy*: Metodo detach() che rimuove tutte le relazioni dalla tabella pivot


**VIEW**

+ Per legegre qualcosa relativo ad una relazione si può usare il Traversal Model. Ad esempio in product abbiamo definito la funzione user() per ritornare il la foreignKey dell'utente legato al prodotto. Nella vista non è necessario richiamare la funzione, ma è possibile richiamare la proprietà user per attraversare la tabella: modello riferimento ($product) -> modello collegato (user) -> proprietà (id)

+ 