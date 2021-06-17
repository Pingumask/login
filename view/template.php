<!DOCTYPE html>
    <html lang="en">
    <head>
        <?php include("../view/components/head.php"); ?>
    </head>
    <body>
        <?php include("../view/components/header.php"); ?><!--
        --><?php include("../view/components/menu.php"); ?><!--
        --><main class="<?=$page?>"><!--
            --><?php include("../view/pages/$page"); ?><!--
        --></main><!--
        --><?php include("../view/components/footer.php"); ?>
    </body>
</html>