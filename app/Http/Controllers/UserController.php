<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        // On récupère les données du formulaire
        $data = $request->only(['title', 'content', 'draft']);

        // Créateur de l'article (auteur)
        $data['user_id'] = Auth::user()->id;

        // Gestion du draft
        $data['draft'] = isset($data['draft']) ? 1 : 0;

        // On crée l'article
        $article = Article::create($data); // $Article est l'objet article nouvellement créé
        // on vérifie si l'utilisateur a sélectionné des catégories
        // et on les associe à l'article
        // On associe les catégories à l'article
        // On vérifie si l'utilisateur a sélectionné des catégories
        // et on les associe à l'article
        // On utilise la méthode sync pour synchroniser les catégories
        // avec l'article. Cela va ajouter les catégories sélectionnées
        // et supprimer celles qui ne sont pas sélectionnées.
        if ($request->has('categories')) {
            $article->categories()->sync($request->input('categories'));
        }
        return redirect()->route('dashboard');
    }



    public function index()
    {
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', [
            'articles' => $articles
        ]);
    }



    public function edit(Article $article)
    {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::user()->id) {
            abort(403);
        }

        // On retourne la vue avec l'article
        return view('articles.edit', [
            'article' => $article
        ]);
    }

    public function update(Request $request, Article $article)
    {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::user()->id) {
            abort(403);
        }

        // On récupère les données du formulaire
        $data = $request->only(['title', 'content', 'draft']);

        // Gestion du draft
        $data['draft'] = isset($data['draft']) ? 1 : 0;

        // On met à jour l'article
        $article->update($data);
        // Mise à jour des catégories
        if ($request->has('categories')) {
            $article->categories()->sync($request->input('categories'));
        } else {
            $article->categories()->sync([]); // aucune catégorie sélectionnée
        }
        // On redirige l'utilisateur vers la liste des articles (avec un flash)
        return redirect()->route('dashboard')->with('success', 'Article mis à jour !');
    }

    public function remove(Article $article)
    {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::user()->id) {
            abort(403);
        }
        // Suppression des commentaires liés à l'article
        $article->comments()->delete();
        // Suppression des liens avec les catégories
        $article->categories()->detach();
        // Suppression d'un article
        $article->delete();
        // On redirige l'utilisateur vers la liste des articles (avec un flash)
        return redirect()->route('dashboard')->with('success', 'Article Supprimer.');
    }



    //
}
