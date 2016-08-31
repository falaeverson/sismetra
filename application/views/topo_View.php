<?php
/**
 * Todos os controladores de Painel devem extends um Modelo correspondente
 * 
 * @author Elves
 */
class topo_View extends gerenteClass 
{
   
    private $mysql;

    function __construct()
    {
        $this->mysql = new mysql_Class;
        
        $GLOBALS['usuario'] = usuario('name_user');
        $this->home();
        
    }
    
    /**
     * Esta função é obrigatoria em todos os controladores
     */
    public function home() 
    {
        $Ls = '';

        $menu = $this->mysql->myConsulta('SELECT * FROM phpzon_menu
            WHERE status_menu = 1 ORDER BY orden_menu ASC');
        while($linhas = $this->mysql->myLista($menu)){
            $Ls .= '<a ';
            if(MAP == $linhas->id_menu){
                $Ls .= 'class="myButton myButton_atual" ';
            }else{
                $Ls .= 'class="myButton" ';
            }
            $Ls .= 'href="'.PATH_CONTROLLER.'/'.$linhas->link_menu.'">';
            $Ls .= utf8_encode($linhas->nome_menu).'</a>';
        }
        $GLOBALS['menu'] = $Ls;
        
    }
    

       
   
    
}
