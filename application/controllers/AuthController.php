<?php


/**
 * 
 */
class AuthController extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('DatabaseModel');
	}

	public function index()
	{
		$user_id = $this->session->userdata('user_id');
        if(!empty($user_id))
        {
            redirect('dashboard');
        }

		if($this->input->server('REQUEST_METHOD')=='POST'){

			$email = $this->input->post('email');
			$password = $this->input->post('password');

			if(!empty($email) and !empty($password)){

				/** check if email exists */
				if($this->DatabaseModel->exists('users',array('email'=>$email))){

					/** check if email already verified */
					if($this->DatabaseModel->exists('users',array('email'=>$email,'status'=>0))){
						$this->session->set_flashdata('error','Oops.. Your email is not verified');
						redirect($_SERVER['HTTP_REFERER']);
					}

					/** Login User */
					if($user_id = $this->DatabaseModel->validateLogin($email,$password)){

						/** Set user session */	
						$this->session->set_userdata('user_id',$user_id);

						$this->session->set_flashdata('success','You have logged in Successfully!');
						redirect('dashboard');
						
					}else{
						$this->session->set_flashdata('error','Oops.. You have entered wrong email or password');
						redirect($_SERVER['HTTP_REFERER']);
					}

				}else{
					$this->session->set_flashdata('error','Oops.. Email address not exists');
					redirect($_SERVER['HTTP_REFERER']);
				}

			}else{
				$this->session->set_flashdata('error','Oops.. Missing required parameter');
				redirect($_SERVER['HTTP_REFERER']);
			}

		}else{
			$this->load->view('login');
		}

	}


	public function register()
	{
		if($this->input->server('REQUEST_METHOD')=='POST'){

			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			if(!empty($name) and !empty($email) and !empty($password)){

				/** check if email already exists */
				if(!$this->DatabaseModel->exists('users',array('email'=>$email))){

					/** Save user Data */
					$data_arr = array(
						'name' => $name,
						'email' => $email,
						'password' => password_hash($password, PASSWORD_DEFAULT)
					);

					if($this->DatabaseModel->saveData('users',$data_arr)){

						$this->session->set_flashdata('success','Account Register Successfully, Please verify your email for active account');
						redirect('verify-email');

					}else{
						$this->session->set_flashdata('error','Something went wrong, Please try again');
						redirect($_SERVER['HTTP_REFERER']);
					}

				}else{
					$this->session->set_flashdata('error','Oops.. Email already exists');
					redirect($_SERVER['HTTP_REFERER']);
				}

			}else{
				$this->session->set_flashdata('error','Oops.. Missing required parameter');
				redirect($_SERVER['HTTP_REFERER']);
			}		

		}
		else{
			$this->load->view('register');
		}
	}

	public function verifyEmail()
	{
		if($this->input->server('REQUEST_METHOD')=='POST'){

			$email = $this->input->post('email');

			if(!empty($email)){

				/** Check email exists or not */
				if($this->DatabaseModel->exists('users',array('email'=>$email))){

					/** check if email already verified */
					if($this->DatabaseModel->exists('users',array('email'=>$email,'status'=>1))){
						$this->session->set_flashdata('error','Your email is already verified');
						redirect($_SERVER['HTTP_REFERER']);
					}

					/** sent opt on email address */
					$otp = rand(100000,999999);

					if($this->DatabaseModel->update('users',array('pass_hash'=>$otp),'email',$email)){

						if($this->mail($email, "[IMPORTANT] Email Verification Code", $otp)){
							$this->session->set_flashdata('success','OTP Sent Successfully on '.$email);

							$this->session->set_userdata('email', $email);
							redirect('verify-otp');
						}else{
							$this->session->set_flashdata('error','Oops.. Email did not sent');
							redirect($_SERVER['HTTP_REFERER']);
						}
						

					}else{
						$this->session->set_flashdata('error','Something went wrong, Please try again');
						redirect($_SERVER['HTTP_REFERER']);
					}

				}else{
					$this->session->set_flashdata('error','Oops.. Email address not exists');
					redirect($_SERVER['HTTP_REFERER']);
				}

			}else{
				$this->session->set_flashdata('error','Oops.. Missing email address');
				redirect($_SERVER['HTTP_REFERER']);
			}

		}else{
			$this->load->view('verify_email');
		}

	}


	public function verifyOtp()
	{
		if($this->input->server('REQUEST_METHOD')=='POST'){

			$otp = $this->input->post('otp');

			if(!empty($otp)){

				/** check user email session value */
				$email = $this->session->userdata('email');
				if(!empty($email) and isset($email)){

					/** Check User OPT */
					$userdata = $this->DatabaseModel->getData('users',array('email'=>$email));
					if($userdata[0]['pass_hash'] == $otp){

						$data_arr = array(
							'status' => 1,
							'pass_hash' => rand(100000,999999)
						);

						if($this->DatabaseModel->update('users',$data_arr,'id',$userdata[0]['id'])){

							$this->session->set_flashdata('success','Your email verified successfully, Please login here');
							redirect(base_url());

						}else{
							$this->session->set_flashdata('error','Something went wrong, Please try again');
							redirect($_SERVER['HTTP_REFERER']);
						}

					}else{
						$this->session->set_flashdata('error','Oops.. You have entered invalid or expired OTP');
						redirect($_SERVER['HTTP_REFERER']);
					}

				}else{
					$this->session->set_flashdata('error','Oops.. Your session has expired, Please verify your email again');
					redirect($_SERVER['HTTP_REFERER']);
				}


			}else{
				$this->session->set_flashdata('error','Oops.. Missing OTP');
				redirect($_SERVER['HTTP_REFERER']);
			}

		}else{
			$this->load->view('verify_otp');
		}
	
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}

	private function mail($to,$subject,$body){

		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => '',
			'smtp_port' => 80,
			'smtp_user' => '',
			'smtp_pass' => '',
			'smtp_timeout' => '4',
			'mailtype' => 'html',
			'charset' => 'iso-8859-1'
		);

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('', 'OTP');

		$this->email->to($to); // replace it with receiver mail id

		$this->email->subject($subject); // replace it with relevant subject

		$this->email->message($body);

		if($this->email->send())
			return true;
		else
			return false;

	}



}

?>