<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    /**
     * Renvoie tous les liens.
     */
    public function index()
    {
        $links = Link::where("user_id", Auth::user()->id ?? 1)->paginate(5);

        return response()->json($links);
    }

    /**
     * Enrégistre le lien dans la BDD.
     */
    public function store(Request $request)
    {
        $link = new Link([
            "short_link" => $request->short_link,
            "full_link" => $request->full_link,
            "user_id" => Auth::user()->id,
            "views" => 0 // la 1ère fois, on le met à zéro
        ]);

        $link->save();

        return response()->json($link, 201); // status 201 Created
    }

    /**
     * Renvoie un lien spécifique.
     */
    public function show(Link $link)
    {
        return response()->json($link);
    }

    /**
     * M-à-j un lien donné
     */
    public function update(Request $request, Link $link)
    {
        $link->full_link = $request->full_link;
        $link->short_link = $request->short_link;

        $link->save();
        return response()->json($link);
    }

    /**
     * Supprime un lien donné
     */
    public function destroy(Link $link)
    {
        $link->delete();
        return response()->noContent(); // renvoi une réponse 204 No Content
    }
}
