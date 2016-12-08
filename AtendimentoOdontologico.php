<?php 

final class AtendimentoOdontologico implements iFicha {

	/**
	 * Regras de validação contidas em Validate
	 * @return array Regras
	 */
	public static function validateRules() {
		return array('numProntuario', 'cnsCidadao', 'dtNascimento',);
	}

}
