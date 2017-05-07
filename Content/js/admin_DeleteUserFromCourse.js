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
	
	$.post('index.php?con=5&page=9', {id_coursesusers:id_coursesusers},
	function(data)
	{
		alert( "Data Loaded: " + data );
	});
}