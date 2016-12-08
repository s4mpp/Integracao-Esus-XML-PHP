<?php 

final class AtendimentoIndividual implements iFicha {

	/**
	 * Regras de validação contidas em Validate
	 * @return array Regras
	 */
	public static function validateRules() {
		return array('cnesDadoSerializado', 'codibge', 'ineDadoSerializado', 'numeroProntuario', 'cns', 'dataNascimento', 'sexo', 'turno');
	}

	/**
	 * Gera o XML da ficha
	 * @param  string   $folder		Diretorio onde estao os modelos XML
	 * @param  object   $r			registro a ser gravado na ficha
	 * @return string 				XML montado
	 */
	public function getXml($folder, $r) {
		
		// Criando um elemento raiz vazio
		$xml = simplexml_load_file($folder.'/examples/Atendimento_Individual.esus.xml');

		$xml->tipoDadoSerializado = $r->tipoDadoSerializado;
		$xml->codIbge = $r->codIbge;
		$xml->cnesDadoSerializado = $r->cnesDadoSerializado;
		$xml->ineDadoSerializado = $r->ineDadoSerializado;
		$xml->numLote = $r->numLote;

		//fichaAtendimentoIndividualMasterTransport
		$xml->fichaAtendimentoIndividualMasterTransport = $xml->xpath('//ns4:fichaAtendimentoIndividualMasterTransport')[0];
		
		//lotacaoFormPrincipal
		$headerTransport = $xml->fichaAtendimentoIndividualMasterTransport->headerTranspo$r->headerTransport;
		$headerTransport->lotacaoFormPrincipal->cboCodigo_2002 = $r->cboCodigo_2002;
		$headerTransport->lotacaoFormPrincipal->cnes = $r->cnes;
		$headerTransport->lotacaoFormPrincipal->ine = $r->ine;

		//lotacaoFormAtendimentoCompartilhado
		$headerTransport->lotacaoFormAtendimentoCompartilhado->ine = $r->ine;
		$headerTransport->lotacaoFormAtendimentoCompartilhado->cboCodigo_2002 = $r->cboCodigo_2002;
		$headerTransport->lotacaoFormAtendimentoCompartilhado->cnes = $r->cnes;
		$headerTransport->lotacaoFormAtendimentoCompartilhado->ine = $r->ine;

		//Atendimento
		$headerTransport->dataAtendimento = $r->dataAtendimento;
		$headerTransport->codigoIbgeMunicipio = $r->codigoIbgeMunicipio;

		//atendimentosIndividuais
		$atendimentosIndividuais = $xml->fichaAtendimentoIndividualMasterTransport->atendimentosIndividuais;
		$atendimentosIndividuais->numeroProntuario = $r->numeroProntuario;
		$atendimentosIndividuais->cns = $r->cns;
		$atendimentosIndividuais->dataNascimento = $r->dataNascimento;
		$atendimentosIndividuais->localDeAtendimento = $r->localDeAtendimento;
		$atendimentosIndividuais->sexo = $r->sexo;
		$atendimentosIndividuais->turno = $r->turno;
		$atendimentosIndividuais->tipoAtendimento = $r->tipoAtendimento;
		$atendimentosIndividuais->pesoAcompanhamentoNutricional = $r->pesoAcompanhamentoNutricional;
		$atendimentosIndividuais->alturaAcompanhamentoNutricional = $r->alturaAcompanhamentoNutricional;
		$atendimentosIndividuais->atencaoDomiciliarModalidade = $r->atencaoDomiciliarModalidade;
		$atendimentosIndividuais->problemaCondicaoAvaliada = $r->problemaCondicaoAvaliada;
		$atendimentosIndividuais->examesSolicitados = $r->examesSolicitados;
		$atendimentosIndividuais->outrosSia = $r->outrosSia;
		$atendimentosIndividuais->vacinaEmDia = $r->vacinaEmDia;
		$atendimentosIndividuais->ficouEmObservacao = $r->ficouEmObservacao;
		$atendimentosIndividuais->nasfs = $r->nasfs;
		$atendimentosIndividuais->condutas = $r->condutas;
		$atendimentosIndividuais->condutas = $r->condutas;
		$atendimentosIndividuais->stGravidezPlanejada = $r->stGravidezPlanejada;
		$atendimentosIndividuais->nuGestasPrevias = $r->nuGestasPrevias;
		$atendimentosIndividuais->nuPartos = $r->nuPartos;
		$atendimentosIndividuais->racionalidadeSaude = $r->racionalidadeSaude;
		$atendimentosIndividuais->perimetroCefalico = $r->perimetroCefalico;

		//ficha
		$xml->tpCdsOrigem = $r->tpCdsOrigem;
		$xml->uuidFicha = $r->uuidFicha;

		//remetente
		$remetente = $xml->xpath('//ns4:remetente')[0];
		$remetente->contraChave = $r->contraChave;
		$remetente->uuidInstalacao = $r->uuidInstalacao;
		$remetente->cpfOuCnpj = $r->cpfOuCnpj;
		$remetente->nomeOuRazaoSocial = $r->nomeOuRazaoSocial;
		$remetente->versaoSistema = $r->versaoSistema;
		$remetente->nomeBancoDados = $r->nomeBancoDados;

		//originadora
		$remetente = $xml->xpath('//ns4:remetente')[0];
		$remetente->contraChave = $r->contraChave;
		$remetente->uuidInstalacao = $r->uuidInstalacao;
		$remetente->cpfOuCnpj = $r->cpfOuCnpj;
		$remetente->nomeOuRazaoSocial = $r->nomeOuRazaoSocial;
		$remetente->versaoSistema = $r->versaoSistema;
		$remetente->nomeBancoDados = $r->nomeBancoDados;

		//Retorna o XML criado
		return $xml->asXML();
		
	}

}
