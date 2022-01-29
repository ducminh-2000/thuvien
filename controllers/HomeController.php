<?php
require_once 'controllers/Controller.php';
require_once 'models/sach.php';

class HomeController extends Controller {
  public function index() {
    $sach_model = new Sach();
    $sachs = $sach_model->getSachInHomePage();

    $this->content = $this->render('views/homes/home.php', [
      'sachs' => $sachs
    ]);
    require_once 'views/layouts/main_home.php';
  }
}