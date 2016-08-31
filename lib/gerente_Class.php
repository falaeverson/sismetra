<?php
/**
 * Esta class é responsavel por compilar os controles, layout e 
 * helpers de exibição  e tambem a aclopação das views 
 * 
 * @ category PhpZom
 * @ package lib
 * @ copyright (c) 2013, Everson Teixeira 
 * @ version 1.0 - gerente_Class.php
 * @ author Everson <falaeverson@gmail.com>
 * 
 */
class gerenteClass {

    /**
     * Configura o arquivo para manipulação
     * @private
     */
    private $arquivo = "";

    /**
     * Configura o titulo do layout de exibição
     * @private 
     */
    private $tiPag = "";

    /**
     * Retorna um array com os diretorios da aplicação
     * @private 
     */
    private $dirArq = array();

    /**
     * Configura a extenção dos arquivos de layout
     * @private 
     */
    private $ext = '.html';

    /**
     * Configura o prefixo das String  de exibição do layout
     * @private 
     */
    private $prFixo = '{';

    /**
     * Configura o sufixo das String  de exibição do layout
     * @private 
     */
    private $suFixo = '}';

    /**
     * Configura o arquivo de linguagem padrão
     * @private 
     */
    private $lng = 'br-pt';

    /**
     * Configura o arquivo de linguagem padrão
     * @private 
     */
    private $setLng = array();

    /**
     * Armazena os dados do layout
     * @private 
     */
    private $tplData;

    /**
     * Armazena os dados dos paineis
     * @private 
     */
    private $pnlData;

    /**
     * Armazena todo o conteudo de um arquivo em uma string
     * @public 
     */
    private $pilha = array();

    /**
     * Para uso dos paineis
     * @private 
     */
    private $painelHtml;
    /**
     * Ao instancia a classe este metodo carrega automaticamente os diretorios reais 
     * da aplicaÃ§Ã£o, carregando tambem os arquivos de linguagem
     * @public 
     */    
    private $my;
    /**
     * Este metodo Ã© responsavel por retornar a as funcÃµes de transaÃ§Ã£o com
     * o banco de dados
     * @return type
     */
    public function dbMysql() 
    {
        $this->my = new mysql_Class();
        return $this->my;
    }
    
    private function diretorios($dir) {
        $this->dirArq = array(
            'layouts' => dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'public',
            'views' => dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'public/views',
            'helpers' => dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'public/helpers',
            'erro' => dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'public/erro',
            'lng' => dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'application/lng/' . config('lng'),
            'app_controllers' => dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'application/controllers',
            'app_views' => dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'application/views',
            'app_models' => dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'application/models'
        );
        return $this->dirArq[$dir];
    }

    /**
     * Retorna a estrutura renderizada da aplicação
     * @private
     */
    private function montLayou() {
        if (file_exists($this->setDiretorios('layouts', "{$this->arquivo}" . $this->ext))):
            $this->Dados = file_get_contents($this->setDiretorios('layouts', "{$this->arquivo}" . $this->ext));
        else:
            $this->Dados = file_get_contents($this->setDiretorios('erro', "{$this->arquivo}" . $this->ext));
        endif;

        $this->Dados = $this->getPN();

        if (isset($GLOBALS["Helper"])):
            $this->Dados = $this->getTR($this->Dados, $GLOBALS["Helper"]);
        endif;
        $this->Dados = $this->getGL($this->Dados);
        $this->Dados = $this->getLI($this->Dados);
        $this->Dados = $this->getCons();

        print $this->Dados;
    }

    /**
     * Calcula o diretorio real de cada arquivo requizitado
     * @private 
     */
    private function setDiretorios($type, $file) {
        return $this->diretorios($type) . '/' . $file;
    }

    /**
     * Configura o layout e o titulo da aplicação para exibição, 
     * @public
     */
    public function Layout($pagina, $titulo) {
        $this->tiPag = $titulo;
        $this->arquivo = $pagina;
        $this->montLayou();
    }

    /**
     * Configura um helpers da aplicação para exibição, 
     * @public
     */
    public function Helper($PanelId) {
        $snippetFile = $this->setDiretorios('helpers', "{$PanelId}_Helper" . $this->ext);
        $snippetData = file_get_contents($snippetFile);
        return $this->getGL($snippetData);
    }

    /**
     * Carrega e preocessa os arquivos de linguagem
     * @private 
     */
    function Lng($lng) {
        $vars = parse_ini_file($this->setDiretorios('lng', $this->lng . '.ini'));
        $this->setLng = array_merge($this->setLng, $vars);
        return $this->setLng[$lng];
    }

    /**
     * Configura o painel layout e controle para ser preocessado
     * @private 
     */
    private function setPN($idPainel) {

        $classNome = strtolower($idPainel) . '_View';
        $painelControle = $this->setDiretorios("app_views", strtolower($idPainel) . "_View.php");
        $painelLayout = $this->setDiretorios("views", "{$idPainel}_View" . $this->ext);

        if (file_exists($painelControle)) {
            include_once($painelControle);
            $objPainel = new $classNome();
            $objPainel->home();
            $this->pnlData = $objPainel->setControlePainel($painelLayout);
        } elseif (file_exists($painelLayout)) {
            $this->pnlData = file_get_contents($painelLayout);
        } else {
            $this->pnlData = sprintf($this->Lng('DNE'), 'View_' . $idPainel);
        }

        return $this->pnlData;
    }

