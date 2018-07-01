<?php

class Sessao extends BaseSessao {

	public static function retrieveByToken($token){

		$sqlParam = array();
		$sqlParam[':TOKEN'] = $token;


		$db = Database::getInstance();
		$sql = "SELECT * FROM SESSAO WHERE TOKEN = :TOKEN " ;
		try{
			$result = $db->queryOne($sql, $sqlParam);

			if (is_null($result)) {
				return null;
			} else {
				$obj = new Sessao();
				$obj->hydrate($result);

				return $obj;
			}

		} catch (PDOException $e) {
			throw new PDOException($e->getMessage());
		}
	}

}