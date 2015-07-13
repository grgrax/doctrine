<?php

function category_name($id){
	$ci=& get_instance();
	$category=$ci->category_m->read_row($id);
	return $category?$category['name']:null;			
}

?>