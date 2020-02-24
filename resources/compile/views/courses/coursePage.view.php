@template(("dash/header", ["title"=>"Course"]))!

    <div id="courseToolbar" class="contents">

        <div id="screen_home" class="waves-effect courseToolbarSelected courseToolbarSection">
            <i class="material-icons-outlined">home</i>
            Course
        </div>

        <div id="screen_people" class="waves-effect courseToolbarSection">
            <i class="material-icons-outlined">person</i>
            People
        </div>

        <div id="screen_settings" class="waves-effect courseToolbarSection">
            <i class="material-icons-outlined">settings</i>
            Options
        </div>

    </div>

<!-- <h2 id="className"></h2> -->



    <div class="contents" id="classPosts">

    </div>

    <script>

        function loadPosts() {
            var postsExists = false;
            $("#classPosts").html("");
            Cajax.post("/course/{{$pageid}}").then(function (resp) {
                parsedJSON = JSON.parse(resp.responseText);

                $("#className").text(parsedJSON.title);
                for (var i = 0; i < (parsedJSON.posts).length; i++) {
                    var contents = parsedJSON.posts[i].contents;
                    if (parsedJSON.posts[i].type == "POST" || parsedJSON.posts[i].type == "WORKSHEAT") {
                        postsExists = true;
                        var postHtml = "<div class=\"classPost waves-effect\" style='max-height: 400px;' postId=\"" + parsedJSON.posts[i].id + "\">";
                        postHtml += "<a class=\"classPostTitle\">" + ((contents.title != null) ? contents.title : "") + "</a>";
                        postHtml += "<a class=\"classPostPost\">" + ((contents.title != null) ? contents.text : "") + "</a>";
                        postHtml += "</div>";
                        $("#classPosts").html(postHtml + $("#classPosts").html());
                    } else if (parsedJSON.posts[i].type == "IMAGE_WORKSHEAT") {
                        console.log("a");
                        var postHtml = "<div class=\"classPost waves-effect\" style='max-height: 400px;' postId=\"" + parsedJSON.posts[i].id + "\">";
                        postHtml += "<a class=\"classPostTitle\">" + ((contents.title != null) ? contents.title : "") + "</a>";
                        postHtml += "<img style='max-height: 80%' src=\"" + ((contents.image != null) ? contents.image : "") + "\" width='100%' />";
                        postHtml += "</div>";
                        $("#classPosts").html(postHtml + $("#classPosts").html());
                    }
                }
                @if(($isMine))#
                    $("#classPosts").html("<br>"+ '<a href="/course/{{$pageid}}/new" class="flatButton2 waves-effect waves-light"><i class="material-icons">add</i><span>Add post</span></a><br><br>' + $("#classPosts").html());
                @endif
                $("#classPosts").html("<h1>"+parsedJSON.title+"</h1>"+$("#classPosts").html());
                $(".classPost").click(function () {
                    window.location = "/course/{{$pageid}}/post/" + $(this).attr("postId");
                });
            }).catch(function () {
                alert("Something went wrong!");
            }).send();
        }
        
        function loadPeople() {
            $("#classPosts").html("<br>"+ '<a id="opennewuserdiv" class="flatButton2 waves-effect waves-light"><i class="material-icons">add</i><span>Add new user</span></a><br><br>' +
            '<div id="newuserdiv"><input type="text" class="flatInput" id="userautocomplete">'+
            '<div id="userautocompletion"></div><script src="/assets/js/userautocompletion.js"><\/script>'+
            "<br><br><a id='addnewuser' style='display:inline-block' class='flatButton1 waves-effect waves-light'>Add</a><br><br>"+
            "</div>"+
            "<h3>Teacher</h3>"+
            "<br><div id='people_teacher'></div><br>"+
            "<h3>Students</h3>"+
            "<br><div id='people_people'></div>");
            $("#newuserdiv").hide();
            $("#opennewuserdiv").click(function() {
                $("#newuserdiv").show();
            });
            $("#addnewuser").click(function(){
                Cajax.post("/course/{{$pageid}}/people/add", {
                    user: $("#userautocomplete").val()
                }).then(function(resp){
                    parsedJSON = JSON.parse(resp.responseText);
                    if (parsedJSON.done) {
                        loadPeople();
                    }
                }).send();
            });
            Cajax.post("/course/{{$pageid}}/people").then(function (resp) {
                parsedJSON = JSON.parse(resp.responseText);
                $("#className").text(parsedJSON.title);
                for (var i = 0; i < (parsedJSON.user).length; i++) {
                    var user = parsedJSON.user[i];
                    var outHtml  = "<div class='course_peoplelistentry'>"
                        + "<img src='"+user.profileimage+"' />"
                        + "<a>"+user.username+"</a>"
                        + "</div>";

                    $( (user.type=="TEACHER") ? "#people_teacher" : "#people_people" ).html(outHtml + $( (user.type=="TEACHER") ? "#people_teacher" : "#people_people" ).html());
                }
            }).catch(function() {

            }).send();
        }

        function changeScreenToHome() {
            window.location.hash = "home";
            $(".courseToolbarSelected").removeClass("courseToolbarSelected");
            $("#screen_home").addClass("courseToolbarSelected");
            loadPosts();
        }

        function changeScreenToPeople() {
            window.location.hash = "people";
            $(".courseToolbarSelected").removeClass("courseToolbarSelected");
            $("#screen_people").addClass("courseToolbarSelected");
            loadPeople();
        }

        function changeScreenToSettings() {
            window.location.hash = "settings";
            $(".courseToolbarSelected").removeClass("courseToolbarSelected");
            $("#screen_settings").addClass("courseToolbarSelected");
        }

        if (window.location.hash == "#people") {
            changeScreenToPeople();
        } else if (window.location.hash == "#settings") {
            changeScreenToSettings();
        } else {
            changeScreenToHome();
        }

        $("#screen_home").click(()=>{
            changeScreenToHome();
        });

        $("#screen_people").click(()=>{
            changeScreenToPeople();
        });

        $("#screen_settings").click(()=>{
            changeScreenToSettings();
        });


    </script>
@template(("dash/footer"))!