<?php
class indexController extends Security {

	public function index() {
		
 		$produtos = Produto::retrieveAll();
		
 		$this->saud->produtos = $produtos;
		$this->saud->show("index");
	}
}