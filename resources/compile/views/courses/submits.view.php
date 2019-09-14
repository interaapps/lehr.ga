@template(("dash/header", ["title"=>"Hello"]))!
<h1>Submits</h1>

<div class="contents" id="classPosts"></div>

<script>
    var parsedJSON;
    if ("{{$type}}" == "WORKSHEAT") {
        Cajax.post("/course/{{$courseid}}/post/{{$pageid}}/submits").then(function (resp) {
            parsedJSON = JSON.parse(resp.responseText);
            if (parsedJSON.done) {
                var out = "";
                for (var i=0; i < (parsedJSON.data).length ; i++) {
                    var th = "";
                    var td = "";
                    for (var a in parsedJSON.data[i].contents) {
                        th += "<th style='font-weihgt: normal'>"+a+"</th>";
                        td += "<td>"+parsedJSON.data[i].contents[a]+"</td>";
                    }

                    out += "<div class='classPost'>";
                    out += "<h3>"+parsedJSON.data[i].user+"</h3>";
                    out += "<table>";
                    out += "<tr>";
                    out += th;
                    out += "</tr>";
                    out += "<tr style='padding-left: 30px;'>";
                    out += td;
                    out += "</tr>";
                    out += "</table>";
                    out += "</div>";
                }
                $("#classPosts").append(out);
            }
        }).catch(function () {
            $("#postName").text("Something went wrong!");
        }).send();
    } else if ("{{$type}}" == "IMAGE_WORKSHEAT") {
        Cajax.post("/course/{{$courseid}}/post/{{$pageid}}/submits:image").then(function (resp) {
            parsedJSON = JSON.parse(resp.responseText);
            if (parsedJSON.done) {
                var out = '<img style="display: none" id="imagepreview" /> <div class="grid">';
                for (var obj in parsedJSON.data) {
                    out += '<div class="classPost waves-effect" postid="'+obj+'">';
                    out += '    <a class="classPostTitle">'+parsedJSON.data[obj].user+'</a>';
                    out += '    <img style="margin-top: 12px;max-width: 155px" src="'+parsedJSON.data[obj].image+'" />';
                    out += '</div>';
                }
                out += "</div>";
                $("#classPosts").append(out);
            }
            $(".classPost").click(function() {
                console.log("asdf2");
                $("#imagepreview").css({
                    display: "block",
                    maxWidth: "100%",
                    marginBottom: "100px"
                });
                $("#imagepreview").attr("src", parsedJSON.data[$(this).attr("postid")].image);
                // parsedJSON.data
            });
        }).catch(function(resp) {

        }).send();
    }
</script>

<style>
.grid {
  display: grid;
  grid-gap: 10px;
  grid-template-columns: repeat(auto-fill, 186px);
}

.grid div {
    height: 200px;
}
</style>
@template(("dash/footer"))!