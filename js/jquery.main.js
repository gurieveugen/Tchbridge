// =========================================================
// OPTIONS
// =========================================================
var page_number = 2;
var interval_id = 0;

(function(jQuery) {
	jQuery(function() {		
		jQuery('input, select').styler();
		
    	jQuery('.lightbox-mask').click(function(event){
    		event.stopPropagation();
    		showHide(false, ['']);
    	});
    	// =========================================================
    	// SIGN IN BLOCK
    	// =========================================================
    	jQuery('#employment-control').change(function(){
    		if(jQuery(this).val() == 'Other')
    		{
    			jQuery('#please-specify').show();
    			jQuery('#please-specify').attr('name', 'employment');
    		}    		
    		else
    		{
    			jQuery('#please-specify').hide();
    		}
    	});
    	jQuery('.question-text .ico-info .box').each(function(){
    		jQuery(this).css({'top' : parseInt( '-' + (jQuery(this).height() / 2)-10) })
    	});    	

    	// =========================================================
    	// Slider
    	// =========================================================
		var jcarousel = jQuery('.jquery-toolkit');

	    jcarousel.on('jcarousel:reload jcarousel:create', function () {
				jcarousel.jcarousel('items').width(105);
				jcarousel.jcarousel('scroll', SCROLL_POSITION, false);  }).jcarousel({
	                wrap: 'circular',                
	                animation: {
	                        duration: 800,
	                        easing:   'linear',
	                        complete: function() {
	                        }
	                    }
	            });

    	// =========================================================
    	// Next button
    	// =========================================================
    	jQuery('.jquery-toolkit-next')
    	.mouseup(function() {  			  	
  			clearInterval(interval_id);
  			setScrollPosition(); })
    	.mousedown(function() {
  			interval_id = setInterval( function(){ jQuery('.jquery-toolkit').jcarousel('scroll', '+=1'); }, 100); });

    	// =========================================================
    	// SIGN IN
    	// =========================================================
    	jQuery('#form-sign-in').on('submit', function(e){
    		jQuery.ajax({
    			type: "POST",
    			url: ajax_login_object.ajaxurl + '?action=loginajax',
    			dataType: 'json',
    			data: {
    				log: jQuery('#form-sign-in input[name="log"]').val(),			
    				pwd: jQuery('#form-sign-in input[name="pwd"]').val(),
    				security: jQuery('#form-sign-in input[name="security"]').val()},    			
    			success: function(data){    				
    				if(!data.loggedin)
    				{
    					jQuery('.error-password').fadeIn('slow');
    				}
    				else
    				{
    					document.location.href = data.redirect_to;
    				}
    			}
    		});
    		e.preventDefault();
    	});    	
    	// =========================================================
    	// SIGN UP
    	// =========================================================
    	jQuery('#form-sign-up').on('submit', function(e){
    		var employment = jQuery('#form-sign-up select[name="employment"]').val();
    		if(employment == 'Other') employment = jQuery('#form-sign-up input[name="employment"]').val();

    		jQuery.ajax({
    			type: "POST",
    			url: ajax_login_object.ajaxurl + '?action=registrationajax',
    			dataType: 'json',
    			data: {
    				fullname: jQuery('#form-sign-up input[name="full_name"]').val(),
    				email: jQuery('#form-sign-up input[name="user_email"]').val(),
    				log: jQuery('#form-sign-up input[name="user_login"]').val(),
    				pwd: jQuery('#form-sign-up input[name="password"]').val(),
    				employment: employment,
    				security: jQuery('#form-sign-up input[name="security"]').val()},    			
    			success: function(data){
    				console.log(data);
    				if(!data.registered)
    				{
    					jQuery('.error-user').text(data.message);
    					jQuery('.error-user').fadeIn('slow');
    				}
    				else
    				{
    					document.location.href = ajax_login_object.redirecturl;
    				}
    			}
    		});
    		e.preventDefault();
    	});    	
		// =========================================================
    	// Renew lost password
    	// =========================================================
    	jQuery('#forgot-password').on('submit', function(e){
    		jQuery.ajax({
    			type: "POST",
    			url: ajax_login_object.ajaxurl + '?action=lostpasswordajax',
    			dataType: 'json',
    			data: {    				
    				email: jQuery('#forgot-password input[name="email"]').val(),
    				security: jQuery('#forgot-password input[name="security"]').val()},    			
    			success: function(data){
    				console.log(data);
    				if(!data.renewpassword)
    				{
    					jQuery('.error-user').text(data.message);
    					jQuery('.error-user').fadeIn('slow');
    				}
    				else
    				{
                        jQuery('.error-user').text(data.message);
                        jQuery('.error-user').fadeIn('slow');

                        setTimeout(function() { document.location.href = ajax_login_object.redirecturl; }, 4000);
    					
    				}
    			}
    		});
    		e.preventDefault();
    	}); 
})
})(jQuery)