    /**
     * Nucleo principal, encarregado de processar as variaveis e constantes
     * da aplicação 
     * @private 
     */
    private function get($prefix, $text, $replace) {
        $output = $text;
        preg_match_all('/(?siU)(' . $this->prFixo . $prefix . '[a-zA-Z0-9_\.]+' . $this->suFixo . ')/', $output, $this->pilha);
        foreach ($this->pilha[0] as $this->key => $this->k) {
            $padrao = $this->k;
            $this->padrao1 = str_replace($this->prFixo, '', $padrao);
            $this->padrao1 = str_replace($this->suFixo, '', $this->padrao1);
            $this->padrao1 = str_replace($prefix, '', $this->padrao1);

            if (is_array($replace) && isset($replace[$this->padrao1])) {
                $output = str_replace($padrao, $replace[$this->padrao1], $output);
            } 
            elseif(is_string($replace) && method_exists($this, $replace)) {
                # Instancia a função setPN()
                $result = $this->$replace($this->padrao1);
                $output = str_replace($padrao, $result, $output);
            }
        }
        return $output;
    }

    /**
     * Encarregado de processar todo o conteudo do painel configurado 
     * @private 
     */
    private function getPN($input = false) {
        if (!$input) {
            $this->tplData = $this->Dados;
        } else {
            $this->tplData = $input;
        }

        $this->tplData = $this->get('View_', $this->tplData, 'setPN');
        return $this->tplData;
    }

    /**
     * Encarregado de processar todo o conteudo do helpers configurado 
     * @private 
     */
    private function getTR($tplData, $snippets) {
        $this->tplData = $this->get('Helper_', $tplData, $snippets);
        return $this->tplData;
    }

    /**
     * Encarregado de processar toda variavel global
     * @private 
     */
    private function getGL($tplData) {
        $this->tplData = $this->get("Global_", $tplData, $GLOBALS);
        return $this->tplData;
    }

    /**
     * Encarregado de processar toda variavel de linguagem
     * @private 
     */
    private function getLI($tplData) {
        $this->tplData = $tplData;
        preg_match_all("/(?siU)(" . $this->prFixo . "LI_[a-zA-Z0-9_]{1,}" . $this->suFixo . ")/", $this->tplData, $this->pilha);
        foreach ($this->pilha[0] as $this->key => $this->k) {
            $pattern1 = $this->k;
            $this->pattern2 = str_replace($this->prFixo, "", $pattern1);
            $this->pattern2 = str_replace($this->suFixo, "", $this->pattern2);
            $this->pattern2 = str_replace("LI_", "", $this->pattern2);

            if ($this->Lng($this->pattern2)) {
                $this->tplData = str_replace($pattern1, $this->Lng($this->pattern2), $this->tplData);
            } else {
                $this->tplData = str_replace($pattern1, sprintf($this->Lng('DNE'), $pattern1), $this->tplData);
            }
        }
        return $this->tplData;
    }

    /**
     * Configura as constantes da aplicação
     * @private 
     */
    private function getCons() {

        $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER["PHP_SELF"]) . '/';
        $link = 'http://' . $_SERVER['HTTP_HOST'] . dirname(dirname($_SERVER["PHP_SELF"]));
        $this->tplData = $this->Dados;
        $this->title = $this->tiPag;
        $this->title = str_replace(array("<", ">"), array("&lt;", "&gt;"), $this->title);
        $this->tplData = str_replace($this->prFixo . "TITULO" . $this->suFixo, $this->title, $this->tplData);
        $this->tplData = str_replace($this->prFixo . "CSS" . $this->suFixo, $url . config('psCss') . '/', $this->tplData);
        $this->tplData = str_replace($this->prFixo . "JS" . $this->suFixo, $url . config('psJs') . '/', $this->tplData);
        $this->tplData = str_replace($this->prFixo . "IMG" . $this->suFixo, $url . config('psImagen') . '/', $this->tplData);
        # Setando diretorios
        $this->tplData = str_replace($this->prFixo . "ACTION" . $this->suFixo, ACTION, $this->tplData);
        $this->tplData = str_replace($this->prFixo . "CONTROLLER" . $this->suFixo, CONTROLLER, $this->tplData);
        $this->tplData = str_replace($this->prFixo . "PATH" . $this->suFixo, $link, $this->tplData);
        $this->tplData = str_replace($this->prFixo . "PATH_ACTION" . $this->suFixo, $link.'/'.CONTROLLER.'/'.ACTION, $this->tplData);
        $this->tplData = str_replace($this->prFixo . "PATH_CONTROLLER" . $this->suFixo, $link.'/'.CONTROLLER, $this->tplData);
        $this->tplData = str_replace($this->prFixo . "PATH_PUBLIC" . $this->suFixo, $url, $this->tplData);

        return $this->tplData;
    }

    private function setControlePainel($HTMLFile) {
        $this->painelHtml = '';

        if (file_exists($HTMLFile)) {
            # Abre o arquivo para leitura
            $this->fp = fopen($HTMLFile, 'rb');
            if ($this->fp) {
                while (!feof($this->fp)) {
                    # Lendo linha alinha do arquivo
                    $this->painelHtml .= fgets($this->fp, 4096);
                }
                fclose($this->fp);
            }
        }

        return $this->painelHtml;
    }

    function erroNaExecucao($tituloErro) {
        self::Layout('index_Erro', $tituloErro);
    }

}
