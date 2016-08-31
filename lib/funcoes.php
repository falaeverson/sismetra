<?php

/**
 * Este arquivo de funções
 * 
 * @ category PhpZom
 * @ package lib
 * @ copyright (c) 2013, Everson Teixeira 
 * @ version 1.0 - funcoes.php
 * @ author Everson <falaeverson@gmail.com>
 *
 * 
 * 
 * @param type $file prefixo da classe a ser instanciada
 * @return classe instanciada
 */
function getClass($file) {
    $nome = "{$file}Class";
    return new $nome;
}

/**
 * @param type $path carrega as biblioteca, modelo, controle e aplicacao
 * @param type $file nome do arquivo a ser carregado
 * @return classe carregada e instanciada
 */
function getImportClass($path, $file) {
    $class = new ini_Class;
    $class->import($path, $file);
    $nome = "{$file}";
    return new $nome;
}
/**
 * @param type $data_nasc data de nascimento
 * @return idade 
 */
function getIdade($data_nasc) {
    $data_nasc=explode("/",$data_nasc);
    $data=explode("/",date("d/m/Y"));
    $anos=$data[2]-$data_nasc[2];
    
    if ($data_nasc[1] > $data[1]) {
        return $anos-1;
    } 
    if ($data_nasc[1] == $data[1]) {
        if ($data_nasc[0] <= $data[0]) {
            return $anos;
        } else {
            return $anos-1;
        }
    } if ($data_nasc[1] < $data[1]) {
        return $anos;
    }
}
/**
 * função responsavel por tratar os parametro de configuração do arquivo 
 * em /biblioteca/setup.ini
 * @param type $var nome do parametro de configuração 
 * @return o parametro correspondente do arquivo de configuração
 */
function config($var) {
    $setConfig = array();
    $vars = parse_ini_file(ini_Class::raiz('configs', 'setup', 'ini'));
    $Config = array_merge($setConfig, $vars);
    return $Config[$var];
}

function msgAlerta($var) {
    $setConfig = array();
    $vars = parse_ini_file(ini_Class::raiz('configs', 'msg', 'ini'));
    $Config = array_merge($setConfig, $vars);
    return $Config[$var];
}

/**
 * processaString: tira caracteres que são incluidos automaticamente no envio de um form
 */
function processaString($fonte) {
    $fonte = str_replace('\\"', '"', $fonte);
    $fonte = str_replace('\\\\', '\\', $fonte);
    return $fonte;
}

/**
 * Retira acentos de uma string
 */
function retiraAcentos($texto) {

    $array1 = array("Ã¡", "Ã ", "Ã¢", "Ã£", "Ã¤", "Ã©", "Ã¨", "Ãª", "Ã«", "Ã­", "Ã¬", "Ã®", "Ã¯", "Ã³", "Ã²", "Ã´", "Ãµ", "Ã¶", "Ãº", "Ã¹", "Ã»", "Ã¼", "Ã§", "Ã�", "Ã€", "Ã‚", "Ãƒ", "Ã„", "Ã‰", "Ãˆ", "ÃŠ", "Ã‹", "Ã�", "ÃŒ", "ÃŽ", "Ã�", "Ã“", "Ã’", "Ã”", "Ã•", "Ã–", "Ãš", "Ã™", "Ã›", "Ãœ", "Ã‡");
    $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");

    return str_replace($array1, $array2, $texto);
}

/**
 * Renderizando session de usuario
 */
function usuario($campo) {

    if (isset($_SESSION["PhpZon_User"])) {
        return $_SESSION["PhpZon_User"]->$campo;
    }
    else
        return null;
}

// ------------------------------------------------------------------------------
// * urlOrigem: Envia a url atual
// ------------------------------------------------------------------------------
function urlOrigem() {
    $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $url = str_replace('?pagina=busca', '', $url);
    return base64_encode($url);
}

// ------------------------------------------------------------------------------
// * urlDistino: Retorna a url atual
// ------------------------------------------------------------------------------
function urlDistino($origem) {
    return base64_decode($origem);
}
// ------------------------------------------------------------------------------
// * dataDMY_YMD e dataYMD_DMY: Converte datas.
// ------------------------------------------------------------------------------
function dataDMY_YMD($fonte) {
    return substr($fonte, 6, 4) . "-" . substr($fonte, 3, 2) . "-" . substr($fonte, 0, 2);
}

function dataYMD_DMY($fonte) {
    return substr($fonte, 8, 2) . "/" . substr($fonte, 5, 2) . "/" . substr($fonte, 0, 4);
}

// ------------------------------------------------------------------------------
// * nomeDia: retorna o dia da semana (1-dom , 7-sï¿½b)
// ------------------------------------------------------------------------------
function nomeDia($dia) {
    switch ($dia) {
        case 1: return "Domingo";
            break;
        case 2: return "Segunda-feira";
            break;
        case 3: return "Terçaa-feria";
            break;
        case 4: return "Quarta-feira";
            break;
        case 5: return "Quinta-feira";
            break;
        case 6: return "Sexta-feira";
            break;
        case 7: return "Sábado";
            break;
    }
}

// ------------------------------------------------------------------------------
// * nomeMes: retorna o mï¿½s do ano
// ------------------------------------------------------------------------------
function nomeMes($mes) {
    switch ($mes) {
        case 1: return "Janeiro";
            break;
        case 2: return "Fevereiro";
            break;
        case 3: return "Marï¿½o";
            break;
        case 4: return "Abril";
            break;
        case 5: return "Maio";
            break;
        case 6: return "Junho";
            break;
        case 7: return "Julho";
            break;
        case 8: return "Agosto";
            break;
        case 9: return "Setembro";
            break;
        case 10: return "Outubro";
            break;
        case 11: return "Novembro";
            break;
        case 12: return "Dezembro";
            break;
    }
}