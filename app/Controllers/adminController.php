<?php

namespace App\Controllers;

use App\Models\adminModel;
use App\Models\categoriesModel;
use App\Models\productModel;

class adminController extends BaseController
{
    public $db;
    public function __construct()
    {
        $this->db = db_connect();
    }


    // Login Authentication
    public function login()
    {

        $adminModel = new adminModel();
        $session = session();
        if ($this->request->getMethod() == "post") {
            $data = [
                'email' => 'required|valid_email',
                'password' => 'required'
            ];
            if ($this->validate($data)) {

                $email = $this->request->getVar()['email'];
                $password = md5($this->request->getVar()['password']);

                $result = $adminModel->where('email', $email)->where('password', $password)->findAll();
                if (count($result) > 0) {
                    $session->set("username", $email);
                    $session->set("user_id", $result[0]['id']);
                    return redirect()->to('/homepage');
                } else {
                    $session->setFlashdata("error", "<strong>Invalid Credentials!</strong> Please Check Your Email & Password.");
                    return view('login');
                }
            } else {
                $session->setFlashdata("error", "<strong>Invalid Credentials!</strong> Please Check Your Email & Password.");
                return view('login');
            }
        } else {
            return view('login');
        }
    }
    // Function to convert associative array into index array 
    function getIndexedArray($array)
    {
        $arrayTemp = array();
        for ($i = 0; $i < count($array); $i++) {
            $keys = array_keys($array[$i]);
            $innerArrayTemp = array();
            for ($j = 0; $j < count($keys); $j++) {

                $innerArrayTemp[$j] = $array[$i][$keys[$j]];
            }
            array_push($arrayTemp, $innerArrayTemp);
        }
        return $arrayTemp;
    }

    // sidebar all table view and all table data view inside it.
    public function gettablecat($table = null)
    {
        $session = session();
            $res = $this->db->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '{$table}'");
            $res = $res->getResultArray();
            $res2 = $this->db->query("SELECT * FROM {$table}");
            $res2 = $res2->getResultArray();
            $adminController = new adminController();
            $finalres = $adminController->getIndexedArray($res2);

            return view('tablecat', ['tablehead' => $res, 'finalres' => $finalres]);
        
    }

    // all table view of category and product in dashboard tablebasic route 
    public function tablebasic()
    {
        $session = session();
            $result = $this->db->query('SELECT product.id, product.product_name, product.product_desc, product.product_img, product.product_price ,categories.category_name,product.user_id,product.status,product.created_at FROM `product` JOIN categories ON product.category_id= categories.id');
            $result = $result->getResultArray();
            $categoriesModel = new categoriesModel();
            $productModel = new productModel();
            $category = $categoriesModel->findAll();
            $res = $this->db->query("SELECT TABLE_NAME AS 'TABLES' FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='admin_panel' AND TABLE_NAME LIKE '%_product'");
            $res = $res->getResultArray();
            return view('tables-basic', ["categories" => $category, "products" => $result, 'tablecat' => $res]);
        
    }


    // after inserting otp function 
    public function resetpassword()
    {
        $session = session();
        if ($this->request->getMethod() == "post") {
            $adminModel = new adminModel();
            $email = $this->request->getVar()['email'];
            $password = md5($this->request->getVar()['password']);
            $otp = $this->request->getVar()['otp'];
            $data = [
                'email' => 'required|is_not_unique[admin_login.email]|valid_email',
                'otp' => 'required|exact_length[6]',
                'password' => 'required|alpha_numeric_punct|min_length[8]|max_length[20]'
            ];
            if ($this->validate($data)) {
                $data = [
                    "email" => $email,
                    "otp" => $otp
                ];
                $result = $adminModel->where('email', $email)->where('otp', $otp)->where('status', "1")->findAll();
                if (count($result) > 0) {
                    $id = $result[0]['id'];
                    $adminModel->update($id, ['password' => $password, 'otp' => '', 'status' => '0']);
                    $session->setFlashdata("success", "Your password has been successfully reseted");
                    return redirect()->to('/login');
                } else {
                    $session->setFlashdata("Error", "Record Not found, please Signup to register account.");
                }
            } else {
                $error = $this->validator->getErrors();
                $session->setFlashdata("success", "Invalid OTP or Password");
                return view('forget-password', ['email' => $email, 'validation' => $error]);
            }
        }
    }

