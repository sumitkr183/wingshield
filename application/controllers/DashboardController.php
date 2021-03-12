<?php

/**
 * 
 */
class DashboardController extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('DatabaseModel');

		/** Check if user already logged in */
		$this->_auth();
	}


	public function index()
	{
		$data['employees'] = $this->DatabaseModel->getData('employee',array('status'=>1));

		$this->load->view('dashboard/dashboard',$data);
	}

	public function addEmployee()
	{
		if($this->input->server('REQUEST_METHOD')=='POST'){

			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$category = $this->input->post('category');
			$phone = $this->input->post('phone');

			if(!empty($name) and !empty($email) and !empty($category) and !empty($phone)){

				/** Check Unique Email or Phone Number */
				if($this->DatabaseModel->exists('employee',array('email'=>$email))){
					$this->session->set_flashdata('error','Oops.. Email already exists');
					redirect($_SERVER['HTTP_REFERER']);
				}

				if($this->DatabaseModel->exists('employee',array('phone'=>$phone))){
					$this->session->set_flashdata('error','Oops.. Phone number already exists');
					redirect($_SERVER['HTTP_REFERER']);
				}

				$data_arr = array(
					'name' => $name,
					'email' => $email,
					'category_id' => $category,
					'phone' => $phone
				);

				if($this->DatabaseModel->saveData('employee',$data_arr)){
					$this->session->set_flashdata('success','Employee register successfully!');
					redirect('dashboard');
				}else{
					$this->session->set_flashdata('error','Something went wrong, Please try again');
					redirect($_SERVER['HTTP_REFERER']);
				}


			}else{
				$this->session->set_flashdata('error','Oops.. Missing required parameters');
				redirect($_SERVER['HTTP_REFERER']);
			}

		}else{
			$data['category'] = $this->DatabaseModel->getData('category',array('status'=>1));
			$this->load->view('dashboard/add_employee',$data);
		}
	}


	public function editEmployee($id)
	{
		if($this->input->server('REQUEST_METHOD')=='POST'){

			$id = $this->input->post('id');
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$category = $this->input->post('category');
			$phone = $this->input->post('phone');

			if(!empty($name) and !empty($email) and !empty($category) and !empty($phone)){

				$users = $this->DatabaseModel->getData('employee',array('id'=>$id));

				/** check if email or phone update and already exists */
				if($users[0]['email'] != $email){
					if($this->DatabaseModel->exists('employee',array('email'=>$email))){
						$this->session->set_flashdata('error','Oops.. Email already exists');
						redirect($_SERVER['HTTP_REFERER']);
					}
				}

				if($users[0]['phone'] != $phone){
					if($this->DatabaseModel->exists('employee',array('phone'=>$phone))){
						$this->session->set_flashdata('error','Oops.. Phone number already exists');
						redirect($_SERVER['HTTP_REFERER']);
					}
				}

				$data_arr = array(
					'name' => $name,
					'email' => $email,
					'category_id' => $category,
					'phone' => $phone
				);

				if($this->DatabaseModel->update('employee',$data_arr,'id',$id)){
					$this->session->set_flashdata('success','Employee updated successfully!');
					redirect('dashboard');
				}else{
					$this->session->set_flashdata('error','Something went wrong, Please try again');
					redirect($_SERVER['HTTP_REFERER']);
				}


			}else{
				$this->session->set_flashdata('error','Oops.. Missing required parameters');
				redirect($_SERVER['HTTP_REFERER']);
			}

		}else{
			$data['employee'] = $this->DatabaseModel->getData('employee',array('id'=>$id));
			$data['category'] = $this->DatabaseModel->getData('category',array('status'=>1));

			$this->load->view('dashboard/edit_employee',$data);
		}
	}


	public function deleteEmployee($id)
	{
		if($this->DatabaseModel->delete('employee',array('id'=>$id))){
			$this->session->set_flashdata('success','Employee deleted successfully!');
			redirect('dashboard');
		}else{
			$this->session->set_flashdata('error','Something went wrong, Please try again');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function addCategory()
	{
		if($this->input->server('REQUEST_METHOD')=='POST'){

			$name = $this->input->post('name');
			if(!empty($name)){

				/** check if category already exists */
				if(!$this->DatabaseModel->exists('category',array('name'=>$name))){

					if($this->DatabaseModel->saveData('category',array('name'=>$name))){
						$this->session->set_flashdata('success','Category added successfully!');
						redirect('add-category');
					}else{
						$this->session->set_flashdata('error','Something went wrong, Please try again');
						redirect($_SERVER['HTTP_REFERER']);
					}

				}else{
					$this->session->set_flashdata('error','Oops.. Category already exists');
					redirect($_SERVER['HTTP_REFERER']);
				}
						
			}else{
				$this->session->set_flashdata('error','Missing required parameters');
				redirect($_SERVER['HTTP_REFERER']);
			}

		}else{
			$data['category'] = $this->DatabaseModel->getData('category',array('status'=>1));
			$this->load->view('dashboard/add_category',$data);
		}
	}


	public function editCategory($id)
	{
		if($this->input->server('REQUEST_METHOD')=='POST'){

			$name = $this->input->post('name');
			$id = $this->input->post('id');
			if(!empty($name) and !empty($id)){

				/** check if category already exists */
				$category = $this->DatabaseModel->getData('category',array('id'=>$id));

				if($category[0]['name'] != $name){
					if($this->DatabaseModel->exists('category',array('name'=>$name))){
						$this->session->set_flashdata('error','Oops.. Category already exists');
						redirect($_SERVER['HTTP_REFERER']);
					}
				}

				if($this->DatabaseModel->update('category',array('name'=>$name),'id',$id)){
					$this->session->set_flashdata('success','Category updated successfully!');
					redirect('add-category');
				}else{
					$this->session->set_flashdata('error','Something went wrong, Please try again');
					redirect($_SERVER['HTTP_REFERER']);
				}		
						
			}else{
				$this->session->set_flashdata('error','Missing required parameters');
				redirect($_SERVER['HTTP_REFERER']);
			}

		}else{
			$data['category'] = $this->DatabaseModel->getData('category',array('id'=>$id));
			$this->load->view('dashboard/edit_category',$data);
		}
	}

	public function deleteCategory($id)
	{
		if($this->DatabaseModel->delete('category',array('id'=>$id))){
			$this->session->set_flashdata('success','Category deleted successfully!');
			redirect('add-category');
		}else{
			$this->session->set_flashdata('error','Something went wrong, Please try again');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}


	private function _auth()
    {
        $user_id = $this->session->userdata('user_id');

        if(empty($user_id))
        {
            redirect('login');
        }
        return true;
    }



}

?>