<div class="container">
    <div class="row">
        <div class="col-xs-12 col-xs-offset-2">
            <p class="lead">This is the game to feed the farmer and pets. Please read the description of how to play this.</p>
        </div>
        <div class="col-xs-12 col-xs-offset-2">
            <ul>
                <li>There’s a button to start a new game.</li>
                <li>There's a single button to feed the farmer and the animals.</li>
                <li>Every time you click on that button, the system randomly chooses whom to feed. Every click on this button is a turn.</li>
                <li>If farmer is not getting the food atleast once in 15 round, he died and game is over.</li>
                <li>The maximum number of turns is 50 and after game is over.</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-primary">
                <!-- Default panel contents -->
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="<?php echo BASEURL.'/feed'; ?>">
                        <?php
                        $btn_action = "Start";
                        if(isset($_SESSION['game_id'])){
                            $btn_action = 'Resume';
                        } ?>
                        <p class="h4 text-center">Click to <strong><?php echo $btn_action;?> Game</strong> button to <?php echo strtolower($btn_action);?> the game</p>
                        <!-- start game button -->
                        <div class="row">
                            <div class="col-xs-offset-2 col-md-8 col-xs-offset-2">
                                <button class="btn btn-info btn-block" type="submit" name="start">
                                    <?php echo $btn_action;?> Game
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
