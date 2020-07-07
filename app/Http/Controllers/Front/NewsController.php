<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App\News;
use App\NewsView;

use Session;
use Auth;
use DB;

class NewsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */   
    private $numNews = 10;
	public function getIndex($type){
		$newsData = News::where('active',1)->where('type',$type)->orderBy("created_at","desc")
					->paginate($this->numNews);
		
		/*$newsgcss = DB::connection('mysql2')->select("select * from article");*/

		$type_news=$type;	
		
		if ($type_news	==='news')
		{
			if(Session::get('locale') == "ar")
			{$type_news='أخبارنا';}
			else
			{$type_news='Our news';}
			$code_img='0';
		}
		else 
		{
			if(Session::get('locale') == "ar")
			{$type_news='مقالاتنا';}
			else
			{$type_news='Our articles';}
			$code_img='1';
		}
		return view('front.news.index',array(
				"newsData"=>$newsData,"type_news"=>$type_news,"code_img"=>$code_img
			));
	}
	
	public function getLoadMoreNews(Request $request){
		$currentPage = $request->current_page + 1;
		
		Paginator::currentPageResolver(function() use ($currentPage) {
		    return $currentPage;
		});
		
		$newsData = News::where('active',1)->orderBy("created_at","desc")
					->paginate($this->numNews);							
		
		$result = array();
		$result[0] = str_replace('"', '\"', view("front.news._news",array(
			"newsData"=>$newsData
		)));
		$result[1] = $currentPage;
		$result[2] = $newsData->lastPage();
		return json_encode($result);
	}

	public function getView($type, $slug){
		
		$news = News::join("news_translations","news_translations.news_id","=","news.id")
				->where("news_translations.slug",$slug)->firstOrFail(["news.*"]);	
				
		$type_news=$type;	
		if ($type_news	==='news')
		{
			$type_news= session()->get('locale') === "ar" ? "أخبارنا" : "News";
			$code_img='0';
		}
		else 
		{
			$type_news= session()->get('locale') === "ar" ? "مقالاتنا" : "Articles";
			$code_img='1';
		}	
		$news_trans = $news->news_trans(session()->get('locale'));
		// if($news_trans->slug != $slug){
		
		// 	//echo "Afef";
		// 	return redirect(App('urlLang').'news/'.$news_trans->slug,301);
		// }else{
		
			$this->views($news->id);
						
			return view("front.news.view",array(
							"news"=>$news,"news_trans"=>$news_trans,"type_news"=>$type_news,"code_img"=>$code_img
					));
		// }			
		
	}
	
	public function views($newsId){		
		//echo "Afef";
		$ip = $_SERVER['REMOTE_ADDR'];
		/*if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
		    $ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
		}*/
		
		$ipmodel = NewsView::where('news_id',$newsId)->where('ip',$ip)
			->where(DB::raw("Date(created_at)"),"=",date('Y-m-d'))->first();
		if(empty($ipmodel)){
			$newsView = new NewsView();
			$newsView->news_id = $newsId;
			$newsView->ip = $ip;			
			$newsView->save();
		}
	
	}
	

}
