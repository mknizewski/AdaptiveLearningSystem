$( "#dropDownMenu_Courses li #goout" ).click(function() 
{
	$id = $(this).attr('deleteID');
	post($id);
});

//funkcja edycji danych
function post($id)
{
	$id_coursesusers = $id;
	alert($id_coursesusers);
	
	$.post('sciezka', {id_coursesusers:id_coursesusers},
	function(data)
	{
		
	});
}