    // function to send otp to email as well as get route for showing ui forgetpassword 
    public function forgetpassword()
    {
        if ($this->request->getMethod() == "post") {
            $adminModel = new adminModel();
            $session = session();
            $data = ['email' => 'required|valid_email|is_not_unique[admin_login.email]'];
            if ($this->validate($data)) {

                $email = $this->request->getVar()['email'];

                $result = $adminModel->where('email', $email)->find();
                if (count($result) > 0) {
                    $id = $result[0]['id'];
                    $subject = "Reset Your Password";
                    $otp = rand(100000, 999999);
                    $message = "<h1>Following is the OTP for your forgotten password- {$otp}.</h1>";
                    $message .= "<pre><b>Dear {$email},<br><br>
                    We have received a request to reset the password for your account associated with this email address. 
                    To complete the process, please enter the following One-Time Password (OTP)  code when prompted:
                        
                        OTP Code:{$otp},
                        
                        If you did not request this password reset, please disregard this email and ensure the security of your account. 
                        
                        
                        Thank you,
                        Rushikesh Sawant.</b></pre>";

                    $header = "From:rushikesh.sawant@darwinpgc.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";

                    $retval = mail($email, $subject, $message, $header);
                    if ($retval == true) {
                        $data = ["otp" => $otp, "status" => "1"];
                        $adminModel->update($id, $data);
                        $session->setFlashdata("success", "OTP sent successfully to {$email}, Please check your email");
                        $session->setFlashdata("email", $email);
                        return view('forget-password');
                    } else {
                        $session->setFlashdata("Error", "We think You are not Registered, Please Register and then continue.");
                        return view('forget-password');
                    }
                } else {
                    $session->setFlashdata("Error", "We think You are not Registered, Please Register and then continue.");
                    return redirect()->back()->withInput();
                }
            } else {
                $session->setFlashdata("Error", "Please Enter Valid Credentials.");
                return redirect()->back()->withInput();
            }
        } else {

            return view('forget-password');
        }
    }

    // homepage function 
    public function homepage()
    {
        $session = session();
       
            return view('index');
    
    }



    // function to logout 
    public function logout()
    {

        session()->destroy();
        return redirect()->to('/login');
    }


    // function to signup 
    public function signup()
    {
        if ($this->request->getMethod() == 'post') {

            $adminModel = new adminModel();
            $uname = $this->request->getVar()['uname'];
            $email = $this->request->getVar()['email'];
            $password = md5($this->request->getVar()['password']);
            $isValid = $this->validate([
                'email' => 'required|valid_email|is_unique[admin_login.email]',
                'uname' => 'required|min_length[8]',
                'password' => 'required|min_length[8]'
            ], [
                'email' => ['is_unique' => "Following email is Already Registered, Please Try other one.", "required" => "Email cannot be Empty", "valid_email" => "Please Enter Valid Email"],
                'uname' => ['required' => 'Username is Required', 'min_length' => 'Username Minimum length should be 8 characters'],
                'password' => ['required' => 'Password is Required', 'min_length' => 'Password Minimum Length should be 8 characters']
            ]);
            if ($isValid) {

                $data = [
                    'uname' => $uname,
                    'email' => $email,
                    'password' => $password
                ];

                if ($adminModel->insert($data)) {
                    return redirect()->to('login');
                }
            } else {
                $error = $this->validator->getErrors();
                return view('register-user', $error);
            }
        } else {
            return view('register-user');
        }
    }
}
