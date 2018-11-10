<?php                                           
// PHP7/HTML5, EDGE/CHROME                                     *** Main.php ***

// ****************************************************************************
// * KwinFlat.ru                                  Развернуть главную страницу *
// ****************************************************************************

//                                                   Автор:       Труфанов В.Е.
//                                                   Дата создания:  01.11.2016
// Copyright © 2016 TVE                              Посл.изменение: 05.03.2018

// Объявляем и инициируем сайтовые переменные
require_once $_SERVER['DOCUMENT_ROOT']."/TPHPPROWN/GetAbove.php";
require_once $_SERVER['DOCUMENT_ROOT']."/TPHPPROWN/MakeCookie.php";
require_once $_SERVER['DOCUMENT_ROOT']."/VerifyParm.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Common.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Inimem.php";

// Подключаем рабочие модули
require_once $SiteRoot."/TException/ExceptionClass.php";
require_once $SiteRoot."/TException/UserMessages.php";
require_once $SiteRoot."/IniMenu.php";

require_once $SiteRoot."/TPHPPROWN/OutFit.php";
require_once $SiteRoot."/TPHPPROWN/NoZero.php";
require_once $SiteRoot."/TPHPPROWN/regx.php";
require_once $SiteRoot."/TPHPPROWN/ViewGlobal.php";
require_once $SiteRoot."/TPHPPROWN/ViewArray.php";
require_once $SiteRoot."/TPHPPROWN/StringFilters.php";
require_once $SiteRoot."/TPHPPROWN/Number1string.php";
require_once $SiteRoot."/TPHPPROWN/CtrlNumber.php";
require_once $SiteRoot."/TPHPPROWN/CtrlArray.php";
require_once $SiteRoot."/TPHPPROWN/PullArray.php";
require_once $SiteRoot."/TPHPPROWN/isCountArrays.php";
require_once $SiteRoot."/TPHPPROWN/SqueezeArrays.php";
require_once $SiteRoot."/TPHPPROWN/TestNumerical.php";
require_once $SiteRoot."/TPHPPROWN/isSubstrInUri.php";

require_once $SiteRoot.'/TDomikva/DomikvaClass.php';
require_once $SiteRoot.'/TViewNach/VerifyNach.php';
require_once $SiteRoot.'/TViewNach/ViewNachClass.php';
require_once $SiteRoot.'/TViewLgo/ViewLgoClass.php';
require_once $SiteRoot.'/TRefbooks/RefbooksClass.php';
require_once $SiteRoot.'/TViewLaws/ViewLawsClass.php';

require_once $SiteRoot.'/TViewNorms/ViewNormsClass.php';
require_once $SiteRoot.'/TViewNorms/getNorms.php';

require_once $SiteRoot."/Codif.php";
require_once $SiteRoot."/IniCtrlObj.php";
require_once $SiteRoot."/IniSeoTags.php";
require_once $SiteRoot."/ShowLgo.php";
require_once $SiteRoot."/ShowNch.php";
require_once $SiteRoot."/ShowCommon.php";

// Подключаем динамические страницы с SEO-тегами, H1 и вступлениями
if (isComRequest('refNormotop'))
    require $SiteRoot.'/Pages/Normativy_po_otopleniyu.php';
elseif (isComRequest('Norms'))
    require $SiteRoot.'/Pages/Sotsialnyye_normy_ploshchadi_zhilya.php';
else
    require $SiteRoot.'/Pages/Other_Main.php';
    

// Определяем, следуем ли инициировать начальные условия расчетов
$Atfirst=Inane;
if (IsSet($_GET['Com'])) 
{                                      
    if ($_GET['Com']=='Atfirst')
    {
        $Atfirst=Atfirst;
    }
}
// Изменяем высоту дива инструкции                       *
IniHeightInstr($wi);
// Инициируем параметры расчета
IniCtrlObj($db,$Domik,$Nch,$Lgo,$Ref,$Law,$Norm,$Comm,$Atfirst);
// Инициируем SEO-теги и начало главной страницы
IniSeoTags();
echo "<div id=\"notes\" style=\"max-height: ".$wi."rem\">";

