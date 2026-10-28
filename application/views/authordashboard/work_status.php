
<?php include 'layout/header.php' ?>


<style>
    .value_area_system {
        border-left: 1px solid rgb(34 10 139);
        ;
    }

    .value_area_system>h2::before {
        content: " - ";
    }

    .value_area_system h2 {
        font-size: 20px;
        font-weight: 400;
        color: rgb(34 10 139);
        margin-bottom: 10px;
    }

    .ASF {
        width: 90px;
        height: 46px;
    }

    .agreement {
        width: 160px;
        height: 46px;
    }

    .typing {
        width: 120px;
        height: 46px;
    }

    .manuscript {
        width: 170px;
        height: 46px;
    }

    .cover-design {
        width: 180px;
        height: 46px;
    }

    .formate-editing {
        width: 215px;
        height: 46px;
    }

    .Proofreading {
        width: 190px;
        height: 46px;
    }

    svg {
        background: rgb(241 76 76);
        height: 25px;
        width: 25px;
        border-radius: 50%;
        padding: 5px;
        color: #ffffff;
    }

    svg.bi-check2-circle {
        background: #0f9d58;
        height: 25px;
        width: 25px;
        border-radius: 50%;
        padding: 5px;
        color: #ffffff;
    }
    svg.bi-arrow-repeat {
        background: #7978E9;
        height: 25px;
        width: 25px;
        border-radius: 50%;
        padding: 5px;
        color: #ffffff;
    }

    .spectacledcoder-card3:hover .value_area_system>h2 {
        color: #ffffff;
    }

    .grid-mrg-map {
            margin-bottom: 1.5rem;
        }

        .sales-report-map {
            position: relative;
            border-radius: 12px;
            height: 100%;
        }

        .sales-report-map .sales-report-body-map {
            padding: 20px 26px 20px 16px;
            background: #90caf982;
            border-radius: 12px;
            height: 100%;
        }

        .sales-report-map .card-img-absolute-map {
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
        }

        .sales-report-body-map h3 {
            font-size: 20px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            padding-top: 5px;
            color: #d43d3f;
            text-transform: uppercase;
        }
</style>

