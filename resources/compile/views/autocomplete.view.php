<?php tmpl("dash/header", ["title"=>"New post"]); ?>
<h1>Test</h1>

@view(("tools/filepicker"))!
<script>
    filePicker.whenSelected = function(file) {
        alert(file);
    };
</script>



<?php tmpl("dash/footer"); ?>