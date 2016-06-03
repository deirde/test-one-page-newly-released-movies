<?php

require_once 'Results.class.php';
$Results = new \Deirde\NewlyReleasedMovies\Results();

?>

<html>
    <head>
        <title>
            <?php echo $Results->pageTitle(); ?>
        </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/assets/main.css">
    </head>
    <body>
        <div class="row">
            <div class="container">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="/">
                                <?php echo $Results->pageTitle(); ?>
                            </a>
                        </div>
                    </div>
                </nav>
                <div class="col-md-12">
                    <ul id="items-wrapper">
                        <?php foreach ($Results->getAllNewlyReleasedItems() as $item) { ?>
                            <li class="item">
                                <div class="item-left item-middle">
                                    <img class="item-cover" src="<?php echo $item->imageURL; ?>"
                                        alt="<?php echo $item->title; ?>" />
                                </div>
                                <div class="item-body">
                                    <h2 class="item-heading">
                                        <?php echo $item->title; ?>
                                    </h2>
                                    <?php foreach ($item->price as $key => $value) { ?>
                                        <h4>
                                            <?php echo $key . ': ' . $value; ?>
                                        </h4>
                                    <?php } ?>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
