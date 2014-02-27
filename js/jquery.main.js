var page_number = 2;
var index       = 10;

(function(jQuery) {
	jQuery(function() {
		jQuery('input, select').styler();
		jQuery('.jcarousel').on('jcarousel:createend', function() {        
    		jQuery(this).jcarousel('scroll', index, false); }).jcarousel({ 	
			wrap: 'circular',
			animation: 'slow'});

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

    	jQuery('.jcarousel-control-next').jcarouselControl({ target: '+=1' });
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
    jQuery.post('/wp-admin/admin-ajax.php?action=gettools', {				
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
		url: '/wp-admin/admin-ajax.php?action=setanswer',
		data: {
			post_id : post_id,			
			answer  : answers},
		dataType: 'json',
		success: function(data){
			if(data.msg == 'OK')
			{
				alert('Answer saved!');
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
		url: '/wp-admin/admin-ajax.php?action=selectdeselectcat',
		data: {
			select : select,
			cat    : cat, 
			term_id: term_id},
		dataType: 'json',
		success: function(data){
			if(data.msg != '') window.open('/resources/', '_self', '');			
		}
	});
    
    return false;
}

/**
 * Next jcarousel slide
 */
function next()
{
	//jQuery('.jcarousel').jcarouselControl({ target: '+=1' });
}

/**
 * Show OR Hide light box
 * @param  boolean show 
 * @param  array   doms 
 */
function showHide(show, doms)
{
	if(typeof(doms) == 'undefined') return;
	var  default_doms = ['#sign-in', '#sign-up', '.lightbox-mask'];

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