jQuery(function() {
	if(window.PIE){
		jQuery('#wrapper, .top-bar, .btn, .btn i, .toolkit-section, .main-green .t-box, .question-text .ico-info .box').each(function(){
			PIE.attach(this);
		});
	}
});