<>
  <section class="content-wrapper mt-5 pt-5">
    <div class="container py-5">
    <?php if($this->session->userdata('author_login')['lead_new']=='1'){?>
          <div class="d-flex">
           <div class="toolti pe-2"><img src="<?php echo base_url() ?>authordashboard/assets/img/demo-book.png" class="img-fluid md-40"></a>
            </div>
            <div class="profilebook w-50">
            <select class="form-select" id="book_id" onchange="work_status();">
            <!-- <option value="">Select</option> -->
            <?php if(!empty($book_details)){
               foreach($book_details as $value){
                if(!empty($value->book_title)){
              ?>
            <option <?php if(!empty($bookid==$value->id)) echo 'selected';?> value="<?php echo $value->id;?>" data-new="<?php echo $value->lead_new;?>" data-id="<?php echo $value->lead_id;?>" ><?php echo $value->book_title;?></option>
            <?php }}}?>
          </select>
        </div> 
          </div>
          <?php }?>
      </br>
        <div class="row">
            <div class="col-12 col-md-4 col-lg-3 stretch-card grid-mrg-map">
                <div class="sales-report-map card-img-holder text-dark">
                    <div class="sales-report-body-map">
                        <img src="https://authordashboard.bfcpublications.com/authordashboard/assets/img/circle.svg"
                            class="card-img-absolute-map">
                        <span class="float-right">
                        </span>
                        <h3 class="mb-3">ASF</h3>
                        <div class="value_area_system">
                          <?php if(empty($package_details->asf_pdf_data)){?>
                            <h2>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                                    </svg>
                                </span>

                                <span>
                                    Pending
                                </span>
                            </h2>
                            <?php } else{?>
                            <h2>
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-check2-circle" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                        <path
                                            d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                    </svg></span>

                                <span>Filled</span>
                            </h2>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-3 stretch-card grid-mrg-map">
                <div class="sales-report-map card-img-holder text-dark">
                    <div class="sales-report-body-map">
                        <img src="https://authordashboard.bfcpublications.com/authordashboard/assets/img/circle.svg"
                            class="card-img-absolute-map">
                        <span class="float-right">
                        </span>
                        <h3 class="mb-3">Agreement</h3>
                        <div class="value_area_system">
                        <?php if(empty($package_details->final_mail_agreement_upload)){?>
                            <h2>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                                    </svg>
                                </span>

                                <span>
                                    Pending
                                </span>
                            </h2>
                            <?php } else{?>
                            <h2>
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-check2-circle" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                        <path
                                            d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                    </svg></span>

                                <span>Signed</span>
                            </h2>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(!empty($package_details->number_of_pages_2)){?>
            
            <div class="col-12 col-md-4 col-lg-3 stretch-card grid-mrg-map">
                <div class="sales-report-map card-img-holder text-dark">
                    <div class="sales-report-body-map">
                        <img src="https://authordashboard.bfcpublications.com/authordashboard/assets/img/circle.svg"
                            class="card-img-absolute-map">
                        <span class="float-right">
                        </span>
                        <h3 class="mb-3">Typing</h3>
                        <div class="value_area_system">
                        <?php if(!empty($package_details->number_of_pages_2)){?>
                            <div class="col-12 col-md-4 col-lg-3 stretch-card grid-mrg-map">
                <div class="sales-report-map card-img-holder text-dark">
                    <div class="sales-report-body-map">
                        <img src="https://authordashboard.bfcpublications.com/authordashboard/assets/img/circle.svg"
                            class="card-img-absolute-map">
                        <span class="float-right">
                        </span>
                        <h3 class="mb-3">Format Editing</h3>
                        <div class="value_area_system">
                        <?php if(empty($package_details->typist)){?>
                            <h2>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                                    </svg>
                                </span>

                                <span>
                                    Pending
                                </span>
                            </h2>
                            <?php }
                             elseif(!empty($package_details->typist_status=='1' || $package_details->typist_status=='2')){?>
                            
                            <h2>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                        <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"/>
                                        <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"/>
                                      </svg>
                                </span>

                                <span>
                                    In Process
                                </span>
                            </h2>
                            <?php }
                            elseif(!empty($package_details->typist_status=='3')){?>
                            <h2>
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-check2-circle" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                        <path
                                            d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                    </svg></span>

                                <span>Approved</span>
                            </h2>
                            <?php }?>
             
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
            
            <div class="col-12 col-md-4 col-lg-3 stretch-card grid-mrg-map">
                <div class="sales-report-map card-img-holder text-dark">
                    <div class="sales-report-body-map">
                        <img src="https://authordashboard.bfcpublications.com/authordashboard/assets/img/circle.svg"
                            class="card-img-absolute-map">
                        <span class="float-right">
                        </span>
                        <h3 class="mb-3">Manuscript</h3>
                        <div class="value_area_system">
                        <?php if(empty($package_details->ms_upload)){?>
                            <h2>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                                    </svg>
                                </span>

                                <span>
                                    Pending
                                </span>
                            </h2>
                         
                            <!-- <h2>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                        <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"/>
                                        <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"/>
                                      </svg>
                                </span>

                                <span>
                                    In Process
                                </span>
                            </h2> -->
                            <?php } else{?>
                            <h2>
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-check2-circle" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                        <path
                                            d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                    </svg></span>

                                <span>Approved</span>
                            </h2>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-3 stretch-card grid-mrg-map">
    <div class="sales-report-map card-img-holder text-dark">
        <div class="sales-report-body-map">
            <img src="https://authordashboard.bfcpublications.com/authordashboard/assets/img/circle.svg"
                class="card-img-absolute-map">
            <span class="float-right"></span>

            <h3 class="mb-3">Cover Design</h3>

            <div class="value_area_system">

            <?php 
            // 1️⃣ Pending
            if (empty($package_details->assign_gd)) { ?>

                <h2>
                    <span>
                        <!-- Hourglass Icon -->
                        ⏳
                    </span>
                    <span>Pending</span>
                </h2>

            <?php 
            // 2️⃣ Approved (Check first for status 3)
            } elseif (
                $package_details->gd_cover_status == '3' ||
                $package_details->additional_gd_status == '3'
            ) { ?>

                <h2>
                    <span>
                        <!-- Check Icon -->
                        ✔
                    </span>
                    <span>Approved</span>
                </h2>

            <?php 
            // 3️⃣ In Process (Status 1 or 2)
            } elseif (
                in_array($package_details->gd_cover_status, ['1','2']) ||
                in_array($package_details->additional_gd_status, ['1','2'])
            ) { ?>

                <h2>
                    <span>
                        <!-- Process Icon -->
                        🔄
                    </span>
                    <span>In Process</span>
                </h2>

            <?php } ?>

            </div>
        </div>
    </div>
</div>
            <?php if(!empty($formatediting)){?>
            <div class="col-12 col-md-4 col-lg-3 stretch-card grid-mrg-map">
                <div class="sales-report-map card-img-holder text-dark">
                    <div class="sales-report-body-map">
                        <img src="https://authordashboard.bfcpublications.com/authordashboard/assets/img/circle.svg"
                            class="card-img-absolute-map">
                        <span class="float-right">
                        </span>
                        <h3 class="mb-3">Format Editing</h3>
                        <div class="value_area_system">
                        <?php if(empty($package_details->assign_fe)){?>
                            <h2>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                                    </svg>
                                </span>

                                <span>
                                    Pending
                                </span>
                            </h2>
                            <?php }
                             elseif(!empty($package_details->fe_status=='1' || $package_details->fe_status=='2')){?>
                            
                            <h2>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                        <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"/>
                                        <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"/>
                                      </svg>
                                </span>

                                <span>
                                    In Process
                                </span>
                            </h2>
                            <?php }
                            elseif(!empty($package_details->fe_status=='3')){?>
                            <h2>
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-check2-circle" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                        <path
                                            d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                    </svg></span>

                                <span>Approved</span>
                            </h2>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
            <?php if(!empty($proofreading)){?>
            <div class="col-12 col-md-4 col-lg-3 stretch-card grid-mrg-map">
                <div class="sales-report-map card-img-holder text-dark">
                    <div class="sales-report-body-map">
                        <img src="https://authordashboard.bfcpublications.com/authordashboard/assets/img/circle.svg"
                            class="card-img-absolute-map">
                        <span class="float-right">
                        </span>
                        <h3 class="mb-3">Proofreading</h3>
                        <div class="value_area_system">
                        <?php if(empty($package_details->assign_pr)){?>
                            <h2>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                                    </svg>
                                </span>

                                <span>
                                    Pending
                                </span>
                            </h2>
                            <?php }
                             elseif(!empty($package_details->pr_status=='1' || $package_details->pr_status=='2')){?>
                            <h2>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                        <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"/>
                                        <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"/>
                                      </svg>
                                </span>

                                <span>
                                    In Process
                                </span>
                            </h2>
                            <?php }
                            elseif(!empty($package_details->pr_status=='3')){?>
                            <h2>
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-check2-circle" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                        <path
                                            d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                    </svg></span>

                                <span>Approved</span>
                            </h2>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>

        </div>
        
    </div>
    </section>
  
<script>
 
  function work_status(){
   var book_id=$("#book_id").val(); 
  // console.log(book_id); 
   if (book_id) {
    window.location.href = "<?php echo base_url();?>AuthorDashboard/work_status/" + book_id;
  } else {
    alert("Book ID is missing.");
  }
  }
</script>

<?php include 'layout/footer.php' ?>
<script>
$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const alreadyRedirected = urlParams.get('redirected');
    const book_id = $("#book_id").val();

    if (book_id && !alreadyRedirected) {
        window.location.href = "<?php echo base_url(); ?>AuthorDashboard/work_status/" + book_id + "?redirected=true";
    }
});

</script>
