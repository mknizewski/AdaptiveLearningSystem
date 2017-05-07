$( "#dropDownMenu_Courses li #goout" ).click(function() 
{
	var id = $(this).attr('deleteID');
	post(id);
});

//funkcja edycji danych
function post(id)
{
	$.ajax({
		url: "index.php?con=5&page=10",
		data: { userId: id },
		type: "POST",
		success: function() {
			location.reload(true);
		}
	});
}