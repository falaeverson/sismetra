<?php
/**
 * Esta class
 * 
 * @ category PhpZom
 * @ package lib
 * @ copyright (c) 2013, Everson Teixeira 
 * @ version 1.0 - odbc_Class.php
 * @ author Everson <falaeverson@gmail.com>
 */
class odbc_Class {
    //put your code here

    private $connect;
    private $odbc;
    private $user;
    private $password;
    
    
    function __construct() 
    {
        $this->odbc = config('odbc_dados');
        $this->user = config('odbc_user');
        $this->password = config('odbc_password');
        
        $this->odbc_Connecte();
        
       /* $connec = odbc_connect('tst', '', '');
        #$sql = 'select * from usuarios';
        $sql = "SELECT * FROM usuarios ";
        
        $result = odbc_exec($connec, $sql);
        
        while(odbc_fetch_row($result))
        {
            print odbc_result($result, 'cod_usuario').' - ';
            print odbc_result($result, 'nom_funcionario').'<br />';
        }
        * */
        
    }
    
    private function odbc_Connecte()
    {
        $this->connect = odbc_connect($this->odbc, $this->user, $this->password);
    }
    
    private function odbc_execu($query)
    {
        return odbc_exec($this->connect, $query);
    }
    
    public function sql_query($query)
    {
        return $this->odbc_execu($query);
    }

}

?>
