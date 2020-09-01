$(document).ready(function()
{
	//button for profile post
	$('#submit_profile_post').click(function(){
		$.ajax({
			//submit type
			type: "POST",
			//submit destination
			url: "include/handlers/ajax_submit_profile_post.php",
			//data sent
			data: $('form.profile_post').serialize(),
			//if submission is successful, hide the modal
			success: function(msg)
			{
				$("#post_form").modal('hide');
				//reload the page
				location.reload();
			},
			// if submission is failed, alert "Failture"
			error: function(){
				alert("Failure");
			}
		});
	});
});