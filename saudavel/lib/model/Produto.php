<?php
class Produto extends BaseProduto {

	public static function retrieveAll() {

		$sqlParam = array();

		$db = Database::getInstance();
		
		$sql = "SELECT * FROM PRODUTO " ;
		
		try{
			$result = $db->query($sql, $sqlParam);

			if (is_null($result)) {
				return null;
			} else {

				$retorno = array();
				foreach($result as $r){
					$obj = new Produto();
					$obj->hydrate($r);

					$retorno[] = $obj;
				}


				return $retorno;
			}

		} catch (PDOException $e) {
			throw new PDOException($e->getMessage());
		}
	}

}