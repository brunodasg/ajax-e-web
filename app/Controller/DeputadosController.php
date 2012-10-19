<?php
App::uses('AppController', 'Controller');
/**
 * Campos Controller
 *
 * @property Deputado $Deputado
 */
class DeputadosController extends AppController{


    /**
     * Recupera todos os Deputados Federais
     *
     * @return array
     */
    public function index(){
        $arrDeputados = $this->Deputado->getDeputadosFederais();

        $deputadosFederais = array();
        foreach($arrDeputados as $id => $deputado){
            $deputados[$id] = $deputado['Deputado']['nome'];
            $deputadosFederais[] = $deputado['Deputado'];
        }
		
				
		$this->set(array(
            'deputadosFederais' => $deputadosFederais,
            '_serialize' => array('deputadosFederais')
        ));
		
		$this->set(compact('deputados'));
    }
    
    
    /**
     * Recupera informações de um deputado
     * @param id $id ID do deputado
     * @return void
     */
    public function view($id){
        $deputado = $this->Deputado->getDeputadoFederal($id);
        
		$this->set(array(
            'deputadoFederal' => $deputado,
            '_serialize' => array('deputadoFederal')
        ));
    }
    
    
    /**
     * Recupera informações de um deputado
     * @param id $id ID do deputado
     * @return void
     */
    public function infoDeputado($id){
        $vars['deputado'] = $this->Deputado->getDeputadoFederal($id);

        $this->layout = 'ajax';
        $this->set($vars);
    }


    /**
     * Recupera notícias acerca de um deputado
     * @param id $id ID do deputado
     * @return array
     */
    public function noticias($id){
        $deputado = $this->Deputado->getDeputadoFederal($id);

        $query = 'deputado%20'.str_replace(' ', '%20', strtolower(urlencode($deputado['nome'])));

        $vars['news'] = file_get_contents("https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q=$query");

        $noticias = json_decode($vars['news'], true);
        
        $this->layout = 'ajax';

        $this->set(compact('deputado', 'noticias'));
    }


    /**
     * Recupera tweets acerca de um deputado
     * @param id $id ID do deputado
     * @return array
     */
    public function tweets($id){
        $deputado = $this->Deputado->getDeputadoFederal($id);

        $params = array('q' => strtolower($this->removeCaracteresEspeciais($deputado['nome'])));
        $query = http_build_query($params);
        $vars['tweets'] = file_get_contents("http://search.twitter.com/search.json?$query");

        $tweets = json_decode($vars['tweets'], true);

        $this->layout = 'ajax';

        $this->set(compact('deputado', 'tweets'));
    }


    /**
     * Recupera posts no facebook acerca de um deputado
     * @param id $id ID do deputado
     * @return array
     */
    public function facebook_posts($id){
        $deputado = $this->Deputado->getDeputadoFederal($id);
        
        $params = array('q' => strtolower($this->removeCaracteresEspeciais($deputado['nome'])),
                        'type' => 'post');
        $query = http_build_query($params);

        $posts = file_get_contents("https://graph.facebook.com/search?$query");

        $posts = json_decode($posts, true);

        $this->layout = 'ajax';

        $this->set(compact('deputado', 'posts'));
    }


    /**
     * Recupera posts no facebook acerca de um deputado
     * @param id $id ID do deputado
     * @return array
     */
    public function faltas($id){
        $deputado = $this->Deputado->getDeputadoFederal($id);

        $arrMatricula = $this->Deputado->getMatriculaDeputadosFederais();

        $query = array('nuLegislatura' => 54,
            'dtInicio' => '01/02/2011',
            'dtFim' => date("d/m/Y"),
            'id' => $id,
            'nuMatricula' => $deputado['matricula']);


        $faltas['plenario'] = $this->Deputado->getParticipacaoPlenario($query);
        $faltas['comissoes'] = $this->Deputado->getParticipacaoComissoes($query);
        
        $this->layout = 'ajax';

        $this->set(compact('deputado', 'faltas'));
    }
}
