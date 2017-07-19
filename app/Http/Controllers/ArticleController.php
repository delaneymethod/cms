<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Traits\ArticleTrait;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
	use ArticleTrait;
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('auth');
	}

	/**
	 * Get pages view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$page = [];
		
		$page['title'] = 'Articles';
		$page['subTitle'] = '';
		
		$articles = $this->getArticles();
		
		return view('dashboard.articles.index', compact('page', 'articles'));
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushArticlesCache() 
	{
		$this->flushCache('articles');	
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushArticleCache($article) 
	{
		$this->flushCache('articles:id:'.$article->id);
	}
}
