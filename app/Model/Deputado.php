<?php
App::uses('AppModel', 'Model');
/**
 * Deputado Model
 *
 */
class Deputado extends AppModel{


    /**
     * Lista todos os deputados federais
     * @return array
     */
    function getDeputadosFederais(){
        try{
            # Lê a página
            $deputadosAux = file('http://www.zanluca.blog.br/deputados-federais.htm', FILE_SKIP_EMPTY_LINES);
            //$deputadosAux = file('files/df.htm', FILE_SKIP_EMPTY_LINES);

            if(!$deputadosAux){
                throw new Exception('Falha ao tentar ler o site.');
            }


            # Remove cabeçalho
            $deputadosAux = array_splice($deputadosAux, 41);


            # Remove todas as tags html exceto os links
            foreach($deputadosAux as $key => $value){
                $deputadosAux[$key] = trim(strip_tags($value, '<a>'));
            }


            # Remove elementos em branco do array
            $deputadosAux = array_filter($deputadosAux);


            # Formata dados dos deputados parcialmente
            foreach($deputadosAux as $key => $value){
                # Captura ID e site página no portal da Camara
                if(strpos($value, 'Detalhes do Deputado')){
                    $sCamera = strtolower(substr($value, 38, 68));
                    $id = end(explode('=', $sCamera));

                    $deputadosAux[$key] = $id;
                    $deputados[$id]['Deputado']['id'] = $id;
                    $deputados[$id]['Deputado']['site_camara'] = $sCamera;

                    # Captura o site pessoal
                }elseif(substr($value, 0, 4) == 'http'){
                    $deputados[$id]['Deputado']['site_pessoal'] = strtolower(str_replace(array('/</a>', '</a>'), '', $value));

                    unset($deputadosAux[$key]);

                    # Captura o endereço de e-mail
                }elseif(substr($value, 0, 4) == 'dep.'){
                    $deputados[$id]['Deputado']['email'] = str_replace('</a>', '', $value);

                    unset($deputadosAux[$key]);

                    # Demais itens
                }else{
                    $deputadosAux[$key] = trim(strip_tags($value));
                }
            }

            # Remove elementos em branco do array
            $deputadosAux = array_filter($deputadosAux);

            # Separa o array por deputados
            $deputadosAux = array_chunk($deputadosAux, 4);
            
            # Recupera o número de matricula de todos os deputados
            $arrMatricula = $this->getMatriculaDeputadosFederais();

            # Monta o array com dados dos deputados formatado
            foreach($deputadosAux as $key => $deputado){
                foreach($deputado as $dado){
                    $id = $deputado[0];
                    $dados1 = explode('/', str_replace(array('Partido/UF: ', ' - Gabinete: ', ' - Anexo:'), '/', $deputado[2]));
                    $dados2 = explode(' - Fax: ', $deputado[3]);

                    $deputados[$id]['Deputado']['nome'] = utf8_encode(ucwords(strtolower($deputado[1])));
                    $deputados[$id]['Deputado']['matricula'] = isset($arrMatricula[$id]) ? $arrMatricula[$id] : '';
                    $deputados[$id]['Deputado']['partido'] = $dados1[1];
                    $deputados[$id]['Deputado']['uf'] = $dados1[2];
                    $deputados[$id]['Deputado']['gabinete'] = $dados1[3];
                    $deputados[$id]['Deputado']['anexo'] = trim(substr($dados2[0], 0, 3));
                    $deputados[$id]['Deputado']['fone'] = substr($dados2[0], -9);
                    $deputados[$id]['Deputado']['fax'] = $dados2[1];
                    $nomeFoto = utf8_encode(strtolower(str_replace(' ', '', $deputado[1])).'.jpg');
                    $deputados[$id]['Deputado']['foto'] = 'http://www.camara.gov.br/internet/deputado/bandep/'.$nomeFoto;
                    $deputados[$id]['Deputado']['site_pessoal'] = isset($deputados[$id]['site_pessoal']) ? $deputados[$id]['site_pessoal'] : '';
                }
            }
        }catch(Exception $e){
            $erros = array('error' => true, 'code' => $e->getCode(), 'message' => $e->getMessage());

            return $erros;
        }

        return $deputados;
    }


    /**
     * Retorna dados de um deputado
     * @param int $id ID do Deputado
     * @return array 
     */
    public function getDeputadoFederal($id){
        $deputados = $this->getDeputadosFederais();

        $deputado = $deputados[$id]['Deputado'];

        return $deputado;
    }

    /**
     * Recupera quantida de presemças e faltas no plenário
     * @param array $params 
     * @return array 
     */
    function getParticipacaoPlenario($params){
        $query = http_build_query($params);
        $submit_url = "http://www.camara.gov.br/internet/deputado/RelPresencaPlenario.asp?$query";

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_URL, $submit_url);

        $faltas_plenario = curl_exec($curl);
        curl_close($curl);


        $faltas = array();

