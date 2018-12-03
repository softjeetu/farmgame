<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-bricky">
                <!-- Default panel contents -->
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="<?php echo BASEURL.'/feed'; ?>">
                        <?php $play_again_btn = '<button class="btn btn-xs btn-info pull-right" type="submit" name="start">Play Again</button>' ?>
                        <?php if($is_game_over == 1){ ?>
                            <div class="alert alert-danger text-center">
                                OOPS! YOU LOST.
                                <?php echo $play_again_btn; ?>
                            </div>
                        <?php }else if($is_game_over == 2){ ?>
                            <div class="alert alert-success text-center">
                                HOORAY! YOU WON.
                                <?php echo $play_again_btn; ?>
                            </div>
                        <?php }else{ ?>
                            <p class="h4 text-center">Click on <strong>Feed</strong> button to feed the Farmer & Animals.</p>
                            <!-- start game button -->
                            <div class="row">
                                <div class="col-xs-offset-2 col-md-8 col-xs-offset-2">
                                    <button class="btn btn-info btn-block" type="submit" name="feed">
                                        Feed
                                    </button>
                                    <hr>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <?php if(sizeof($farm_objects) > 0):
                                            foreach($farm_objects as $fo):
                                                $th_bg_color = '';
                                                $th_color = '';
                                                if(in_array($fo['id'], $died_records))
                                                {
                                                    $th_bg_color = 'red';
                                                    $th_color = '#fff';
                                                }
                                                ?>
                                                <th scope="col" style="background:<?php echo $th_bg_color;?>; color:<?php echo $th_color; ?>;"><?php echo $fo['head_name'];?></th>
                                            <?php endforeach;
                                        endif; ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if(sizeof($feed_records) > 0):
                                        for($round = 1; $round <= sizeof($feed_records); $round++):?>
                                            <tr>
                                                <th scope="row">Round <?php echo $round;?></th>
                                                <?php if(sizeof($farm_objects) > 0):
                                                    foreach($farm_objects as $fo):?>
                                                        <td>
                                                            <?php
                                                            if(isset($feed_records[$round-1]['farm_object_id']) && $fo['id']==$feed_records[$round-1]['farm_object_id'])
                                                                echo "Fed";
                                                            ?>
                                                        </td>
                                                    <?php endforeach;
                                                endif; ?>
                                            </tr>
                                        <?php endfor;
                                    else:?>
                                        <tr>
                                            <td align="center" colspan="<?php echo 1+sizeof($farm_objects); ?>">
                                                No Feed Found in current game. Click on Feed button for feeding.
                                            </td>
                                        </tr>
                                    <?php endif;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
