<?php 

require_once 'Validation.php';
require_once 'iFicha.php';
require_once 'AtendimentoIndividual.php';
require_once 'AtendimentoOdontologico.php';
require_once 'CadastroIndividual.php';
require_once 'CadastroDomiciliar.php';
require_once 'Procedimentos.php';
require_once 'VisitaDomiciliar.php';

abstract class Ficha {

	/**
	 * Nome da ficha
	 * @var string
	 */
	private $ficha;

	/**
	 * Pasta de gravação dos arquivos
	 * @var string
	 */
	private $folder = 'esustestes';

	/**
	 * Pasta de modelos de xml
	 * @var string
	 */
	private $folderModels = APPPATH.'/third_party/Esus';

	/**
	 * Array de objetos com os registros a serem exportados
	 * @var array
	 */
	private $registros;
	
	/**
	 * Configura o tipo de ficha
	 * @param string $ficha Nome da ficha
	 */
	public function setFicha($ficha) {
		$this->ficha = $ficha;
	}

	/**
	 * Configura a pasta de geração dos arquivos
	 * @param string $ficha Nome da pasta
	 */
	public function setFolder($folder) {
		$this->folder = $folder;
	}

	/**
	 * COnfigura os registos a serem exportados
	 * @param array $registros Array de registros a serem validados
	 */
	public function setRegistros($registros) {
		$this->registros = $registros;
	}

	/**
	 * Pega os erros recebidos
	 * @return array Array com os erros
	 */
	public function getErrors() {
		return $this->errors;
	}


	/**
	 * Faz uma exportação
	 * @param  [callback]   $callback	Callback para ser chamado em cada ficha
	 * @return object 					Status da gravação
	 */
	public function export($callback = null) {
		
		set_time_limit(0);
		ini_set('memory_limit','256M');

		try {

			//Instancia a classe da ficha
			$ficha = new $this->ficha;

			//Cria o arquivo zip
			$zip = new ZipArchive();
			
			//Cria o nome do arquivo, no formato NomeDoArquivo_d/m/y_His.zip
			$nameFile = ucfirst($this->ficha).'_'.date('dmY_His').'.zip';
			
			//Cria o arquivo
			$file = $zip->open($this->folder.'/'.$nameFile, ZipArchive::CREATE);

			//Verifica se deu erro ao criar o arquivo;
			if(!$file) {
				throw new Exception('Erro ao criar o arquivo. Verifique.');
			}

			//faz um loop entre os registros
			$qtdFichas = 0;
			foreach($this->registros as $registro) {
				
				//Instancia a classe de validação
				$validation = new Validation();

				//Faz a validação
				if($validation->validate($registro, $ficha)) {
					
					//Gera um uuid
					$uuid = $this->getUUID();

					//Se passou na validação
					//Grava a ficha dentro do ZIP
					$zip->addFromString($uuid.'.esus.xml', $ficha->getXml($this->folderModels));

					//Executa um callback para cada iteração na ficha
					if(is_callable($callback)) {
						call_user_func($callback, $registro->id);
					}

					//Incrementa a quantidade de fichas;
					$qtdFichas++;
				} else {
				
					//Se não passou na validação mostra o erro
					echo '<p><strong>Erro:</strong> '.$validation->getErrorMessage().'<br/>
						 <strong>Valor recebido:</strong> '.$validation->getErrorField().'<br/>
						 <strong>Ficha:</strong> #'.$registro->id.'</p>';
				}

			}

			//Fecha o zip
			$zip->close();

			//Verifica se o arquivo foi criado
			if($file) {
				echo 'Arquivo <strong>'.$nameFile.'</strong> gerado com sucesso contendo <strong>'.$qtdFichas.'</strong> fichas.';
			}
		
		} catch(Exception $e) {

			echo 'Erro na exportação: '.$e->getError();

			return false;
		}










	}

	/**
	 * Gera um código de UUID única
	 * @return string  	Hash no formato uuid
	 */
	protected function getUUID() {
		$uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		mt_rand(0, 0xffff), mt_rand(0, 0xffff),
		mt_rand(0, 0xffff),
		mt_rand(0, 0x0fff) | 0x4000,
		mt_rand(0, 0x3fff) | 0x8000,
		mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
		
		return $uuid;
	}
}
