<?php

namespace App\Controllers;

use App\Models\categoriesModel;

class categoryController extends BaseController
{
    protected $db;
    protected $session;
    public function __construct()
    {
        $this->db = db_connect();
        $this->session= session();
    }

    public function setupdatecategorydata()
    {
        // print_r($this->request->getVar());
        $categoriesModel = new categoriesModel();
            if (isset($this->request->getVar()['status'])) {
                $status = 1;
            } else {
                $status = 0;
            }
            $val = [
                'category_id' => 'required|is_not_unique[categories.id]',
                'category_name' => 'required',
                'category_desc' => 'required',
                'category_image' => 'required'
            ];
            if ($this->validate($val)) {
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

                    $this->session->setFlashdata("success", "<strong>Data Updated Successfully &#128522;</strong>");
                    return redirect()->to('tablebasic');
                } else {
                    $this->session->setFlashdata("error", "Data cant update due to technical reason.!");
                    return redirect()->to('tablebasic');
                }
            } else {
                $this->session->setFlashdata("error", "Data cant update due to Invalid data.!");
                return redirect()->to('tablebasic');
            }
      
    }



    public function addCategory()
    {
            $categoriesModel = new categoriesModel();

            $val = [
                'catname' => 'required',
                'catdesc' => 'required',
                'catimg' => 'required'
            ];
            if ($this->validate($val)) {
                $catname = $this->request->getVar()['catname'];
                $catdesc = $this->request->getVar()['catdesc'];
                $catimg = $this->request->getVar()['catimg'];
                $userid = $this->session->get("user_id");
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

                    $this->session->setFlashdata("success", "<strong>Data Inserted Successfully &#128522;</strong>");
                    return redirect()->to('tablebasic');
                } else {
                    $this->session->setFlashdata("error", "Data cannot be inserted due to technical reason.!");
                    return redirect()->to('tablebasic');
                }
            } else {
                $this->session->setFlashdata("error", "Data cannot be inserted due to Invalid data.!");
                return redirect()->to('tablebasic');
            }
       
    }


    public function deletecategory($num = null)
    {

            if ($num != null) {
                $userModel = new categoriesModel();
                $delete = [
                    "id" => $num
                ];
                if ($userModel->delete($delete)) {
                    $this->session->setFlashdata("success", "Data Deleted Successfully..!");
                    return redirect()->to('tablebasic');
                } else {
                    $this->session->setFlashdata("error", "Issues Deleting the data, Please Try again After Sometime..!");
                    return redirect()->to('tablebasic');
                }
            }
       
    }


    // Get Data Record To Update Data 
    public function getupdatecategorydata()
    {
        $id = $this->request->getVar();

        $userModel = new categoriesModel();
        $data = $userModel->where($id)->find();
        return json_encode($data);
         
    }
}
