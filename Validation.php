<?php 

class Validation {

	/**
	 * Armazena um erro encontrado.
	 * @var array
	 */
	private $errorMessage;


	/**
	 * Retorna um erro encontrado
	 * @return string Mensagem de erro
	 */
	public function getErrorMessage() {
		return $this->errorMessage;
	}

	/**
	 * Retorna o valor de um erro encontrado
	 * @return string Conteudo do campo
	 */
	public function getErrorField() {
		return $this->errorValue;
	}

	/**
	 * Faz a validação da ficha
	 * @param  object  $ficha 		Representa uma ficha a ser validada
	 * @param  object  $tipoFicha 	Classe da ficha
	 * @return boolean 				Resultado do teste
	 */
	public function validate($ficha, iFicha $tipoFicha) {

		//Obtem as regras de validação
		$rules = $tipoFicha::validateRules();

		/**
		 * Percorre os campos para a validação.
		 * Caso encontre erros, armazena em $this->errors e retorna false.
		 */
		foreach($ficha as $field => $key) {

			//Verifica se existe a validação pro campo atual
			if(in_array($field, $rules)) {

				$result = $this->$field($ficha->$field);

				//Se retornar algum erro, mostra-o na tela
				if(is_string($result)) {
					$this->errorMessage = $result;
					$this->errorValue = (empty($ficha->$field)) ? 'vazio' : $ficha->$field;

					//Retorna false
					return false;
				}
			}
		}

		//Retorna true se nao encontrar nenhum erro
		return true;
	}


	/************************************************************************
	 * 
	 * VALIDAÇÕES
	 *
	 ************************************************************************/


	/**
	 * Verifica se CNES informado é válido
	 * @param  int $val 	Valor informado
	 * @return bool 		Válido ou não
	 */	
	public function cnesDadoSerializado($val) {

		//Retorna true se for numerico e o tamanho igual a 7
		if(!is_numeric($val) || strlen($val) != 7) {

			//Cria mensagem de erro
			return 'cnesDadoSerializado inválido';
		}

	}
	
	/**
	 * Verifica se o numero do prontuário é válido
	 * @param  int $val 	Valor informado
	 * @return bool 		Válido ou não
	 */	
	public function codibge($val) {

		//Retorna true se for numerico e o tamanho igual a 7
		if(!is_numeric($val) || strlen($val) != 7) {

			//Cria mensagem de erro
			return 'codibge inválido';
		}

	}
	
	/**
	 * Verifica se o numero do prontuário é válido
	 * @param  int $val 	Valor informado
	 * @return bool 		Válido ou não
	 */	
	public function ineDadoSerializado($val) {
		//Retorna true se for vazio ou numerico e o tamanho igual a 10. Este campo nao é obrigatorio
		if(!empty($val) && strlen($val) != 10) {

			//Cria mensagem de erro
			return 'ineDadoSerializado inválido';
		}

	}

	/**
	 * Verifica se o numero do prontuário é válido
	 * @param  int $val 	Valor informado
	 * @return bool 		Válido ou não
	 */	
	public function numeroProntuario($val) {

		//Retorna se foi informado, se é menor/igual a 30 ou se é numerico. Este campo nao é obrigatorio
		if(!empty($val) && (strlen($val) > 30 || !is_numeric($val))) {

			//Cria mensagem de erro
			return 'numeroProntuario inválido';
		}

	}

	/**
	 * Verifica se a data de nascimento é válida
	 * @param  int $val 	Valor informado
	 * @return bool 		Válido ou não
	 */	
	public function dataNascimento($val) {

		//Retorna true se existir o valor, se for em formato timestamp, se form menor/igual a data atual e nao for anterior a 129 anos.
		if(($val && !strtotime($val)) && 
				(strtotime($val) <= strtotime(date('Y-m-d'))) &&
				(date('Y') - date('Y', strtotime($val)) > 130)) {

			//Cria mensagem de erro
			return 'dataNascimento inválido';
		}
	}

	/**
	 * Verifica se o sexo do paciente é válido
	 * @param  int $val 	Valor informado
	 * @return bool 		Válido ou não
	 */	
	public function sexo($val) {

		//Retorna true se for igual a F ou M
		if(!$val != 1 && !$val != 0) {

			//Cria mensagem de erro
			return 'sexo inválido';
		}

	}

