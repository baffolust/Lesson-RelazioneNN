<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;


class ProductController extends Controller
{
    
    public function create(){

        return view('product.create');

    }

    public function store(ProductRequest $request)
    {

        /* dd($request); */

        /* CREAZIONE OGGETTO PRODOTTO E SALVARLO NEL DB */
        /* Va creato un modello (un oggetto definito in Laravel) tramite CMD Line php artisan make:model [nome_modello] */

        $name = $request->name;
        // è uguale a scrivere $name = $request->input('name');

        $description = $request->description;
        $price = $request->price;
        $img = null;
        // inizializzo il valore di $img a null, che è comunque accettato dal DB

        if($request->file('img')){
            /* 
            controllo se è stato passato un valore a 'img', quindi se è stata caricata un'immagine 
            se non è stato passato niente, non eseguo store()
            */

            $img = $request->file('img')->store('img', 'public');
        }
        // file('img') recupera l'input di tipo file dal form col nome "img"
        /* 
        store('img', 'public') salva su disco il file nel percorso "storage/app/public/img". 
        ATTENZIONE:
        - se non viene indicato 'public' Laravel salva di default in "storage/app/private/img"
        - Crea se non esiste la cartella img
        - Associa un nome con un codice univoco ad ogni file caricato
        - Restituisce un valore di tipo string che è il percorso del file
        */

        // CREAZIONE PRODOTTO METODO #1
        // Istanziamo un oggetto $product di classe Product
        /* $product = new Product(); */

        // i costruttori nei modelli Laravel non si utilizzano, dato che utilizza Eloquent per generare i modelli con una struttura particolare che permette di utilizzare la seguente sintassi

        /* 
        $product->name = $name;
        $product->description = $description;
        $product->price = $price; 
        */
        // valorizzo gli attributi di $product

        /* $product->save(); */
        // salva l'oggetto nel DB

        // CREAZIONE PRODOTTO METODO #2 - MASS ASSIGNMENT

        Product::create([

            'name' => $name,
            'description' => $description,
            'price' => $price,
            'img' => $img
            // aggiunta del dato img catturato nel parametro $img

        ]);

        return redirect()->back()->with('message', 'Prodotto inserito');
    }

    public function index()
    {

        //Faccio chiamata al DB, per richiedere tutti i prodotti con metodo all() del modello Product
        $products = Product::all(); // Equivale a query SELECT * FROM Products

        // passo la variabile $products alla vista index
        /* $product non è un oggetto di tipo collection, non un array di array. $name, $description e $price sono proprietà, e quindi si recuperano con la square syntax procuts[], ma con $product-> */
        return view('product.index', ['products' => $products]);
    }
}
