@template(("dash/header", ["title"=>"Hello"]))!
<h2 id="postName">My Account</h2>
<div class="contents" id="post">
    <br><br>
    <a style="color: #AAAAAA; font-size: 13px">USERNAME</a><br>
    <a id="username"></a><br><br>

    <a style="color: #AAAAAA; font-size: 13px">TYPE</a><br>
    <a id="type"></a><br><br>


    <a style="color: #AAAAAA; font-size: 13px">SETTINGS</a><br>
    <br><a id="darkmodebutton" class="flatButton2 waves-effect waves-light"><i class="material-icons">brightness_5</i><span>Darkmode</span></a><br><br>

</div>
<script>
    var postsExists = false;
    Cajax.post("/auth/myaccount").then(function (resp) {
        parsedJSON = JSON.parse(resp.responseText);
        if (parsedJSON.done) {
            $("#username").text(parsedJSON.name !== null ? parsedJSON.name : "");
            $("#type").append(parsedJSON.type !== null ? parsedJSON.type : "");
        } else $("#postName").text(parsedJSON.errorMessage);
    }).catch(function () {
        $("#postName").text("Something went wrong!");
    }).send();

    $(document).ready(function() {
        $("#darkmodebutton").click(function(){
            changeDarkMode();
        });
    });
</script>
@template(("dash/footer"))!