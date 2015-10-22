<div class="content">

    <div class="col-md-12">
        <div class="row">
        <div class="col-md-9">
        <h2><?php  date_default_timezone_set('America/Chicago'); $Hour = date('G');
        if ( $Hour >= 5 && $Hour <= 11 ) {
            echo "Good Morning!";
        } else if ( $Hour >= 12 && $Hour <= 18 ) {
            echo "Good Afternoon!";
        } else if ( $Hour >= 19 || $Hour <= 4 ) {
            echo "Good Evening! ";
        } echo $user; ?> </h2>
        </div>

        <div class="col-md-3 pull-right">
            <a href="<?php echo base_url()?>post" type="button" class="btn btn-primary" aria-label="Right Align">
                Want to sell?<br>Post it!
            </a>
        </div>
        </div>

        <br>

        <ul class="nav nav-pills nav-justified">
            <li class="active">
                <a href="#1b" data-toggle="tab">Profile</a>
            </li>
            <li><a href="#2b" data-toggle="tab">Order History</a>
            </li>
            <li><a href="#3b" data-toggle="tab">Your Posts</a>
            </li>
            <li><a href="#4b" data-toggle="tab">Message</a>
            </li>
        </ul>


        <div class="tab-content clearfix">
            <div class="tab-pane active" id="1b">
                <hr>
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-3">
                        <div class="text-center">
                            <img src="//placehold.it/100" class="avatar img-circle" alt="avatar">
                            <h6>Upload a different photo...</h6>

                            <input type="file" class="form-control">
                        </div>
                    </div>

                    <!-- edit form column -->
                    <div class="col-md-9 personal-info">

                        <h2>Personal info</h2>

                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">First name:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" value="Jane">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Last name:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" value="Bishop">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Gender:</label>
                                <div class="col-lg-8">
                                    <div class="ui-select">
                                        <select id="gender" class="form-control">
                                            <option value="Female">Women</option>
                                            <option value="Male">Man</option>


                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Email:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" value="janesemail@gmail.com">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Username:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" value="janeuser">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Password:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="password" value="11111122333">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Confirm password:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="password" value="11111122333">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-8">
                                    <input type="button" class="btn btn-primary" value="Save Changes">
                                    <span></span>
                                    <input type="reset" class="btn btn-primary" value="Cancel">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="tab-pane" id="2b">
                <hr>

                <?php $index=0 ; foreach ($orderlist as $rows) { if($index % 3==0 ){ ?>
                <div class="row">
                    <?php } ?>

                    <div class="col-md-4 portfolio-item">
                        <a href="<?php echo base_url().'detail?id='.$rows->id?>">
                            <img class="img_list img-responsive" src=<?php if($rows->img) { echo $rows->img; } else { echo "http://placehold.it/700x400"; }?> alt="">
                        </a>
                        <h3>
                    <a href="<?php echo base_url().'detail?id='.$rows->id?>"><?php echo $rows->name?></a>
                </h3>
                    </div>
                    <?php if($index % 3==2 ){ ?>
                </div>
                <?php } $index++; } if($index % 3 !=0 ) { ?>
            </div>
            <?php }?>


            <!-- Pagination -->
            <div class="row text-center">
                <div class="col-lg-12">
                    <ul class="pagination">
                        <li>
                            <a href="#">&laquo;</a>
                        </li>
                        <li class="active">
                            <a href="#">1</a>
                        </li>
                        <li>
                            <a href="#">2</a>
                        </li>
                        <li>
                            <a href="#">3</a>
                        </li>
                        <li>
                            <a href="#">4</a>
                        </li>
                        <li>
                            <a href="#">5</a>
                        </li>
                        <li>
                            <a href="#">&raquo;</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.row -->

        </div>


        <div class="tab-pane" id="3b">
            <hr>


        <?php
        $index = 0;
        foreach ($postlist as $rows) {
            if($index % 3 == 0){ ?>
        <div class="row">
            <?php } ?>

            <div class="col-md-4 portfolio-item">
                <div style="width:280px; height:180px;">
                <a href="<?php echo base_url().'detail?id='.$rows->id?>">
                    <img class="img_list img-responsive" src=<?php if($rows->img) { echo $rows->img; } else { echo "http://placehold.it/700x400"; }?> alt="">
                </a>
            </div>
                <h3>
                    <a href="<?php echo base_url().'detail?id='.$rows->id?>"><?php echo $rows->name?></a>
                </h3>
            </div>
            <?php if($index % 3 == 2){ ?>
        </div>
        <?php } $index++; } if($index % 3 != 0) { ?>
        </div>
        <?php }?>

            
            <!-- Pagination -->
            <div class="row text-center">
                <div class="col-lg-12">
                    <ul class="pagination">
                        <li>
                            <a href="#">&laquo;</a>
                        </li>
                        <li class="active">
                            <a href="#">1</a>
                        </li>
                        <li>
                            <a href="#">2</a>
                        </li>
                        <li>
                            <a href="#">3</a>
                        </li>
                        <li>
                            <a href="#">4</a>
                        </li>
                        <li>
                            <a href="#">5</a>
                        </li>
                        <li>
                            <a href="#">&raquo;</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.row -->
        </div>





        <div class="tab-pane" id="4b">
            <hr>

            <p>This is for message part.</p>



            <div class="col-md-12 panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Message History</div>

                <!-- Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sent/Received</th>
                            <th>From</th>
                            <th>Preview</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Sent</th>

                            <td>Otto</td>
                            <td>i like this dress....</td>
                        </tr>
                        <tr>
                            <th scope="row">Received</th>

                            <td>Thornton</td>
                            <td>Could you lower the price ...</td>
                        </tr>
                        <tr>
                            <th scope="row">Received</th>

                            <td>the Bird</td>
                            <td>muhiahiahiahiahia....</td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>

    </div>
</div>


</div>
<!--<div class="content">-->