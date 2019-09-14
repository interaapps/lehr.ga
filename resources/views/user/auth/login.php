<?php tmpl("dash/header", ["title"=>"Hello", "usingSidenav"=>false]); ?>
    <div class="contents">
        <form>
            <h1>Login</h1>
            <input class="flatInput" type="text" id="username" placeholder="Username">
            <input class="flatInput" type="password" id="password" placeholder="Password">
            <a id="error" style="color: #ee5648"></a>
            <br><a id="submit" class="flatButton1">Submit</a>
        </form>
    </div>

    <script>
        $("#submit").click(function () {
            Cajax.post("/auth/login", {
                username: $("#username").val(),
                password: $("#password").val()
            }).then(function (resp) {
                parsedJSON = JSON.parse(resp.responseText);
                if (parsedJSON.done) {
                    window.location = parsedJSON.redirect;
                } else
                    $("#error").text(parsedJSON.errorMessage);
            }).catch(function () {
                $("#error").text("Something went wrong :(");
            }).send();
        });
    </script>
<?php tmpl("dash/footer"); ?>