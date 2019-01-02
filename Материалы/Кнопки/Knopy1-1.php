<!DOCTYPE html> 
<!-- 
-->
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>KwinFlat-близкая информация!</title>
    <link rel="stylesheet" type="text/css" href="Knopy1-1.css" />
</head>

<body>

<header>
    <div class="header-bg">
    <img src="../images/Kwinflat.jpg" alt="Kwinflat-близкий всем!" />
    </div>
</header>
 
<nav>
    <ul>
	<li><a href="#">SiteMem</a></li>
	<li><a href="#">PhpMem</a></li>
	<li><a href="#">SessMem</a></li>
    </ul>
</nav>

<article>
    <?php
    $SiteRoot = $_SERVER['DOCUMENT_ROOT'];      // Корневой каталог сайта
    //include ($SiteRoot."/ViewGlobal.php");
    //phpinfo();
   
    // Показываем сайтовые переменные
    /*
    $cSiteMem='';
    $cSiteMem=$cSiteMem
      .'Корневой каталог сайта='.$SiteRoot;
    echo $cSiteMem;
    */	 
    ?>
</article>

<footer>
    Copyright &copy; Владимир Труфанов
</footer>

</body>
</html>
