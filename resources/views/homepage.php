<?php tmpl("dash/header", ["title"=>"Hello"]); ?>

<div class="contents">
    <h1 style="text-align: center; font-size: 20px">Welcome back, <?php echo (USER["username"]); ?></h1>
</div>
<?php tmpl("dash/footer"); ?>