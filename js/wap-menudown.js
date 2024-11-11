jQuery(function(){
    var v_width= jQuery(document.body).width();
    jQuery(".select_textul").width(v_width);
    
    jQuery(".select_textdiv").click(function(){
		jQuery(this).parent().parent().siblings().find(".select_textul").hide();
    	jQuery(".select_textdiv").removeClass("divfocus");
    	jQuery(this).addClass("divfocus");
    	jQuery(this).siblings(".select_textul").fadeToggle(100);
        var lilength = jQuery(this).siblings(".select_textul").find("li.focus").has(".select_second_ul").length;
    	if(lilength > 0){
    		jQuery(this).siblings(".select_textul").find("li.focus>.select_second_ul").show();
    	}else{
    		jQuery(".select_first_ul>li>p").css("width","100%");
    	}
    })
	jQuery(".select_first_ul>li>p").click(function(){
		jQuery(".select_second_ul").hide();
		jQuery(this).parent("li").addClass("focus").siblings("li").removeClass("focus");
		var ynul = jQuery(this).parent("li").has(".select_second_ul").length;
        if(ynul == 0){
        	
        	var choose = jQuery(this).text();
			jQuery(this).parents(".select_textul").siblings(".select_textdiv").find(".s_text").text(choose);
			jQuery(this).parents(".select_textul").siblings("input").val(choose);
			jQuery(this).parents(".select_textul").fadeOut(300);
        }else{
        	jQuery(".select_second_ul").hide();
		    jQuery(this).siblings(".select_second_ul").show();
		    event.stopPropagation();
			chooseclick();
        }
		
	});
	
	chooseclick();
	function chooseclick(){
		jQuery(".select_second_ul>li").click(function(){
			var choose = jQuery(this).text();
			jQuery(this).addClass("focusli").siblings("li").removeClass("focusli");
			jQuery(this).parents(".select_textul").siblings(".select_textdiv").find(".s_text").text(choose);
			jQuery(this).parents(".select_textul").siblings("input").val(choose);
			jQuery(this).parents(".select_textul").fadeOut(300);
			
			event.stopPropagation();
		});
	}
		
})
