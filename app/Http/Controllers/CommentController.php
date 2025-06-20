<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
{
    // Vérifier si l'utilisateur est connecté
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // Valider les données du formulaire
    $validated = $request->validate([
        'content' => 'required|string',
        'article_id' => 'required|exists:articles,id',
    ]);

    // Créer le commentaire
    Comment::create([
        'content' => $validated['content'],
        'article_id' => $validated['article_id'],
        'user_id' => Auth::user()->id,
    ]);

    // Rediriger vers la page de l'article commenté (toujours la page show)
    $article = \App\Models\Article::find($validated['article_id']);
    return redirect()->route('public.show', [
        'user' => $article->user_id,
        'article' => $validated['article_id'],
    ]);
}


    //
}
