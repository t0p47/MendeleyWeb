<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

class JournalArticle extends Model
{

	use Searchable;

	/*public function searchableAs(){
		return "title";
	}*/

	/*public function toSearchableArray(){
		$array = $this->toArray();

		return $array;
	}*/

    //
    protected $fillable = ['title','authors','abstract','journal_id','year','volume','issue','pages','ArXivID','DOI','PMID', 'folder', 'filepath','uid','is_new'];
}
