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
                    <?php echo $top_ten->render() ?>
                </div>
                <div class="span6" >
                    <?php echo $results_table->render() ?>
                </div>
            </div>
            
        </div>
    </body>
</html>