	/**
	 * Verifica se existe ou foi informado a nº do prontuário
	 * @param  int $val 	Valor informado
	 * @return bool 		Válido ou não
	 */	
	public function turno($val) {
		//Retorna se o turno é válido
		if(!$val == 'M' && !$val == 'T' && !$val == 'N') {

			//Cria mensagem de erro
			return 'turno inválido';
		}

	}

	
	/**
	 * Verifica se existe ou foi informado a nº do prontuário
	 * @param  int $val 	Valor informado
	 * @return bool 		Válido ou não
	 */	
	public function numProntuário($val) {

		if(!$this->numeroProntuario($val)) {

			//Cria mensagem de erro
			return 'numProntuário inválido';
		}

	}
	
	/**
	 * Verifica se existe ou foi informado o cns do cidadao
	 * @param  int $val 	Valor informado
	 * @return bool 		Válido ou não
	 */
	public function cnsCidadao($val) {

		//Chama a validação do cns
		if(!$this->validaCNS($val)) {

			//Cria mensagem de erro
			return 'cnsCidadao inválido';
		}

	}

	/**
	 * Verifica se existe ou foi informado o cns do cidadao
	 * @param  int $val 	Valor informado
	 * @return bool 		Válido ou não
	 */
	public function cns($val) {

		//Chama a validação do cns
		if(!$this->validaCNS($val)) {

			//Cria mensagem de erro
			return 'cns inválido';
		}

	}
	
	/**
	 * Verifica se existe ou foi informado a microarea
	 * @param  int $val 	Valor informado
	 * @return bool 		Válido ou não
	 */
	public function dtNascimento($val) {

		//Chama a validação da data de nascimento
		if(!$this->dataNascimento($val)) {

			//Cria mensagem de erro
			return 'dtNascimento inválido';
		}

	}
	
	/**
	 * Verifica se existe ou foi informado a microarea
	 * @param  int $val 	Valor informado
	 * @return bool 		Válido ou não
	 */
	public function procedimentos($val) {

		//Valida o procedimento
		if(!$this->validaProcedimento($val)) {

			//Cria mensagem de erro
			return 'procedimentos inválido';
		}

	}
	
	/**
	 * Verifica se existe ou foi informado a microarea
	 * @param  int $val 	Valor informado
	 * @return bool 		Válido ou não
	 */
	public function microarea($val) {

		if(empty($val)) {

			//Cria mensagem de erro
			return 'microarea inválido';
		}

	}
	
	/**
	 * Verifica se existe ou foi informado o desfecho
	 * @param  int $val 	Valor informado
	 * @return bool 		Válido ou não
	 */
	public function desfecho($val) {

		if(empty($val)) {

			//Cria mensagem de erro
			return 'desfecho inválido';
		}

	}
	
	/**
	 * Verifica se existe ou foi informado o tipo de imóvel
	 * @param  int $val 	Valor informado
	 * @return bool 		Válido ou não
	 */
	public function tipoDeImovel($val) {

		if(empty($val)) {

			//Cria mensagem de erro
			return 'tipoDeImovel inválido';
		}

	}
	
	/**
	 * Valida o tipo de atendimento
	 * @param  string $val 	Código do atendimento
	 * @return bool 		Válido ou não
	 */
	public function tipoAtendimento($val) {

		//Verifica se o código é aceito
		if($val != 2 && $val != 4 && $val != 5 && $val != 6) {

			//Cria mensagem de erro
			return 'tipoAtendimento inválido';
		}

	}
	

	/************************************************************************
	 * 
	 * MÉTODOS AUXILIARES
	 *
	 ************************************************************************/

	/**
	 * Valida o tipo de procedimento
	 * @param  string $val 	Código do procedimento
	 * @return bool 		Válido ou não
	 */
	private function validaProcedimento($val) {
		$codProc = array('ABPG001', 'ABPG002', 'ABPG003', 'ABPG004', 'ABPG005', 'ABPG006', 'ABPG007', 'ABPG008', 'ABEX004', 'ABPG010', 'ABPG011', 'ABPG012', 'ABPG013', 'ABPG014', 'ABPG015', 'ABPG016', 'ABPG017', 'ABPG018', 'ABPG019', 'ABPG020', 'ABPG021', 'ABPG022', 'ABPG040', 'ABPG024', 'ABPG025', 'ABPG026', 'ABPG027', 'ABPG028', 'ABPG029', 'ABPG030', 'ABPG031', 'ABPG032', 'ABPG041');

		//Retorna se estiver ou nao no array acima
		return(in_array($val, $codProc));
	}


