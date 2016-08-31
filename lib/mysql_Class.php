<?php
/**
 * Esta class
 * 
 * @ category PhpZom
 * @ package lib
 * @ copyright (c) 2013, Everson Teixeira 
 * @ version 1.0 - mysql_Class.php
 * @ author Everson <falaeverson@gmail.com>
 * 
 * 
 * SQL unico
 * $var = $this->mysql->myDados('select * from tabela');
 * $var->coluna;
 *
 * 
 * SQL em lup continuo
 * $Sql = $this->mysql->myConsulta('select * from tabela');
 * while($var = $this->mysql->myLista($Sql)){
 *      $var->coluna;	
 * }
 * 
 * 
 * SQL Update
 * $this->mysql->myConsulta("update tabela set coluna='parametro' where coluna='parametro'");
 *
 * 
 * SQL Delet
 * As coluna abrigatoriamente deve ser igual ao nome do campo da tabela
 * $this->mysql->myConsulta("update tabela set coluna='string' where coluna='parametro'");
 *
 * 
 * SQL Insert
 * As coluna abrigatoriamente deve ser igual ao nome do campo da tabela
 * $dados = array('coluna1'=>'string1' ,'coluna2'=>'string2', 'coluna3'=>'string3');
 * $this->mysql->myExecuta('tabela', $dados);
 *
 * 
 * SQL Update 2
 * As coluna abrigatoriamente deve ser igual ao nome do campo da tabela
 * $dados = array('coluna1'=>'string1' ,'coluna2'=>'string2', 'coluna3'=>'string3');
 * $this->mysql->myExecuta('tabela', $dados, 'update', 'coluna=parametro');
 * 
 */


class mysql_Class 
{
	private $dbHost;
	private $dbNome;
	private $dbSenha;
	private $dbBanco;
        private $dbLink; 
	
	public function __construct() 
	{ 
          
	  $this->dbHost =  config('dbHost');
	  $this->dbNome =  config('dbNome');
	  $this->dbSenha = config('dbSenha');
	  $this->dbBanco = config('dbBanco');

	  $this->dbLink = mysql_connect($this->dbHost, $this->dbNome, $this->dbSenha);
	  
          if(!$this->dbLink):
              print "Falha na conexao com o servidor<br />";
          else:
            if(!mysql_select_db($this->dbBanco)):
              print "Falha ao selecionar o banco de dados";
            endif;
          endif;

	  return $this->dbLink;
	}
	/* Fecha uma conexão aberta com 
         * @author Elves
         */      
	public function myDesconect() 
	{
	  return mysql_close($this->dbLink);
	}
	public function myConsulta($consulta) 
	{
	  $this->dbLink;
	  $result = mysql_query($consulta, $this->dbLink);
	  return $result;
	}
	
	public  function myLista($db_consulta) 
	{
          return mysql_fetch_object($db_consulta);
	}
	
	public function myExecuta($tabela, $dados, $acao = 'insert', $parametros = '') 
	{
	  reset($dados);
	  if (strtolower($acao) == 'insert') {
		$consulta = 'insert into ' . $tabela . ' (';
		while (list($coluna, ) = each($dados)) $consulta .= $coluna . ', ';
		$consulta = substr($consulta, 0, -2) . ') values (';
	
		reset($dados);
		while (list(, $valor) = each($dados)) {
		  switch ((string)$valor) {
			case 'now()':
			  $consulta .= 'now(), ';
			  break;
			case 'null':
			  $consulta .= 'null, ';
			  break;
			default:
			  $consulta .= '\'' . $this->myEntrada($valor) . '\', ';
			  break;
		  }
		}
		$consulta = substr($consulta, 0, -2) . ')';
	
	  } elseif (strtolower($acao) == 'update') {
		$consulta = 'update ' . $tabela . ' set ';
	
		reset($dados);
		while (list($coluna, $valor) = each($dados)) {
		  switch ((string)$valor) {
			case 'now()':
			  $consulta .= $coluna . ' = now(), ';
			  break;
			case 'null':
			  $consulta .= $coluna .= ' = null, ';
			  break;
			default:
			  $consulta .= $coluna . ' = \'' . $this->myEntrada($valor) . '\', ';
			  break;
		  }
		}
		$consulta = substr($consulta, 0, -2) . ' where ' . $parametros;
	  }
	  return $this->myConsulta($consulta);
	} 
	
	public function myLinhas($db_consulta) 
	{
	  return mysql_num_rows($db_consulta);        
	}
	
	public function myEntrada($string) 
	{
	  return addslashes($string);
	} 
	
	public function myDados($string) 
	{
	  return $this->myLista($this->myConsulta($string));
	}

	
}