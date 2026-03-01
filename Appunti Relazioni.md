# RELAZIONI 

- 3 Tipoologie di relazioni tra tabelle: 1-1 [ONE-TO-ONE], 1-N [ONE-TO-MANY], N-N [MANY-TO-MANY] 

**ONE-TO-ONE**

- La tabella A ha una relazione "one to one" con la tabella B quando ogni record della tabella A ha un ed un solo record relazionato con la tabella B.
        
        esempio: tabella "utenti" e tabella "dashboard"

- Documentazione: https://laravel.com/docs/12.x/eloquent-relationships#one-to-one

**ONE-TO-MANY**

- La tabella A ha una relazione "one to many" con la tabella B quando un record della tabella A ha più record in relazione con la tabella B.
        
        esempio: tabella "utenti" e tabella "articoli inseriti"

- La tabella A è la tabella <Parent> la tabella B è la tabella <Child>

- In laravel, nella tabella Child va indicato una colonna-chiave del record della tabella Parent, tipicamente l'ID, con la nomencaltura key_ID.

        esempio: user_ID

Questo tipo di chiave è detta "Foreign KEY"

- Documentazione: https://laravel.com/docs/12.x/eloquent-relationships#one-to-many


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