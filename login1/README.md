26 06

PARTE 1 VUE INNESTATO IN LARAVEL

in Routes API

Cancello la rotta middlware di default , usremo solo rotte pubbliche

Le api restituiscono un JSON , i metodi del controller non restituiranno piu le view ma un json
usano una chiamata axios

Route::get('/prova-api', function () {

    $user = [
        'name' => 'Emilio',
        'lastname' => 'Cellini'
    ];

    return response()->json($user);

});

questa rotta non ha bisogno del name

http://127.0.0.1:8000/api/prova-api
prendo la rotta la metto in thunderclient e metto la base dell'endpoint, ottengo il json
cosi facendo ho soli i valori

se dovessi paassrlo in compact avrei anche le chiavi

-   creo un controller per le API, in una cartella api (non e' un resource controller)

php artisan make:controller Api/PostController

importo il modeluse App\Models\Post;

nella index stampo tutti i post
public function index(){

        $posts = Post::all();

        return response()->json($posts);

}
}

-VADO IN ROUTES API PHP E raggruppo tutte le rotte api relative ai post
innanzitutto mi importo il controller api
use App\Http\Controllers\Api\PostController;

do un name space alle rotte , tutte le rotte che prendo saranno sotto il nome Api

Creo dunque la rotta alla mia API

Route::
namespace('Api')
->prefix('posts')
->group(function () {

        Route::get('/', [PostController::class, 'index']);
    });

-ANDANDO SU THUNDERCLIENT http://127.0.0.1:8000/api/posts VEDO TUTTI I POST

---INNESTO VUE IN LARAVEL NELLE VIEWS IN GUEST in home blade

home blade estende layouts guest
