<?php

function Probaf($Arti)
{
   echo 'Probaf($Arti)<br>';
   $pdo=$Arti->BaseConnect();
   
   /* Все варианты сортировки */
   $sort_list = array(
   'uid_asc'   => '"uid"',
   'uid_desc'  => '"uid" DESC',
   'pid_asc'   => '"pid"',
   'pid_desc'  => '"pid" DESC',
   'NameArt_asc'  => '"NameArt"',
   'NameArt_desc' => '"NameArt" DESC',
   'IdCue_asc'  => '"IdCue"',
   'IdCue_desc' => '"IdCue" DESC',
   );
	
   /* Проверка GET-переменной */
   $sort = @$_GET['sort'];
   if (array_key_exists($sort, $sort_list)) 
   {
	   $sort_sql = $sort_list[$sort];
   } 
   else 
   {
	  $sort_sql = reset($sort_list);
   }
   echo '$sort_sql='.$sort_sql.'<br>';

   /* Запрос в БД */	
   //$cSQL="SELECT uid,pid,NameArt,IdCue FROM stockpw ORDER BY uid";
   $cSQL="SELECT uid,pid,NameArt,IdCue FROM stockpw ORDER BY {$sort_sql}";
   $stmt=$pdo->query($cSQL);
   $list=$stmt->fetchAll();
   
   echo '$cSQL='.$cSQL.'<br>';
   //print_r($list);
   
   /* Функция вывода ссылок */
   function sort_link_th($title,$a,$b) 
   {
	  $sort = @$_GET['sort'];
	  if ($sort == $a) 
      {
	    return '<a class="active" href="?sort=' . $b . '">' . $title . ' <i>>..</i></a>';
	  } 
      elseif ($sort == $b) 
      {
	    return '<a class="active" href="?sort=' . $a . '">' . $title . ' <i><..</i></a>'; 
	  } 
      else 
      {
	    return '<a href="?sort=' . $a . '">' . $title . '</a>'; 
	  }
   }

   ?> <!-- -->
   <table>
   <thead>
   <tr>
      <th><?php echo sort_link_th('..Пункт меню..',   'uid_asc',    'uid_desc');     ?></th>
      <th><?php echo sort_link_th('..Родитель..',     'pid_asc',    'pid_desc');     ?></th>
      <th><?php echo sort_link_th('..Статья сайта..', 'NameArt_asc','NameArt_desc'); ?></th>
      <th><?php echo sort_link_th('..Тип статьи..',   'IdCue_asc',  'IdCue_desc');   ?></th>
   </tr>
   </thead>
   <tbody>
   <?php foreach ($list as $row): ?>
   <tr>
   <td><?php echo $row['uid']; ?>             </td>
   <td><?php echo $row['pid']; ?>             </td>
   <td><?php echo $row['NameArt']; ?>         </td>
   <td><?php echo $row['IdCue']; ?> тип статьи</td>
   </tr>
   <?php endforeach; ?> 
   </tbody>
   </table>
   <?php
}
