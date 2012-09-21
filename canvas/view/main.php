<!DOCTYPE html>
<html>
    <head>
        <title>Hello world</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="css/styles.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div class="container canvas">
            <div class="row" >
                <div class="span12" >
                    <div class="media-grid" >
                        <h5 class="tab">Welcome <small><?php echo he(idx($basic, 'name')); ?></small></h5>
                        <a href="#">
                            <img src="https://graph.facebook.com/<?php echo he($user_id); ?>/picture?type=normal" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="row" >
                <div class="span12" >
                    <h5 class="tab">Teams</h5>
                    <?php echo $res_table->render() ?>
                </div>
            </div>
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
