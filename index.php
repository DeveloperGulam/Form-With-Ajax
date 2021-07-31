<?php require_once './csrf_token.php'; ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="robots" content="noindex, nofollow">
      <title>Form</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet" id="bootstrap-css">
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
   </head>
   <body>
      <form method="post" id="uploadForm" enctype="multipart/form-data">
		<input type="hidden" name="token" value="<?= csrf_token(); ?>"/>
         <label>
            <p class="label-txt">ENTER YOUR NAME</p>
            <input type="text" class="input" name="name" required>
            <div class="line-box">
               <div class="line"></div>
            </div>
         </label>
         <label>
            <p class="label-txt">ENTER YOUR EMAIL</p>
            <input type="text" class="input" name="email" required>
            <div class="line-box">
               <div class="line"></div>
            </div>
         </label>
		 <label>
            <p class="label-txt">Profile</p>
            <input type="file" name="file" id="fileInput" class="input" required>
         <label>
		 
         <button type="submit" name="submit" value="UPLOAD">Submit</button>
		 <!-- <div id="msg"></div> -->
		
      </form>
	   
</div>
	  <!-- Display upload status -->
<div id="uploadStatus"></div>
<!-- Progress bar -->
	  <div class="progress">
    <div class="progress-bar"></div>
	  <script>
$(document).ready(function(){
    // File upload via Ajax
    $("#uploadForm").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                        $(".progress-bar").html(percentComplete+'%');
                    }
                }, false);
                return xhr;
            },
            type: 'POST',
            url: 'upload.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $(".progress-bar").width('0%');
                $('#uploadStatus').html('<img src="loading.gif"/>');
            },
            error:function(){
                $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
            },
            success: function(resp){
                if(resp == 'ok'){
                    $('#uploadForm')[0].reset();
                    $('#uploadStatus').html('<p style="color:#28A74B;">File has uploaded successfully!</p>');
                }else if(resp == 'err'){
                    $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid file to upload.</p>');
                }else{
                    $('#uploadStatus').html('<p style="color:#EA4335;">'+resp+'</p>');
                }
            }
        });
    });
	
    // File type validation
    $("#fileInput").change(function(){
        var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        var file = this.files[0];
        var fileType = file.type;
        if(!allowedTypes.includes(fileType)){
            alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG/GIF).');
            $("#fileInput").val('');
            return false;
        }
    });
});
</script>
   </body>
</html>