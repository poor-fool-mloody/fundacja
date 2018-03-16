<?php
/**
 * Created by PhpStorm.
 * User: Tomcio
 * Date: 2017-12-05
 * Time: 18:44
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Admin extends CI_Controller
{
    public function __construct() {
        parent::__construct();

        session_start();

        $this->load->model('admin_model');
        $this->load->model('amount_model');
        $this->load->model('products_model');
        $this->load->model('prices_model');
        $this->load->model('photos_model');

        //Logowanie
        $this->load->library('logging');

		

        if( !isset($_SESSION['isLogin']) || $_SESSION['isLogin'] !== true ){
            redirect(base_url().'index.php/login/', 'refresh');
        }

    }


    public function index(){
        $data['title'] = "Admin - Lista produktów";
        $data['amount'] = $this->amount_model->getAmount();
        $data['products'] = $this->products_model->getAll();
		$data['photo'] = $this->photos_model->getActivePhoto();

        //Dopisywanie maksymalnej oferty do produktu
        foreach($data['products'] as $index => $prod){
            $max_price = $this->prices_model->getMaxPrice($prod['id']);
            $data['products'][$index]['max_price'] = $max_price;
        }

        $this->load->view('header', $data);
        $this->load->view('admin/nav_bar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('footer');
    }

    public function register($login = null, $password = null){
        if($login === null && $password === null)
            show_404();

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $isUser = $this->admin_model->getUserId($login);
        if($isUser === null) {
            echo $this->admin_model->addUser($login, $hash) == 1 ? "Dodano użytkownika pomyślnie" : "Błąd dodawania";

            //Logowanie
            $logger = $this->logging->get_logger('info');
            $logger->info('Rejestracja nowego użytkownika: ' . $login . ' przez: ' . $_SESSION['adminLogin']);
        }
        else{
            echo 'Użytkownik już istnieje!';
        }

        echo '<br><a href="' . base_url() . '">Powrót do listy produktów</a>';
    }

    public function logout(){
        session_destroy();
        redirect(base_url().'index.php/login/', 'refresh');
    }

    public function addPrice($id = null){
        if($id === null)
            show_404();

        $this->load->library('form_validation');

        //Ustawianie wymaganych pół formularzy
        $this->form_validation->set_rules('bidder_id', 'Numer licytującego', 'required|numeric');
        $this->form_validation->set_rules('price', 'Kwota', 'required|numeric');

        //Jeżeli wprowadzono poprawne dane
        if ($this->form_validation->run() === true){
            $bidder_id = $this->input->post('bidder_id');
            $price = $this->input->post('price');

            $price = $this->validatePrice($price);

            //Czy kwota większa od maksymalnej
            if ($price > $this->prices_model->getMaxPrice($id)){
                //Dodaj
                $this->prices_model->addPrice($id, $bidder_id, $price);

                //Aktualizuj 'amounts'
                $this->amount_model->setAmount();

                //Logowanie
                $logger = $this->logging->get_logger('info');
                $logger->info('Dodanie ceny: ' . $price/100 . ' przez: ' . $_SESSION['adminLogin'] . ' dla produktu o id: ' . $id);
            }

        }

        redirect("/admin/product/$id", 'refresh');
    }

    public function product($id = null){
        if ($id === null)
            show_404();

        $this->load->helper('form');

        $data['title'] = "Admin - Opis produktu";
        $data['amount'] = $this->amount_model->getAmount();
        $data['product'] = $this->products_model->getById($id);
        $data['prices'] = $this->prices_model->getPrices($id);
        $data['max_price'] = $this->prices_model->getMaxPrice($id);
		$data['photo'] = $this->photos_model->getActivePhoto();


        $this->load->view('header', $data);
        $this->load->view('admin/nav_bar', $data);
        $this->load->view('admin/product', $data);
        $this->load->view('footer');
    }

    public function addProduct(){
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = "Admin - dodaj produkt";
        $data['amount'] = $this->amount_model->getAmount();
		$data['photo'] = $this->photos_model->getActivePhoto();


        //Ustawianie wymaganych pół formularzy
        $this->form_validation->set_rules('product_name', 'Nazwa produktu', 'required');

        //Jeżeli wprowadzono poprawne dane
        if ($this->form_validation->run() === true){
            $product_name = $this->input->post('product_name');

            $this->products_model->add($product_name);

			$productId = $this->products_model->getIdByName($product_name);
			
            //Logowanie
            $logger = $this->logging->get_logger('info');
            $logger->info('Dodanie nowego produktu: ' . $product_name . ' przez: ' . $_SESSION['adminLogin'] . ' id: ' . $productId);

            redirect("/admin/", 'refresh');
        }


        else {
            $this->load->view('header', $data);
            $this->load->view('admin/nav_bar', $data);
            $this->load->view('admin/add', $data);
            $this->load->view('footer');
        }

    }

    public function deleteProduct($id = null){
        if($id === null)
            show_404();

		$productName = $this->products_model->getById($id)['name'];
        
		$this->products_model->delete($id);
		
        //Logowanie
        $logger = $this->logging->get_logger('info');
        $logger->info('Usuwanie produktu: ' . $productName .' o id: ' . $id .' przez: ' . $_SESSION['adminLogin']);

        redirect("/admin/", 'refresh');
    }

    public function editProduct($id = null){
        if($id === null)
            show_404();

        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = "Admin - edytuj produkt";
        $data['max_price'] = $this->prices_model->getMaxPrice($id);
        $data['amount'] = $this->amount_model->getAmount();
        $data['product'] = $this->products_model->getById($id);
        $data['prices'] = $this->prices_model->getPrices($id);
		$data['photo'] = $this->photos_model->getActivePhoto();


        //Ustawianie wymaganych pół formularzy
        $this->form_validation->set_rules('product_name', 'Nazwa produktu', 'required');

        //Jeżeli wprowadzono poprawne dane
        if ($this->form_validation->run() === true){
            $product_name = $this->input->post('product_name');

            $this->products_model->edit($id, $product_name);

            //Logowanie
            $logger = $this->logging->get_logger('info');
            $logger->info('Edycja produktu o id: ' . $id .' przez: ' . $_SESSION['adminLogin'] . ' nowa nazwa: ' . $product_name);

            redirect("/admin/product/".$id, 'refresh');
        }

        else {
            $this->load->view('header', $data);
            $this->load->view('admin/nav_bar', $data);
            $this->load->view('admin/edit_product', $data);
            $this->load->view('footer');
        }
    }

    /**
     * @param $productId - Id produktu do którego należy rekord licytacji - używany po przekierowania!
     */
    public function editBid($productId = null){
        if($productId === null)
            show_404();

        $this->load->helper('form');
        $this->load->library('form_validation');

        //Ustawianie wymaganych pół formularzy
        $this->form_validation->set_rules('bidder_id', 'Id licytującego', 'required|numeric');
        $this->form_validation->set_rules('price', 'Cena licytacji', 'required|numeric');
        $this->form_validation->set_rules('id', 'Id rekordu licytacji (ukryte)', 'required|numeric');

        if ($this->form_validation->run() === true) {
            $id = $this->input->post('id');
            $new_price = $this->input->post('price');
            $new_bidder_id = $this->input->post('bidder_id');

            $new_price = $this->validatePrice($new_price);

            $this->prices_model->editPrice($id, $new_bidder_id, $new_price);

            //Logowanie
            $logger = $this->logging->get_logger('info');
            $logger->info('Edycja kwoty produktu o id: ' . $productId .' przez: ' . $_SESSION['adminLogin'] .
                            ' Nowe id licytującego: ' . $new_bidder_id . ' | Nowa cena: ' . $new_price/100 . ' | Id rekordu licytacji: ' . $id);

            redirect("/admin/product/" . $productId, 'refresh');
        } else{
            http_response_code(400);
        }

    }

    public function deleteBid($bidId = null, $prodId = null){
        if($bidId === null || $prodId === null)
            show_404();

		$price = $this->prices_model->getPrice($bidId);
        $this->prices_model->deletePrice($bidId);

        //Logowanie
        $logger = $this->logging->get_logger('info');
        $logger->info('Usuwanie kwoty produktu o id: ' . $prodId .' przez: ' . $_SESSION['adminLogin'] . ' | Id rekordu licytacji: ' . $bidId . ' | Kwota usunięta: ' . $price/100);

        redirect("/admin/editproduct/".$prodId, 'refresh');
    }

    private function validatePrice($price){
        if(strpos($price, '.') === false)
            $price = $price . '.00';
        elseif (strpos($price, '.') === strlen($price) - 2)
            $price = $price . '0';
        elseif (strpos($price, '.') < strlen($price) - 3){
            $price = substr($price, 0, strpos($price, '.') + 3);
            echo 'dd';
        }

        $price = str_replace('.', '', $price);
        $price = intval($price);

        return $price;
    }

}