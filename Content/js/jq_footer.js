$( "ul.contact-container li img" ).click(function() 
{
	$("ul.contact-container li img").css("opacity", 0.7);
	$(this).css("opacity", 1);
	
	$(this).parent().parent().find("li").find(".about-info").css("display", "none");	
	$(this).parent().find(".about-info").fadeIn( "slow" ).css("display", "block");		
	jumpToPageBottom();
	
	$("ul.contact-container li img").addClass("animated");
	$(this).removeClass("animated");
	
	$(this).parent().parent().find("li").find(".about-info").addClass("animated fadeIn");
});


function jumpToPageBottom() 
{
	$('html, body').scrollTop( $(document).height() - $(window).height() );	
}