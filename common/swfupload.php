<?php 

class SwfuploadCommon extends Feng
{
	
	public static function swfUpload()
	{
		$public = ltrim(APP_ROOT, '/') . '/public';
		$str = <<<startStr
<link href="{$public}/swfupload/css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$public}/swfupload/swfupload.js"></script>
<script type="text/javascript" src="{$public}/swfupload/js/fileprogress.js"></script>
<script type="text/javascript" src="{$public}/swfupload/js/handlers.js"></script>
<script type="text/javascript">
		var swfu;
		window.onload = function() {
			var settings = {
				flash_url : "{$public}/swfupload/swfupload.swf",
				upload_url: "{$public}/swfupload/upload.php",
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
				file_size_limit : "100 MB",
				file_types : "*.*",
				file_types_description : "All Files",
				file_upload_limit : 100,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				//debug: true,

				// Button settings
				button_image_url: "{$public}/swfupload/images/TestImageNoText_65x29.png",
				button_width: "65",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="theFont">select</span>',
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,
				
				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess
			};
			swfu = new SWFUpload(settings);
	     };
	</script>
<div id="swfupload-content">
	<form id="form1" action="index.php" method="post" enctype="multipart/form-data">
		<div class="fieldset flash" id="fsUploadProgress">
		</div>
		<div id="divStatus"></div>
		<div id="divMovieContainer">
			<span id="spanButtonPlaceHolder"></span>
			<input type="button" value="Start Upload" onclick="swfu.startUpload();" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
		</div>

	</form>
</div>
						<script>
							function uploadSuccess(file, serverData) {
						console.log(file);
						console.log(serverData);
							try {
								var progress = new FileProgress(file, this.customSettings.progressTarget);
								progress.setComplete();
								progress.setStatus("Complete.");
								progress.toggleCancel(false);
							} catch (ex) {
								this.debug(ex);
							}
							} 
						</script>
		
startStr;
		return $str;
	}
}