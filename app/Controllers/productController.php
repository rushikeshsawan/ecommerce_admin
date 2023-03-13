<?php

namespace App\Controllers;

use App\Models\adminModel;
use App\Models\categoriesModel;
use App\Models\productModel;

class productController extends BaseController
{
    public $db;
    public function __construct()
    {
        $this->db = db_connect();
    }



    public function editProduct()
    {
        $productModel = new productModel();
        $session = session();
            if (isset($this->request->getVar()['status'])) {
                $status = 1;
            } else {
                $status = 0;
            }
            $val = [
                'productname' => 'required',
                'productid' => 'required|is_not_unique[product.id]',
                'productimg' => 'required|valid_url',
                'productdesc' => 'required',
                'productprice' => 'required',
                'stars'=>'required',
                'productcatid' => 'required|is_not_unique[categories.id]'
            ];

            if ($this->validate($val)) {
                $productname = $this->request->getVar()['productname'];
                $productid = $this->request->getVar()['productid'];
                $productimg = $this->request->getVar()['productimg'];
                $productdesc = $this->request->getVar()['productdesc'];
                $productprice = $this->request->getVar()['productprice'];
                $productcatid = $this->request->getVar()['productcatid'];
                $rating= $this->request->getVar()['stars'];

                $data = [
                    "product_name" => $productname,
                    "product_desc" => $productdesc,
                    "product_img" => $productimg,
                    "product_price" => $productprice,
                    "category_id" => $productcatid,
                    "status" => $status,
                    "rating"=>$rating
                ];
                if ($productModel->update($productid, $data)) {
                    $session->setFlashdata("success", "<strong>Data Updated Successfully &#128522;</strong>");
                    return redirect()->to('tablebasic');
                } else {
                    $session->setFlashdata("error", "Data cant update due to technical reason.!");
                    return redirect()->to('tablebasic');
                }
            } else {
                $session->setFlashdata("error", "Data cant update due to Invalid Data.!");
                return redirect()->to('tablebasic');
            }
       
    }

    public function addProduct()
    {
        $session = session();

            $val = [
                'productname' => 'required',
                'productdesc' => 'required',
                'productimg' => 'required',
                'productprice' => 'required',
                'catid' => 'required|is_not_unique[categories.id]',
                'stars'=>'required'
            ];
            if ($this->validate($val)) {
                $productModel = new productModel();
                $productname = $this->request->getVar()['productname'];
                $productdesc = $this->request->getVar()['productdesc'];
                $productimg = $this->request->getVar()['productimg'];
                $productprice = $this->request->getVar()['productprice'];
                $catid = $this->request->getVar()['catid'];
                $userid = $session->get("user_id");
                $rating= $this->request->getVar()['stars'];
                if (isset($this->request->getVar()['status'])) {
                    $status = 1;
                } else {
                    $status = 0;
                }
                $data = [
                    "product_name" => $productname,
                    "product_desc" => $productdesc,
                    "product_img" => $productimg,
                    "product_price" => $productprice,
                    "category_id" => $catid,
                    "user_id" => $userid,
                    "status" => $status,
                    "rating"=>$rating
                ];
                if ($productModel->insert($data)) {

                    $session->setFlashdata("success", "<strong>Product Inserted Successfully &#128522;</strong>");
                    return redirect()->to('tablebasic');
                } else {
                    $session->setFlashdata("error", "Product cannot be inserted due to technical reason.!");
                    return redirect()->to('tablebasic');
                }
            } else {
                $session->setFlashdata("error", "Product cannot be inserted due to Invalid data.!");
                return redirect()->to('tablebasic');
            }
        
    }



    // Delete Single Data from Database 
    public function deleteProduct($num = null)
    {
        $session = session();

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
       
    }




    public function getupdateproductdata()
    {
        $id = $this->request->getVar();
        $session = session();
            $userModel = new productModel();
            $data = $userModel->where($id)->find();
            return json_encode($data);
        
    }
}
