<?php
// PHP7/HTML5, EDGE/CHROME                              *** GalleryNews.php ***

// ****************************************************************************
// * ittve.me                                   Развернуть новостную галлерею *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  13.01.2019
// Copyright © 2019 tve                              Посл.изменение: 30.11.2020

//echo '<form id="fGallery" action="'.$SpecSite.'">';
echo '<form action="" method="post" enctype="multipart/form-data" id="uploadiImage">';

$FileName="ittveNews/ittve01-001-Подъём-настроения.jpg";
$Comment="Ночная прогулка по Ладоге до рассвета и подъёма настроения.";
GViewImage($FileName,$Comment);

$FileName="ittveNews/ittve01-001-С-заботой-и-к-мамам.jpg";
$Comment="'С заботой и к мамам' - такой мамочкин хвостик.";
GLoadImage($FileName,$Comment,true,"Upload");

$FileName="ittveNews/ittve01-001-На-Сампо.jpg";
$Comment="На горе Сампо всем хорошо!";
GViewImage($FileName,$Comment);

echo '</form>';

// Из галереи задаем режим представления выбранной картинки - "на высоту страницы"
$s_ModeImg=prown\MakeSession('ModeImg',vimOnPage,tInt);           

// <!-- --> *********************************************** GalleryNews.php ***
