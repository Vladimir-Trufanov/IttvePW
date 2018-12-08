<?php

header("Content-Type:text/html;charset=UTF8");
//подключаем файл конфигурации
include 'config.php';
include 'functions.php';


if($_GET['id']) {
	$id = (int)$_GET['id'];
	$result = get_text($id);
}
if($_POST['search']) {
	$str = $_POST['search'];
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />

<link  rel="stylesheet" href="css/style.css"/>
<link  rel="stylesheet" href="css/jquery-ui-1.10.3.custom.css"/>

<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-1.10.3.custom.js"></script>
<script src="js/script.js"></script>

</head>

<body>
	
	<div class="wrap">
		
		<div class='header'>
		</div>
		
		<div class='content'>
		
			<div class="main_text">
				<h1><?php echo $str;?></h1>
			<?		if ($result) {
				
					printf("<table class='table' width='780' border='0' cellspacing='0' cellpadding='0'>
				     		 <tr>
				     		 <td class='td_top'>
				      		<h5><a title='%s' href='text.php?id=%s'>%s</a></h5>
							
				     		 Дата добавления: %s
							 </td>
				            </tr>
				            <tr>
				            <td>
								<img title='%s' align='left' src='%s'><p>%s</p></td>
				            </tr>
				            <tr>
				            <td>
							<p>Просмотров: %s </p>
							</td>
				            </tr>
				            </table>
							",$result['title'],$result['id'],$result['title'],$result['date'],$result['title'],$result['img_src'],$result['text'],$result['view']);
			}	
			?>
			</div>
			
		</div>
		
		<div class='footer'>
			
			<? echo "<p style='text-align:right;font_size:5px; color:white;margin:10px;'>".$site_name."</p>";?>
		</div>
	</div>
</body>
</html>