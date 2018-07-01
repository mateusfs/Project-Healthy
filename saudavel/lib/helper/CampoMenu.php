<?php
class CampoMenu {

	protected $arrMenu;

	function __construct($arrMenu = array()) {
		$this->arrMenu = $arrMenu;
	}

	private function montaAtributosLink($arr) {

		$attr = "";
		foreach ($arr as $k=>$v) {
			$attr.= $k."='".$v."' ";
		}

		return $attr;
	}

	public function toHTML() {

		/* EXEMPLOS
		 *
		 * ---Subníveis
		 * $arrMenu['Cadastros']['Categoria Promoção'] = array('href'=> 'categoria_promocao', 'onclick'=>'alert(1)');
		 * $arrMenu['Cadastros']['Parceiro'] = array('href'=> 'categoria_promocao');
		 * $arrMenu['Relatorio']['Cidade'] = array('href'=> 'cidade', 'target'=> 'conteudo');
		 *
		 * ---Menu direto
		 * $arrMenu['Sair'] = array('href'=> 'login/delete');
		 */

		$menu = "<ul id='cssdropdown'>";
		foreach ($this->arrMenu as $kMenu=>$vMenu) {
			$menu.= "<li class='headlink'>";

			if (is_array(current($vMenu))) {
				$menu.= "<a href='jcmsw'>".$kMenu."<img alt='jcmsw' src='../web/img/setinha.gif'/></a><ul>";

				foreach ($vMenu as $kLink=>$vLink) {
					$menu.= "<li><a ".$this->montaAtributosLink($vLink).">".$kLink."</a></li>";
				}

				$menu.= "</ul>";
			} else {
				$menu.= "<a ".$this->montaAtributosLink($vMenu).">".$kMenu."</a>";
			}

			$menu.= "</li>";
		}
		$menu.= "</ul>";

		echo $menu;

	}

}