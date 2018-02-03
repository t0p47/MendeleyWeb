<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Journal;
use App\JournalArticle;
use Response;

class JournalController extends Controller
{
    //
    public function showSearchPage(){


    	$journals = Journal::orderBy("popularity",'desc')->get();

    	//foreach($articles as $key => $article){

    	foreach($journals as $key => $journal){
    		$articles = JournalArticle::where('journal_id',$journal->id)->orderBy("takescount",'desc')->get();
    		$artCount = count($articles);
    		if($artCount>0){
    			$journal->artOneId = $articles[0]->id;
    			$journal->articleOne = $articles[0]->name;
    			if($artCount>1){
    				$journal->artTwoId = $articles[1]->id;
    				$journal->articleTwo = $articles[1]->name;
    				if($artCount>2){
    					$journal->artThreeId = $articles[2]->id;
    					$journal->articleThree = $articles[2]->name;
    				}
    			}	
    		}
    	}

    	$isOdd = count($journals)%2;

        return view('search/journal')->with(['journals'=>$journals,'isOdd'=>$isOdd,'journalsCount'=>count($journals),'type'=>'Журналы']);
    }

    public function searchJournal(Request $request){

    	//$articles = JournalArticle::search($request->search_query)->get();
    	$journals = Journal::search($request->search_query)->get();

    	foreach($journals as $key => $journal){
    		$articles = JournalArticle::where('journal_id',$journal->id)->orderBy("takescount",'desc')->get();
    		$artCount = count($articles);
    		if($artCount>0){
    			$journal->artOneId = $articles[0]->id;
    			$journal->articleOne = $articles[0]->name;
    			if($artCount>1){
    				$journal->artTwoId = $articles[1]->id;
    				$journal->articleTwo = $articles[1]->name;
    				if($artCount>2){
    					$journal->artThreeId = $articles[2]->id;
    					$journal->articleThree = $articles[2]->name;
    				}
    			}	
    		}
    	}

    	$isOdd = count($journals)%2;

        return view('search/journal')->with(['journals'=>$journals,'isOdd'=>$isOdd,'journalsCount'=>count($journals),'type'=>'Журналы']);

    }

    public function showJournal(Request $request){

        $id = $request->id;


        $journal = Journal::whereId($id)->get();

        $years = JournalArticle::select("year")->where("journal_id",$id)->orderBy("year","desc")->distinct()->get();

        //$years = JournalArticle::select

        $currentYear = $years[0]->year;

        if(isset($request->year)){
            $articles = JournalArticle::where([
                ["journal_id","=",$id],
                ["year","=",$request->year]
            ])->get();
            $currentYear = $request->year;
        }else{
            $articles = JournalArticle::where([
                ["journal_id","=",$id],
                ["year","=",$years[0]->year]
            ])->get();
        }

        

        //'articlesCount'=>count($articles)
        $isOdd = count($articles)%2;

        //return Response::json($years);

        return view('show/journal')->with(['articles'=>$articles,'journal'=>$journal,"years"=>$years,"isOdd"=>$isOdd,'articlesCount'=>count($articles),'currentYear'=>$years[0]->year,"jid"=>$id]);

    }
}
