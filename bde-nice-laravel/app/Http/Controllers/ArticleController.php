<?php

namespace App\Http\Controllers;

use App\Article;
use App\Gestion\FileUploadGestion;
use App\Gestion\SlugGestion;
use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ArticleUpdateRequest;

use App\Http\Requests\EventCreateRequest;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\PictureRepository;
use App\Repositories\ArticleCatRepository;

use App\Picture;

use http\Env\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;



class ArticleController extends Controller {

    const NB_PER_PAGE = 9;

    protected $articleRepository;
    protected $pictureRepository;
    protected $articleCatRepository;
    protected $commentRepository;

    public function  __construct(ArticleRepository      $articleRepository,
                                 PictureRepository      $pictureRepository,
                                 ArticleCatRepository   $articleCatRepository,
                                 CommentRepository      $commentRepository)
    {
        $this->articleRepository        = $articleRepository;
        $this->pictureRepository        = $pictureRepository;
        $this->articleCatRepository     = $articleCatRepository;
        $this->commentRepository        = $commentRepository;

        /*$this->middleware('Auth', ['only'=>['store','update', 'destroy']]);
        $this->middleware('Admin', ['only'=>['store','update', 'destroy']]);*/

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $articles = $this->articleRepository->getPaginate(self::NB_PER_PAGE);
        $links = $articles->render();
        $articleCategories = $this->articleCatRepository->findAll();

        return view('articles.index', compact('articles', 'links', 'articleCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $articleCategories = $this->articleCatRepository->findAll();
        return view('articles.creation', compact('articleCategories'));
    }


    public function search(Request $request)
    {

        $articleCategories = $this->articleCatRepository->findAll();

        $search = $request->input('search');
        $query = Article::where('name', 'LIKE', '%' . $search . '%');
        $i = 0;

        $categories = $request->input('categories');
        if (isset($categories))
            if (is_array($categories))
                foreach ($categories as $category) {
                    if ($i == 0)
                        $query->whereHas('articleCategories', function ($query) use ($category) {
                            $query->where('id', '=', $category);
                        });
                    else
                        $query->orWhereHas('articleCategories', function ($query) use ($category) {
                            $query->where('id', '=', $category);
                        });
                    $i++;
                }

        $sort           = $request->input('sort');
        $sort_direction = $request->input('sort-direction');

        if(isset($sort) && isset($sort_direction))
            $query->orderBy($request->input('sort'), $request->input('sort-direction'));



        $priceMinimum = $request->input('price-min');
        $priceMaximum = $request->input('price-max');

        if(isset($priceMinimum))
            $query->where('price', '>=', $priceMinimum);
        if(isset($priceMaximum))
            $query->where('price', '<=', $priceMaximum);

        $articles = $query->paginate(self::NB_PER_PAGE);
        $links = $articles->render();

        $params = compact('articles', 'links', 'articleCategories');

        return $request->ajax() ? response()->json($params) : view('articles.index', $params);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleCreateRequest $request)
    {

        $article = $this->articleRepository->store(array_merge($request->all(), array('user_id' => session('user'))));

        $this->articleCatRepository->storeRelation($article, $request->input('categories'));

        $image = $request->file('picture');
        $extension = $image->getClientOriginalExtension();
        $picture_name = $request->input('picture_name');

        $picture_slug = SlugGestion::slugify(($picture_name));

        FileUploadGestion::uploadFile($image, $picture_slug, 'article-photos');

        $this->pictureRepository->store(array('name' => $picture_name, 'article_id' => $article->id, 'extension' => $extension));

        return redirect('articles')->withOk("L'évènement ". $article->name . " a été proposé à l'équipe du BDE.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $article = $this->articleRepository->getById($id);
        $comments = $this->commentRepository->findByArticleId($id);

        return view('articles.show', compact('article', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $articleCategories = $this->articleCatRepository->findAll();
        $article = $this->articleRepository->getById($id);

        return view('articles.edit', compact('article', 'articleCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleUpdateRequest $request, $id) {

        $artCatRepo     = new ArticleCatRepository();

        $article = $this->articleRepository->update($id, $request->all());

        if($request->input('categories') != null)
            $artCatRepo->updateRelation($article, $request->input('categories'));

        return redirect('articles')->withOk("L'article".$request->input('name')."a été modifié.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $this->articleRepository->destroy($id);

        return redirect()->back();
    }

    /**
     * Redirect to specified article with given name
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function showArticlesName(Request $request) {
        $name = $request->input('articleName');

        $article = Article::query()->where('name', $name)->get();

        if (!$article) {
            return $this->index();
        }

        return redirect("articles/" . $article[0]->id);
    }

    /**
     * Get alla articles names
     *
     * @return false|string
     */
    public function getAll() {
        $articles = Article::all();
        $names = [];
        foreach ($articles as $article) {
            array_push($names, $article->name);
        }
        return json_encode($names);

    }
}


