<?php
include_once 'lib/lib.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Hello world</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div class="container canvas">
            <div class="row">
                <div class="span6" >
                    <?php echo data_writer::write_top_ten() ?>
                </div>
                <div class="span6" >
                    <?php echo data_writer::write_results_table() ?>
                </div>
            </div>
            
            
        </div>
    </body>
</html>
