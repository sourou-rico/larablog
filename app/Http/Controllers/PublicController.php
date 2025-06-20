<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(User $user)
{
    // On récupère les articles publiés de l'utilisateur
    // $articles = Article::where('user_id', $user->id)->where('draft', 0)->get();

    $articles = Article::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

    // On retourne la vue
    return view('public.index', [
        'articles' => $articles,
        'user' => $user
    ]);
}

public function show(User $user, Article $article)
{
    // Vérifie que l'article appartient bien à l'utilisateur passé dans l'URL
    if ($article->user_id !== $user->id) {
        abort(404); // ou 403 si tu veux dire "accès refusé"
    }

    // Vérifie que l'article est publié
    if ($article->draft) {
        abort(403, 'Cet article est en brouillon.');
    }

    // Affiche l'article dans la vue show
    return view('public.show', [
        'article' => $article,
        'user' => $user
    ]);
}

    public function like(Article $article)
    {
        $article->increment('likes');
        return redirect()->back();
    }
}
