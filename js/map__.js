 var touchorclick;
var Map = function(){
	var $this = this;
	/** ������ ����� Google */
	var map;
	/** ���������� */
	var eqLocation;
	/** ������ */
	var eqMarker;
	/** ������, ������� ����� ��������� ��� ��������� ������ �������� */
	var homeMarker;
	/** ����������� ��������� � ������� */
	var eqInfo;
	/** ��� ��������, ������� ����� �������������� �� ����� */
	var travellingMode = google.maps.TravelMode.DRIVING;
	/** �������������� ����������� */
	var geocoder = new google.maps.Geocoder();
	
	var info;
	
	/** ���� ����� */
	var lang;
	
	var googleErrors = [];
	
	/** �������� ����� �������� �� ����� ��� ������� */
	var directionsRenderOptions = {
		suppressMarkers: true
	};
	
	var directionsDisplay = new google.maps.DirectionsRenderer(directionsRenderOptions);
	var directionsService = new google.maps.DirectionsService();
	
	/** ���������� �������� */
	this.route = function(){
		var request = {
		    origin: $('.abpoint-a input').val(),
		    destination: eqLocation,
		    travelMode: travellingMode
		};
		directionsService.route(request, function(response, status) {
			switch (status){
				case google.maps.DirectionsStatus.OK: 
					directionsDisplay.setDirections(response);
					var address = $('.abpoint-a > input').val();
                    
					geocoder.geocode({'address' : address},function(results,status){
						addHomeMarker(results[0].geometry.location,address);
					});
					break;
				case google.maps.DirectionsStatus.NOT_FOUND:
					alert(googleErrors[0]);
					break;
				case google.maps.DirectionsStatus.ZERO_RESULTS:
					alert(googleErrors[1]);
					break;
			}
		});
	}
	/** ��������� ������ ������ ������ */
	function addHomeMarker(position, content){
		if (typeof(info) != 'undefined'){
			info.close();
		}
		info = new google.maps.InfoWindow();
		info.setContent(content);
		info.setPosition(position);
		
		if (typeof (homeMarker) != 'undefined'){
			homeMarker.setPosition(position);
		} else {
			homeMarker = new google.maps.Marker({
				position: position,
				map: map
				//icon: 'img/way/marker_start.png'
			});
			google.maps.event.addListener(homeMarker,touchorclick,function(){
				info.open(map);
			});
		}
	}
	
	/** ����� ���� ������������� �������� */
	this.changeTravellingMode = function(){
		$(this).siblings().removeClass('selected').end().addClass('selected');
		if ($('.travelling-mode').index($(this)) == 0){
			travellingMode = google.maps.TravelMode.DRIVING;
		} else {
			travellingMode = google.maps.TravelMode.WALKING;
		}
		if ($.trim($('.abpoint-a>input').val()) != '') $this.route();
	}
	
	/** ����������� � ��������� ����� */
	function determineLang(){
		var href = window.location.href;
		var regExp = /\/rus\//;
        lang = 'rus';
		/*if (href.search(regExp) != -1){
			lang = 'rus';
		} else {
			lang = 'eng';
		}*/
	}
	/** �������������� �������� ��������� */
	function initLang(){
		switch(lang){
			case 'rus':
				googleErrors[0] = "����� �� ������. ����������, ��������� ������������ ���������� ������!";
				googleErrors[1] = "����� �� ������. ����������, ��������� ������������ ���������� ������.";
				break;
			case 'eng':
				googleErrors[0] = "Address not found. Please check the entered address!";
				googleErrors[1] = "Sorry... No route could be found between the origin and destination!";
				break;
		}
	}
	
	/** ������������� */
	(function init(){
		determineLang();
		initLang();
		eqLocation = new google.maps.LatLng(48.011907334578346,37.78056889772415);
		var mapOptions = {
			zoom: 15,
			center: new google.maps.LatLng(48.01524109912293,37.78054744005203),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false,
            panControl: false
		};
		map = new google.maps.Map(document.getElementById('map'),mapOptions);
		directionsDisplay.setMap(map);
		eqMarker = new google.maps.Marker({
					position: eqLocation,
					map: map,
					title: '������'
				});
        var th="�. ������, ��. ��������, 118 (����� � \"������� ������\")";
		eqInfo = new google.maps.InfoWindow({
			content:"<div><img style='float:left;width:90px;height:68px;' src='../img/vid.jpg'/><div style='width:87px;float:left;'><img style='width:141px;margin-left:47px;' src='../img/logo.png'/></div><div style='clear:both;'></div><div style='font-family:Arial;font-size:12px;color:#000;margin-top: 10px;'>�. ������, ��. ��������, 118 (����� � \"������� ������\")<br /><i style='color:#999999;'>+38&nbsp;(067) 862 86 48<br />+38&nbsp;(095) 172 72 72<br /></i> </div> </div>"
		});
		google.maps.event.addListener(eqMarker,'click',function(){
			eqInfo.open(map,eqMarker);
		});
        eqInfo.open(map,eqMarker);
	})();
}
/** ������ �������� �� ������� ENTER'� */
var enter = function(e){
	if (e.keyCode == 13){
		$('.c-button').trigger(touchorclick);
	}
}

$(function(){
   
    (!!('ontouchstart' in window))?touchorclick='touchstart':touchorclick='click';
	var map = new Map();
	//$('.google-map-route input:first').focus();
	$(document).on(touchorclick,'.c-button',map.route);
	$(document).on(touchorclick,'.travelling-mode',map.changeTravellingMode);
    $(document).on(touchorclick,'.abpoint-a-aft .selected',function()
    {
        $('.abpoint-a-aft span').addClass('selected')
        $('.abpoint-a input').val($(this).data('addr'))
        $(this).removeClass('selected')
    });
    $(document).on('keyup','.abpoint-a input',function()
    {
         $('.abpoint-a-aft span').addClass('selected')
    })
	$('input').bind('keyup', enter);
});
