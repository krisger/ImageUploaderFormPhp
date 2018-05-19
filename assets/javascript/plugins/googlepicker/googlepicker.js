	var developerKey = 'your-key';
	var clientId = 'your-id.apps.googleusercontent.com';
	var scope = 'https://www.googleapis.com/auth/drive';

	var pickerApiLoaded = false;
	var oauthToken;

	function onApiLoad() {
		gapi.load('auth2', onAuthApiLoad);
		gapi.load('picker', onPickerApiLoad);
	}

	function onAuthApiLoad() {
		var authBtn = document.getElementById('auth');
		authBtn.disabled = false;
		authBtn.addEventListener('click', function() {
	      gapi.auth2.authorize({
	        client_id: clientId,
	        scope: scope,
	        immediate:false
	      }, handleAuthResult);
		});
	}

	function onPickerApiLoad() {
		pickerApiLoaded = true;
		createPicker();
	}

	function handleAuthResult(authResult) {
		if (authResult && !authResult.error) {
			oauthToken = authResult.access_token;
			createPicker();
		}
	}

	function createPicker() {
		if (pickerApiLoaded && oauthToken) {
			var view = new google.picker.View(google.picker.ViewId.DOCS);
	        view.setMimeTypes("image/png,image/jpeg,image/jpg");
			var picker = new google.picker.PickerBuilder().
			addView(view).
			setOAuthToken(oauthToken).
			setDeveloperKey(developerKey).
			setCallback(pickerCallback).
			build();
			picker.setVisible(true);
		}
	}

	function pickerCallback(data) {
		var imageId, name, mimeType, url, doc, token
		if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
			console.log(data);
			doc = data[google.picker.Response.DOCUMENTS][0];
			token = oauthToken;
			url = doc[google.picker.Document.URL];
			imageId = data.docs[0].id;
		    name = data.docs[0].name;
		    mimeType = data.docs[0].mimeType;
		}
		document.getElementById('google-outh-token').value = token;
		document.getElementById('google-image-file').value = url;
		document.getElementById('google-image-name').value = name;
		document.getElementById('google-image-id').value = imageId;
		document.getElementById('google-image-mime-type').value = mimeType;
	}