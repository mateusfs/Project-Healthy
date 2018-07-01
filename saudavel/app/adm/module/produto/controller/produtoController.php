<?php
class produtoController extends SecurityAdmin {
	
	public function index() {
		$idProduto = $_POST ["idProduto"];
		if ($idProduto) {
			$produto = Produto::retrieveByPk ( $idProduto );
			$this->view->produto = $produto;
		}
		$this->saud->show ( "index" );
	}
}