/**
 * Get tools
 * @param  integer posts_per_page 
 */
function getTools()
{
	var view_more = '';
	var check_new = '';
    jQuery.post(SITE_FOLDER + '/wp-admin/admin-ajax.php?action=gettools', {				
		paged: page_number
    }, 
    function(data) 
    {
		if(data != "")
		{ 			
			page_number += 1;
			view_more = jQuery('#view-more');
			check_new = jQuery('#check-new-materials');
			view_more.remove();
			check_new.remove();
			jQuery('.toolkit-section').append(data);
			if((page_number-1) < pages_count)
			{
				jQuery('.toolkit-section').append(view_more);				
			}			
		}
    }); 
}

/**
 * Save answe to user data
 * @param integer user_id 
 * @param integer post_id 
 */
function setAnswer(post_id)
{
	var answers = new Array();
	jQuery('.answer').each(function(){
		answers[jQuery(this).attr('data-id')] = jQuery(this).val();		
	});
	
	jQuery.ajax({
		type: "POST",
		url: SITE_FOLDER + '/wp-admin/admin-ajax.php?action=setanswer',
		data: {
			post_id : post_id,			
			answer  : answers},
		dataType: 'json',
		success: function(data){
			if(data.msg == 'OK')
			{
				alert('Answer(s) saved!');
			}
			else
			{
				alert('The answer can not be saved');				
			}
		}
	});
    
    return false;
}

/**
 * Select/Deselect filter category
 * @param  boolean select 
 * @param  integer cat
 * @return boolean
 */
function selectDeselectCat(select, cat, term_id)
{
	jQuery.ajax({
		type: "POST",
		url: SITE_FOLDER + '/wp-admin/admin-ajax.php?action=selectdeselectcat',
		data: {
			select : select,
			cat    : cat, 
			term_id: term_id},
		dataType: 'json',
		success: function(data){
			if(data.msg != '') window.open(SITE_FOLDER + '/resources/', '_self', '');			
		}
	});
    
    return false;
}

/**
 * Next jcarousel slide
 */
function next()
{
	//jQuery('.jcarousel-control-next').jcarouselControl({ target: '+=1' }); 
	setScrollPosition();
	jQuery('.jcarousel').jcarousel('scroll', '+=1');
}

/**
 * Set scroll position
 */
function setScrollPosition()
{	
	// var targetIndex = parseInt(jQuery('.jcarousel').jcarousel('index', jQuery('.jcarousel').jcarousel('target')));
	var position    = parseInt(jQuery('.jquery-toolkit ul li').first().data('index')); 
	var max         = getMaxPosition();

	if(position > max) position = 1;

	jQuery.ajax({
		type: "POST",
		url: SITE_FOLDER + '/wp-admin/admin-ajax.php?action=set_scroll_position',
		data: { position :  position}, dataType : 'json',
		success: function(){}});
}

/**
 * Get max position of jcarousel items
 * @return integer
 */
function getMaxPosition()
{
	var position = 1;
	jQuery('.jquery-toolkit ul li').each(function(){
		position = Math.max(position, parseInt(jQuery(this).data('index')));
	});
	return position;
}

/**
 * Show OR Hide light box
 * @param  boolean show 
 * @param  array   doms 
 */
function showHide(show, doms)
{
	if(typeof(doms) == 'undefined') return;
	var  default_doms = ['#sign-in', '#sign-up', '#forgot-password', '.lightbox-mask'];

	for(var ddom in default_doms)
	{
		jQuery(default_doms[ddom]).hide();
	}

	if(show)
	{
		for(var dom in doms)
		{
			jQuery(doms[dom]).show();
		}
	}	
}

/**
 * Open Close accordion
 */
function openClose(obj)
{
	obj = jQuery(obj).parent().parent();
	if(obj.hasClass('open'))
	{
		obj.removeClass('open');
	}
	else
	{
		obj.addClass('open');	
	}
}