<?php tmpl("dash/header", ["title"=>"Course"]); ?>

    <div class="contents">
        <input type="text" class="flatInput" id="userautocomplete">
    </div>


    <script>


        
        function loadPeople() {
            /*
            Cajax.post("/course/<?php echo ($pageid); ?>/people").then(function (resp) {

            }).catch(function() {

            }).send();
            */
        }

    </script>
<?php tmpl("dash/footer"); ?>