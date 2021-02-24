<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;

class Product extends ResourceController
{
    use ResponseTrait;
    //get all product
    public function index(){
        $model = new ProductModel();
        $data['products'] = $model -> orderBy('_id','DESC')->findAll();
        return $this->respond($data);
    }
    //get product by id
    public function getProduct($id = null){
        $model = new ProductModel();
        $data = $model->where('_id',$id)->first();
        if($data){
            return $this->respond($data);
        }
        else{
            return $this->failNotFound('No product found');
        }
    }
    //create new Product
    public function create(){
        $model = new ProductModel();
        $data = [
            'name'=>$this->request->getVar('name'),
            'category'=>$this->request->getVar('category'),
            'price'=>$this->request->getVar('price'),
            'tags'=>$this->request->getVar('tags')
        ];
        $model->insert($data);
        $response =[
            'status' => 201,
            'error' => null,
            'message' => 'Product created successfully'
        ];
        return $this->respond($response);
    }
    //update product
    public function update($id = null){
        $model = new ProductModel();
        $data = [
            'name' => $this->request-> getVar('name'),
            'category' => $this->request -> getVar('category'),
            'price' => $this->request -> getVar('price'),
            'tags' => $this->request -> getVar('tags')
        ];
        //$mosel->where('_id',$id)->set($data)->update();
        $model->update($id,$data);
        $response =[
            'status' => 201,
            'error' => null,
            'message' => 'Product update successfully'
        ];
        return $this->respond($response);
    }
    //delete
    public function delete($id=null){
        $model = new ProductModel();
        //$data = $model->where('_id',$id)->delete($id);
        $data = $model->find($id);
        if($data){
            $model->delete($id);
            $response =[
                'status' => 201,
                'error' => null,
                'message' => ['Product delete successfully']
            ];
            return $this->respond($response);
        }
        else{
            return $this->failNotFound("No product found");
        }
    }
}