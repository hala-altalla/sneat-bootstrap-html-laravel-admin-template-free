<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavoriteRequeststore;
use App\Models\Favorite;
use App\Services\FavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    protected $favoriteservice;
    public function __construct(FavoriteService $favoriteService)
    {
      $this->favoriteservice=$favoriteService;
    }
    public function store(FavoriteRequeststore $favoriteRequeststore)
    {
      $user= auth()->user();
     $fav= $this->favoriteservice->store($favoriteRequeststore->validated(),$user);
     if(!$fav)
     {
      return response()->json([
        'message' => __('messages.Favorite_messageWrong')
      ]);
     }
      return response()->json([
        'message' => __('messages.Favorite_message')
      ]);
    }
    public function index()
    {
      $user=Auth()->user();
      $favorites=Favorite::where('normal_user_id' ,$user->normalUser->id)->with('service')->latest()->get();
      return response()->json([
        __('messages.Favorite_messages') => $favorites
      ]);
    }
    public function delete($id)
    {
       $favorite=Favorite::where('service_id' , $id);
       if($favorite)
       {
        $favorite->delete();
        return response()->json([__('messages.deletefavorite')]);
       }
       return response()->json([__('messages.favoritefound')]);
    }
}