// Формируем заголовок H1, настраиваем плюс-минус и
// выводим текстовое наполнение динамической страницы
макеh1();
IniPlusMinus(Instr);
intro();

// Заполняем страницу браузера
echo "</div>";
?>
<div class="linel" id="LineTop">
    <div id="Ers">
    <?php
    if (IsSet($_GET['Com'])) 
    {                                      
        if ($_GET['Com']=='Mess')
        {
            echo $_GET['mess'];
        }
    }
    ?>
    </div>
    <?php 
    // echo $_SERVER['HTTP_HOST'];
    IniTopMenu($Comm,$Law->isLaws($Comm),$Norm->isNorms($Comm),$Ref->isReffs($Comm)); 
    ?>
    <div id="Pers">
        <?php //echo " ".$PersName." ".$PersMain."[".$PersEntry."]"; ?>
        <?php echo " ".$PersName." "."[".$PersEntry."]"; ?>
    </div>
</div>
 
<div id="Сontents">
    <section id="mleft">
        
        <div id="main">
        <h2>Жилищно-коммунальные услуги, начисления</h2>
        <!--noindex-->
        <table class="inventory">
        <tr>
        <?php                                           
        // Выводим заголовок чекбоксов при запросе на удаление
        if (IsSet($_GET['Com'])) 
        { 
            if ($_GET['Com']=="delUsl")
            {
                echo "<th> </th>";
            }
        }
        ?>
        <th scope="col">Услуга</th>
        <th scope="col">Норма</th>
        <th scope="col">Тариф</th>
        <th scope="col">Колич.</th>
        <th scope="col">Начислено</th>
        <th scope="col">Коррек.</th>
        <th scope="col">Сумма</th>
        </tr>
		<?php
            ShowNch($Nch,$db,$Domik)
        ?>
		</table>
        <!--/noindex-->
        </div>
        
        <div id="lgoty">
        <h2>Льготополучатели, начисленные льготы - ЕДК</h2>
        <!--noindex-->
        <table class="inventory">
        <tr>
        <th scope="col">Услуга</th>
        <th scope="col">Расчет</th>
        <th scope="col">Фамилия И.О.</th>
        <th scope="col">Норма</th>
        <th scope="col">Доля</th>
        <th scope="col">Льгота</th>
        <th scope="col"> </th>
        </tr>
		<?php
            ShowLgo($Lgo,$Domik)
        ?>
        </table>
        <!--/noindex-->
        </div>
    </section>
    <?php
    // Выводим поясняющую информация или справочники, или законы 
    ShowCommon($Comm,$Domik,$Ref,$Law,$Norm,$db,$Nch);
    ?>
</div>

<div class="linel" id="LineBottom">
    <?php 
    IniPlusMinus(ListUsl);
    // Добавляем счетчик LiveInternet
    echo "<div id=\"MainCounter\">";
    if ($_SERVER['HTTP_HOST']=='kwinflat.ru')
    {
        echo "<!--noindex-->";
        ?>
        <!--LiveInternet counter--><script type="text/javascript">
        document.write("<a href='//www.liveinternet.ru/click' "+
        "target=_blank><img src='//counter.yadro.ru/hit?t53.6;r"+
        escape(document.referrer)+((typeof(screen)=="undefined")?"":
        ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
        screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
        ";h"+escape(document.title.substring(0,150))+";"+Math.random()+
        "' alt='' title='LiveInternet: показано число просмотров и"+
        " посетителей за 24 часа' "+
        "border='0' width='88' height='31'><\/a>")
        </script><!--/LiveInternet-->
        <?php 
        echo "<!--/noindex-->";
    }
    echo "</div>";
    IniBottomMenu($Comm); 
    ?>
    <div id="Persmail">
        <?php echo "e-mail: tve58@inbox.ru"; ?>
    </div>
</div>

<?php
echo "<footer>";
echo "<h2>KwinFlat-близкий всем!</h2>";
//prown\ViewGlobal('avgSESSION');
//prown\ViewGlobal('avgCOOKIE');
//prown\ViewGlobal('avgREQUEST');
echo "</footer>";
IniEndHtml();

// *************************************************************** Main.php ***
