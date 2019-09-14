<?php tmpl("dash/header", ["title"=>"New post"]); ?>
    <h2 id="className">Add a new post to: </h2>
    <div class="contents" id="classPosts">
        <input type="text" id="postTitle" class="flatInput" placeholder="Title">
        <select id="postType" class="flatInput">
            <option selected value="POST">Text</option>
            <option value="WORKSHEAT">Worksheat</option>
            <option value="IMAGE_WORKSHEAT">Image-Worksheat</option>
        </select>
        @view(("tools/editor"))!
        <div id="IMAGE_WORKSHEAT">
            <input style="display: none" id="IMAGE_WORKSHEAT_imageupload" accept="image/*" type="file">
            <img id="IMAGE_WORKSHEAT_imageuploadImage" width="100%" src="/assets/images/nopb.png" />
        </div>
        <br><br>
        <a id="submitPost" class="flatButton1">Submit</a>
    </div>
    <script>
        base64Image = "";
        var imageUrl = "";
        $("#IMAGE_WORKSHEAT").hide();
        function setTypePost() {
            $("#forminputs").hide();
            $("#lehrgaeditorouter").show();
            $("#IMAGE_WORKSHEAT").hide();
        }

        function setTypeWorksheat() {
            $("#forminputs").show();
            $("#lehrgaeditorouter").show();
            $("#IMAGE_WORKSHEAT").hide();
        }

        function setImageWorksheat() {
            $("#forminputs").hide();
            $("#lehrgaeditorouter").hide();
            $("#IMAGE_WORKSHEAT").show();
        }

        $("#postType").change(function () {
            type = $("#postType").val();
            if (type == "POST")
                setTypePost();
            else if(type == "IMAGE_WORKSHEAT")
                setImageWorksheat();
            else
                setTypeWorksheat();
        });

        setTypePost();

        function sendPost(requestJson) {
            Cajax.post("/course/{{$pageid}}/new", requestJson).then(function (resp) {
                parsedJSON = JSON.parse(resp.responseText);
                if (parsedJSON.done) {
                    if (parsedJSON.redirect !== false)
                        window.location = parsedJSON.redirect;
                }
            }).catch(function () {
                alert("Error");
            }).send();
        }

        $("#submitPost").click(function () {
            requestJson = { };
            if ($("#postType").val()=="WORKSHEAT" || $("#postType").val()=="POST") {
                requestJson = {
                    title: $("#postTitle").val(),
                    type: $("#postType").val(),
                    text: $("#lehrgaeditor").html()
                }
                sendPost(requestJson);
            } else if ($("#postType").val() == "IMAGE_WORKSHEAT") {
                
                if (imageUrl != "") {
                    requestJson = {
                        title: $("#postTitle").val(),
                        type: $("#postType").val(),
                        text: imageUrl
                    }
                    sendPost(requestJson);
                } else
                    alert("No image selected");
            
            }
            
        });

        $("#IMAGE_WORKSHEAT_imageuploadImage").click(function() {
            filePicker.openFilepicker();
            filePicker.whenSelected = function(file) {
                document.getElementById("IMAGE_WORKSHEAT_imageuploadImage").src = file;
                imageUrl = file;
                filePicker.closeFilepicker();
            };            
        });

    </script>
<?php tmpl("dash/footer"); ?>