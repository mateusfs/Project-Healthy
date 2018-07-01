<?php
class CampoAjax
{
	private $conteudo;

    function __construct($url, $target, $param = '', $callback = '') {

		$this->conteudo = "<script type='text/javascript'>
			loadPage(\"{$url}\", \"{$target}\", \"{$param}\", \"{$callback}\");
		</script>";
    }

    public function toHTML() {
        return $this->conteudo;
    }
}
?>
