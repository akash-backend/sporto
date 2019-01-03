<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends Base_Controller {


 
 

      // For Iphone Notification
    private $sandBox =  0; // 0-Sandbox / 1-Live
    private $pem_Dev ='/home3/ctinf0eg/public_html/CT06/sport/assets/CertificatesApns13July.pem';
    private $pem_Pro ='/home3/ctinf0eg/public_html/CT06/sport/assets/CertificatesApns13July.pem';
    private $passPhrase = '123456';

	public function __construct()
	{
		parent:: __construct();
		$this->checkAuth();		
		$this->load->helper('common');
	}	

	public function getKey()
	{
		$result = $this->common->getFieldKey($_POST['table']);
		echo json_encode($result);
	}

	public function login()
	{				
		$_POST['password'] = md5($_POST['password']);
		
		$result = $this->common->getData('user',array('mobile or email = ' => $_POST['email'], 'password' => $_POST['password']),array('single'));


		if($result){
			if(isset($_POST['android_token'])){
				$old_device = $this->common->getData('user',array('android_token' => $_POST['android_token']),array('single','field'=>'id'));	
			}		
			if (isset($_POST['ios_token'])) {
				$old_device = $this->common->getData('user',array('ios_token' => $_POST['ios_token']),array('single','field'=>'id'));	
			}
			if($old_device){
				$this->common->updateData('user',array('android_token' => "", "ios_token" => ""),array('id' => $old_device['id']));
			}

			$this->common->updateData('user',array('ios_token' =>$_POST['ios_token'], 'android_token' => $_POST['android_token']), array('id' => $result['id']));
			$this->response(true,'Successfully Login',array("userinfo" => $result));					
		}else{
			$message = "Wrong email or password";			
			$this->response(false,$message,array("userinfo" => ""));
		}
	}

	public function signup()
	{	


		if($_POST['email'] == ""){
			$exist = $this->common->getData('user',array('email' => $_POST['mobile']),array('single'));
			$_POST['otp'] = '1234';
		}else{
			$exist = $this->common->getData('user',array('email' => $_POST['email']),array('single'));
			$_POST['otp'] = str_pad(rand(0, pow(10, 4)-1), 4, '0', STR_PAD_LEFT);
		}
		if(!empty($exist)){
			$response = $this->response('false',"This email or mobile number already exists.",array("userinfo" => ""));				
		}else{
			$iname = '';
			if(isset($_FILES['image'])){
				$image = $this->common->do_upload('image','./assets/userfile/profile/');
				if(isset($image['upload_data'])){
					$iname = $image['upload_data']['file_name'];
				}
			}			
			$_POST['image'] = $iname;
			$_POST['password'] = md5($_POST['password']);
			$_POST['created_at'] = date('Y-m-d H:i:s');
						
			$old_device = $old_ios = false;
			if(isset($_POST['android_token'])){
				$old_device = $this->common->getData('user',array('android_token' => $_POST['android_token']),array('single','field'=>'id'));
			}
			if(isset($_POST['ios_token'])){
				$old_ios =  $this->common->getData('user',array('ios_token' => $_POST['ios_token']),array('single','field'=>'id'));
			}
			if($old_device || $old_ios){
				$this->common->updateData('user',array('android_token' => "", "ios_token" => ""),array('id' => $old_device['id']));
			}
			$post = $this->common->getField('user',$_POST); 
			
			$result = $this->common->insertData('user',$post);
			if($result){
				$userid = $this->db->insert_id();					
				$info = $this->common->getData('user',array('id' => $userid),array('single'));
				if($_POST['email'] != ""){
					$template = $this->load->view('template/verify-email',array('email' => $_POST['email'],'otp' => $_POST['otp'],'name' => $_POST['name']),true);
					$this->common->sendMail($_POST['email'],"Verify Email",$template);
				}
				
				$this->response(true,"Your registration successfully completed.",array("userinfo" => $info));					
			}else{
				$this->response(false,"There is a problem, please try again.",array("userinfo" => ""));
			}
		}
	}

	public function mailcheck()
	{
		$template = $this->load->view('template/verify-email',array('email' => 'devendra@mailinator.com','otp' => '1258','name' => 'Devendra'),true);
		$r = $this->common->sendMail('devendra@mailinator.com','verify mail',$template);
		if($r){
			echo "send";
		}else{
			echo "not send";
		}
	}


	public function joinevent($event_id,$user_id)
	{
		
        	$user_id1 =$user_id;
        	$event_count = $this->common->getData('sport_event',array('id' => $event_id),array('single'));

        	$user_event_count = $this->common->getData('user',array('id' => $user_id),array('single'));

        	$join_user_event = $user_event_count['user_event'];			
        	$join_user = $event_count['join_user'];
        	$event_participant_no = $event_count['event_participant_no'];
        	$arr=(explode(",",$join_user));
        	
        	
        	
        	if (in_array($user_id,$arr))
        	{
        		$Join_data = array('status'=>false,'message'=>"particepent already added");
        		return  $Join_data;
        	}
        	
			if(count($arr) >= $event_participant_no)
        	{
   				$Join_data = array('status'=>false,'message'=>"Particepent have not added because does not have any place available");
        		return  $Join_data;
			}
        	

    		if(empty($join_user))
        	{
        		$user_id;
        	}
        	else
        	{
        		$user_id = $join_user.','.$user_id;
        	}

        	if(empty($join_user_event))
        	{
        		$user_event_id = $event_id;
        	}
        	else
        	{
        		$user_event_id = $join_user_event.','.$event_id;
        	}

        	$arr_image=(explode(",",$user_id));
        	if(!empty($arr_image))
        	{
        		foreach($arr_image as $value)
        		{

        			$user_image = $this->common->getData('user',array('id' => $value),array('single'));
        			if(!empty($user_image['image']))
        			{
        				$image_user[]=base_url('/assets/userfile/profile/'.$user_image['image']);
        			 
        			}
        			else
        			{
        				$image_user[]="";
        			}
        		}
        	}
        	


        	$data['join_user']=$user_id;
        	$user_info['user_event']=$user_event_id;
        	
        	$result = $this->common->updateData('sport_event',$data,array('id' => $event_id));
        	$result = $this->common->updateData('user',$user_info,array('id' => $user_id1));

        	
        	if($result){
			$event = $this->common->getData('sport_event',array('id' => $event_id),array('single'));
			$event['image_user']=$image_user;
			$notification_id=$event['user_id'];


			

			
			$Join_data = array('status'=>true,'message'=>"Join Event Successfully.",'eventinfo' => $event);
        		return  $Join_data;
			}else{
			
				$Join_data = array('status'=>false,'message'=>"There is a problem, please try again.",'eventinfo' => "");
        		return  $Join_data;
			}
	}

	public function pending_user()
	{
		if(!empty($_REQUEST['event_id']))
        {
        	$event_id = $_REQUEST['event_id'];
        	$event = $this->common->getData('join_event_tbl',array('event_id' => $event_id),array('single'));

        	$where = "JE.event_id = '".$event_id."'";
        	$user_info = $this->common->get_join_user($where);

        	if($user_info){
				$this->response(true,"Profile fetch Successfully.",array("userinfo" => $user_info));			
			}else{
				$this->response(false,"There is a problem, please try again.",array("userinfo" => ""));
			}		


        }
        else
        {
        	$this->response(false,"Missing Parameter.");
        }
	}



	public function joinevent_user()
	{

		
		if(!empty($_REQUEST['event_id']) && !empty($_REQUEST['user_id']))
        {
        	$event_id=$_REQUEST['event_id'];
			$user_id=$_REQUEST['user_id'];
        	
        	$event_count = $this->common->getData('sport_event',array('id' => $event_id),array('single'));

        	$user_event_count = $this->common->getData('user',array('id' => $user_id),array('single'));

        	$join_user_event = $user_event_count['user_event'];			
        	 $join_user = $event_count['join_user'];
        	 $event_participant_no = $event_count['event_participant_no'];
        	 $event_user_id = $event_count['user_id'];

        	$arr=(explode(",",$join_user));

        	if (in_array($user_id,$arr))
        	{
        		$this->response(false,"particepent already added");
        		exit();
        	}
        	

        	

        	if(count($arr) >= $event_participant_no)
        	{
   				$this->response(false,"Particepent have not added because does not have any place available");
		        exit();
        	}


			$where="user_id	='" .  $event_user_id . "' AND join_id ='" . $user_id . "' AND event_id ='" . $event_id . "' ";
		    $value = $this->common->getData('join_event_tbl',$where,array('single'));
						;
						
		if(empty($value))
		{	
			$insert = $this->common->insertData('join_event_tbl',array('user_id' => $event_user_id,'join_id' => $user_id,'event_id' =>$event_id)); 


			


			// notification start
				$user_data = $this->common->getData('user',array('id'=>$event_user_id),array('single'));
				$ios_token = $user_data['ios_token'];
				$android_token = $user_data['android_token'];
				$today = Date('Y-m-d H:i:s'); 
				


				$insert_notification = $this->common->insertData('notification_tbl',array('user_id' => $event_user_id,'message' => "Wants to Join Your Event",'date'=>$today,'user_send_from'=>$user_id,'type'=>"Join",'event_id'=>$event_id));
								
				$notification = array('user_id' => $event_user_id,'message' => "Wants to Join Your Event",'date'=>$today,'user_send_from'=>$user_id,'type'=>"Join",'event_id'=>$event_id);
				$sendmsg = "Join Event Request";
				
				if($ios_token != ""){
					$isSend = $this->push_iOS($ios_token,$notification,$sendmsg);
				}
				else if($android_token != "")
				{
					$registatoin_id = array($user_data["android_token"]); 
					$this->send_notification($registatoin_id, $sendmsg);

				}

				// notification end
		
							
	
						
			$this->response(true,"join user request send successfully");
							
		}
		else
		{
			$this->response(false,"join user request already added");
		}
        	

        	
        	
        }
        else
        {
        	$this->response(false,"Missing Parameter.");
        }
	}




	 // For IOS notification
      function push_iOS($token, $msg, $alert) {


        if (!empty($this->pem_Pro) && !empty($this->passPhrase)) {
            // Provide the Host Information.

            if (!empty($this->sandBox))
                $tHost = 'gateway.push.apple.com';
            else
                $tHost = 'gateway.sandbox.push.apple.com';

            $tPort = 2195;

            // Provide the Certificate and Key Data.
            
            // $counts = $this->get_record_where("user", array("user_device_token" => $token),"user_id,noti_count");
            // $data1=array("noti_count"=>$counts[0]['noti_count']+1);
            // $where=array("user_device_token" => $token);
            // $up_id = $this->update_records('user', $data1,$where);

            if (!empty($this->sandBox))
                $tCert = $this->pem_Pro;
            else
                $tCert = $this->pem_Dev;

            // Provide the Private Key Passphrase

            $tPassphrase = $this->passPhrase;

            // Provide the Device Identifier (Ensure that the Identifier does not have spaces in it).

            $tToken = $token;

            // The message that is to appear on the dialog.

            $tAlert = $alert;

            // The Badge Number for the Application Icon (integer >=0).
            //            $tBadge = 8;
            // Audible Notification Option.

            $tSound = 'default';

            // The content that is returned by the LiveCode "pushNotificationReceived" message.

            $tPayload = 'Notification sent';

            // Create the message content that is to be sent to the device.

            $tBody['aps'] = array(
                'alert' => $tAlert,
                'msg' => $msg,
              //  'badge' => intval($counts[0]['noti_count']+1),
                'sound' => $tSound,
            );

            $tBody ['payload'] = $tPayload;

            // Encode the body to JSON.

            $tBody = json_encode($tBody);

            // Create the Socket Stream.

            $tContext = stream_context_create();

            stream_context_set_option($tContext, 'ssl', 'local_cert', 'pushcert.pem');

            // Remove this line if you would like to enter the Private Key Passphrase manually.

            stream_context_set_option($tContext, 'ssl', 'passphrase', $tPassphrase);

            // Open the Connection to the APNS Server.

            $tSocket = stream_socket_client('ssl://' . $tHost . ':' . $tPort, $error, $errstr, 30, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $tContext);

            // Check if we were able to open a socket.

            if (!$tSocket)
                exit("APNS Connection Failed: $error $errstr" . PHP_EOL);

            // Build the Binary Notification.

            $tMsg = chr(0) . chr(0) . chr(32) . pack('H*', $tToken) . pack('n', strlen($tBody)) . $tBody;

            // Send the Notification to the Server.

                $tResult = fwrite($tSocket, $tMsg, strlen($tMsg));

        //       if (!$result){
        // echo 'Message not delivered' . PHP_EOL;
        //  }
        
        // else{
        //      echo 'Message successfully delivered' . PHP_EOL;
        //  }

        //  die();


           //  if ($tResult)
           //  echo 'Delivered Message to APNS' . PHP_EOL;
           // else
           // echo 'Could not Deliver Message to APNS' . PHP_EOL;
           // // Close the Connection to the Server.
           // die();

            fclose($tSocket);
        }
    }





	public function notification_list()
	{
		if(!empty($_REQUEST['user_id']))
        {
        	$user_id = $_REQUEST['user_id'];
        
        	$where = "NT.user_id = '".$user_id."'";

        	$user_info = $this->common->get_notification_user($where);
        
        	$this->response(true,"Notification list.",array("notification_info" =>$user_info));
        }
        else
        {
        	$this->response(false,"Missing Parameter.");
        }
	}

	public function searchUser()
	{
		if(!empty($_REQUEST['user_id']) && !empty($_REQUEST['user_name']))
        {
        	$user_id = $_REQUEST['user_id'];
        	$user_name = $_REQUEST['user_name'];
        	$where="id	!='" . $user_id . "' AND name ='" . $user_name . "' AND status = 0";
			$result = $this->common->getData('user',$where);
			if(!empty($result))
			{
				foreach ($result as $key => $value) {
					if(!empty($value['image']))
					{
						$image =  base_url('/assets/userfile/profile/'.$value['image']);
					}
					else
					{
						$image ="";
					}

						$age= date_diff(date_create($value['user_dob']), date_create('today'))->y;
					$arr[]=array('id'=>$value['id'],'name'=>$value['name'],'email'=>$value['email'],'user_dob'=>$value['user_dob'],'user_address'=>$value['user_address'],'image'=>$image,'Age'=>$age);

				}
				$this->response(true,"User Found Successfully.",array("userinfo" => $arr));
			}
			else
			{
				$this->response(false,"User Not Found");
			}		
        }
        else
        {
        	$this->response(false,"Missing Parameter.");
        }
	
	}


	public function create_event()
	{
		if(!empty($_REQUEST['game_id']) && !empty($_REQUEST['event_time']) && !empty($_REQUEST['event_duration']) && !empty($_REQUEST['event_participant_no']) && !empty($_REQUEST['event_description']) && !empty($_REQUEST['latitude']) && !empty($_REQUEST['longitude']) && !empty($_REQUEST['event_address']) && !empty($_REQUEST['user_id']) && !empty($_REQUEST['title']) )
		{

		$data['title'] = $_REQUEST['title'];
		$data['game_id'] = $_REQUEST['game_id'];
		$data['event_time'] = $_REQUEST['event_time'];
		$data['event_duration'] = $_REQUEST['event_duration'];
		$data['event_participant_no'] = $_REQUEST['event_participant_no'];
		$data['event_description'] = $_REQUEST['event_description'];
		$data['latitude'] = $_REQUEST['latitude'];
		$data['longitude'] = $_REQUEST['longitude'];
		$data['event_address'] = $_REQUEST['event_address'];
		$data['user_id'] = $_REQUEST['user_id'];
		$user_id = $_REQUEST['user_id'];
		$data['event_user_type'] = 2;


		$result = $this->common->insertData('sport_event',$data);
		$insert_id = $this->db->insert_id();
		if($result){
			$event = $this->common->getData('sport_event',array('id'=>$insert_id),array('single'));
			$data['join_user']=$user_id;
        	

        	$user_event_count = $this->common->getData('user',array('id' => $user_id),array('single'));

        	$join_user_event = $user_event_count['user_event'];	

        	if(empty($join_user_event))
        	{
        		$user_event_id = $insert_id;
        	}
        	else
        	{
        		$user_event_id = $join_user_event.','.$insert_id;
        	}
        	$user_info['user_event']=$user_event_id;

			$result = $this->common->updateData('sport_event',$data,array('id' => $insert_id));
        	$result = $this->common->updateData('user',$user_info,array('id' => $_REQUEST['user_id']));

			$this->response(true,"Event Create Successfully.",array("eventinfo" => $event));
		}
		else{
			$this->response(false,"There is a problem, please try again.");
		}
		
		}
		else
		{
			$this->response(false,"Missing Parameter.");
		}		 	
		
	}

	public function event_detail()
	{
		if(!empty($_REQUEST['id']))
		{
			$id = $_REQUEST['id'];


			$result = $this->common->get_eventList(array('SE.id'=>$id));
		
			if(!empty($result))
			{


				

			foreach ($result as $key => $value) {


				if(!empty($value['join_user']))
				{
						$join_user = $value['join_user'];
						$arr_user=(explode(",",$join_user));
						$user_id_string = implode("','", $arr_user);
						$where = "`id` IN ('".$user_id_string."')";
						$result_user = $this->common->getData('user',$where);

						

						foreach($result_user as $user_data)
						{
							if(!empty($user_data['image']))
							{
								$image = base_url('/assets/userfile/profile/'.$user_data['image']);
							}
							else
							{
								$image ="";
							}
							
                 		
							$user_info[]=array('id'=>$user_data['id'],'image'=>$image);
						}



				}
				else
				{
					$user_info="";
				}

				if(!empty($value['game_image']))
			{
				$game_image = base_url('/assets/Game/gamelogo/'.$value['game_image']);
			}
			else
			{
				$game_image = "";
			}


			if(!empty($value['event_image']))
			{
				$event_image = base_url('/assets/event/image/'.$value['event_image']);
			}
			else
			{
				$event_image = "";
			}

;
			$event_arr=array('id'=>$value['id'],'title'=>$value['title'],'game_id'=>$value['game_id'],'event_user_type'=>$value['event_user_type'],'event_time'=>$value['event_time'],'event_duration'=>$value['event_duration'],'event_participant_no'=>$value['event_participant_no'],'event_description'=>$value['event_description'],'status'=>$value['status'],'game_name'=>$value['game_name'],'event_address'=>$value['event_address'],'game_image'=>$game_image,'event_image'=>$event_image,'longitude'=>$value['longitude'],'latitude'=>$value['latitude'],'user_info' => $user_info);

			if($value['event_user_type']==2)
				{
					$event_arr['user_id']=$value['user_id'];
					$userinfo = $this->common->getData('user',array('id'=>$value['user_id']),array('single'));



					$event_arr['user_name'] = $userinfo['name'];
					$event_arr['user_email'] = $userinfo['email'];
				
				}
				else
				{
					$event_arr['price'] = $value['price'];
				}

		}
	}
			
			if($result){
				$this->response(true,"Profile fetch Successfully.",array("userinfo" => $event_arr));			
			}else{
				$this->response(false,"There is a problem, please try again.",array("userinfo" => ""));
			}		
			
		}
		else
		{
			$this->response(false,"Missing Parameter.");
		}
	}



	public function my_sport()
	{
		if(!empty($_REQUEST['user_id']))
		{
			$user_id = $_REQUEST['user_id'];

			$where = 'SE.status = 0';
        	$result = $this->common->get_eventList($where);

        	


        	foreach ($result as $key => $value) {
			$game_image = base_url('/assets/Game/gamelogo/'.$value['game_image']);

			$join_user = $value['join_user'];
			
			$join_user_arr=(explode(",",$join_user));
			

        	if (in_array($user_id,$join_user_arr))
        	{
        		 $event_time=$value['event_time'];
        		$today = Date('Y-m-d H:i:s'); 
        		
        		if($event_time < $today)
        		{
        			 $Sport_status = 'active';
        		}
        		else
        		{
        			$Sport_status = 'done';
        		}

        		$arr[]=array('id'=>$value['id'],'title'=>$value['title'],'game_id'=>$value['game_id'],'event_user_type'=>$value['event_user_type'],'event_time'=>$value['event_time'],'event_duration'=>$value['event_duration'],'event_participant_no'=>$value['event_participant_no'],'event_description'=>$value['event_description'],'status'=>$value['status'],'game_name'=>$value['game_name'],'game_image'=>$game_image,'join_user'=>$value['join_user'],'Sport_status'=>$Sport_status,'event_address'=>$value['event_address'],'latitude'=>$value['latitude'],'longitude'=>$value['longitude']);
        	}

	}

		if(!empty($arr))
		{
			$this->response(true,"Sport fetch Successfully.",array("sportinfo" => $arr));
		}
		else
		{
			$this->response(false,"Sport Not found.");
		}
		

		}
		else
		{
			$this->response(false,"Missing Parameter.");
		}
	}



	public function follow_user()
	{
		if(!empty($_REQUEST['user_id']) && !empty($_REQUEST['follow_uid']))
		{
			 $user_id = $_REQUEST['user_id'];
			 $follow_uid = $_REQUEST['follow_uid'];
				$status = $_REQUEST['status'];
				if ($status == 1) {
					if (!empty($follow_uid)) {
					
						$where="user_id	='" . $user_id . "' AND following_id ='" . $follow_uid . "' ";
						$value = $this->common->getData('user_following',$where,array('single'));
						;
						
					if(empty($value))
						{	
							$insert = $this->common->insertData('user_following',array('user_id' => $user_id,'	following_id' => $follow_uid));

							 $user_data = $this->common->getData('user',array('id'=>$user_id),array('single'));
							 	$name = $user_data['name'];
							 	$ios_token = $user_data['ios_token'];
							 	$android_token = $user_data['android_token'];
							 	$today = Date('Y-m-d H:i:s'); 
								$insert_notification = $this->common->insertData('notification_tbl',array('user_id' => $user_id,'message' => "Started Following You",'user_send_from'=>$follow_uid,'date'=>$today,'type'=>"Following"));
							
							
							$notification = array('user_id' => $user_id,'message' => "Started Following You",'user_send_from'=>$follow_uid,'date'=>$today,'type'=>"Following");
							$sendmsg = "followed";

							
							if($ios_token != ""){
										 $isSend = $this->push_iOS($ios_token,$notification,$sendmsg);


								}
								else if($android_token != "")
								{
									$registatoin_id = array($user_data["android_token"]); 
									$this->send_notification($registatoin_id, $sendmsg);

								}

								$uid  = $this->db->insert_id();
						
							$this->response(true,"followed");
							
						}
						else
						{
							$this->response(false,"Follow already added");
						}

					}
				}

				else
                {
                    
                    if (!empty($follow_uid)) {
                    	$where="user_id	='" . $user_id . "' AND following_id ='" . $follow_uid . "' ";
                    	
                    	$value = $this->common->deleteData('user_following',$where);
                    	$this->response(true,"Unfollowed");
                    	$today = Date('Y-m-d H:i:s'); 
                    	$insert_notification = $this->common->insertData('notification_tbl',array('user_id' => $user_id,'message' =>"Unfollowed You",'user_send_from'=>$follow_uid,'date'=>$today,'type'=>"Unfollowed"));

                    	 $user_data = $this->common->getData('user',array('id'=>$user_id),array('single'));
							 	$name = $user_data['name'];
							 	$ios_token = $user_data['ios_token'];
							 	$android_token = $user_data['android_token'];
							 	


                    	$notification = array('user_id' => $user_id,'message' =>"Unfollowed You",'user_send_from'=>$follow_uid,'date'=>$today,'type'=>"Unfollowed");
							$sendmsg = "Unfollowed";

							
							if($ios_token != ""){
										 $isSend = $this->push_iOS($ios_token,$notification,$sendmsg);


								}
								else if($android_token != "")
								{
									$registatoin_id = array($user_data["android_token"]); 
									$this->send_notification($registatoin_id, $sendmsg);

								}

							
                    }
                }
		}
		else
		{
			$this->response(false,"Missing Parameter.");
		}	
	}

	public function accept_reject()
	{
	if(!empty($_REQUEST['user_id']) && !empty($_REQUEST['following_id']) && !empty($_REQUEST['status']))
		{
			$user_id = $_REQUEST['user_id'];
			$following_id = $_REQUEST['following_id'];
			$status = $_REQUEST['status'];

			$where="user_id	='" . $user_id . "' AND user_id	='" . $user_id . "' AND user_id	='" . $user_id . "' ";
			$follow = $this->common->getData('join_event_tbl',$where1,array('single'));

			$data['status']	= $status;
			if($status == 1)
			{
				$message = "Accept User Successfully";
			}
			else
			{
				$message = "Reject User Successfully";
			}
			$result = $this->common->updateData('user_following',$data,array('user_id' => $user_id,'following_id' => $following_id));
			if($result){
			$this->response(true,"$message");
			}else{
			$this->response(false,"There is a problem, please try again.",array("userinfo" => ""));
			}
		}
		else
		{
			$this->response(false,"Missing Parameter.");
		}	

	}


	public function accept_reject_event()
	{
		if(!empty($_REQUEST['join_id']) && !empty($_REQUEST['event_id']) &&!empty($_REQUEST['status']) &&!empty($_REQUEST['notification_id']))
		{
			
			$join_id = $_REQUEST['join_id'];
			$event_id = $_REQUEST['event_id'];
			$status = $_REQUEST['status'];
			$notification_id = $_REQUEST['notification_id'];

			$even_data_user = $this->common->getData('sport_event',array('id'=>$event_id),array('single'));
			$user_id = $even_data_user['user_id'];

			$where1 = "user_id	='" . $user_id . "' AND join_id	='" . $join_id . "' AND event_id	='" . $event_id . "' ";
			$status_match = $this->common->getData('join_event_tbl',$where1,array('single'));
			if($status_match['status']==1)
			{
				$this->response(false,"Already Accepted");
				exit();
			}
			if($status_match['status']==2)
			{
				$this->response(false,"Already Rejected");
				exit();
			}



			$where_notification="id	='".$notification_id ."'";
            $value_notification = $this->common->deleteData('notification_tbl',$where_notification);

				
			if($status == 1)
			{

				$data_join = $this->joinevent($event_id,$join_id);
				$message = $data_join['message'];
					
				if($data_join['status'])
				{

					


					$message = "Accept User Successfully";
					$data['status'] = $status;
					$result = $this->common->updateData('join_event_tbl',$data,array('user_id' => $user_id,'join_id' => $join_id,'event_id'=>$event_id));
						
					if($result){


				// notification start
				$user_data = $this->common->getData('user',array('id'=>$join_id),array('single'));
				$ios_token = $user_data['ios_token'];
				$android_token = $user_data['android_token'];
				$today = Date('Y-m-d H:i:s'); 
				$insert_notification = $this->common->insertData('notification_tbl',array('user_id' => $join_id,'message' => "Now Joinee Your Event",'date'=>$today,'user_send_from'=>$user_id,'type'=>"Event",'event_id'=>$_REQUEST['event_id']));
								
				$notification = array('user_id' => $join_id,'message' => "Now Joinee Your Event",'date'=>$today,'user_send_from'=>$user_id,'type'=>"Event",'event_id'=>$_REQUEST['event_id']);
				$sendmsg = "Accept Joining";
				
				if($ios_token != ""){
					$isSend = $this->push_iOS($ios_token,$notification,$sendmsg);
				}
				else if($android_token != "")
				{
					$registatoin_id = array($user_data["android_token"]); 
					$this->send_notification($registatoin_id, $sendmsg);

				}

				// notification end



						$this->response(true,$message);
						exit();
					}
					else
					{
						$this->response(false,"There is a problem, please try again.");
						exit();
					}
				
				}else
				{
					$this->response(false,$message);
					exit();
				}
			}
			else
			{
				$message = "Reject User Successfully";
				$data['status'] = $status;
				$result = $this->common->updateData('join_event_tbl',$data,array('user_id' => $user_id,'join_id' => $join_id,'event_id'=>$event_id));
				
				if($result){

					// notification start
					$user_data = $this->common->getData('user',array('id'=>$join_id),array('single'));
					$ios_token = $user_data['ios_token'];
					$android_token = $user_data['android_token'];
					$today = Date('Y-m-d H:i:s'); 
					$insert_notification = $this->common->insertData('notification_tbl',array('user_id' => $join_id,'message' =>"Cancel Join Request",'date'=>$today,'user_send_from'=>$user_id,'type'=>"Joining",'event_id'=>$_REQUEST['event_id']));
									
					$notification = array('user_id' => $join_id,'message' =>"Cancel Join Request",'date'=>$today,'user_send_from'=>$user_id,'type'=>"Joining",'event_id'=>$_REQUEST['event_id']);
					$sendmsg = "Reject Joining";
					
					if($ios_token != ""){
						$isSend = $this->push_iOS($ios_token,$notification,$sendmsg);
					}
					else if($android_token != "")
					{
						$registatoin_id = array($user_data["android_token"]); 
						$this->send_notification($registatoin_id, $sendmsg);

					}

					// notification end


					$this->response(true,$message);
					exit();
				}
				else
				{
					$this->response(false,"There is a problem, please try again.");
					exit();
				}
			}
					
					
		}
		else
		{
			$this->response(false,"Missing Parameter.");
		}	

	}



	public function game_list()
	{
		$where="status = 0";
        $result = $this->common->getData('sport_game',$where);
        if(!empty($result)){

        	 foreach ($result as $key => $value) {
        	 	if(!empty($value['game_image']))
                 	{
                 		$game_image = base_url('/assets/Game/gamelogo/'.$value['game_image']);
                 	}
                 	else
                 	{
                 		$game_image = '';
                 	}

                 $arr[]=array('id'=>$value['id'],'game_name'=>$value['game_name'],'game_image'=>$game_image);
        	 }
			$this->response(true,"user fetch Successfully.",array("gameinfo" => $arr));			
		}else{
			$this->response(false,"There is a problem, please try again.",array("gameinfo" => ""));
		}

	}

	public function user_list()
	{
		if(!empty($_REQUEST['user_id']))
		{
				$user_id = $_REQUEST['user_id'];
				 $where="id	!='" . $user_id . "' AND status = 0 ";
               
                 $result = $this->common->getData('user',$where);
               

            if(!empty($result)){     
                 foreach ($result as $key => $value) {
                 	if(!empty($value['image']))
                 	{
                 		$image = base_url('/assets/userfile/profile/'.$value['image']);
                 	}
                 	else
                 	{
                 		$image = '';
                 	}
		
		$where1="user_id ='" . $user_id . "' AND following_id = '" . $value['id'] . "' ";
		$follow = $this->common->getData('user_following',$where1,array('single'));

	
	

		if(!empty($follow))
		{
			$follow_status = 1;
		}
		else
		{
			$follow_status = 2;
		}

			$id = $value['id'];
		

		$user_where = "(user_from='".$user_id."' and user_to='".$id."') or (user_from='".$id."' and user_to='".$user_id."')";
	
		$result_chat = $this->common->getData('chat',$user_where,array('sort_by'=>'created_at','sort_direction' => 'desc'));
		if(!empty($result_chat))
		{
			$created_at = $result_chat[0]['created_at'];

		}
		else
		{
			$created_at ="";
		}
		

		


		$arr[]=array('id'=>$value['id'],'name'=>$value['name'],'email'=>$value['email'],'image'=>$image,'follow_status'=>$follow_status,'created_at'=>$created_at);
		}

	
		
			$this->response(true,"user fetch Successfully.",array("userinfo" => $arr));			
		}else{
			$this->response(false,"User Not Found",array("userinfo" => ""));
		}
		}
		else
		{
			$this->response(false,"Missing Parameter.");
		}

	}


	public function user_detail()
	{
		if(!empty($_REQUEST['user_id']))
		{
			$user_id = $_REQUEST['user_id'];
			$result = $this->common->getData('user',array('id' => $user_id),array('single'));
			if(!empty($result))
			{

				if(!empty($result['user_game_id']))
			{

				$game = $this->common->getData('sport_game',array('id' => $result['user_game_id']),array('single'));
			


				if(!empty($game['game_image']))
				{
					$game_image = base_url('/assets/Game/gamelogo/'.$game['game_image']);
				
				}
				else
				{
					$game_image  = "";
				}
			}
			else
			{
				$game_image = "";
			}

				$user_dob= $result['user_dob'];
				$user_address= $result['user_address'];
				 $age= date_diff(date_create($user_dob), date_create('today'))->y;
				if(!empty($result['image']))
				{
				$user_image = $image = base_url('/assets/userfile/profile/'.$result['image']);
				}
				else
				{
					$user_image="";
				}

				$arr[]=array('id'=>$result['id'],'name'=>$result['name'],'email'=>$result['email'],'user_image'=>$user_image,'game_image'=>$game_image,'user_dob'=>$age,'user_address'=>$user_address);
				
				$this->response(true,"user fetch Successfully.",array("userinfo" => $arr));	
			}
			else
			{
				$this->response(false,"User Not Found",array("userinfo" => ""));
			}
		}
		else
		{
			$this->response(false,"Missing Parameter.");
		}

	}


	


	public function verification()
	{		
		if($_POST['type'] =='mobile'){
			$userinfo = $this->common->getData('user',array('mobile'=>$_POST['mobile']),array('single'));
			if($_POST['otp'] != $userinfo['otp']){
				$this->response(false,"Wrong OTP entered. please try again.",array("userinfo" => $userinfo)); exit();
			}
			$this->common->updateData('user',array('verified'=> '1','otp' => null),array('mobile'=> $_POST['mobile']));
			$message = "OTP verified successfully.";
		}

		if($_POST['type'] == 'email'){
			$userinfo = $this->common->getData('user',array('email'=>$_POST['email']),array('single'));
			if($_POST['otp'] != $userinfo['otp']){
				$this->response(false,"Wrong OTP entered. please try again.",array("userinfo" => $userinfo)); exit();
			}
			$this->common->updateData('user',array('verified' => '1','otp' => null),array('email' => $_POST['email']));
			$message = "Email verified successfully.";	
		}
		
		$this->response(true,$message,array("userinfo" => $userinfo));
	}



	public function social_login()
	{		
		$user = $this->common->getData('user',array('email' => $_POST['email']),array('single'));
		$url = $this->input->post('image');
		$uimg = "";
		if($url != ""){
			$uimg = rand().time().'.png';
			file_put_contents('assets/userfile/profile/'.$uimg, file_get_contents($url));
		}
		if($user){
			
			$old_device = $this->common->getData('user',array('ios_token' => $_POST['ios_token']),array('single','field'=>'id'));
			if($old_device){
				$this->common->updateData('user',array('android_token' => "", "ios_token" => ""),array('id' => $old_device['id']));
			}
			$update = $this->common->updateData('user',array('image' => $uimg, 'ios_token' =>$_POST['ios_token'], 'android_token' => $_POST['android_token']),array('id' => $user['id']));
			if($update){				
				if($user['image'] != "" && file_exists('assets/userfile/profile/'.$user['image'])){
					unlink('assets/userfile/profile/'.$user['image']);
				}
				$user['image'] = $uimg;
				$this->response(true,"Login Successfully.",array("userinfo" => $user));
			}else{
			 	$this->response(false,"There is a problem, please try again.",array("userinfo" => ""));
  			}
		}else{			
			$insert = $this->common->insertData('user',array('email' => $_POST['email'],'image' => $uimg,'name' => $_POST['name'],'ios_token' =>$_POST['ios_token'],'user_dob'=>$_POST['user_dob'],'user_address'=>$_POST['user_address'],'user_latitude'=>$_POST['user_latitude'],'user_longitude'=>$_POST['user_longitude'],'android_token' => $_POST['android_token'],'created_at' => Date('Y-m-d H:i:s'),'social'=>1));


			$uid  = $this->db->insert_id();
			if($insert){
		    $user = $this->common->getData('user',array('id'=> $uid),array('single'));
		
		    // $user['image'] =base_url('/assets/userfile/profile/'.$user['image']);
		    
				$this->response(true,"Your Registration Successfully Completed.",array("userinfo" => $user));
			}else {
		     	$this->response(false,"There is a problem, please try again.",array("userinfo" => ""));
		    }
		}
	}


	public function updateProfile(){
		chmod('./assets/userfile/profile/',0777);
		

		$id = $_POST['id']; unset($_POST['id']);		
		if(!empty($_FILES['file'])){

			$image = $this->common->do_upload('file','./assets/userfile/profile/');
			$_POST['image'] = $image['upload_data']['file_name'];
			$old_image = $this->common->getData('user',array('id'=>$id),array('single','field'=>'image'));
			if(file_exists('./assets/userfile/profile/'.$old_image['image'])){ 
				unlink('./assets/userfile/profile/'.$old_image['image']);

			}
		}	



		$post = $this->common->getField('user',$_POST);
		if(!empty($post))
		{		
			$result = $this->common->updateData('user',$post,array('id' => $id)); 
		}
		else
		{
			$result = "";
		}
		
		if($result){
			$user = $this->common->getData('user',array('id' => $id),array('single'));

			
			
			if(!empty($user['user_game_id']))
			{

				$game = $this->common->getData('sport_game',array('id' => $user['user_game_id']),array('single'));



				if(!empty($game['game_image']))
				{
					$user['game_image'] = base_url('/assets/Game/gamelogo/'.$game['game_image']);
				
				}
				else
				{
					$user['game_image']  = "";
				}
			}
			else
			{
				$user['game_image'] = "";
			}
			if(!empty($user['image']))
			{
				$user['image'] = $image = base_url('/assets/userfile/profile/'.$user['image']);
			}
			else
			{
				$user['image']='';
			}
			
			$this->response(true,"Profile Update Successfully.",array("userinfo" => $user));
		}else{
			$this->response(false,"There is a problem, please try again.",array("userinfo" => ""));
		}
	}


	public function updateEvent(){
		chmod('./assets/userfile/profile/',0777);
		$id = $_POST['id']; unset($_POST['id']);		
		
		$post = $this->common->getField('sport_event',$_POST);		
		$result = $this->common->updateData('sport_event',$post,array('id' => $id)); 

		if($result){
			$this->response(true,"Event Update Successfully.",array("userinfo" => $user));
		}else{
			$this->response(false,"There is a problem, please try again.",array("userinfo" => ""));
		}
	}




	public function getData1()
	{
		echo "hello" ;
	}

	public function getProfile()
	{
		$value = $this->common->getData('user',array('id' => $_POST['id']),array('single'));

		


		if(!empty($value))
		{

			if(!empty($value['user_game_id']))
			{
				$game = $this->common->getData('sport_game',array('id' => $value['user_game_id']),array('single'));
				$game_image = $game['game_image'];
				if(!empty($game['game_image']))
				{
					$game_image = base_url('/assets/Game/gamelogo/'.$game['game_image']);
				}
				else
				{
					$game_image = "";
				}
			}
			else
				{
					$game_image = "";
				}


			if(!empty($value['image']))
			{
				$image = base_url('/assets/userfile/profile/'.$value['image']);
			}
			else
			{
				$image = "";
			}

			
			
			$age= date_diff(date_create($value['user_dob']), date_create('today'))->y;
		$user=array('id'=>$value['id'],'name'=>$value['name'],'email'=>$value['email'],'image'=>$value['image'],'social'=>$value['social'],'ios_token'=>$value['ios_token'],'android_token'=>$value['android_token'],'created_at'=>$value['created_at'],'user_address'=>$value['user_address'],'Age'=>$age,'user_dob'=>$value['user_dob'],'status'=>$value['status'],'image'=>$image,'game_logo'=>$game_image);
		$this->response(true,"Profile fetch Successfully.",array("userinfo" => $user));
		}
		else{
			$this->response(false,"There is a problem, please try again.",array("userinfo" => ""));
		}		
		
	}

	



// 	function get_mysqli() { 
// $db = (array)get_instance()->db;
// return mysqli_connect('localhost', $db['username'], $db['password'], $db['database']);}

	public function chat()
	{
		
		
		if(!empty($_REQUEST['user_from']))
		{

				
			$post['user_from'] = $_REQUEST['user_from'];

			if(!empty($_REQUEST['group_id']))
			{
				$group_id = $_REQUEST['group_id'];
				$eventinfo = $this->common->getData('sport_event',array('id'=>$group_id),array('single'));
				if(!empty($eventinfo['join_user']))
				{
					$join_user = $eventinfo['join_user'];
					$arr_user=(explode(",",$join_user));
				}
				else
				{
					$arr_user=array();
				}
					
					
				if (!in_array($_REQUEST['user_from'], $arr_user))
				{
					$this->response(false,'Not allow to chat');
					exit();
				}
				else
				{
					$post['group_id'] = $_REQUEST['group_id'];
					$user_to = $_REQUEST['group_id'];
				}

			}
			else
			{
				$post['user_to'] = $_REQUEST['user_to'];
				$user_to = $_REQUEST['user_to'];
			}
				

			if(!empty($_FILES['message']['name']))
			{
				$image = $this->common->do_upload_file('message','./assets/chat/');
				if(isset($image['upload_data']))
				{
						$msg_image = $image['upload_data']['file_name'];
						$msg = base_url('/assets/chat/'.$msg_image);
						$post['message']=json_encode($image['upload_data']['file_name']);
				}
				else
				{
					$this->response(false,'Missing parameter');
					exit();
				}
			}
			else
			{
				$message_user = $_REQUEST['message'];
				$message_user = json_encode($message_user);
				$post['message']  =  $message_user;
				$msg = $_REQUEST['message'];
			}

				


	  			

			$post['created_at'] = date('Y-m-d H:i:s');
			$result = $this->common->insertData('chat',$post);
			$insert_id = $this->db->insert_id();
			if($result)
			{
				$title = 'chat';
				$type = "chat";
				$message = "message sent successfully";
				$last_msg =array("id" => $insert_id,
		            "user_from" => $_POST['user_from'],
					"user_to" => $user_to,
		            "message"=> $msg,
		            "sender_id" => $_POST['user_from'],
		            "created_at" => $post['created_at']);
				
				$messages_push = array("title" => $title, "message" => $msg, "type" => $type,"sender_id" => $_POST['user_from'],"last_msg" => $last_msg);
				unset($messages_push['last_msg']);

				$userinfo = $this->common->getData('user',array('id'=>$_POST['user_from']),array('single','name,image'));
				$messages_push['name'] = $userinfo['name'];
				$messages_push['image'] = $userinfo['image'];
				

				// notification start
				$user_data = $this->common->getData('user',array('id'=>$user_to),array('single'));
				$ios_token = $user_data['ios_token'];
				$android_token = $user_data['android_token'];
				$today = Date('Y-m-d H:i:s'); 
				$insert_notification = $this->common->insertData('notification_tbl',array('user_id' => $user_to,'message' => "Sent You a Message",'user_send_from'=>$_REQUEST['user_from'],'date'=>$today,'type'=>"Message"));
								
				$notification = array('user_id' => $user_to,'message' => "Sent You a Message",'user_send_from'=>$_REQUEST['user_from'],'date'=>$today,'type'=>"Message");
				$sendmsg = "Message Send";
				
				if($ios_token != ""){
					$isSend = $this->push_iOS($ios_token,$notification,$sendmsg);
				}
				else if($android_token != "")
				{
					$registatoin_id = array($user_data["android_token"]); 
					$this->send_notification($registatoin_id, $sendmsg);

				}

				// notification end
						 
			}
			else{
				$message = false;
			}
			if($message){
				$this->response(true,$message,array("last_msg" => $last_msg));		
			}else{
				$this->response(false,$message,array("last_msg" => $last_msg));		
			}		 	
		}
		else
		{
			$this->response(false,'Missing Parameter');	
		}
	}


	public function get_event()
	{
		if(!empty($_REQUEST['get_type']) && !empty($_REQUEST['user_latitude']) && !empty($_REQUEST['user_longitude']))
        {

        	$user_latitude = $_REQUEST['user_latitude'];
        	$user_longitude = $_REQUEST['user_longitude'];
        	if($_REQUEST['get_type'] == 1)
        	{
        	

        		$where = 'SE.event_user_type = 1 AND SE.status = 0 AND SG.status = 0';
				$result = $this->common->get_eventList_by_lat($where,$user_latitude,$user_longitude);

        	}
        	else
        	{
        		$where = 'SE.status = 0 AND SG.status = 0';
        		$result = $this->common->get_eventList_by_lat($where,$user_latitude,$user_longitude);
        	}

        	
		$arr=array();
		$i=0;
		foreach ($result as $key => $value) {
			if(!empty($value['game_image']))
			{
				$game_image = base_url('/assets/Game/gamelogo/'.$value['game_image']);
			}
			else
			{
				$game_image = "";
			}


			if(!empty($value['event_image']))
			{
				$event_image = base_url('/assets/event/image/'.$value['event_image']);
			}
			else
			{
				$event_image = "";
			}
			
			
		$arr[$i]=array('id'=>$value['id'],'title'=>$value['title'],'game_id'=>$value['game_id'],'event_user_type'=>$value['event_user_type'],'event_time'=>$value['event_time'],'event_duration'=>$value['event_duration'],'event_participant_no'=>$value['event_participant_no'],'price'=>$value['price'],'event_description'=>$value['event_description'],'status'=>$value['status'],'game_name'=>$value['game_name'],'game_image'=>$game_image,'event_image'=>$event_image,'latitude'=>$value['latitude'],'longitude'=>$value['longitude'],'event_address'=>$value['event_address'],'distance'=>$value['distance']);

			if($value['event_user_type']==2)
				{
					$arr[$i]['user_id']=$value['user_id'];
					$userinfo = $this->common->getData('user',array('id'=>$value['user_id']),array('single'));



					$arr[$i]['user_name'] = $userinfo['name'];
					$arr[$i]['user_email'] = $userinfo['email'];
				
				}
				$i++;
		}

	
		if($result){
			$this->response(true,"Event fetch Successfully.",array("eventinfo" => $arr));			
		}else{
			$this->response(false,"There is a problem, please try again.",array("userinfo" => ""));
		}
		}
		else
		{
			$this->response(false,"Missing parameter");
		}			
		
		

	}
	
	public function chatlist()
	{

      	$userId = $this->common->getData('user',array('id' => $_POST['id']),array('single'));
      	$user_event_my = $userId['user_event'];

      	$arr_event=(explode(",",$user_event_my));
        $comma_separated = implode("','", $arr_event);

	$where = "user_from = '".$_POST['id']."' or user_to = '".$_POST['id']."' or  `group_id` IN ('".$comma_separated."')";
	
		$result = $this->common->getData('chat',$where,array('sort_by'=>'created_at','sort_direction' => 'desc'));
		
		
		


		$user_id = $user = $result1 = $group = array();
		if(!empty($result)){	

			foreach ($result as $key => $value) {			
			if($value['group_id'] != 0){

					if (!in_array($value['group_id'], $group))
				  	{
				  		
				  		
						$group[] = $value['group_id'];
						
						
					}
					}
					else
					{			
				if($value['user_from'] == $_POST['id']){
					if (!in_array($value['user_to'], $user_id))
				  	{
				  	
							$user_id[] = $value['user_to'];
										  		
				  	}
					
				}else{
					if (!in_array($value['user_from'], $user_id))
				  	{
				  	
				  		
							$user_id[] = $value['user_from'];
												
					}
				}
				}				
			} 

			

				$main_data = array();
			$i=0;
			foreach($user_id as $user_value)
			{
				$main_data[$i]['user'] = $user_value; 
				$i++;
			}

		

			foreach($group as $group_value)
			{
				$main_data[$i]['group'] = $group_value; 
				$i++;
			}

		


		if(!empty($main_data)){
			foreach ($main_data as $key => $value) {

				 if(!empty($value['group']))
				 {
				 	
				 	 $groupdetail = $this->common->getData('sport_event',array('id'=> $value['group']),array('single'));
				 	 
					 	 if(!empty($groupdetail['event_image']))
	                 	{
	                 		$image = base_url('/assets/userfile/profile/'.$groupdetail['event_image']);
	                 	}
	                 	else
	                 	{
	                 		$image = '';
	                 	}
	                 	

	                 	$result_group = $this->common->getData('chat','group_id = '.$value['group'],array('single','field' => 'message,created_at,id','sort_by' =>'id' , 'sort_direction' => 'desc'));



	                 	$result1[] = array('message'=>$result_group['message'],'created_at'=>$result_group['created_at'],'image' => $image,'id'=>$result_group['id']);


				 }
				else
				{

			$userdinfo = $this->common->getData('user',array('id'=> $value['user']),array('single'));

				if(!empty($userdinfo['image']))
                 	{
                 		$image = base_url('/assets/userfile/profile/'.$userdinfo['image']);
                 	}
                 	else
                 	{
                 		$image = '';
                 	}
                 	

                 	$where_user = "(user_from='".$value['user']."' and user_to='".$_POST['id']."') or (user_to='".$value['user']."' and user_from='".$_POST['id']."')";

				$result_user= $this->common->getData('chat',$where_user,array('single','field' => 'message,created_at,id','sort_by' =>'id' , 'sort_direction' => 'desc'));

		
				
				$result1[] = array('message'=>$result_user['message'],'created_at'=>$result_user['created_at'] ,'image' => $image,'id'=>$result_user['id'],'user_id' =>$value['user']);


				}

			}
		}

			
		

				if(!empty($result1)){
				 	
				 
				foreach($result1 as $value)
				{
					if(!empty($value['message']))
					{
					 $msg = json_decode($value['message']);
					 preg_match('/\.[^\.]+$/i',$msg,$ext);
					 if(!empty($ext))
					 {
					 	 $ext = $ext[0];
					 }
					 else
					 {
					 	 $ext = "";
					 }
				
                            $type=Array(1 => '.jpg', 2 => '.jpeg', 3 => '.png', 4 => '.gif',5 => '.3gp',6 => '.mp4',7 => '.avi',8 =>'.wmv');
                            
                            if(!(in_array($ext,$type)))
                            {
                                  $message=$msg;	
                                  $message_staus = 2;
                            }
                            else {
                              
                               $message = base_url('/assets/chat/'.$msg);	
                               $message_staus = 1;
                                
                            }

                           }
                           else
                           {
                           	 	$message="";	
                               $message_staus ="";
                           }

				 $created_at = $value['created_at'];
				  $image = $value['image'];
				  $id = $value['id'];
				  $user_id = $value['user_id'];
				  
				 $userdetail[] = array('message'=>$message,'created_at'=>$created_at,'image' => $image,'message_staus'=>$message_staus,'id'=>$id,'user_id'=>$user_id);

					
				
				
			}
			$data = $this->array_sort($userdetail,'id', SORT_DESC);
			

			foreach ($data as $key => $value) {

				$user_info = $this->common->getData('user',array('id' => $value['user_id']),array('single'));


				$user[]= array('message'=>$value['message'],'created_at'=>$value['created_at'],'image' => $value['image'],'message_staus'=>$value['message_staus'],'id'=>$value['id'],'user_id'=>$value['user_id'],'user_name'=>$user_info['name']);
			}

			}
		}
		if($user){
			$this->response(true,$user);		
		}else{
			$this->response(false,array());		
		}	

		 
	}



	function array_sort($array, $on, $order=SORT_ASC){

    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

	public function chatHistory()
	{
		if(!empty($_POST['group_id']))
		{
				
				$where="group_id = '". $_POST['group_id'] ."'";
		}
		else
		{
			$where = '(user_from = '.$_POST['id'].' AND user_to = '.$_POST['uid'].') OR (user_from = '.$_POST['uid'].' AND user_to = '.$_POST['id'].')';
			
		}

		$result = $this->common->getData('chat',$where,array('sort_by'=>'created_at','sort_direction' => 'asc'));

		




		if(!empty($result))
		{
		foreach($result as $value)
        {
        	

        	if(!empty($value['message']))
					{
					 $msg = json_decode($value['message']);
					 preg_match('/\.[^\.]+$/i',$msg,$ext);
					 if(!empty($ext))
					 {
					 	 $ext = $ext[0];
					 }
					 else
					 {
					 	 $ext = "";
					 }
					 
					 
                            $type=Array(1 => '.jpg', 2 => '.jpeg', 3 => '.png', 4 => '.gif',5 => '.3gp',6 => '.mp4',7 => '.avi',8 =>'.wmv');
                            
                            if(!(in_array($ext,$type)))
                            {
                                  $value['message']=$msg;	
                                  $value['message_staus'] = 2;
                            }
                            else {
                              
                               $value['message']=base_url('/assets/chat/'.$msg);	
                               $value['message_staus'] = 1;
                                
                            }

                           }
                           else
                           {
                           	 	$value['message']="";	
                               $value['message_staus'] ="";
                           }

			if(!empty($_POST['group_id']))
			{
					$arr_chat[]=array('id'=>$value['id'],'user_from'=>$value['user_from'],'message'=>$value['message'],'message_staus' => $value['message_staus'],'created_at'=>$value['created_at']);
			}
			else
			{

        	$arr_chat[]=array('id'=>$value['id'],'user_from'=>$value['user_from'],'user_to'=>$value['user_to'],'message'=>$value['message'],'message_staus' => $value['message_staus'],'created_at'=>$value['created_at']);
        	}
        }

        if(!empty($_POST['group_id']))
			{

				$user = $this->common->getData('sport_event',array('id' => $_POST['group_id']),array('single','field' => 'title,event_image'));
				if($user){
			$arr_chat = $arr_chat ? $arr_chat : array();
			if(!empty($user['event_image']))
                 	{
                 		$image = base_url('/assets/event/image/'.$user['event_image']);
                 	}
                 	else
                 	{
                 		$image = '';
                 	}

			$this->response(true,$arr_chat,array("name" => $user['title'],"image" => $image));		
		}else{
			$this->response(false,array());		
		}

			}
			else
			{
		$user = $this->common->getData('user',array('id' => $_POST['uid']),array('single','field' => 'name,image'));
		if($user){
			$arr_chat = $arr_chat ? $arr_chat : array();
			if(!empty($user['image']))
                 	{
                 		$image = base_url('/assets/userfile/profile/'.$user['image']);
                 	}
                 	else
                 	{
                 		$image = '';
                 	}

			$this->response(true,$arr_chat,array("name" => $user['name'],"image" => $image));		
		}else{
			$this->response(false,array());		
		}	
		}
		}
		else
		{

			$this->response(false,array());	
		}		 
	}


	// public function searchUser()
	// {
	// 	$user = $this->common->searchUser($_POST);
	// 	$this->findUser($user);
	// }
	
	public function contactUs()
	{
		$message = '<h4>'.$_POST['name'].'</h4><p>'.$_POST['message'].'</p>';
		$mail = $this->common->sendMail('devendra@mailinator.com','Contact Us',$message,array('fromEmail'=>$_POST['email']));
		$mail_msg = $mail ? 'Email send successfully' : 'Email not send. Please send again';
		$this->response($mail,$mail_msg);	
	}
	
	public function report()
	{		
		$_POST['created_at'] = date('Y-m-d H:i:s');
		$post = $this->common->getData('post',array('id' => $_POST['post_id']),array('single'));
		$user = $this->common->getData('user',array('id'=> $post['uid']),array('single','field'=>'email,name'));
		$post1 = $this->common->getField('report',$_POST);
		$report = $this->common->insertData('report',$post1);
		$mail = false;
		if($report){
			//$this->checkMail();
			$message = "Hello Administrator <br> One post <a href='".base_url('api/postDetail/'.$post['id'])."'>".$post['title']."</a> is reported. We will delete your post if found inappropriate. <br>".$_POST['comment'];

			$mail = $this->common->sendMail("info@positivenetwork.com.au",'Report on your post',$message);
		}
		$response = $this->response($mail,"Reported Successfully");		
	}
	
}