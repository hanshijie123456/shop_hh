<?php 


	function cname($cm)
	{
		if($cm == '0'){

			return '顶级分类';
		} else {

			$rs = DB::table('category')->where('id',$cm)->first();

			return $rs->catename;

		}
	}



 ?>