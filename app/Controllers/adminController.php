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
            "status" => $status
        ];
        $categoriesModel->update($category_id, $data);
        if ($categoriesModel->update($category_id, $data)) {

            $session->setFlashdata("success", "<strong>Data Updated Successfully &#128522;</strong>");
            return redirect()->to('tablebasic');
        } else {
            $session->setFlashdata("error", "Data cant update due to technical reason.!");
            return redirect()->to('tablebasic');
        }
    }

    public function editProduct()
    {
        print_r($this->request->getVar());
        $productModel = new productModel();
        $session = session();
        if (isset($this->request->getVar()['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $productname = $this->request->getVar()['productname'];
        $productid = $this->request->getVar()['productid'];
        $productimg = $this->request->getVar()['productimg'];
        $productdesc = $this->request->getVar()['productdesc'];
        $productprice = $this->request->getVar()['productprice'];
        $productcatid = $this->request->getVar()['productcatid'];
        $data = [
            "product_name" => $productname,
            "product_desc" => $productdesc,
            "product_img" => $productimg,
            "product_price" => $productprice,
            "category_id" => $productcatid,
            "status" => $status,
        ];
        if ($productModel->update($productid, $data)) {
            $session->setFlashdata("success", "<strong>Data Updated Successfully &#128522;</strong>");
            return redirect()->to('tablebasic');
        } else {
            $session->setFlashdata("error", "Data cant update due to technical reason.!");
            return redirect()->to('tablebasic');
        }
    }

    public function addProduct()
    {
        $session = session();
        if ($session->get('username')) {
            $productModel = new productModel();
            $productname = $this->request->getVar()['productname'];
            $productdesc = $this->request->getVar()['productdesc'];
            $productimg = $this->request->getVar()['productimg'];
            $productprice = $this->request->getVar()['productprice'];
            $catid = $this->request->getVar()['catid'];
            $userid = $session->get("user_id");
            if (isset($this->request->getVar()['status'])) {
                $status = 1;
                echo "status set";
            } else {
                echo "status Unset";
                $status = 0;
            }
            $data = [
                "product_name" => $productname,
                "product_desc" => $productdesc,
                "product_img" => $productimg,
                "product_price" => $productprice,
                "category_id" => $catid,
                "user_id" => $userid,
                "status" => $status
            ];
            if ($productModel->insert($data)) {

                $session->setFlashdata("success", "<strong>Product Inserted Successfully &#128522;</strong>");
                return redirect()->to('tablebasic');
            } else {
                $session->setFlashdata("error", "Product cannot be inserted due to technical reason.!");
                return redirect()->to('tablebasic');
            }


            // if ($num != null) {
            //     $userModel = new categoriesModel();
            //     $delete = [
            //         "id" => $num
            //     ];
            //     if ($userModel->delete($delete)) {
            //         $session->setFlashdata("success", "Data Deleted Successfully..!");
            //         return redirect()->to('tablebasic');
            //     } else {
            //         $session->setFlashdata("error", "Issues Deleting the data, Please Try again After Sometime..!");
            //         return redirect()->to('tablebasic');
            //     }
            // }
        } else {
            return redirect()->to("/");
        }
    }


    public function addCategory()
    {
        $session = session();
        if ($session->get('username')) {
            $categoriesModel = new categoriesModel();
            $catname = $this->request->getVar()['catname'];
            $catdesc = $this->request->getVar()['catdesc'];
            $catimg = $this->request->getVar()['catimg'];
            $userid = $session->get("user_id");
            if (isset($this->request->getVar()['status'])) {
                $status = 1;
                echo "status set";
            } else {
                echo "status Unset";
                $status = 0;
            }
            $data = [
                "category_name" => $catname,
                "category_desc" => $catdesc,
                "category_img" => $catimg,
                "user_id" => $userid,
                "status" => $status
            ];
            if ($categoriesModel->insert($data)) {

                $session->setFlashdata("success", "<strong>Data Inserted Successfully &#128522;</strong>");
                return redirect()->to('tablebasic');
            } else {
                $session->setFlashdata("error", "Data cannot be inserted due to technical reason.!");
                return redirect()->to('tablebasic');
            }


            // if ($num != null) {
            //     $userModel = new categoriesModel();
            //     $delete = [
            //         "id" => $num
            //     ];
            //     if ($userModel->delete($delete)) {
            //         $session->setFlashdata("success", "Data Deleted Successfully..!");
            //         return redirect()->to('tablebasic');
            //     } else {
            //         $session->setFlashdata("error", "Issues Deleting the data, Please Try again After Sometime..!");
            //         return redirect()->to('tablebasic');
            //     }
            // }
        } else {
            return redirect()->to("/");
        }
    }

    // Delete Single Data from Database 
    public function deleteProduct($num = null)
    {
        $session = session();
        if ($session->get('username')) {
            if ($num != null) {
                $userModel = new productModel();
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
    public function getupdateproductdata()
    {
        $id = $this->request->getVar();
        $session = session();
        //  if ($session->get('username')) {
        $userModel = new productModel();
        $data = $userModel->where($id)->find();
        return json_encode($data);
        //  }
    }

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



    public function gettablecat($num = null)
    {
        $res = $this->db->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '{$num}'");
        $res = $res->getResultArray();
        $res2 = $this->db->query("SELECT * FROM {$num}");
        $res2 = $res2->getResultArray();
        $adminController = new adminController();
        $finalres = $adminController->getIndexedArray($res2);
        // print_r($finalres);
        // echo count($finalres[1]);
        // foreach ($finalres as $finalres) {
        //     for ($i = 0; $i < count($finalres); $i++) {
        //         echo $finalres[$i];
        //         echo "<br>";
        //     }
        //     echo "------------------------------<br>";
        // }
        // die();
        return view('tablecat', ['tablehead' => $res, 'finalres' => $finalres]);
        // foreach($res as $res){
        //     echo $res['COLUMN_NAME'];
        //     echo "<br>";
        // }
        // print_r($res);
        // echo $num;

        die();
    }


    public function tablebasic()
    {


        // $db = db_connect();
        $result = $this->db->query('SELECT product.id, product.product_name, product.product_desc, product.product_img, product.product_price ,categories.category_name,product.user_id,product.status,product.created_at FROM `product` JOIN categories ON product.category_id= categories.id');
        $result = $result->getResultArray();
        $categoriesModel = new categoriesModel();
        $productModel = new productModel();
        // $products= $productModel->findAll();
        $category = $categoriesModel->findAll();
        $res = $this->db->query("SELECT TABLE_NAME AS 'TABLES' FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='admin_panel' AND TABLE_NAME LIKE '%_product'");
        $res = $res->getResultArray();
        return view('tables-basic', ["categories" => $category, "products" => $result, 'tablecat' => $res]);
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
                // var_dump($error);
                // die();
                // var_dump($this->validator->getError('uname'));
                // var_dump($this->validator->getError('password'));
                return view('register-user', $error);
                // die();
            }
        } else {

            return view('register-user');
        }
    }


    public function getalltables()
    {
    }
}
