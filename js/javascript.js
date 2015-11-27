/** * PROTOTYPE PORK TRACEABILITY SYSTEM 
* Copyright © 2014 UPLB. **/ 
$(document).ready(function() {
	jQuery.event.props.push('dataTransfer');
	var z = -40;
	var maxFiles = 5;
	var errMessage = 0;
	var dataArray = [];
	$('#drop-files').bind('drop', function(e) {
		
		e.preventDefault();
		var files = e.dataTransfer.files;
		$('#uploaded-holder').show();
		$.each(files, function(index, file) {
			if (!files[index].type.match('image.*')) {
				if (errMessage == 0) {
					$('#drop-files').html('Hey! Images only');
					++errMessage
				} else if (errMessage == 1) {
					$('#drop-files').html('Stop it! Images only!');
					++errMessage
				} else if (errMessage == 2) {
					$('#drop-files').html("Can't you read?! Images only!");
					++errMessage
				} else if (errMessage == 3) {
					$('#drop-files').html("Fine! Keep dropping non-images.");
					errMessage = 0;
				}
				return false;
			}
			if ($('#dropped-files > .image').length < maxFiles) {
				var imageWidths = ((220 + (40 * $('#dropped-files > .image').length)) / 2) - 20;
				$('#upload-button').css({
					'left': imageWidths + 'px',
					'display': 'block'
				});
			}
			var fileReader = new FileReader();
			fileReader.onload = (function(file) {
				return function(e) {
					dataArray.push({
						name: file.name,
						value: this.result
					});
					z = z + 40;
					var image = this.result;
					if (dataArray.length == 1) {
						$('#upload-button span').html("1 file to be uploaded");
					} else {
						$('#upload-button span').html(dataArray.length + " files to be uploaded");
					}
					if ($('#dropped-files > .image').length < maxFiles) {
						$('#dropped-files').append('<div class="image" style="left: ' + z + 'px; background: url(' + image + '); background-size: cover;"> </div>');
					} else {
						$('#extra-files .number').html('+' + ($('#file-list li').length + 1));
						$('#extra-files').show();
						$('#extra-files #file-list ul').append('<li>' + file.name + '</li>');
					}
				};
			})(files[index]);
			fileReader.readAsDataURL(file);
		});
	});


	function restartFiles() {
		$('#loading-bar .loading-color').css({
			'width': '0%'
		});
		$('#loading').css({
			'display': 'none'
		});
		$('#loading-content').html(' ');
		$('#upload-button').hide();
		$('#dropped-files > .image').remove();
		$('#extra-files #file-list li').remove();
		$('#extra-files').hide();
		$('#uploaded-holder').hide();
		dataArray.length = 0;
		z = -40;
		return false;
	}
	$('#upload-button .upload').click(function() {
		$("#loading").show();
		var totalPercent = 100 / dataArray.length;
		var x = 0;
		var y = 0;
		var a = $('#id_pig').val();
		$('#loading-content').html('Uploading ' + dataArray[0].name);
		$.each(dataArray, function(index, file) {
			$.post('upload.php', dataArray[index], function(data) {
				var fileName = dataArray[index].name;
				++x;
				$('#loading-bar .loading-color').css({
					'width': totalPercent * (x) + '%'
				});
				if (totalPercent * (x) == 100) {
					$('#loading-content').html('Uploading Complete!');
					setTimeout(restartFiles, 500);
				} else if (totalPercent * (x) < 100) {
					$('#loading-content').html('Uploading ' + fileName);
				}
				var dataSplit = data.split(':');
				if (dataSplit[1] == 'uploaded successfully') {
					var realData = '<li><a href="images/' + dataSplit[0] + '">' + fileName + '</a> ' + dataSplit[1] + '</li>';
					$('#uploaded-files').append('<li><a href="images/' + dataSplit[0] + '">' + fileName + '</a> ' + dataSplit[1] + '</li>');
					if (window.localStorage.length == 0) {
						y = 0;
					} else {
						y = window.localStorage.length;
					}
					window.localStorage.setItem(y, realData);
				} else {
					$('#uploaded-files').append('<li><a href="images/' + data + '. File Name: ' + dataArray[index].name + '</li>');
				}
			});
		});
		return false;
	});
	$('#drop-files').bind('dragenter', function() {
		$(this).css({
			'box-shadow': 'inset 0px 0px 20px rgba(0, 0, 0, 0.1)',
			'border': '4px dashed #b44230'
		});
		return false;
	});
	$('#drop-files').bind('drop', function() {
		$(this).css({
			'box-shadow': 'none',
			'border': '4px dashed rgba(0,0,0,0.2)'
		});
		return false;
	});
	$('#extra-files .number').toggle(function() {
		$('#file-list').show();
	}, function() {
		$('#file-list').hide();
	});
	$('#dropped-files #upload-button .delete').click(restartFiles);
	if (window.localStorage.length > 0) {
		$('#uploaded-files').show();
		for (var t = 0; t < window.localStorage.length; t++) {
			var key = window.localStorage.key(t);
			var value = window.localStorage[key];
			if (value != undefined || value != '') {
				$('#uploaded-files').append(value);
			}
		}
	} else {
		$('#uploaded-files').hide();
	}
	
	
});