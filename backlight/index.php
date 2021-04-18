<?php
// http://zonakoda.ru/raskraska-koda-na-c99-sredstvami-php-2-ya-chast.html



function tab2sp($str)
{
    return htmlspecialchars(str_replace("\t", "    ", $str), ENT_NOQUOTES);
}
$numbering = " checked";                    //Нумеровать строки
$raw_txt = "";                                //Верхняя текстовая область пуста
if (isset($_POST['raw_txt']))
{
    $numbering = isset($_POST['numbering']) ? " checked" : "";
    $num_checked = ($numbering == " checked"); //true, если требуется нумерация
    $raw_txt = $_POST['raw_txt'];
    $strings = explode("\r\n", $raw_txt);
    $count = count($strings);
    $colored_txt = array();
    $key_words = '#^_Bool$|^_Complex$|^_Imaginary$|^auto$|^bool$|^break$|' .
                 '^case$|^char$|^complex$|^const$|^continue$|^default$|' .
                 '^do$|^double$|^else$|^enum$|^extern$|^false$|^float$|' .
                 '^for$|^goto$|^if$|^imaginary$|^inline$|^int$|^long$|' .
                 '^register$|^restrict$|^return$|^short$|^signed$|^sizeof$|' .
                 '^static$|^struct$|^switch$|^true$|^typedef$|^union$|' .
                 '^unsigned$|^void$|^volatile$|^while$#';
    $sp_kw = '<span class="kw">';        //Ключевые слова
    $sp_pd = '<span class="pd">';        //Директивы препроцессора
    $sp_cm = '<span class="cm">';        //Комментарии
    $sp_st = '<span class="st">';        //Строковые литералы
    $sp_ch = '<span class="ch">';        //Символьные литералы
    $sp_nm = '<span class="nm">';        //Числовые литералы
    $sp_op = '<span>';
    $sp_cl = '</span>';
    $dv_cl = '</div>';
    $s = "[\\dabcdefxpul\\.]*";  //Шаблон "цифры, буквы, точки"
    $comment = false;       //true, если обрабатываются многострочные комментарии 
    $number = false;        //true, если обрабатываются числа
    if ($num_checked)
        $capacity = (int) log10($count) + 1; //Максимальное число разрядов номера строки
    for ($i = 0; $i < $count; $i++)
    {
        $string = $strings[$i];
        $size = strlen($string);
        $colored_txt[$i] = "<div>";
        if ($num_checked)
            $colored_txt[$i] .= $sp_op . sprintf("%$capacity" . "u.", $i + 1) . $sp_cl;
        $start = 0;    //По умолчанию каждую строку обрабатываем, стартуя с первого символа
        //Многострочные комментарии
        if ($comment)
        {
            $pos = strpos($string, "*/");
            if ($pos === false)
            {
                if (trim($string) !== "")
                    $colored_txt[$i] .= $sp_cm . tab2sp($string) . $sp_cl;
                $colored_txt[$i] .= $dv_cl;
                continue;
            }
            else
            {
                $colored_txt[$i] .= $sp_cm . tab2sp(substr($string, 0, $pos + 2)) . $sp_cl;
                $comment = false;
                $start = $pos + 2;
            }
        }
        for ($j = $start; $j < $size; $j++)
        {
            $c = $string[$j];
            $n = ord($c);
            //Многострочные комментарии
            if ($c == '/' && $j != $size - 1 && $string[$j + 1] == '*')
            {
                $pos = strpos($string, "*/", $j + 1);
                if ($pos === false)
                {
                    $c = $sp_cm . tab2sp(substr($string, $j)) . $sp_cl;
                    $j = $size - 1;
                    $comment = true;
                }
                else
                {
                    $c = $sp_cm . tab2sp(substr($string, $j, $pos - $j + 2)) . $sp_cl;
                    $j = $pos + 1;
                }
            }            
            //Строковые литералы
            elseif ($c == '"')
            {
                while (++$j < $size)
                {    
                    $c .= $string[$j];
                    if ($string[$j] == '"' && $string[$j - 1] != '\\')
                        break;
                }
                $c = $sp_st. htmlspecialchars($c, ENT_NOQUOTES). $sp_cl;
            }
            //Символьные литералы
            elseif ($c == "'")
            {
                while (++$j < $size)
                {    
                    $c .= $string[$j];
                    if ($string[$j] == "'" && $string[$j - 1] != "\\")
                        break;
                }
                $c = $sp_ch. htmlspecialchars($c, ENT_NOQUOTES). $sp_cl;
            }
            //Директивы препроцессора
            elseif ($c == '#')
            {
                $c = $sp_pd . tab2sp(substr($string, $j)) . $sp_cl;
                $j = $size - 1;
            }
            //Однострочные комментарии
            elseif ($c == '/' && $j != $size - 1 && $string[$j + 1] == '/')
            {
                $c = $sp_cm . tab2sp(substr($string, $j)) . $sp_cl;
                $j = $size - 1;
            }
            //Символы табуляции
            elseif ($c == "\t")
                $c = "    ";
            //Символы '<'
            elseif ($c == '<')
                $c = "&lt;";
            //Символы '>'
            elseif ($c == '>')
                $c = "&gt;";
            //Символы '&'
            elseif ($c == '&')
                $c = "&amp;";
            //Идентификаторы и ключевые слова
            elseif ($c == '_' || $n >= 65 && $n <= 90 || $n >= 97 && $n <= 122)
            {
                preg_match("#^[_a-z][_a-z\\d]*#i", substr($string, $j), $result);
                $c = $result[0];
                $j +=  strlen($c) - 1;
                if (preg_match($key_words, $c) == 1)
                    $c = $sp_kw . $c . $sp_cl;
            }
            //Числа, начинающиеся с '+' и '-'
            elseif (($c == '+' || $c == '-') && ($j == 0 || $j != 0 &&
                        strpos(" ({[=<>;,:", $string[$j - 1]) !== FALSE))
            {
                if (preg_match("#^\\+\\d$s|^-\\d$s|^\\+\\.\\d$s|^-\\.\d$s#i",
                               substr($string, $j), $result) == 1)
                {
                    $c = $result[0];
                    $j +=  strlen($c) - 1;
                    $number = true;
                }
            }
            //Числа, начинающиеся с '.'
            elseif ($c == '.')
            {
                if (preg_match("#^\\.\\d$s#i", substr($string, $j), $result) == 1)
                {
                    $c = $result[0];
                    $j +=  strlen($c) - 1;
                    $number = true;
                }
            }
            //Числа, начинающиеся с цифры
            elseif ($n >= 48 && $n <= 57)
            {
                preg_match("#^$s#i", substr($string, $j), $result);
                $c = $result[0];
                $j +=  strlen($c) - 1;
                $number = true;
            }
            //Обработка чисел
            if ($number)
            {
                if (preg_match('#e$|p$#i', $c) == 1 && $j != $size - 1
                    && preg_match("#^\\+[\\d]+[lf]?|^-[\\d]+[lf]?#i",
                                  substr($string, $j + 1), $result) == 1)
                {
                    $c .= $result[0];
                    $j +=  strlen($result[0]);
                }
                $c = $sp_nm . $c . $sp_cl;
                $number = false;
            }
            $colored_txt[$i] .= $c;            
        }
        $colored_txt[$i] .= $dv_cl;
    }
    $colored_txt = implode("\r\n", $colored_txt);
    $num_class = $num_checked ? "num" : "not_num";
    $colored_txt = "<pre class=\"c99 $num_class\">" . $colored_txt . '</pre>';
    $colored_txt_for_area = htmlspecialchars($colored_txt, ENT_NOQUOTES);
    $raw_txt = htmlspecialchars($raw_txt, ENT_NOQUOTES);
}
require_once "template.php"
?>