        # qtd
        $posInicial = strpos($faltas_plenario, "<table class=\"tabela-2\">");
        $posMedia = substr($faltas_plenario, $posInicial, 189);
        $qtd = trim(substr($posMedia, -5));
        $faltas['qtd_sessoes'] = $qtd;

        # qtd pres
        $posInicial = strpos($faltas_plenario, "<table class=\"tabela-2\">");
        $posMedia = substr($faltas_plenario, $posInicial, 420);
        $qtd = trim(substr($posMedia, -7));
        $faltas['qtd_presenca'] = $qtd;

        # qtd ausencia
        $posInicial = strpos($faltas_plenario, "<table class=\"tabela-2\">");
        $posMedia = substr($faltas_plenario, $posInicial, 670);
        $qtd = trim(substr($posMedia, -10));
        $faltas['qtd_justificada'] = $qtd;

        # qtd ausencia
        $posInicial = strpos($faltas_plenario, "<table class=\"tabela-2\">");
        $posMedia = substr($faltas_plenario, $posInicial, 930);
        $qtd = trim(substr($posMedia, -7));
        $faltas['qtd_nao_justificada'] = $qtd;

        return $faltas;
    }

    /**
     * Recupera quantida de presemças e faltas nas comissões
     * @param array $params
     * @return array 
     */
    function getParticipacaoComissoes($params){
        $query = http_build_query($params);
        $submit_url = "http://www.camara.gov.br/internet/deputado/RelPresencaComissoes.asp?$query";

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_URL, $submit_url);

        $faltas_plenario = curl_exec($curl);
        curl_close($curl);


        $faltas = array();

        # qtd
        $posInicial = strpos($faltas_plenario, "<table class=\"tabela-2\">");
        $posMedia = substr($faltas_plenario, $posInicial, 143);
        $qtd = trim(substr($posMedia, -3));
        $qtd = str_replace(array('<', '>', '/', 'td'), '', strtolower($qtd));
        $faltas['qtd_sessoes'] = $qtd;

        # qtd pres
        $posInicial = strpos($faltas_plenario, "<table class=\"tabela-2\">");
        $posMedia = substr($faltas_plenario, $posInicial, 260);
        $qtd = trim(substr($posMedia, -10));
        $qtd = str_replace(array('<', '>', '/', 'td'), '', strtolower($qtd));
        $faltas['qtd_presenca'] = intval(trim(strip_tags($qtd)));

        # qtd ausencia justificada
        $posInicial = strpos($faltas_plenario, "<table class=\"tabela-2\">");
        $posMedia = substr($faltas_plenario, $posInicial, 363);
        $qtd = trim(substr($posMedia, -10));
        $qtd = str_replace(array('<', '>', '/', 'td'), '', strtolower($qtd));
        $faltas['qtd_justificada'] = intval(trim(strip_tags($qtd)));

        # qtd escusa
        $posInicial = strpos($faltas_plenario, "<table class=\"tabela-2\">");
        $posMedia = substr($faltas_plenario, $posInicial, 437);
        $qtd = trim(substr($posMedia, -10));
        $qtd = str_replace(array('<', '>', '/', 'td'), '', strtolower($qtd));
        $faltas['qtd_escusa'] = intval(trim(strip_tags($qtd)));

        # qtd ausencia
        $posInicial = strpos($faltas_plenario, "<table class=\"tabela-2\">");
        $posMedia = substr($faltas_plenario, $posInicial, 550);
        $qtd = trim(substr($posMedia, -10));
        $qtd = str_replace(array('<', '>', '/', 'td'), '', strtolower($qtd));
        $faltas['qtd_nao_justificada'] = intval(trim(strip_tags($qtd)));

        return $faltas;
    }
    
    function getMatriculaDeputadosFederais(){
        $url = "http://www2.camara.gov.br/deputados/pesquisa";

        $curl1 = curl_init();

        curl_setopt($curl1, CURLOPT_HEADER, false);
        curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl1, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl1, CURLOPT_URL, $url);

        $resDuputados = curl_exec($curl1);
        curl_close($curl1);

        $pInicial = strpos($resDuputados, "<select id=\"deputado\"");
        $pMedia = substr($resDuputados, $pInicial, 600);
        $arrPage = explode("\n", $resDuputados);
        $arrSelect = array();

        foreach($arrPage as $key => $value){
            $arrSelect[] = trim(strip_tags($value));
        }

        $arrSelect = array_values(array_filter($arrSelect));

        $arrSelect = array_slice($arrSelect, 172, 512);
        
        $arrMatricula = array();
        foreach($arrSelect as $key => $value){
            $arr = explode('%', $value);
            $arr2 = explode('!', trim($arr[1]));

            $vlr = $arr2[0];
            if(strlen($vlr) == 5){
                $arrMatricula[substr($arr[0], -6)] = substr($vlr, -3);
            }else{
                $arrMatricula[substr($arr[0], -6)] = substr($vlr, 2, 2);
            }
        }
        
        return $arrMatricula;
    }
}
