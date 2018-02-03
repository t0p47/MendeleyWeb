<?php
function createTreeView($array, $currentParent, $currLevel = 0, $prevLevel = -1) {

	foreach ($array as $categoryId => $category) {

		if ($currentParent == $category['parent_id']) {                       
		    if ($currLevel > $prevLevel) echo " <ul class='treeview-menu' style='display: none;'> "; 

		    if ($currLevel == $prevLevel) echo " </li> ";

		    echo '<li><a id="folder'.$categoryId.'" class="curs-point"><i class="fa fa-circle-o"></i><span class="text">'.$category['name'].'</span></a>';

		    if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }

		    $currLevel++; 

		    createTreeView ($array, $categoryId, $currLevel, $prevLevel);

		    $currLevel--;               
	    }   

	}

if ($currLevel == $prevLevel) echo " </li>  </ul> ";

}
?>