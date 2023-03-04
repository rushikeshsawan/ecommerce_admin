<?php

namespace App\Controllers;

use App\Models\adminModel;
use App\Models\categoriesModel;

class adminController extends BaseController
{


    // Delete Single Data from Database 
    public function delete($num = null)
    {
        $session = session();
        if ($session->get('username')) {
            if ($num != null) {
                $userModel = new categoriesModel();
                $delete = [
                    "id" => $num
                ];
                if ($userModel->delete($delete)) {
                    $session->setFlashdata("success", "Data Deleted Successfully..!");
                    return redirect()->to('tablebasic');
                } else {
                    $session->setFlashdata("error", "Issues Deleting the data, Please Try again After Sometime..!");
                    return redirect()->to('tablebasic');
                }
            }
        } else {
            return redirect()->to("/");
        }
    }

    public function setupdatedata()
    {
        // print_r($this->request->getVar());
        $categoriesModel = new categoriesModel();
        $session = session();
        if (isset($this->request->getVar()['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $category_id = $this->request->getVar()['category_id'];
        $category_name = $this->request->getVar()['category_name'];
        $category_desc = $this->request->getVar()['category_desc'];
        $category_image = $this->request->getVar()['category_image'];
        $data = [
            "category_name" => $category_name,
            "category_desc" => $category_desc,
            "category_image" => $category_image,
            "status"=>$status
        ];
        $categoriesModel->update($category_id, $data);
        if ($categoriesModel->update($category_id, $data)) {

            $session->setFlashdata("success", "<strong>Data Updated Successfully &#128522;</strong>");
            return redirect()->to('tablebasic');
        } else {
            $session->setFlashdata("error", "Data cant update due to technical reason.!");
            return redirect()->to('tablebasic');
        }
        // $session = session();
        // if ($session->get('username')) {
        //     $id = $this->request->getVar()['id'];
        //     $email = $this->request->getVar()['email'];
        //     $password = $this->request->getVar()['password'];
        //     $data = [
        //         "name" => $name,
        //         "uname" => $email,
        //         "pass" => $password,
        //     ];

        //     $userModel = new userModel();
        //     if ($userModel->update($id, $data)) {
        //         $session->setFlashdata("success", "<strong>Data Updated Successfully &#128522;</strong>");
        //         return redirect()->to('all-data');
        //     } else {
        //         $session->setFlashdata("error", "Data cant update due to technical reason.!");
        //         return redirect()->to('all-data');
        //     }
        // }
    }
    // Get Data Record To Update Data 
    public function getupdatedata()
    {
        $id = $this->request->getVar();
        $session = session();
        //  if ($session->get('username')) {
        $userModel = new categoriesModel();
        $data = $userModel->where($id)->find();
        return json_encode($data);
        //  }
    }


    public function tablebasic()
    {
        $categoriesModel = new categoriesModel();
        $category = $categoriesModel->findAll();
        return view('tables-basic', ["categories" => $category]);
    }
    public function resetpassword()
    {
        $session = session();
        if ($this->request->getMethod() == "post") {
            $adminModel = new adminModel();
            $email = $this->request->getVar()['email'];
            $password = md5($this->request->getVar()['password']);
            $otp = $this->request->getVar()['otp'];
            $data = [
                "email" => $email,
                "otp" => $otp
            ];
            print_r($data);
            $result = $adminModel->where('email', $email)->where('otp', $otp)->where('status', "1")->findAll();
            if (count($result) > 0) {
                $id = $result[0]['id'];
                $adminModel->update($id, ['password' => $password, 'otp' => '', 'status' => '0']);
                $session->setFlashdata("success", "Your password has been successfully reseted");
                return redirect()->to('/login');
            } else {
                $session->setFlashdata("Error", "Record Not found, please Signup to register account.");
                return redirect()->to('/login');
                echo "record not found";
            }
        }
    }
    public function forgetpassword()
    {
        if ($this->request->getMethod() == "post") {
            $adminModel = new adminModel();
            $session = session();
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
                // $retval=true;
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
                return view('forget-password');
            }
        } else {

            return view('forget-password');
        }
    }
    public function homepage()
    {
        $session = session();
        if (!$session->get('username')) {
            return redirect()->to('/login');
        } else {
            return view('index');
        }
    }

    public function login()
    {

        $adminModel = new adminModel();
        $session = session();
        if ($session->get('username')) {
            return redirect()->to('/homepage');
        }
        if ($this->request->getMethod() == "post") {

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
            return view('login');
        }
    }


    public function logout()
    {

        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
    public function signup()
    {
        if ($this->request->getMethod() == 'post') {
            $adminModel = new adminModel();
            $uname = $this->request->getVar()['uname'];
            $email = $this->request->getVar()['email'];
            $password = md5($this->request->getVar()['password']);
            $isValid = $this->validate([
                'email' => 'required|valid_email|is_unique[admin_login.email]',
                'uname' => 'required',
                'password' => 'required'
            ], [
                'email' => ['is_unique' => "email must be unique"]
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
                print_r($error = $this->validator->getErrors());
                // var_dump($error);
                // die();
                var_dump($this->validator->getError('uname'));
                var_dump($this->validator->getError('password'));
                return view('register-user');
                // die();
            }
        } else {

            return view('register-user');
        }
    }
}
