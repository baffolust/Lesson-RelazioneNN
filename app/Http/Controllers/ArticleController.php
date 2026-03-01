<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

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
        return view('article.create');
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
        return view('article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {

        // Controllo che sia stata caricata una nuova immagine dall'utente
        if ($request->file('img')) {
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

        return redirect(route('article.index'))->with('message', 'Articolo Modificato');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->back()->with('message', 'Articolo Eliminato');
    }
}
