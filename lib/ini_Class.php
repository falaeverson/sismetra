<?php
/**
 * Esta class é responsável pela inicialização do sistema 
 * 
 * @ category PhpZom
 * @ package lib
 * @ copyright (c) 2013, Everson Teixeira 
 * @ version 1.0 - ini_Class.php
 * @ author Everson <falaeverson@gmail.com>
 * 
 */

class ini_Class 
{
    /**
     * @param type $pos
     * @return type
     */
    function ini()
    {
        session_start();
        define("SYSTEM",          "index", true);
        
        self::import("lib", 
                array(
                    "gerente_Class", 
                    "odbc_Class", 
                    "mysql_Class", 
                    "consulta_Class", 
                    "fpdf_Class", 
                    "funcoes"
                    ) 
              );
        self::iniControle(); 
    }

    private static function iniControle()
    {

        /**
         * carregando layout de erro
         */
        $erro = new gerenteClass();
        /**
         * coletando inforações da url mapeamento do sistema
         */
        $class = self::action(0);
        $funcao = self::action(1);
        
        # Verificando acesso  
        $session = usuario('name_user');
        if(!$session){
            if($class != 'login'){
                header('Location: '. config('path').'login');
            }
        }
        if($session){
            if($class == 'login' && $funcao != 'sair'){
                header('Location: '. config('path').'');
            }
        }

        
        /**
         * verificando carregamento inicial
         */
        if(empty($class)):
            $actionControle = 'index';
            $actionFuncao = 'home';
        else: 
            $actionControle = $class;
            
            if(empty($funcao)):
                $actionFuncao = 'home';
            else: 
                $actionFuncao = $funcao;
            endif;
            
        endif;
       
        /**
         * @global definido pelo controle em execução
         */ 
        define("ACTION",          $actionFuncao, true);
        define("CONTROLLER",      $actionControle, true);
        define("PATH_ACTION",     config('path').'/'.CONTROLLER.'/'.ACTION, true);
        define("PATH_CONTROLLER", config('path').'/'.CONTROLLER, true);
        define("PATH_PUBLIC",     config('path').'/public', true);
        define("PATH",            config('path').'/', true);
        define("DIR_PATH",        dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'public', true);

        
        /**
         * criando variaveis de operação pela url
         */
        $classControle  = $actionControle.'_Controller';
        $classModelo = $actionControle.'_Model';
        /**
         * Verificando a existencia dos arquivo e iniciando o carregamento do 
         * sistema
         */
        if(file_exists(self::raiz('controllers', "{$actionControle}_Controller"))):          
            if(file_exists(self::raiz('models', "{$actionControle}_Model"))):
                self::import('models', "{$actionControle}_Model");
                self::import('controllers', "{$actionControle}_Controller"); 
               
                $classControleInstanciado = new $classControle ;
                if(in_array($actionFuncao, array_diff(get_class_methods($classControleInstanciado), get_class_methods($classModelo)))):
                    $classControleInstanciado->$actionFuncao();
                else:
                    $GLOBALS['erro'] = sprintf(msgAlerta('erroAction'), $actionFuncao);
                    $erro->erroNaExecucao('Erro da Action');
                endif;
                
            else:
                    $GLOBALS['erro'] = sprintf(msgAlerta('erroModelo'), $actionControle, $actionControle);
                    $erro->erroNaExecucao('Erro no modelo');
            endif;
        else:
            $GLOBALS['erro'] = sprintf(msgAlerta('erroControle'), $actionControle, $actionControle) ;
            $erro->erroNaExecucao('Erro no controle');
        endif;
        
    }
    /**
     * Tratamento da url
     */
    public static function action($posicaoDaChave)
    {
        $urlEmTempoReal = str_replace(config('path'), '',  'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
        $urlSemEspaco = trim($urlEmTempoReal);
        $arrayDeAction = explode('/', $urlSemEspaco);

        $arrayDeActionTratado = str_replace(
                array('/',',','.','$','%','?','*','-',' '), 
                array('','','','','','','','',''), 
                $arrayDeAction
                );

       if(isset($arrayDeActionTratado[$posicaoDaChave])):
           return strtolower($arrayDeActionTratado[$posicaoDaChave]);
       else:
           return null;
       endif;        
        
    }
    /**
     * importando arquivo unico ou malote de arquivos
     */
    public static function import($path = "", $file = "", $ext = "php")
    {
        if(is_array($file)):
            foreach ($file as $file):
                $require = self::import($path, $file, $ext);
            endforeach;
            return $require;
        else:
            $dir_file = self::raiz($path, $file, $ext);
            if($dir_file):
                require_once $dir_file;
            else:
                trigger_error("O arquivo {$file}.{$ext} nao existe em $path", E_USER_WARNING);
            endif;
        endif;
        
    }
    /**
     * Mapeando diretorios
     */
    public static function raiz($path = "", $file = "", $ext = "php")
    {
        $raizes = array(
          'controllers'   => array(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'application/controllers'),  
          'models'     => array(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'application/models'),
          'configs'    => array(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'application/configs'),
          'lib' => array(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'lib')
        );
        
        foreach ($raizes[$path] as $raiz):
            $arquivo = $raiz . DIRECTORY_SEPARATOR . "{$file}.{$ext}";
            if(file_exists($arquivo)):
                return $arquivo;
            endif;
        endforeach;
        return false;
    }

    

}