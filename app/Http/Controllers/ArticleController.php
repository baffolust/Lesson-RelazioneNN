<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all(); // ritorna tutti gli oggetti della tabella articles

        return view('article.index', compact('articles')); // compact('articles') fa ['articles => $articles]
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        return view('article.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        /*      METODO #1 
        Funzionante e più snello, 
        ma ATTENZIONE
        le i parametri passati nella request devono avere gli stessi nomi di quelli del modello Article

        $article = $request->only(['title', 'subtitle', 'body']);

        if ($request->hasFile('img')) {
            $article['img'] = $request->file('img')->store('img', 'public');
        }

        Article::create($article); // crea oggetto nel DB


        return redirect()->back()->with('message', 'articolo inserito'); */

        /*      METODO #2
        Funziona con tutti 
*/

        $article = Article::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'body' => $request->body
        ]);

        if ($request->file('img')) {
            $article->img = $request->file('img')->store('img', 'public');
            $article->save(); // salva l'oggetto nel DB
        }

        $article->tags()->attach($request->tags);
        // tags() richiama il metodo many-to-many definito nel modello
        // attach($request->tags) crea record nella tabella pivot legati all'articolo
        return redirect()->back()->with('message', 'articolo inserito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $tags = Tag::all();
        return view('article.edit', compact('article','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {

        // Controllo che sia stata caricata una nuova immagine dall'utente
        if ($request->file('img')) {
            Storage::disk('public')->delete($article->img);
            $img = $request->file('img')->store('img', 'public');
        } else {
            $img = $article->img;
        }

        // Si esegue il metodo update sull'oggetto article. Funziona come il metodo create della Classe Article
        $article->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'body' => $request->body,
            'img' => $img
        ]);

        $article->tags()->sync($request->tags); //sincronizza i tag nella tabella pivot, aggiungendo e/o rimuovendo relazioni

        return redirect(route('article.index'))->with('message', 'Articolo Modificato');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->tags()->detach(); // Elimina i vincoli di relazione nella tabella pivot
        $article->delete();
        return redirect()->back()->with('message', 'Articolo Eliminato');
    }
}
