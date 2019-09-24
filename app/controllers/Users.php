<?php
    class Users extends Controller{
        public function __construct(){
            $this->userModel = $this->model('User');

        }
        public function register(){
            //check for POST
            if($_SERVER['REQUEST_METHOD']=='POST'){
                //Process form  

                //sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data=[
                    'name'=>trim($_POST['name']),
                    'email' =>trim($_POST['email']),
                    'password' =>trim($_POST['password']),
                    'confirm_password' =>trim($_POST['confirm_password']),
                    'name_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'confirm_password_error' =>''
                ];    
                //validation
                if(empty($data['email'])){
                    $data['email_error']='Please enter email';
                }else{
                   if($this->userModel->findUserByEmail($data['email'])){
                    $data['email_error']='Email is already used';
                   }
                }
                if(empty($data['name'])){
                    $data['name_error']='Please enter name';
                } 
                if(empty($data['password'])){
                    $data['password_error']='Please enter password';
                } else if(strlen($data['password'])<6){
                    $data['password_error']='Password must be at least 6 characters';
                }
                if(empty($data['confirm_password'])){
                    $data['confirm_password_error']='Please confirm password';
                }else{
                    if($data['password']!=$data['confirm_password']){
                        $data['confirm_password_error']='Passwords do not match';
                    }
                }  
                if(empty($data['email_error'])&&empty($data['name_error'])&&empty($data['password_error'])&&empty($data['confirm_password_error'])){
                    
                    $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);

                    if($this->userModel->register($data)){
                        flash('register_success','You are registered');
                        redirect('users/login');
                    }else{
                        die('Something went wrong');
                    }

                }else{
                    $this->view('users/register',$data);
                }
                
            }else
            {                
                $data=[
                    'name'=>'',
                    'email' =>'',
                    'password' =>'',
                    'confirm_password' =>'',
                    'name_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'confirm_password_error' =>''
                ];
                //Load view
                $this->view('users/register',$data);
            }
        }
        public function login(){
            //check for POST
            if($_SERVER['REQUEST_METHOD']=='POST'){
                //Process form   
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data=[                    
                    'email' =>trim($_POST['email']),
                    'password' =>trim($_POST['password']),                                     
                    'email_error' => '',
                    'password_error' => ''                    
                ];   
              //validation     
                if(empty($data['email'])){
                    $data['email_error']='Please enter email';
                }  
                if(empty($data['password'])){
                    $data['password_error']='Please enter password';
                }
                if(empty($data['email_error'])&&empty($data['password_error'])){
                    die('SUCCESS');
                }else{
                    $this->view('users/login',$data);
                }
            }else
            {               
                $data=[                    
                    'email' =>'',
                    'password' =>'',                     
                    'email_error' => '',
                    'password_error' => ''                    
                ];
                //Load view
                $this->view('users/login',$data);
            }
        }
    }