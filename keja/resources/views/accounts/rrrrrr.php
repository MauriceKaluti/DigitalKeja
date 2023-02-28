 <div class="panel panel-col-amber">
                                            <div class="panel-heading" role="tab" id="headingTwo_18">
                                                <h4 class="panel-title">
                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_18" href="#collapseTwo_18" aria-expanded="false"
                                                       aria-controls="collapseTwo_18">
                                                        <i class="material-icons">cloud_download</i> ENGLISH
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseTwo_18" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_18">
                                                <div class="panel-body">
                                                              <?php 

                                    require('includes/config.php');
                                    // $query = "SELECT * FROM subjects WHERE `subject_name`=`CRE` AND DATE(invo_date) = CURDATE()";
                                    $engo = 'English';
                                    $queryCR = "SELECT * FROM assignments WHERE `subject_name`='$engo' AND DATE(assDate) < CURDATE()";
                                    $resultCRs = mysqli_query($con, $queryCR) or die ( mysqli_error());

                                       if($query->rowCount() > 0)
                                        {

                                        foreach($resultCRs as $resultCR)
                                        { ?>  
                                        <a class="btn btn-primary btn-block bg-primary waves-effect" href='assignments/<?php echo $resultCR['file']; ?>' download>Quick Download <?php echo $resultCR['title']; ?> <i class="fa fa-download"></i> </a>
                                        <a href="assignment.php?id=<?php echo $resultCR['id']; ?>" class="btn btn-block bg-pink waves-effect">Submit Assignment <i class="fa fa-external-link"></i></a>

                                            <?php  }}

                                            
                                            ?>
                                                </div>
                                            </div>
                                        </div>