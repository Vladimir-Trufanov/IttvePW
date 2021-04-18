<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Подсветка кода C99</title>  
  <link rel="stylesheet" href="styles.css"> 
</head>
<body>
  <div id="wrapper">
    <form method="post" action="index.php">
      <p>Введите код на C99</p>
      <textarea name="raw_txt" cols="100" rows="10" wrap="off"><?php echo $raw_txt?></textarea>
      <br>Пронумеровать строки<input type="checkbox" name="numbering"<?php echo $numbering?>>
      <p><input type="submit" value="Раскрасить"></p>
    </form>
    <?php if (isset($colored_txt)):?>
    <p>Раскрашенный текст:</p><?php echo $colored_txt?>
    <p>HTML-код раскрашенного текста:</p>
    <textarea id="source" cols="100" rows="10" wrap="off"><?php echo $colored_txt_for_area?></textarea> 
    <p><button id="copy_btn" onclick="copy()">Копировать</button></p>
    <script>
      function copy()
      {
          source.select()
          document.execCommand('copy')
          copy_btn.focus()
      }
    </script>
    <?php endif?>
  </div>
</body>
</html>