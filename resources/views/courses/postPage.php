<?php tmpl("dash/header", ["title"=>"Hello"]); ?>
<h2 id="postName"></h2>
<div class="contents" id="post">

</div>
<div class="contents">

    <?php if($type == "IMAGE_WORKSHEAT"):?>
        <div>
        <div class="colorSelection" style="background: #000000" data-color="#000000"></div>
        <div class="colorSelection" style="background: #FF0000" data-color="#FF0000"></div>
        <div class="colorSelection" style="background: #00FF00" data-color="#00FF00"></div>
        <div class="colorSelection" style="background: #0000FF" data-color="#0000FF"></div>
        <div class="colorSelection" style="background: #FFFF00" data-color="#FFFF00"></div>
        <div class="colorSelection" style="background: #FF00FF" data-color="#FF00FF"></div>
        <div class="colorSelection" style="background: #00FFFF" data-color="#00FFFF"></div>
        <div class="colorSelection" style="background: #FFFFFF" data-color="#FFFFFF"></div>
        <br>
        <a id="erasor">Erasor</a>
        <br>
        <input type="color" id="customcolor">
        Size: <input type="range" id="penSize" min="1" max="30" value="3"> 
        </div>
        <canvas style="display: none" id="out" width="100%"></canvas>
        <div>
        <canvas style="position: absolute;" id="image"></canvas>
        <canvas id="draw"></canvas>
        <br><br><br><a id="upload" class="flatButton1">UPLOAD</a><br><br>
        <script src="/assets/js/drawing.js"></script>
        <script>
            $("#upload").click(function() {
                outCtx.clearRect(0, 0, canvas.width, canvas.height);
                outCtx.drawImage(canvas2,0,0);
                outCtx.drawImage(canvas,0,0);
                
                Cajax.post("/fileupload:img", {
                    image: outCanvas.toDataURL(),
                    folder: "m"
                }).then(function (resp) {
                    console.log(resp);
                    Cajax.post("/course/<?php echo ($courseid); ?>/post/<?php echo ($pageid); ?>/submit:imageworksheat", {
                        image: resp.responseText
                    }).then(function(response) {
                        parsedJson = JSON.parse(response.responseText);
                        if (parsedJson.redirect !== false)
                            window.location = parsedJson.redirect;
                    }).send();
                }).send();
            });
        </script>
        
        </div>
    <?php endif; ?>
    
    <?php if($isMine):?>
        <br><br>
        <a id="deletePost" style="cursor: pointer"><i class="material-icons" style="vertical-align: middle;">delete</i></a>

        <?php if($type == "WORKSHEAT" || $type == "IMAGE_WORKSHEAT"):?>
            <a href="/course/<?php echo ($courseid); ?>/post/<?php echo ($pageid); ?>/submits" style="vertical-align: middle;">Submits</a>
        <?php endif; ?>
    <?php endif; ?>
</div>
<script>
    
    var postsExists = false;
    Cajax.post("/course/<?php echo ($courseid); ?>/post/<?php echo ($pageid); ?>").then(function (resp) {
        parsedJSON = JSON.parse(resp.responseText);
        if (parsedJSON.done) {
            if (parsedJSON.data.type == "POST") {
                $("#postName").text(parsedJSON.data.contents.title !== null ? parsedJSON.data.contents.title : "");
                $("#post").append(parsedJSON.data.contents.text !== null ? parsedJSON.data.contents.text : "");
            } else if (parsedJSON.data.type == "WORKSHEAT") {
                $("#postName").text(parsedJSON.data.contents.title !== null ? parsedJSON.data.contents.title : "");
                $("#post").append(parsedJSON.data.contents.text !== null ? '<form action="/course/<?php echo ($courseid); ?>/post/<?php echo ($pageid); ?>/submit:work" method="POST">'+parsedJSON.data.contents.text+"<br><input type='submit' value='Submit'></form>" : "");
            } else if (parsedJSON.data.type == "IMAGE_WORKSHEAT") {
                base_image = new Image();
                base_image.src = ''+parsedJSON.data.contents.image;
                base_image.crossOrigin = "anonymous";
                base_image.onload = function(){
                    height = base_image.height;
                    width  = base_image.width;
                    ctx.canvas.width = width;
                    ctx.canvas.height = height;
                    ctx2.canvas.width = width;
                    ctx2.canvas.height = height;
                    outCtx.canvas.width = width;
                    outCtx.canvas.height = height;
                    ctx2.drawImage(this, 0, 0);
                };
            }
        } else $("#postName").text(parsedJSON.errorMessage);
    }).catch(function () {
        $("#postName").text("Something went wrong!");
    }).send();

    $("#deletePost").click(function() {
        Cajax.post("/course/<?php echo ($courseid); ?>/post/<?php echo ($pageid); ?>/delete").then(function (resp) {
            parsedJSON = JSON.parse(resp.responseText);
            if (parsedJSON.done) {
                window.location = parsedJSON.redirect;
            }
        }).catch(function() {
            alert("error");
        }).send();
    });

</script>
<?php tmpl("dash/footer"); ?>