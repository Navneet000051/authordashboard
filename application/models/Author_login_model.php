<?php
class Author_login_model extends CI_Model{


  public function login_data($email,$pass){

 //   $this->db->where('user_email', $email);
    $this->db->where('LOWER(user_email)', strtolower($email)); 
    $this->db->where('user_password', $pass);
    $query = $this->db->get('tblleads')->row();
    return $query;

  }

  public function changePassword($id,$newpws,$oldpws){
     
      $this->db->where('user_password',$oldpws);
      $qu= $this->db->get('tblleads')->row();
      if($qu){ 
        $data['user_password']=$newpws;
        $this->db->where('id',$id);
        $this->db->update('tblleads',$data);
        
        //$this->session->set_flashdata('message','<strong style=color:green>Your password has been changed.</strong>');
        $this->session->set_flashdata('success_msg','Your password has been changed.');

       redirect('AuthorDashboard/change_password');
      }else{
        $this->session->set_flashdata('error_msg','Your old password is incorrect');
       // $this->session->set_flashdata('Oldpassword',"<strong style='color:red'>Your old password is incorrect</strong>" );
        redirect('AuthorDashboard/updatePass');

      }
  }

  public function book_list(){

    $userId =  $this->session->userdata('author_login')['user_id'];
    $lead_new =  $this->session->userdata('author_login')['lead_new']; 
    if(empty($lead_new)){
        $this->db->select('tblleads_create_package.book_title,tblleads_create_package.leadid as lead_id,tblleads.lead_new,tblleads_create_package.id as id');
    $this->db->from('tblleads');
    $this->db->join('tblleads_create_package','tblleads_create_package.leadid=tblleads.id');
    $this->db->where('tblleads.id',$userId);
    $this->db->where('tblleads_create_package.asf_send_date!=','0000-00-00');
   
    $query2 = $this->db->get()->result();
    //echo $this->db->last_query();
    $this->db->select('tblleads.lead_booktitle as book_title,tblleads.id as lead_id,tblleads.lead_new,tblleads.id');
    $this->db->from('tblleads');
    $this->db->where('tblleads.id',$userId);
    //$this->db->where('tblleads.asf_send_date!=','0000-00-00');

    $query1 = $this->db->get()->result();
    //echo $this->db->last_query();
    $this->db->select('create_package_leads.booktitle as book_title,create_package_leads.create_lead_id as lead_id, chorus_asf.asf_new as lead_new,create_package_leads.id as id');
    $this->db->from('tblleads');
    $this->db->join('create_package_leads','create_package_leads.create_lead_id=tblleads.id');
    $this->db->join('chorus_asf','chorus_asf.lead_id=create_package_leads.id');
    $this->db->where('create_package_leads.asf_send_date!=','0000-00-00');
    $this->db->where('create_package_leads.asf_pdf_data IS NOT NULL', null, false);
    $this->db->where('tblleads.id',$userId);
    $this->db->where('chorus_asf.asf_new','1');
    $query3 = $this->db->get()->result();
    // echo $this->db->last_query();
    //die;
    $alldata = array_merge($query1,$query2);
    return array_merge($alldata,$query3);

   


    
    }else{
        $this->db->select('create_package_leads.booktitle as book_title,create_package_leads.create_lead_id as lead_id,tblleads.lead_new,create_package_leads.id as id');
        $this->db->from('create_package_leads');
        $this->db->join('tblleads','create_package_leads.create_lead_id=tblleads.id');
        $this->db->join('chorus_asf','chorus_asf.lead_id=create_package_leads.id');
       // $this->db->where('create_package_leads.asf_send_date!=','0000-00-00');
        $this->db->where('create_package_leads.create_lead_id',$userId);
        $this->db->where('create_package_leads.asf_pdf_data IS NOT NULL', null, false);
        return   $this->db->get()->result();
       
    }
}

  public function send_email(){

    $config = Array(
        'protocol'  => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => '465',
        'smtp_user' => 'shivangiyadav@bfcpublications.com',
        'smtp_pass' => 'BFC@123',
        'mailtype'  => 'html',
        'starttls'  => true,
        'newline'   => "\r\n"
    );

    $this->load->library('email', $config);

    $this->email->from('adityabfcsofttech@gmail.com', 'invoice');
    $this->email->to('adityabfcsofttech@gmail.com');
    $this->email->subject('Invoice');
    $this->email->message('Test');

    $this->email->send();
    echo $this->email->print_debugger();die;
  }

  public function saleReport(){
    
  }

}