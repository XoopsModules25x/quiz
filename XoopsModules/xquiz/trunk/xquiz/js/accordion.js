//---------------------------------
//  Developed by Roshan Bhattarai 
//  Visit http://roshanbh.com.np for this script and more.
//  This notice MUST stay intact for legal use
// ---------------------------------
$(document).ready(function()
{
	//slides the element with class "menu_body" when paragraph with class "menu_head" is clicked 
	$("#firstpane p.menu_head_q").click(function()
    {
		$(this).css({backgroundImage:"url(down.png)"}).next("div.menu_body_q").slideToggle(300).siblings("div.menu_body_q").slideUp("slow");
       	$(this).siblings().css({backgroundImage:"url(left.png)"});
	});
	//slides the element with class "menu_body" when mouse is over the paragraph
	$("#secondpane p.menu_head_q").mouseover(function()
    {
	     $(this).css({backgroundImage:"url(down.png)"}).next("div.menu_body_q").slideDown(500).siblings("div.menu_body_q").slideUp("slow");
         $(this).siblings().css({backgroundImage:"url(left.png)"});
	});
});