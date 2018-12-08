<?php

header("Content-Type:text/html;charset=UTF8");
//подключаем файл конфигурации
include 'config.php';
include 'functions.php';

$result = get_statti();
if($_POST['param']) {
	$param = json_decode($_POST['param']);
	//$param->id = 2
	$row = get_text($param->id);
	echo json_encode($row);
	exit();
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
<script>
	var button = "<?php echo $button; ?>";
</script>
<script src="js/script.js"></script>

</head>

<body>
	
	<div class="wrap">
		
		<div class='header'>
		</div>
		
		<div class='content'>
		
			<form action="view_text.php" method="POST">
				<input type="text" name="search" value="">
				<input type="submit" value="OK">
			</form>
		
			<div class="main_text">
			<?		
				foreach($result as $row) {
				
					printf("<table class='table' width='780' border='0' cellspacing='0' cellpadding='0'>
				     		 <tr>
				     		 <td class='td_top'>
				      		<h5><a title='%s' href='view_text.php?id=%s'>%s</a></h5>
							
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
							",$row['title'],$row['id'],$row['title'],$row['date'],$row['title'],$row['img_src'],$row['discription'],$row['view']);
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