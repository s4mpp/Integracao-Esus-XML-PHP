<?php 

final class Procedimentos implements iFicha {

	/**
	 * Regras de validação contidas em Validate
	 * @return array Regras
	 */
	public static function validateRules() {
		return array('numProntuario', 'cnsCidadao', 'dtNascimento', 'sexo', 'turno', 'procedimentos');
	}

}
