<?php tmpl("dash/header", ["title"=>"Hello"]); ?>
<h2 id="className">My courses</h2>
<div class="contents" id="classPosts">

<br>
<?php if(USER["type"] == "TEACHER" || USER["type"] == "ADMIN"):?>
    <a onclick='$("#addClass").show();' class="flatButton1 waves-effect waves-light" style="float: right;" id="openNewClass">Add class</a>
        <div id="addClass">
            <input type="text" id="addClassName" class="flatInput" placeholder="Name (like 'Maths 9b')">
            <a id="submitNewClass" class="flatButton1 waves-effect waves-light" style="float: right;">Submit</a>
        </div>
    <?php endif; ?>
</div>
<script>
    var postsExists = false;
    Cajax.post("/courses").then(function (resp) {
        parsedJSON = JSON.parse(resp.responseText);
        for (var i=0; i < (parsedJSON.courses).length ; i++) {
            var contents = parsedJSON.courses[i];
            postsExists = true;
            var postHtml = "<div class=\"classPost waves-effect\" courseId=\""+contents.id+"\">";
            postHtml += "<a class=\"classPostTitle\">"+((contents.title != null) ? contents.title : "")+"</a>";
            postHtml += "</div>";
            $("#classPosts").html(postHtml+$("#classPosts").html());

            $(".classPost").click(function () {
                window.location = "/course/"+$(this).attr("courseId");
            });
        }
    }).catch(function (resp) {
        alert("Something went wrong!");
    }).send();

    $(document).ready(function() {
        $("#addClass").hide();




        $("#submitNewClass").click(function () {
            Cajax.post("/course/new", {
                name: $("#addClassName").val()
            }).then(function (resp) {
                parsedJSON = JSON.parse(resp.responseText);
                if (parsedJSON.done) {
                    window.location = parsedJSON.redirect;
                }
            }).catch(function () {
                alert("ERROR")
            }).send();
        });

    });

</script>
<?php tmpl("dash/footer"); ?>