	/**
	 * Verifica o final do cartão do sus (1/2 ou 7/8/9) e chama a validação correspondente
	 * @param  string	 $cns 	Numero do cartao com 15 digitos
	 * @return bool 			Válido ou não
	 */	
	protected function validaCNS($cns) {

		//Verifica o tamanho
		if ((strlen($cns)) != 15) {
			return false;
		}

		//Verifica o ultimo digito
		$prim_dig = substr($cns, 0, 1);

		//Faz a valiadação se for inicio 1 ou 2
		if(in_array($prim_dig, array(1,2))) {
			
			return ($this->validCNSInicio12($cns)) ? $cns : false;

		//Faz a validação se o inicio for 7, 8, ou 9
		} else if(in_array($prim_dig, array(7,8,9))) {
			
			return ($this->validCNSInicio789($cns)) ? $cns : false;

		} else {
			return false;
		}

	}

	/**
	 * Valida o cartao do sus
	 * @param  string	 $cns 	Numero do cartao com inicio 1 ou 2
	 * @return bool 			Válido ou não
	 */	
	private function validCNSInicio12($cns) {

		$pis = substr($cns,0,11);
		$soma = (((substr($pis, 0,1)) * 15) +
				 ((substr($pis, 1,1)) * 14) +
				 ((substr($pis, 2,1)) * 13) +
				 ((substr($pis, 3,1)) * 12) +
				 ((substr($pis, 4,1)) * 11) +
				 ((substr($pis, 5,1)) * 10) +
				 ((substr($pis, 6,1)) * 9) +
				 ((substr($pis, 7,1)) * 8) +
				 ((substr($pis, 8,1)) * 7) +
				 ((substr($pis, 9,1)) * 6) +
				 ((substr($pis, 10,1)) * 5));
		$resto = fmod($soma, 11);
		$dv = 11  - $resto;
		if ($dv == 11) { 
			$dv = 0;    
		}
		if ($dv == 10) { 
			$soma = ((((substr($pis, 0,1)) * 15) +
					  ((substr($pis, 1,1)) * 14) +
					  ((substr($pis, 2,1)) * 13) +
					  ((substr($pis, 3,1)) * 12) +
					  ((substr($pis, 4,1)) * 11) +
					  ((substr($pis, 5,1)) * 10) +
					  ((substr($pis, 6,1)) * 9) +
					  ((substr($pis, 7,1)) * 8) +
					  ((substr($pis, 8,1)) * 7) +
					  ((substr($pis, 9,1)) * 6) +
					  ((substr($pis, 10,1)) * 5)) + 2);
			$resto = fmod($soma, 11);
			$dv = 11  - $resto;
			$resultado = $pis."001".$dv;    
		} else { 
			$resultado = $pis."000".$dv;
		}

		return !($cns != $resultado);
	}

	/**
	 * Valida o cartao do sus
	 * @param  string	 $cns 	Numero do CNS com inicio 7, 8 ou 9
	 * @return bool 			Válido ou não
	 */	
	private function validCNSInicio789($cns) {
		$soma = (((substr($cns,0,1)) * 15) +
			((substr($cns,1,1)) * 14) +
			((substr($cns,2,1)) * 13) +
			((substr($cns,3,1)) * 12) +
			((substr($cns,4,1)) * 11) +
			((substr($cns,5,1)) * 10) +
			((substr($cns,6,1)) * 9) +
			((substr($cns,7,1)) * 8) +
			((substr($cns,8,1)) * 7) +
			((substr($cns,9,1)) * 6) +
			((substr($cns,10,1)) * 5) +
			((substr($cns,11,1)) * 4) +
			((substr($cns,12,1)) * 3) +
			((substr($cns,13,1)) * 2) +
			((substr($cns,14,1)) * 1)); 
			$resto = fmod($soma,11);
			
		return !($resto != 0);
	}
}
