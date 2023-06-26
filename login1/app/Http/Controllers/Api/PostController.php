<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{

public function index(){

        $posts = Post::with('category' , 'tags')->paginate(20);

        return response()->json($posts);

}


}