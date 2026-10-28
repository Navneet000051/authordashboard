<?php
error_reporting(0);
//use FontLib\Table\Type\post;

//require('PHPMailer/phpmailer/PHPMailerAutoload.php');
class AuthorDashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Author_login_model');
        $this->load->library('session');
        //$this->load->library('phpmailer_lib');
        $this->load->library('email');
    }

    public function view_details()
    {
        $this->loginSession();
        $userid = $this->session->userdata('author_login')['user_id'];
        $this->db->select('*');
        $this->db->from('kdp_sale_report');
        $this->db->where('leads_id',$userid);
        // $this->db->where('BookTitle',$bb->book_title);
        $data['sales'] = $this->db->get()->result();   
        // echo "<pre>";
        // print_r($sales);
        // exit;
        $this->load->view('authordashboard/view-detail',$data);
    }
    // *****************************First Page************
    public function login()
    {
        $this->load->view('authordashboard/login_page');
    }
    // *****************************LogOut  Function************
    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->sess_destroy();
       redirect('AuthorDashboard/login');
    }

    // *****************************LogIn Function************

    public function author_login()
    {

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[10]');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_message('required', 'Please enter %s');
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('authordashboard/login_page');
        } else {
            $email = $this->input->post('email');
            $pass = $this->input->post('password');
            $login = $this->Author_login_model->login_data($email, $pass);
            if ($login) {
                $data = array(
                    'userName' => $login->lead_author_name,
                    'user_id' => $login->id,
                    'email' => $login->user_email,
                    'mobileNo' => $login->phonenumber,
                    'lead_new' => $login->lead_new
                ); 

                $this->session->set_userdata('author_login', $data);
                $dd['total_profit']= $this->profit();
                $this->load->view('authordashboard/dashboard',$dd);
            } else {

                $this->session->set_flashdata('error_msg','Invalid account credentials.!');
             
                redirect('AuthorDashboard/author_login');
            }
        }
    }
    // *****************************Author Dashboard************
    public function index()
    {   
        $this->loginSession();
        
        $data['total_profit']= $this->profit();
        // exit;
        $this->load->view('authordashboard/dashboard',$data);
    }

    public function profit(){
        $userid = $this->session->userdata('author_login')['user_id'];
        
        $this->db->select('*');
        $this->db->from('mrpfixation');
        $this->db->where('leads_id',$userid);
        $book = $this->db->get()->result();  

       /* echo "<pre>";
        print_r($book);*/

        foreach($book as $bb){
            $this->db->select('*');
            $this->db->from('kdp_sale_report');
            $this->db->where('leads_id',$userid);
            $this->db->where('BookTitle',$bb->book_title);
            $sales = $this->db->get()->result();   

            // echo $this->db->last_query()."<br>";
            $sold= 1; $return=1; $flipkart=0;  $amazoncount=0; $gpay=0; $kdp=0; $bfc=0;
            foreach($sales as $saleData){

                if($saleData->Marketplace=="Flipkart" && $saleData->UnitsSold>=1){
                    $flipkart = $flipkart+$saleData->UnitsSold;
                }else if($saleData->Marketplace=="Flipkart" && $saleData->UnitsSold<0){
                    $flipkart = $flipkart+$saleData->UnitsSold;
                }

                if($saleData->Marketplace=="GooglePlay" && $saleData->UnitsSold>=1){
                    $gpay= $gpay+$saleData->UnitsSold;
                }else if($saleData->Marketplace=="GooglePlay" && $saleData->UnitsSold<=-1){
                     $gpay= $gpay+$saleData->UnitsSold;
                }

                if($saleData->Marketplace=="KDP" && $saleData->UnitsSold>=1){
                    $kdp= $kdp+$saleData->UnitsSold;
                }else if($saleData->Marketplace=="KDP" && $saleData->UnitsSold<=-1){
                     $kdp= $kdp+$saleData->UnitsSold;
                }

                if($saleData->Marketplace=="Amazon" && $saleData->UnitsSold>=1){
                    $amazoncount= $amazoncount+$saleData->UnitsSold;
                }else if($saleData->Marketplace=="Amazon" && $saleData->UnitsSold<=-1){
                    $amazoncount= $amazoncount+$saleData->UnitsSold;
                }

                if($saleData->Marketplace=="bfc" && $saleData->UnitsSold>=1){
                    $bfc= $bfc+$saleData->UnitsSold;
                }else if($saleData->Marketplace=="bfc" && $saleData->UnitsSold<=-1){
                    $bfc= $bfc+$saleData->UnitsSold;
                }

            } 

            $totalSold += $sold-$return;
            $totalSold = $flipkart+$gpay+$kdp+$amazoncount+$bfc;
            $profit1 =  ($kdp+$gpay)*$bb->kdp;
            $profit2 =  ($amazoncount+$flipkart)*$bb->amazon;
            $profit3 =  $bfc*$bb->bfc;
            $total_profit += $profit1+$profit2+$profit3;

            $total_amazoncount += $amazoncount;
            $total_flipkart += $flipkart;
            $total_gpay += $gpay;
            $total_kdp += $kdp;
            $total_bfc += $bfc;
             // echo $total_profit."<br>";
        }

        $data['totalSold'] = $totalSold;
        $data['total_profit'] = $total_profit;
        $data['flipkart'] = $total_flipkart;
        $data['gpay'] = $total_gpay;
        $data['kdp'] = $total_kdp;
        $data['amazoncount'] = $total_amazoncount;
        $data['bfc'] = $total_bfc;
        $data['other'] = 0;
        // echo  $this->session->userdata('author_login')['email'];
        // echo "<pre>";
        // print_r($data);
        // exit;
        return $data;
    }

    public function payable()
    {
        $this->loginSession();
        // $data['total_profit']= $this->profit();
        $userid = $this->session->userdata('author_login')['user_id'];

        $time = strtotime(date("Y-m-d"));
        $final = date("Y-m", strtotime("-1 month", $time));

        $this->db->select('*');
        $this->db->from('mrpfixation');
        $this->db->where('leads_id',$userid);
        $book = $this->db->get()->result(); 

        foreach($book as $bb){
            $this->db->select('*');
            $this->db->from('kdp_sale_report');
            $this->db->where('leads_id',$userid);
            $this->db->where('BookTitle',$bb->book_title);
            $this->db->where('OrderDateDt<=',$final."-01");
            $sales = $this->db->get()->result();  

            $sold= 1; $return=1; $flipkart=0;  $amazoncount=0; $gpay=0; $kdp=0; $bfc=0;
            foreach($sales as $saleData){

                if($saleData->UnitsSold==1){
                    $sold++;
                }else{
                    $return++;
                }

                if($saleData->Marketplace=="Flipkart" && $saleData->UnitsSold==1){
                    $flipkart++;
                }else if($saleData->Marketplace=="Flipkart" && $saleData->UnitsSold==-1){
                    $flipkart--;
                }

                if($saleData->Marketplace=="GooglePlay" && $saleData->UnitsSold==1){
                    $gpay++;
                }else if($saleData->Marketplace=="GooglePlay" && $saleData->UnitsSold==-1){
                    $gpay--;
                }

                if($saleData->Marketplace=="KDP" && $saleData->UnitsSold==1){
                    $kdp++;
                }else if($saleData->Marketplace=="KDP" && $saleData->UnitsSold==-1){
                    $kdp--;
                }

                if($saleData->Marketplace=="Amazon" && $saleData->UnitsSold==1){
                    $amazoncount++;
                }else if($saleData->Marketplace=="Amazon" && $saleData->UnitsSold==-1){
                    $amazoncount--;
                }

                if($saleData->Marketplace=="bfc" && $saleData->UnitsSold==1){
                    $bfc++;
                }else if($saleData->Marketplace=="bfc" && $saleData->UnitsSold==-1){
                    $bfc--;
                }
            } 

            $totalSold += $sold-$return;
            $profit1 =  ($kdp+$gpay)*$bb->kdp;
            $profit2 =  ($amazoncount+$flipkart)*$bb->amazon;
            $profit3 =  $bfc*$bb->bfc;
            $total_profit += $profit1+$profit2+$profit3;
        }

        $data['pre_profit'] = $total_profit;

        foreach($book as $bb){
            $this->db->select('*');
            $this->db->from('kdp_sale_report');
            $this->db->where('leads_id',$userid);
            $this->db->where('BookTitle',$bb->book_title);
            $this->db->where('OrderDateDt BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-d').'"');

            // $this->db->where('OrderDateDt BETWEEN "2023-09-01" and "2023-09-30" ');
            $sales = $this->db->get()->result();
            // echo $this->db->last_query()."<br>";

            $sold= 1; $return=1; $flipkart=0;  $amazoncount=0; $gpay=0; $kdp=0; $bfc=0;
            foreach($sales as $saleData){

                if($saleData->UnitsSold==1){
                    $sold++;
                }else{
                    $return++;
                }

                if($saleData->Marketplace=="Flipkart" && $saleData->UnitsSold==1){
                    $flipkart++;
                }else if($saleData->Marketplace=="Flipkart" && $saleData->UnitsSold==-1){
                    $flipkart--;
                }

                if($saleData->Marketplace=="GooglePlay" && $saleData->UnitsSold==1){
                    $gpay++;
                }else if($saleData->Marketplace=="GooglePlay" && $saleData->UnitsSold==-1){
                    $gpay--;
                }

                if($saleData->Marketplace=="KDP" && $saleData->UnitsSold==1){
                    $kdp++;
                }else if($saleData->Marketplace=="KDP" && $saleData->UnitsSold==-1){
                    $kdp--;
                }

                if($saleData->Marketplace=="Amazon" && $saleData->UnitsSold==1){
                    $amazoncount++;
                }else if($saleData->Marketplace=="Amazon" && $saleData->UnitsSold==-1){
                    $amazoncount--;
                }

                if($saleData->Marketplace=="bfc" && $saleData->UnitsSold==1){
                    $bfc++;
                }else if($saleData->Marketplace=="bfc" && $saleData->UnitsSold==-1){
                    $bfc--;
                }
            } 

            $totalSold += $sold-$return;
            $profit1 =  ($kdp+$gpay)*$bb->kdp;
            $profit2 =  ($amazoncount+$flipkart)*$bb->amazon;
            $profit3 =  $bfc*$bb->bfc;
            $current_profit += $profit1+$profit2+$profit3;
        }

        $data['current_profit'] = $current_profit;
        $this->load->view('authordashboard/payable',$data);
    }


    public function getprofitDeatils(){
        $userid = $this->session->userdata('author_login')['user_id'];
        $calendar = $this->input->post('calendar');

        $time = strtotime($calendar);
        $final = date("Y-m", strtotime("-1 month", $time));

        $this->db->select('*');
        $this->db->from('mrpfixation');
        $this->db->where('leads_id',$userid);
        $book = $this->db->get()->result();

        $start = $calendar."-01";
        $end = $calendar."-31";

        foreach($book as $bb){
            $this->db->select('*');
            $this->db->from('kdp_sale_report');
            $this->db->where('leads_id',$userid);
            $this->db->where('BookTitle',$bb->book_title);
            $this->db->where('OrderDateDt<=',$final."-31");
            $sales = $this->db->get()->result();  

            $sold= 1; $return=1; $flipkart=0;  $amazoncount=0; $gpay=0; $kdp=0; $bfc=0;
            foreach($sales as $saleData){

                if($saleData->UnitsSold==1){
                    $sold++;
                }else{
                    $return++;
                }

                if($saleData->Marketplace=="Flipkart" && $saleData->UnitsSold==1){
                    $flipkart++;
                }else if($saleData->Marketplace=="Flipkart" && $saleData->UnitsSold==-1){
                    $flipkart--;
                }

                if($saleData->Marketplace=="GooglePlay" && $saleData->UnitsSold==1){
                    $gpay++;
                }else if($saleData->Marketplace=="GooglePlay" && $saleData->UnitsSold==-1){
                    $gpay--;
                }

                if($saleData->Marketplace=="KDP" && $saleData->UnitsSold==1){
                    $kdp++;
                }else if($saleData->Marketplace=="KDP" && $saleData->UnitsSold==-1){
                    $kdp--;
                }

                if($saleData->Marketplace=="Amazon" && $saleData->UnitsSold==1){
                    $amazoncount++;
                }else if($saleData->Marketplace=="Amazon" && $saleData->UnitsSold==-1){
                    $amazoncount--;
                }

                if($saleData->Marketplace=="bfc" && $saleData->UnitsSold==1){
                    $bfc++;
                }else if($saleData->Marketplace=="bfc" && $saleData->UnitsSold==-1){
                    $bfc--;
                }
            } 

            $totalSold += $sold-$return;
            $profit1 =  ($kdp+$gpay)*$bb->kdp;
            $profit2 =  ($amazoncount+$flipkart)*$bb->amazon;
            $profit3 =  $bfc*$bb->bfc;
            $total_profit += $profit1+$profit2+$profit3;
        }

        $data['pre_profit'] = $total_profit;


        foreach($book as $bb){
            $this->db->select('*');
            $this->db->from('kdp_sale_report');
            $this->db->where('leads_id',$userid);
            $this->db->where('BookTitle',$bb->book_title);
            $this->db->where('OrderDateDt BETWEEN "'.$start.'" and "'.$end.'"');
            $sales = $this->db->get()->result();
            // echo $this->db->last_query()."<br>";

            $sold= 1; $return=1; $flipkart=0;  $amazoncount=0; $gpay=0; $kdp=0; $bfc=0;
            foreach($sales as $saleData){

                if($saleData->UnitsSold==1){
                    $sold++;
                }else{
                    $return++;
                }

                if($saleData->Marketplace=="Flipkart" && $saleData->UnitsSold==1){
                    $flipkart++;
                }else if($saleData->Marketplace=="Flipkart" && $saleData->UnitsSold==-1){
                    $flipkart--;
                }

                if($saleData->Marketplace=="GooglePlay" && $saleData->UnitsSold==1){
                    $gpay++;
                }else if($saleData->Marketplace=="GooglePlay" && $saleData->UnitsSold==-1){
                    $gpay--;
                }

                if($saleData->Marketplace=="KDP" && $saleData->UnitsSold==1){
                    $kdp++;
                }else if($saleData->Marketplace=="KDP" && $saleData->UnitsSold==-1){
                    $kdp--;
                }

                if($saleData->Marketplace=="Amazon" && $saleData->UnitsSold==1){
                    $amazoncount++;
                }else if($saleData->Marketplace=="Amazon" && $saleData->UnitsSold==-1){
                    $amazoncount--;
                }

                if($saleData->Marketplace=="bfc" && $saleData->UnitsSold==1){
                    $bfc++;
                }else if($saleData->Marketplace=="bfc" && $saleData->UnitsSold==-1){
                    $bfc--;
                }
            } 

            $totalSold += $sold-$return;
            $profit1 =  ($kdp+$gpay)*$bb->kdp;
            $profit2 =  ($amazoncount+$flipkart)*$bb->amazon;
            $profit3 =  $bfc*$bb->bfc;
            $current_profit += $profit1+$profit2+$profit3;
        }

        $data['current_profit'] = $current_profit;
        $data['date'] =  date("d/m/Y", strtotime($start));
        // echo $final =;
        echo json_encode($data);
    }


    public function loginSession()
    {
        $msg = $this->session->userdata('author_login');
        if ($msg == '') {
          redirect('AuthorDashboard/login');
        }
    }

    public function salesReport()
    {   
        
        $this->loginSession();
        $lead_id = $this->session->userdata('author_login')['user_id'];
        // echo $lead_id;
        // exit;
        $this->db->select('*');
        $this->db->from('kdp_sale_report');
        $this->db->where('leads_id',$lead_id);
        $this->db->group_by('BookTitle'); 
        $data['book_details'] = $this->db->get()->result();    
        $this->load->view('authordashboard/sales-report',$data);
    }


    public function getbookDetailsFilter(){

        $book_title = $this->input->post('booktitle');
        $lead_id = $this->input->post('lead_id');
        $start = $this->input->post('start');
        $end = $this->input->post('end');

        $this->db->select('*');
        $this->db->from('mrpfixation');
        $this->db->where('book_title',$book_title);
        $book = $this->db->get()->row();   

        $this->db->select('*');
        $this->db->from('kdp_sale_report');
        $this->db->where('leads_id',$lead_id);
        $this->db->where('BookTitle',$book_title);
        if( $start!=''){
            $this->db->where('OrderDateDt BETWEEN "'. date('Y-m-d', strtotime($start)). '" and "'. date('Y-m-d', strtotime($end)).'"');
        }
        
        $sales = $this->db->get()->result();  

        // echo $this->db->last_query();
        // exit;
        $flipkart=0;  $amazoncount=0; $gpay=0; $kdp=0; $bfc=0;
        foreach($sales as $saleData){

            if($saleData->Marketplace=="Flipkart" && $saleData->UnitsSold>=1){
                $flipkart = $flipkart+$saleData->UnitsSold;
            }else if($saleData->Marketplace=="Flipkart" && $saleData->UnitsSold<0){
                $flipkart = $flipkart+$saleData->UnitsSold;
            }

            if($saleData->Marketplace=="GooglePlay" && $saleData->UnitsSold>=1){
                $gpay= $gpay+$saleData->UnitsSold;
            }else if($saleData->Marketplace=="GooglePlay" && $saleData->UnitsSold<=-1){
                 $gpay= $gpay+$saleData->UnitsSold;
            }

            if($saleData->Marketplace=="KDP" && $saleData->UnitsSold>=1){
                $kdp= $kdp+$saleData->UnitsSold;
            }else if($saleData->Marketplace=="KDP" && $saleData->UnitsSold<=-1){
                 $kdp= $kdp+$saleData->UnitsSold;
            }

            if($saleData->Marketplace=="Amazon" && $saleData->UnitsSold>=1){
                $amazoncount= $amazoncount+$saleData->UnitsSold;
            }else if($saleData->Marketplace=="Amazon" && $saleData->UnitsSold<=-1){
                $amazoncount= $amazoncount+$saleData->UnitsSold;
            }

            if($saleData->Marketplace=="bfc" && $saleData->UnitsSold>=1){
                $bfc= $bfc+$saleData->UnitsSold;
            }else if($saleData->Marketplace=="bfc" && $saleData->UnitsSold<=-1){
                $bfc= $bfc+$saleData->UnitsSold;
            }

        } 


        $profit1 =  ($kdp+$gpay)*$book->kdp;
        $profit2 =  ($amazoncount+$flipkart)*$book->amazon;
        $profit3 =  $bfc*$book->bfc;

        $total_profit = $profit1+$profit2+$profit3;

        if($flipkart<0){
            $flipkart=0;
        }

        if($kdp<0){
            $kdp=0;
        }

        if($gpay<0){
            $gpay=0;
        }

        if($amazoncount<0){
            $amazoncount=0;
        }

        if($bfc<0){
            $bfc=0;
        }

        $totalSold = $flipkart+$gpay+$kdp+$amazoncount+$bfc;
        $data['totalSold'] = $totalSold;
        $data['total_profit'] = $total_profit;
        $data['flipkart'] = $flipkart;
        $data['gpay'] = $gpay;
        $data['kdp'] = $kdp;
        $data['amazoncount'] = $amazoncount;
        $data['bfc'] = $bfc;
        $data['other'] = 0;
        // print_r($data); 
        echo json_encode($data);
    }

    public function getbookDetails(){
       // echo "helo";
        $book_title = $this->input->post('booktitle');
        $lead_id = $this->input->post('lead_id');

        $this->db->select('*');
        $this->db->from('mrpfixation');
        $this->db->where('book_title',$book_title);
        $book = $this->db->get()->row();    

        $this->db->select('*');
        $this->db->from('kdp_sale_report');
        $this->db->where('leads_id',$lead_id);
        $this->db->where('BookTitle',$book_title);
        $sales = $this->db->get()->result();   
        // echo $this->db->last_query();
    
        $flipkart=0;  $amazoncount=0; $gpay=0; $kdp=0; $bfc=0;
        foreach($sales as $saleData){

            if($saleData->Marketplace=="Flipkart" && $saleData->UnitsSold>=1){
                $flipkart = $flipkart+$saleData->UnitsSold;
            }else if($saleData->Marketplace=="Flipkart" && $saleData->UnitsSold<0){
                $flipkart = $flipkart+$saleData->UnitsSold;
            }

            if($saleData->Marketplace=="GooglePlay" && $saleData->UnitsSold>=1){
                $gpay= $gpay+$saleData->UnitsSold;
            }else if($saleData->Marketplace=="GooglePlay" && $saleData->UnitsSold<=-1){
                 $gpay= $gpay+$saleData->UnitsSold;
            }

            if($saleData->Marketplace=="KDP" && $saleData->UnitsSold>=1){
                $kdp= $kdp+$saleData->UnitsSold;
            }else if($saleData->Marketplace=="KDP" && $saleData->UnitsSold<=-1){
                 $kdp= $kdp+$saleData->UnitsSold;
            }

            if($saleData->Marketplace=="Amazon" && $saleData->UnitsSold>=1){
                $amazoncount= $amazoncount+$saleData->UnitsSold;
            }else if($saleData->Marketplace=="Amazon" && $saleData->UnitsSold<=-1){
                $amazoncount= $amazoncount+$saleData->UnitsSold;
            }

            if($saleData->Marketplace=="bfc" && $saleData->UnitsSold>=1){
                $bfc= $bfc+$saleData->UnitsSold;
            }else if($saleData->Marketplace=="bfc" && $saleData->UnitsSold<=-1){
                $bfc= $bfc+$saleData->UnitsSold;
            }

        } 

        
        $profit1 =  ($kdp+$gpay)*$book->kdp;
        $profit2 =  ($amazoncount+$flipkart)*$book->amazon;
        $profit3 =  $bfc*$book->bfc;

        $total_profit = $profit1+$profit2+$profit3;

        if($flipkart<0){
            $flipkart=0;
        }

        if($kdp<0){
            $kdp=0;
        }

        if($gpay<0){
            $gpay=0;
        }

        if($amazoncount<0){
            $amazoncount=0;
        }

        if($bfc<0){
            $bfc=0;
        }

        $totalSold = $flipkart+$gpay+$kdp+$amazoncount+$bfc;
        $data['totalSold'] = $totalSold;
        $data['total_profit'] = $total_profit;
        $data['flipkart'] = $flipkart;
        $data['gpay'] = $gpay;
        $data['kdp'] = $kdp;
        $data['amazoncount'] = $amazoncount;
        $data['bfc'] = $bfc;
        $data['other'] = 0;
        // print_r($data); 
        echo json_encode($data);
    }


    public function myrecord()
    {
        $this->loginSession();
        $this->load->view('authordashboard/my-record');
    }

    public function book_publish()
    {
        $this->loginSession();
        $data['userid'] = $this->session->userdata('author_login')['user_id'];

       /* $this->db->where('status',1);
        $data['book_genre'] =  $this->db->get('tbl_book_genre')->result();*/
        $this->db->where('status',1);
        $data['book_language'] =  $this->db->get('tbl_language')->result();
        // echo $this->db->last_query();
        // exit;
        $this->load->view('authordashboard/book-publish',$data);
    }

    public function refer_friend()
    {
        $this->loginSession();
        $data['userid'] = $this->session->userdata('author_login')['user_id'];
        $this->load->view('authordashboard/refer-your-friends',$data);
    }

    public function bank_details()
    {
        $this->loginSession();
        $this->load->view('authordashboard/bank-details');
    }

    public function myprofiles($id='',$lead_id='',$lead_new='')
    {   
        
        $data['id']=$id;
        $data['lead_id']=$lead_id;
        $this->loginSession();
        $userId =  $this->session->userdata('author_login')['user_id'];
        $lead_new =  $this->session->userdata('author_login')['lead_new'];
        if(!empty($lead_new)){
           $this->db->select('create_package_leads.booktitle as book_title,create_package_leads.create_lead_id as lead_id,tblleads.lead_new,create_package_leads.id as id');
            $this->db->from('create_package_leads');
            $this->db->join('tblleads','create_package_leads.create_lead_id=tblleads.id');
            $this->db->join('chorus_asf','chorus_asf.lead_id=create_package_leads.id');
            // $this->db->where('create_package_leads.asf_send_date!=','0000-00-00');
            $this->db->where('create_package_leads.create_lead_id',$userId);
            $this->db->where('create_package_leads.asf_pdf_data IS NOT NULL', null, false);
            $data['book_details'] =   $this->db->get()->result();
            $this->db->where('id',$data['book_details'][0]->id);
            $data['package_details'] =   $this->db->get_where('create_package_leads')->row();
            $this->db->where('asf_new','1');
            $this->db->where('lead_id',$data['book_details'][0]->id);
            $data['asf_details'] =   $this->db->get_where('chorus_asf')->row();
        }
        else{
            $this->db->select('tblleads_create_package.book_title,tblleads_create_package.leadid as lead_id,tblleads.lead_new,tblleads_create_package.id as id');
            $this->db->from('tblleads');
            $this->db->join('tblleads_create_package','tblleads_create_package.leadid=tblleads.id');
            $this->db->where('tblleads.id',$userId);
            $this->db->where('tblleads_create_package.asf_send_date!=','0000-00-00');
       
        $query2 = $this->db->get()->result();

        $this->db->select('tblleads.lead_booktitle as book_title,tblleads.id as lead_id,tblleads.lead_new,tblleads.id');
        $this->db->from('tblleads');
        $this->db->where('tblleads.id',$userId);
        $this->db->where('tblleads.asf_send_date!=','0000-00-00');

        $query1 = $this->db->get()->result();

        $this->db->select('create_package_leads.booktitle as book_title,create_package_leads.create_lead_id as lead_id, chorus_asf.asf_new as lead_new,create_package_leads.id as id');
        $this->db->from('tblleads');
        $this->db->join('create_package_leads','create_package_leads.create_lead_id=tblleads.id');
        $this->db->join('chorus_asf','chorus_asf.lead_id=create_package_leads.id');
        $this->db->where('create_package_leads.asf_send_date!=','0000-00-00');
        $this->db->where('create_package_leads.asf_pdf_data IS NOT NULL', null, false);
        $this->db->where('tblleads.id',$userId);
        $this->db->where('chorus_asf.asf_new','1');
        $query3 = $this->db->get()->result();

        $alldata = array_merge($query1,$query2);
        $data['book_details'] = array_merge($alldata,$query3);
        //    echo "<pre>";
        //     print_r($data['book_details']); die;
        if(!empty($id) && !empty($lead_id)){
          
            if($id==$lead_id && empty($lead_new)){
                $this->db->where('id',$data['book_details'][0]->id);
                $data['package_details'] =   $this->db->get_where('tblleads')->row();
            }
            else{
                //echo 'sd'; die;
                if(!empty($lead_new)){
                    $this->db->where('id',$id);
                    $data['package_details'] =   $this->db->get_where('create_package_leads')->row();
                    $this->db->where('lead_id',$id);
                    $this->db->where('asf_new',1);
                    $data['asf_details'] =   $this->db->get_where('chorus_asf')->row();
                }
                else{
                    $this->db->where('id',$id);
                    $data['package_details'] =   $this->db->get_where('tblleads_create_package')->row();
                    $this->db->where('asf_new IS NULL', null, true);
                    $this->db->where('lead_id',$id);
                    $data['asf_details'] =   $this->db->get_where('chorus_asf')->row();
                }
                
            }
      
        }
        else{
            $this->db->where('id',$data['book_details'][0]->id);
            $data['package_details'] =   $this->db->get_where('tblleads')->row();
            $this->db->where('asf_new IS NULL', null, false);
            $this->db->where('lead_id',$data['book_details'][0]->id);
            $data['asf_details'] =   $this->db->get_where('chorus_asf')->row();
        }
        }
        
      
        $this->load->view('authordashboard/my-profile',$data);   
    }
    public function myprofile($id='',$lead_id='',$leadnew=''){

        $data['id']=$id;
        $data['lead_id']=$lead_id;
        $userId =  $this->session->userdata('author_login')['user_id'];
        $lead_new =  $this->session->userdata('author_login')['lead_new']; 
        // print_r($_SESSION); die;
        // echo $lead_new; die;
        if(empty($lead_new)){
            $data['book_details']=$this->Author_login_model->book_list($id='',$lead_id='',$leadnew='');
            ///print_r($data['book_details']); die;
       

       
        if(!empty($id) && !empty($lead_id)){
         
            if($id==$lead_id && empty($lead_new)){
                //echo 'sd'; die;
                $this->db->where('id',$lead_id);
                $data['package_details'] =   $this->db->get_where('tblleads')->row();
                $this->db->where('asf_new IS NULL', null, true);
                $this->db->where('lead_id',$id);
                $data['asf_details'] =   $this->db->get_where('chorus_asf')->row();
            }
            else{
              //  echo $lead_new; die;
                if($leadnew=='1'){
                    $this->db->where('id',$id);
                    $data['package_details'] =   $this->db->get_where('create_package_leads')->row();
                    $this->db->where('lead_id',$id);
                    $this->db->where('asf_new',1);
                    $data['asf_details'] =   $this->db->get_where('chorus_asf')->row();
                   // echo $this->db->last_query();
                }
                else{
                    $this->db->where('id',$id);
                    $data['package_details'] =   $this->db->get_where('tblleads_create_package')->row();
                    $this->db->where('asf_new IS NULL', null, true);
                    $this->db->where('lead_id',$id);
                    $data['asf_details'] =   $this->db->get_where('chorus_asf')->row();
                   // echo $this->db->last_query();
                }
                
            }
      
        }
        else{
           // echo 'sd'; die;
            $this->db->where('id',$data['book_details'][0]->id);
            $data['package_details'] =   $this->db->get_where('tblleads')->row();
            $this->db->where('asf_new IS NULL', null, false);
            $this->db->where('lead_id',$data['book_details'][0]->id);
            $data['asf_details'] =   $this->db->get_where('chorus_asf')->row();
          //  print_r($data['book_details']); die;
           // echo 'sd0'; die;
        }
        
        }else{
 
            $data['book_details']=$this->Author_login_model->book_list();
            $this->db->where('id',$data['book_details'][0]->id);
            $data['package_details'] =   $this->db->get_where('create_package_leads')->row();
            $this->db->where('asf_new','1');
            $this->db->where('lead_id',$data['book_details'][0]->id);
            $data['asf_details'] =   $this->db->get_where('chorus_asf')->row();
        }
    //    echo "<pre>";
    //     print_r($data); die;
        $this->load->view('authordashboard/my-profile',$data); 
    }

    public function change_password()
    {
        $this->loginSession();
        $this->load->view('authordashboard/change-password');
    }


    // *******************************Change Password******************

    public function updatePass()
    {

        $this->form_validation->set_rules('oldPassword', 'Password', 'required');
        $this->form_validation->set_rules('newPassword', 'Password', 'required|max_length[10]');
        $this->form_validation->set_rules('confirm_pass', 'Confirm password', 'required|matches[newPassword]|max_length[10]');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_message('required', 'Enter %s');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('authordashboard/change-password');
        } else {

            $id = $this->input->post('userid');
            $oldpws =  $this->input->post('oldPassword');
            $newpws =  $this->input->post('newPassword');
            $details=    $this->Author_login_model->changePassword( $oldpws);
            if($details){
                //print_r($details);die;
               $data['user_password']= $newpws;
               $this->Author_login_model->check_password($id,$data);
               $this->session->set_flashdata('message','<div class="alert alert-primary" role="alert" style=color:green>Your password has been changed.</div>');
               redirect('AuthorDashboard/change_password',$details);
            }
            else{
               $this->session->set_flashdata('Oldpassword',"<strong style='color:red'>Your old password is incorrect</strong>" );
            $this->load->view('authordashboard/change-password',$details);
            }
    }

    }
    public function refer_friend_info()
    {

        $this->form_validation->set_rules('user_name', 'name', 'required');
        $this->form_validation->set_rules('user_email', 'email', 'required|valid_email|trim');
        $this->form_validation->set_rules('user_mobile', 'mobile number', 'required|max_length[10]|min_length[10]|trim');


        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_message('required', 'Please enter %s');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('authordashboard/refer-your-friends'); 
        } else {
            $data['author_id'] =  $this->input->post('id');
            $data['name'] = trim($this->input->post('user_name'));
            $data['email'] = trim($this->input->post('user_email'));
            $data['phone_no'] = trim($this->input->post('user_mobile'));
            // $this->Author_login_model->insert_data('tbl_refer_friend',$data);
            $this->db->insert('tbl_refer_friend',$data);
            // echo $this->db->last_query();
            // exit;
            $this->session->set_flashdata('success_msg','Refer a friend inserted successfully!');
            redirect('AuthorDashboard/refer_friend');
        }
    }


    public function bookPublish(){

        $this->form_validation->set_rules('book_title', 'book title', 'required|trim');
        $this->form_validation->set_rules('status_of_manuscript', 'status of manuscript', 'required|trim');
        $this->form_validation->set_rules('book_genre', 'genre of book', 'required|trim');
        $this->form_validation->set_rules('book_language', 'book language', 'required|trim');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_message('required', 'Please enter %s');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('authordashboard/book-publish');
        } else {
           $data['authorId']  =    $this->input->post('id');
           $data['book_title'] =  $this->input->post('book_title');
           $data['status_of_manuscript'] =   $this->input->post('status_of_manuscript');
           $data['genre_of_book'] = $this->input->post('book_genre');
           $data['book_language'] =  $this->input->post('book_language');
           $this->db->insert('tbl_book_publish',$data);
           $this->session->set_flashdata('success_msg','Book Publish inserted successfully!');
           redirect('AuthorDashboard/book_publish');
        }

    }

    // *****************Forget Password**********************
    public function forget_password()
    {
        $this->load->view('authordashboard/forget-password');

    }

    public function recover_password(){
        $this->load->view('authordashboard/forget_password');
    }

    public function send_email(){
 
        $id = $this->input->post('id');
        $forget_mail = $this->input->post('emailid');
        // echo $forget_mail ;die;
         $mail= $this->Author_login_model->forget_pws($forget_mail);
        if($mail){
            
            redirect('AuthorDashboard/recover_password');
        }else{
           $val = '<div class="alert alert-danger" role="alert" style=color:red >Please enter correct email.</div>';
           $this->session->set_flashdata('msg',$val);
           redirect('AuthorDashboard/forget_password');
        }    
}   
    public function smtp_mailer(){
    $mail = new PHPMailer();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = '587';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'adityabfcsofttech@gmail.com'; // Add Gmail ID Here
    $mail->Password = 'oawztcsnlmvzhzvr'; // Add Gmail Password Here
    $mail->setFrom('adityabfcsofttech@gmail.com','This is testing'); // Here add your Email ID & Subject
 //   $mail->addAddress('ks623039@gmail.com');  // Here add User Email ID
    //$mail->addReplyTo('elevenstech@gmail.com'); // Here add your Email ID. Where user can send email
    $mail->isHTML(true);
    $mail->Subject = 'This is only testing'; // This is subject of Email   
    $msg = "Forget Password:<a href='recover_password'>Click here</a>";
    $mail->Body = "$msg";
    if(!$mail->send())
    {
        echo "Message could not be sent!";
    }
    else{
        echo "Message could be sent!";
    }
}


}


    

