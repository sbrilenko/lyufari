
//------------------------------------------------
// Функция передает параметры скрипту на pfuhepre категорий
//------------------------------------------------
function promtLink(obj, action) {
	
    var link = prompt('Введите url', "http://");

    if (link != null) {
        replaceSelectedText(obj, action, link);
    }
}
//------------------------------------------------
// Функция вставляет псевдотеги
//------------------------------------------------
function replaceSelectedText(obj, action, url)
{
	var obj = document.getElementById(obj);
	var rs, add_count;
	obj.focus();
	if (document.selection) 
	{
		var s = document.selection.createRange(); 
		if (s.text)
		{
			switch (action) {
				case "bold": 
						s.text = "[strong]" + s.text + "[/strong]";
						break;
                                case "cursiv": 
						s.text = "[em]" + s.text + "[/em]";
						break;
					
				case "color": 	
						s.text = "[color]" + s.text + "[/color]";
						break;
				
				case "url": 	
						s.text = "[url=" + url + "]" + s.text + "[/url]";
						break;
			}
			
			return true;
		}
	}
	else
		if (typeof(obj.selectionStart)=="number")
 		{
			if (obj.selectionStart != obj.selectionEnd)
			{
				var start = obj.selectionStart;
				var end = obj.selectionEnd;
				
				switch (action) {
					case "bold": 
							rs = "[strong]" + obj.value.substr(start, end - start) + "[/strong]";
							add_count = 17; 
							break;
                                                        
					case "cursiv": 
							rs = "[em]" + obj.value.substr(start, end - start) + "[/em]";
							add_count = 9; 
							break;
						
					case "color": 	
							rs = "[color]" + obj.value.substr(start, end - start) + "[/color]";
							add_count = 15; 
							break;

					case "url": 	
							rs = "[url=" + url + "]" + obj.value.substr(start, end - start) + "[/url]";
							add_count = 12 + url.length; 
							break;
				}
				obj.value = obj.value.substr(0, start) + rs + obj.value.substr(end);
				obj.setSelectionRange(end + add_count, end + add_count);
			}
			return true;
		}

	return false;
}


$(function(){
    /*оставить только цифры*/
    $(document).bind('keyup keydown keypress',function(e){onlynumbers(e)});
    function onlynumbers(ev)
    {
        if(ev.keyCode!=37 && ev.keyCode!=38 && ev.keyCode!=40 && ev.keyCode!=39)
        {
            $('.onlynumbers').map(function(){
            var numbers = $(this).val().replace(/[^\d.]/g, "");
            $(this).val(numbers);
            })
        }
    }
    $('#remove_end').on('click',function()
    {
        $('#datepicker2').val('')
    })
})