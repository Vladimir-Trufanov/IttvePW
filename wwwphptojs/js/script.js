$(document).ready(function() {
	//
	$(".content").prepend("<p class='for_button'>" + button + "</p>");
	
	var id = 2;
	var search = "search";
	var ob = {
		'id':3
	}
	//alert(JSON.stringify(ob));
	$(".for_button").click(function() {
		//location.href = "http://localhost/lessons/phptojs/view_text.php?id=" + id;
		$.ajax({
			
			type:'POST',
			url:'index.php',
			dataType:'json',
			data:"param="+JSON.stringify(ob),
			success:function(html) {
$("<p class='for_content'>" + html['title'] + "</p>").
						prependTo(".content").
						hide().
						fadeIn(500);
			}
		});
		
	});
	
	$("input[type=text]").val(search);
});