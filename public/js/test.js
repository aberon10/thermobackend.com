	   // X-CSRF-TOKEN
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	$.ajax({
		url         : form.getAttribute('action'),
		type        : 'POST',
		data        : formData,
		dataType    : 'json',
		contentType : false,
		processData : false,
	})
	.done(function(response) {
		// success
		console.log(response);
	})
	.fail(function(response){
		console.log(response);
	});