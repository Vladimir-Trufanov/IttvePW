<?php
	function get_statti() {
		$result = mysql_query("SELECT id,title,date,img_src,discription
											FROM statti");
		if (!$result){
			exit(mysql_error());
		}
		if(mysql_num_rows($result) == 0) {
			exit('Статтей нет');
		}
		$row = array();
		for($i = 0; $i < mysql_num_rows($result); $i++) {
			$row[] = mysql_fetch_array($result,MYSQL_ASSOC);
		}				
		return $row;
	}
	
	function get_text($id) {
		$result = mysql_query("SELECT id,title,date,img_src,text
											FROM statti WHERE id='$id'");
		if (!$result){
			exit(mysql_error());
		}
		if(mysql_num_rows($result) == 0) {
			exit('Статтей нет');
		}
		
		
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
						
		return $row;
	}
	
?>