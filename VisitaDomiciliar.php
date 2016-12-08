<?php 

final class VisitaDomiciliar implements iFicha {

	/**
	 * Regras de validação contidas em Validate
	 * @return array Regras
	 */
	public static function validateRules() {
		return array('turno', 'numProntuario', 'cnsCidadao', 'dtNascimento', 'sexo', 'microarea', 'desfecho', 'tipoDeImovel');
	}

}
