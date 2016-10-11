<!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
        <?php
            require 'vendor/autoload.php';
            $Essence = new Essence\Essence();
            $Media = $Essence->extract('https://www.youtube.com/watch?v=FRlI2SQ0Ueg');

                if ($Media) {
                    // That's all, you're good to go !
                }
        ?>
        <article>
            <header>
                <h1><?php echo $Media->title; ?></h1>
                <p>By <?php echo $Media->authorName; ?></p>
            </header>
</article>

    </body>
</html>