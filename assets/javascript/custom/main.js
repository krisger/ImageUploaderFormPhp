
function uploadWithGoogle(){
	var googlePicker = document.getElementById('google-picker');
	var localPicker = document.getElementById('local-picker');
	
	if (document.getElementById('upload-google-drive').checked) {
		localPicker.classList.add("hidden");
		googlePicker.classList.remove("hidden");
	}else{
		googlePicker.classList.add("hidden");
		localPicker.classList.remove("hidden");
	}
}
