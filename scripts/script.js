changeRadio = () => {
	if ($("#open_license").prop("checked")) {
		$(".changeattr").attr('required', 'true');
	} else {
		$(".changeattr").removeAttr('required');
	}
}

changeCheck = () => {
	if ($("#unlim").prop("checked")) {
		$(".changeCheck").removeAttr('required');
	} else {
		$(".changeCheck").attr('required', 'true');
	}
}