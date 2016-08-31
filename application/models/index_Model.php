<?php

/**
 * Description of IndexModelo
 *
 * @author Elves
 */
class index_Model extends gerenteClass {

    public $mysql;

    function __construct() {
        $this->mysql = parent::dbMysql();
    }

    function graficosHome() {
        $sql1 = 'select * from phpzon_funcionario where situacao_fun=2';
        $sql2 = 'select * from phpzon_funcionario where situacao_fun in(0,1)';
        $GLOBALS['funcionarioDemi'] = $this->mysql->myLinhas($this->mysql->myConsulta($sql1));
        $GLOBALS['funcionarioAtivo'] = $this->mysql->myLinhas($this->mysql->myConsulta($sql2));

        $sql3 = 'select * from phpzon_funcionario where sexo_fun=1';
        $sql4 = 'select * from phpzon_funcionario where sexo_fun=2';
        $GLOBALS['funcionarioMasco'] = $this->mysql->myLinhas($this->mysql->myConsulta($sql3));
        $GLOBALS['funcionarioFemini'] = $this->mysql->myLinhas($this->mysql->myConsulta($sql4));
    }

    /*
     * Tradando dados do modulo médico
     */

    function medicoList() {
        $Sql = 'select * from phpzon_medico';
        $Lista = new consulta_Class($Sql, 10);
        while ($var = $this->mysql->myLista($Lista->consulta)) {
            $saida .= '<tr>';
            $saida .= '<td class="input-mini"><center>';
            $saida .= '<a onclick="if (!confirm(\'Tem certeza que deseja excluir?\')) return false;" href="' . PATH_ACTION . '/?pagina=delete&id_del=' . $var->id_med . '&origem=' . urlOrigem() . '"';
            $saida .= ' title="Excluir"><i class="icon-trash"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Visualizar"><i class="icon-zoom-in"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=edit&id=' . $var->id_med . '&origem=' . urlOrigem() . '" title="Editar"><i class="icon-edit"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Status"><i class=" icon-ok-circle"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-xlarge">' . $var->nome_med . '</td>';
            $saida .= '<td>' . $var->especialidade_med . '</td>';
            $saida .= '<td class="input-medium">' . $var->fone_med . '</td>';
            $saida .= '<td class="input-medium">' . $var->celular_1_med . '</td>';
            $saida .= '</tr>';
        }
        $GLOBALS['paginacao'] = $Lista->paginacaoM1();

        return $saida;
    }

    function medicoEdit($id) {
        $GLOBALS['map'] = 'Novo'; # Nome nag map

        $GLOBALS['id_med'] = '';
        $GLOBALS['nome'] = '';
        $GLOBALS['especialidade'] = '';
        $GLOBALS['atuacao'] = '';
        $GLOBALS['sexo'] = '';
        $GLOBALS['estado_civil'] = '';
        $GLOBALS['dt_nascimento'] = '01/01/1999';
        $GLOBALS['endereco'] = '';
        $GLOBALS['numero'] = '';
        $GLOBALS['bairro'] = '';
        $GLOBALS['cidade'] = '';
        $GLOBALS['estado'] = '';
        $GLOBALS['cep'] = '';
        $GLOBALS['fone'] = '';
        $GLOBALS['celular_1'] = '';
        $GLOBALS['celular_2'] = '';
        $GLOBALS['email'] = '';

        /*
         * Dados para o formulario de editando
         */
        if ($id > 0) {
            $Sql = 'select * from phpzon_medico where id_med=' . $id;
            $Lista = new consulta_Class($Sql, 1);
            while ($var = $this->mysql->myLista($Lista->consulta)) {
                $GLOBALS['map'] = $var->nome_med;

                $GLOBALS['id_med'] = $var->id_med;
                $GLOBALS['nome'] = $var->nome_med;
                $GLOBALS['especialidade'] = $var->especialidade_med;
                $GLOBALS['atuacao'] = $var->area_atuacao_med;
                $GLOBALS['sexo'] = $var->sexo_med;
                $GLOBALS['estado_civil'] = $var->civil_med;
                $GLOBALS['dt_nascimento'] = dataYMD_DMY($var->data);
                $GLOBALS['endereco'] = $var->endereco_med;
                $GLOBALS['numero'] = $var->numero_med;
                $GLOBALS['bairro'] = $var->bairro_med;
                $GLOBALS['cidade'] = $var->cidade_med;
                $GLOBALS['estado'] = $var->estado_med;
                $GLOBALS['cep'] = $var->cep_med;
                $GLOBALS['fone'] = $var->fone_med;
                $GLOBALS['celular_1'] = $var->celular_1_med;
                $GLOBALS['celular_2'] = $var->celular_2_med;
                $GLOBALS['email'] = $var->email_med;
            }
        }

        /*
         * Criando lista de opcoes para o sexo do formulario
         */
        $sql_sexo = $this->mysql->myConsulta('select * from phpzon_sexo');
        while ($var = $this->mysql->myLista($sql_sexo)) {
            $list_sexo .= '<option value="' . $var->cod_sexo . '"';
            $list_sexo .= (($GLOBALS['sexo'] == $var->cod_sexo) ? 'selected="selected"' : '' ) . '>' . $var->nome_sexo . '</option>';
        } $GLOBALS['list_sexo'] = $list_sexo;

        /*
         * Criando lista de opcoes para estado civil do formulario
         */
        $sql_civil = $this->mysql->myConsulta('select * from phpzon_estado_civil');
        while ($var = $this->mysql->myLista($sql_civil)) {
            $list_civil .= '<option value="' . $var->id_esci . '"';
            $list_civil .= (($GLOBALS['estado_civil'] == $var->id_esci) ? 'selected="selected"' : '' ) . '>' . $var->nome_esci . '</option>';
        } $GLOBALS['list_civil'] = $list_civil;
    }

    function medicoSalvar() {
        $dados = array(
            'id_med' => mysql_real_escape_string($_POST['id_med']),
            'nome_med' => mysql_real_escape_string($_POST['nome']),
            'especialidade_med' => mysql_real_escape_string($_POST['especialidade']),
            'area_atuacao_med' => mysql_real_escape_string($_POST['atuacao']),
            'sexo_med' => mysql_real_escape_string($_POST['sexo']),
            'civil_med' => mysql_real_escape_string($_POST['estado_civil']),
            'endereco_med' => mysql_real_escape_string($_POST['endereco']),
            'numero_med' => mysql_real_escape_string($_POST['numero']),
            'bairro_med' => mysql_real_escape_string($_POST['bairro']),
            'cidade_med' => mysql_real_escape_string($_POST['cidade']),
            'estado_med' => mysql_real_escape_string($_POST['estado']),
            'cep_med' => mysql_real_escape_string($_POST['cep']),
            'fone_med' => mysql_real_escape_string($_POST['fone']),
            'celular_1_med' => mysql_real_escape_string($_POST['celular_1']),
            'celular_2_med' => mysql_real_escape_string($_POST['celular_2']),
            'email_med' => mysql_real_escape_string($_POST['email']),
            'data' => dataDMY_YMD($_POST['dt_nascimento']),
        );
        # campo origatorio
        if (empty($dados['nome_med'])) {
            $saida .= 'Nome, ';
        }
        if (empty($dados['sexo_med'])) {
            $saida .= 'Sexo, ';
        }
        if (empty($dados['civil_med'])) {
            $saida .= 'Estado Civil, ';
        }
        # campo origatorio
        if (empty($dados['especialidade_med'])) {
            $saida .= 'Especialidade, ';
        }
        # campo origatorio
        if (!empty($saida)) {
            print "<div class=\"alert alert-wornig\">";
            print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
            print "<h5>Faltou informar: </h5>";
            print $saida;
            print "</div>";
        } else {
            if ($dados['id_med'] > 0) {
                $this->mysql->myExecuta('phpzon_medico', $dados, 'update', 'id_med=' . $dados['id_med']);
                print "<div class=\"alert alert-success\">";
                print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
                print "Operação realizado com sucesso";
                print "</div>";
            } else {
                $this->mysql->myExecuta('phpzon_medico', $dados);
                $retorno = $this->mysql->myDados('select * from phpzon_medico order by id_med desc');
                print "<div class=\"alert alert-success\">";
                print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
                print "Operação realizado com sucesso";
                print "</div>";
                print '<script>window.location=\'' . urlDistino($_POST['origem']) . '&id=' . $retorno->id_med . '\';</script>';

                ;
            }
        }
    }

    function medicoDelete($id_del) {

        if ($id_del > 0) {
            $sql = 'select * from phpzon_consultas where medico_cons=' . $id_del;
            $qt = $this->mysql->myLinhas($this->mysql->myConsulta($sql));
            $cons = $this->mysql->myDados($sql);
            if ($cons->funcionario_cons > 0) {
                $msn .= '<div class="alert alert-block alert-error fade in">';
                #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                $msn .= '<p>Este médico não pode ser excluido, primeiro exclua as fichas em seu nome. </p>';
                $msn .= '<p>Total de ficha encontradas ' . $qt . '</p>';
                $msn .= '<p>';
                $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                $msn .= '</p>';
                $msn .= '</div>';

                return $msn;
            } else {
                $err = $this->mysql->myConsulta('delete from phpzon_medico where id_med=' . $id_del . ' limit 1');
                if ($err == true) {
                    $msn .= "<script>window.location = '{Global_voltar_pra_list}'</script>";
                } else {
                    $msn .= '<div class="alert alert-block alert-error fade in">';
                    #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                    $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                    $msn .= '<p>Não possivel excluir este registro</p>';
                    $msn .= '<p>';
                    $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                    #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                    $msn .= '</p>';
                    $msn .= '</div>';
                }
                return $msn;
            }
        }
    }

    /*
     * Tradando dados do modulo funcionário
     */

    function funcinarioList() {
        $Sql = "SELECT * FROM phpzon_funcionario
               LEFT JOIN phpzon_setor ON (phpzon_setor.id_set = phpzon_funcionario.setor_fun)
               LEFT JOIN phpzon_situacao_funcionario ON (phpzon_situacao_funcionario.id_sit_fun = phpzon_funcionario.situacao_fun)
               WHERE 1 ORDER BY nome_fun, drt_fun ASC";
        $Lista = new consulta_Class($Sql, 20);
        while ($var = $this->mysql->myLista($Lista->consulta)) {

            # Funcionario demitido
            if ($var->situacao_fun == 2) {
                $saida .= '<tr class="error">';
            } else {
                $saida .= '<tr>';
            }

            $saida .= '<td class="input-mini"><center>';
            $saida .= '<a onclick="if (!confirm(\'Tem certeza que deseja excluir?\')) return false;" href="' . PATH_ACTION . '/?pagina=delete&id_del=' . $var->id_fun . '&origem=' . urlOrigem() . '"';
            $saida .= ' title="Excluir"><i class="icon-trash"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Visualizar"><i class="icon-zoom-in"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=edit&id=' . $var->id_fun . '&origem=' . urlOrigem() . '" title="Editar"><i class="icon-edit"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Status"><i class=" icon-ok-circle"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-mini">' . $var->drt_fun . '</td>';
            $saida .= '<td class="input-xlarge">' . $var->nome_fun . '</td>';
            $saida .= '<td>' . $var->titulo_set . '</td>';
            $saida .= '<td class="input-medium">' . $var->cpf_fun . '</td>';
            $saida .= '<td class="input-medium">' . $var->fone_fun . '</td>';
            $saida .= '<td class="input-medium">' . $var->titulo_sit_fun . '</td>';
            $saida .= '</tr>';
        }
        $GLOBALS['paginacao'] = $Lista->paginacaoM1();

        return $saida;
    }

    function funcinarioBusc($nome = '', $drt = '') {

        if (!empty($nome)) {
            $filtro_nome = " AND phpzon_funcionario.nome_fun like '%$nome%' ";
        }
        if (!empty($drt)) {
            $filtro_drt = " AND phpzon_funcionario.drt_fun=$drt ";
        }

        $Sql = "SELECT * FROM phpzon_funcionario
               LEFT JOIN phpzon_setor ON (phpzon_setor.id_set = phpzon_funcionario.setor_fun)
               LEFT JOIN phpzon_situacao_funcionario ON (phpzon_situacao_funcionario.id_sit_fun = phpzon_funcionario.situacao_fun)
               WHERE 1 $filtro_nome $filtro_drt ORDER BY nome_fun, drt_fun ASC";

        $Lista = new consulta_Class($Sql, 5000);
        while ($var = $this->mysql->myLista($Lista->consulta)) {

            # Funcionario demitido
            if ($var->situacao_fun == 2) {
                $saida .= '<tr class="error">';
            } else {
                $saida .= '<tr>';
            }

            $saida .= '<td class="input-mini"><center>';
            $saida .= '<a onclick="if (!confirm(\'Tem certeza que deseja excluir?\')) return false;" href="' . PATH_ACTION . '/?pagina=delete&id_del=' . $var->id_fun . '&origem=' . urlOrigem() . '"';
            $saida .= ' title="Excluir"><i class="icon-trash"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Visualizar"><i class="icon-zoom-in"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=edit&id=' . $var->id_fun . '&origem=' . urlOrigem() . '" title="Editar"><i class="icon-edit"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Status"><i class=" icon-ok-circle"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-mini">' . $var->drt_fun . '</td>';
            $saida .= '<td class="input-xlarge">' . $var->nome_fun . '</td>';
            $saida .= '<td>' . $var->titulo_set . '</td>';
            $saida .= '<td class="input-medium">' . $var->cpf_fun . '</td>';
            $saida .= '<td class="input-medium">' . $var->fone_fun . '</td>';
            $saida .= '<td class="input-medium">' . $var->titulo_sit_fun . '</td>';
            $saida .= '</tr>';
        }

        $linha = $this->mysql->myLinhas($this->mysql->myConsulta($Sql));
        if ($linha == false) {
            $saida .= '<tr><td>Nenhu registro localizado</td></tr>';
        }


        return $saida;
    }

    function funcinarioEdit($id) {
        $GLOBALS['map'] = 'Novo'; # Nome nag map

        $GLOBALS['id_fun'] = '';
        $GLOBALS['drt'] = '999999';
        $GLOBALS['nome'] = '';
        $GLOBALS['cpf'] = '';
        $GLOBALS['rg'] = '';
        $GLOBALS['estado_civil'] = '';
        $GLOBALS['sexo'] = '';
        $GLOBALS['setor'] = '';
        $GLOBALS['funcao'] = '';
        $GLOBALS['dt_nascimento'] = '01/01/1999';
        $GLOBALS['situacao_fun'] = '';
        $GLOBALS['obs'] = '';
        $GLOBALS['endereco'] = '';
        $GLOBALS['numero'] = '';
        $GLOBALS['bairro'] = '';
        $GLOBALS['cidade'] = '';
        $GLOBALS['estado'] = '';
        $GLOBALS['cep'] = '';
        $GLOBALS['fone'] = '';
        $GLOBALS['celular_1'] = '';
        $GLOBALS['celular_2'] = '';
        $GLOBALS['email'] = '';

        /*
         * Dados para o formulario de editando
         */
        if ($id > 0) {
            $Sql = 'select * from phpzon_funcionario where id_fun=' . $id;
            $Lista = new consulta_Class($Sql, 1);
            while ($var = $this->mysql->myLista($Lista->consulta)) {
                $GLOBALS['map'] = $var->nome_fun;

                $GLOBALS['id_fun'] = $var->id_fun;
                $GLOBALS['drt'] = $var->drt_fun;
                $GLOBALS['nome'] = $var->nome_fun;
                $GLOBALS['cpf'] = $var->cpf_fun;
                $GLOBALS['rg'] = $var->rg_fun;
                $GLOBALS['estado_civil'] = $var->civil_fun;
                $GLOBALS['sexo'] = $var->sexo_fun;
                $GLOBALS['setor'] = $var->setor_fun;
                $GLOBALS['funcao'] = $var->funcao_fun;
                $GLOBALS['dt_nascimento'] = dataYMD_DMY($var->data);
                $GLOBALS['situacao_fun'] = $var->situacao_fun;
                $GLOBALS['obs'] = $var->obs_fun;
                $GLOBALS['endereco'] = $var->endereco_fun;
                $GLOBALS['numero'] = $var->numero_fun;
                $GLOBALS['bairro'] = $var->bairro_fun;
                $GLOBALS['cidade'] = $var->cidade_fun;
                $GLOBALS['estado'] = $var->estado_fun;
                $GLOBALS['cep'] = $var->cep_fun;
                $GLOBALS['fone'] = $var->fone_fun;
                $GLOBALS['celular_1'] = $var->celular_1_fun;
                $GLOBALS['celular_2'] = $var->celular_2_fun;
                $GLOBALS['email'] = $var->email_fun;
            }
        }

        /*
         * Criando lista de opcoes para o sexo do formulario
         */
        $sql_sexo = $this->mysql->myConsulta('select * from phpzon_sexo');
        while ($var = $this->mysql->myLista($sql_sexo)) {
            $list_sexo .= '<option value="' . $var->id_sexo . '"';
            $list_sexo .= (($GLOBALS['sexo'] == $var->id_sexo) ? 'selected="selected"' : '' ) . '>' . $var->nome_sexo . '</option>';
        } $GLOBALS['list_sexo'] = $list_sexo;

        /*
         * Criando lista de opcoes para a situação do formulario
         */
        $sql_situacao = $this->mysql->myConsulta('select * from phpzon_situacao_funcionario order by titulo_sit_fun asc');
        while ($var = $this->mysql->myLista($sql_situacao)) {
            $list_situacao .= '<option value="' . $var->id_sit_fun . '"';
            $list_situacao .= (($GLOBALS['situacao_fun'] == $var->id_sit_fun) ? 'selected="selected"' : '' ) . '>' . $var->titulo_sit_fun . '</option>';
        } $GLOBALS['list_situacao'] = $list_situacao;

        /*
         * Criando lista de opcoes para estado civil do formulario
         */
        $sql_civil = $this->mysql->myConsulta('select * from phpzon_estado_civil');
        while ($var = $this->mysql->myLista($sql_civil)) {
            $list_civil .= '<option value="' . $var->id_esci . '"';
            $list_civil .= (($GLOBALS['estado_civil'] == $var->id_esci) ? 'selected="selected"' : '' ) . '>' . $var->nome_esci . '</option>';
        } $GLOBALS['list_civil'] = $list_civil;

        /*
         * Criando lista de opcoes para select setor
         */
        $sql_setor = $this->mysql->myConsulta('select * from phpzon_setor order by titulo_set asc');
        while ($var = $this->mysql->myLista($sql_setor)) {
            $list_setor .= '<option value="' . $var->id_set . '"';
            if ($GLOBALS['setor'] == $var->id_set) {
                $list_setor .= 'selected="selected">' . $var->titulo_set;
            } else {
                $list_setor .= '>' . $var->titulo_set;
            }
            $list_setor .= '</option>';
        } $GLOBALS['list_setor'] = $list_setor;

        /*
         * Criando lista de opcoes para select funcao
         */
        $sql_funcao = $this->mysql->myConsulta('select * from phpzon_funcao where id_funcao_set=' . $GLOBALS['setor'] . ' order by titulo_funcao asc');
        while ($var = $this->mysql->myLista($sql_funcao)) {
            $list_funcao .= '<option value="' . $var->id_funcao . '"';
            $list_funcao .= (($GLOBALS['funcao'] == $var->id_funcao) ? 'selected="selected"' : '' ) . '>' . $var->titulo_funcao . '</option>';
        } $GLOBALS['list_funcao'] = $list_funcao;
    }

    function funcinarioSalvar() {
        $dados = array(
            'id_fun' => mysql_real_escape_string($_POST['id_fun']),
            'drt_fun' => mysql_real_escape_string($_POST['drt']),
            'nome_fun' => mysql_real_escape_string($_POST['nome']),
            'cpf_fun' => mysql_real_escape_string($_POST['cpf']),
            'rg_fun' => mysql_real_escape_string($_POST['rg']),
            'civil_fun' => mysql_real_escape_string($_POST['estado_civil']),
            'sexo_fun' => mysql_real_escape_string($_POST['sexo']),
            'setor_fun' => mysql_real_escape_string($_POST['setor']),
            'funcao_fun' => mysql_real_escape_string($_POST['funcao']),
            'data' => dataDMY_YMD($_POST['dt_nascimento']),
            'situacao_fun' => mysql_real_escape_string($_POST['situacao_fun']),
            'obs_fun' => mysql_real_escape_string($_POST['obs']),
            'endereco_fun' => mysql_real_escape_string($_POST['endereco']),
            'numero_fun' => mysql_real_escape_string($_POST['numero']),
            'bairro_fun' => mysql_real_escape_string($_POST['bairro']),
            'cidade_fun' => mysql_real_escape_string($_POST['cidade']),
            'estado_fun' => mysql_real_escape_string($_POST['estado']),
            'cep_fun' => mysql_real_escape_string($_POST['cep']),
            'fone_fun' => mysql_real_escape_string($_POST['fone']),
            'celular_1_fun' => mysql_real_escape_string($_POST['celular_1']),
            'celular_2_fun' => mysql_real_escape_string($_POST['celular_2']),
            'email_fun' => mysql_real_escape_string($_POST['email']),
        );
        # campo nome
        if (empty($dados['nome_fun'])) {
            $saida .= 'Nome, ';
        }
        if ($dados['sexo_fun'] == 0) {
            $saida .= 'Sexo, ';
        }
        if ($dados['civil_fun'] == 0) {
            $saida .= 'Estado Civil, ';
        }
        # campo setor
        if (empty($dados['setor_fun'])) {
            $saida .= 'Setor, ';
        }
        # campo funcao
        if (empty($dados['funcao_fun'])) {
            if (!empty($dados['setor_fun'])) {
                $saida .= 'Selecione uma função, ';
            }
        }
        # campo cfp
        if (empty($dados['cpf_fun'])) {
            $saida .= 'CPF, ';
        } else {
            if (empty($dados['id_fun'])) {
                $test_cpf = $this->mysql->myDados('select * from phpzon_funcionario where cpf_fun like "%' . $dados['cpf_fun'] . '%" limit 1');
                if (!empty($test_cpf->cpf_fun)) {
                    $saida .= 'Este CPF já esta cadastrado <b>' . $dados['cpf_fun'] . ' </b>, ';
                }
            } else {
                $pesq_cpf = $this->mysql->myDados('select * from phpzon_funcionario where cpf_fun like "%' . $dados['cpf_fun'] . '%" limit 1');
                if (!empty($pesq_cpf->cpf_fun)) {
                    $test_cpf = $this->mysql->myDados('select * from phpzon_funcionario where cpf_fun like "%' . $pesq_cpf->cpf_fun . '%" 
                    and id_fun=' . $dados['id_fun'] . ' limit 1');
                    if (empty($test_cpf->cpf_fun)) {
                        $saida .= 'Este CPF já esta cadastrado <b>' . $dados['cpf_fun'] . ' </b>, ';
                    }
                }
            }
        }
        # campo rg
        if (empty($dados['rg_fun'])) {
            $saida .= 'RG, ';
        } else {
            if (empty($dados['id_fun'])) {
                $test_rg = $this->mysql->myDados('select * from phpzon_funcionario where rg_fun like "%' . $dados['rg_fun'] . '%" limit 1');
                if (!empty($test_rg->rg_fun)) {
                    $saida .= '</b> Este RG já esta cadastrado <b>' . $dados['rg_fun'] . ' </b>, ';
                }
            } else {
                $pesq_rg = $this->mysql->myDados('select * from phpzon_funcionario where rg_fun like "%' . $dados['rg_fun'] . '%" limit 1');
                if (!empty($pesq_rg->rg_fun)) {
                    $test_rg = $this->mysql->myDados('select * from phpzon_funcionario where rg_fun like "%' . $pesq_rg->rg_fun . '%"  
                    and id_fun=' . $dados['id_fun'] . ' limit 1');
                    if (empty($test_rg->rg_fun)) {
                        $saida .= 'Este RG já esta cadastrado <b>' . $dados['rg_fun'] . $dados['id_fun'] . ' </b>, ';
                    }
                }
            }
        }
        # campo origatorio
        if (!empty($saida)) {
            print "<div class=\"alert alert-wornig\">";
            print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
            print "<h5>Faltou informar: </h5>";
            print $saida;
            print "</div>";
        } else {
            if ($dados['id_fun'] > 0) {
                $this->mysql->myExecuta('phpzon_funcionario', $dados, 'update', 'id_fun=' . $dados['id_fun']);
                print "<div class=\"alert alert-success\">";
                print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
                print "Operação realizado com sucesso";
                print "</div>";
            } else {
                $this->mysql->myExecuta('phpzon_funcionario', $dados);
                $retorno = $this->mysql->myDados('select * from phpzon_funcionario order by id_fun desc');
                print "<div class=\"alert alert-success\">";
                print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
                print "Operação realizado com sucesso";
                print "</div>";
                print '<script>window.location=\'' . urlDistino($_POST['origem']) . '&id=' . $retorno->id_fun . '\';</script>';

                ;
            }
        }
    }

    function funcinarioDelete($id_del) {
        if ($id_del > 0) {
            $sql = 'select * from phpzon_consultas where funcionario_cons=' . $id_del;
            $qt = $this->mysql->myLinhas($this->mysql->myConsulta($sql));
            $cons = $this->mysql->myDados($sql);
            if ($cons->funcionario_cons > 0) {
                $msn .= '<div class="alert alert-block alert-error fade in">';
                #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                $msn .= '<p>Este funcionario não pode ser excluido, primeiro exclua as fichas em seu nome. </p>';
                $msn .= '<p>Total de ficha encontradas ' . $qt . '</p>';
                $msn .= '<p>';
                $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                $msn .= '</p>';
                $msn .= '</div>';

                return $msn;
            } else {
                $err = $this->mysql->myConsulta('delete from phpzon_funcionario where id_fun=' . $id_del . ' limit 1');
                if ($err == true) {
                    $msn .= "<script>window.location = '{Global_voltar_pra_list}'</script>";
                } else {
                    $msn .= '<div class="alert alert-block alert-error fade in">';
                    #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                    $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                    $msn .= '<p>Não possivel excluir este registro</p>';
                    $msn .= '<p>';
                    $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                    #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                    $msn .= '</p>';
                    $msn .= '</div>';
                }
                return $msn;
            }
        }
    }

    function funcinarioSelectAuto() {
        if ($_POST['setor'] > 0) {
            $tmp2s = $this->mysql->myConsulta("SELECT distinct * FROM phpzon_funcao WHERE id_funcao_set=" . $_POST['setor'] . " order by titulo_funcao asc");
            while ($tmp1 = $this->mysql->myLista($tmp2s)) {
                print '<option value="' . $tmp1->id_funcao . '">' . $tmp1->titulo_funcao . '</option>';
            }
        } else {
            print '<option value="0">Aguardando seleção do setor</option>';
        }
    }

    /*
     * Tradando dados do modulo Setor
     */

    function setorList() {
        $Sql = 'select * from phpzon_setor order by titulo_set asc';
        $Lista = new consulta_Class($Sql, 10);
        while ($var = $this->mysql->myLista($Lista->consulta)) {
            $saida .= '<tr>';
            $saida .= '<td class="input-mini"><center>';
            $saida .= '<a onclick="if (!confirm(\'Tem certeza que deseja excluir?\')) return false;" href="' . PATH_ACTION . '/?pagina=delete&id_del=' . $var->id_set . '&origem=' . urlOrigem() . '"';
            $saida .= ' title="Excluir"><i class="icon-trash"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Visualizar"><i class="icon-zoom-in"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=edit&id=' . $var->id_set . '&origem=' . urlOrigem() . '" title="Editar"><i class="icon-edit"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Status"><i class=" icon-ok-circle"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-xlarge">' . $var->titulo_set . '</td>';
            $saida .= '<td>' . $var->descricao_set . '</td>';
            $saida .= '</tr>';
        }
        $GLOBALS['paginacao'] = $Lista->paginacaoM1();

        return $saida;
    }

    function setorBusc($nome = '') {

        if (!empty($nome)) {
            $filtro_nome = " AND phpzon_setor.titulo_set like '%$nome%' ";
        }

        $Sql = "select * from phpzon_setor where 1 $filtro_nome order by titulo_set asc";

        $Lista = new consulta_Class($Sql, 5000);
        while ($var = $this->mysql->myLista($Lista->consulta)) {
            $saida .= '<tr>';
            $saida .= '<td class="input-mini"><center>';
            $saida .= '<a onclick="if (!confirm(\'Tem certeza que deseja excluir?\')) return false;" href="' . PATH_ACTION . '/?pagina=delete&id_del=' . $var->id_set . '&origem=' . urlOrigem() . '"';
            $saida .= ' title="Excluir"><i class="icon-trash"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Visualizar"><i class="icon-zoom-in"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=edit&id=' . $var->id_set . '&origem=' . urlOrigem() . '" title="Editar"><i class="icon-edit"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Status"><i class=" icon-ok-circle"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-xlarge">' . $var->titulo_set . '</td>';
            $saida .= '<td>' . $var->descricao_set . '</td>';
            $saida .= '</tr>';
        }

        $linha = $this->mysql->myLinhas($this->mysql->myConsulta($Sql));
        if ($linha == false) {
            $saida .= '<tr><td>Nenhu registro localizado</td></tr>';
        }


        return $saida;
    }

    function setorEdit($id) {
        $GLOBALS['map'] = 'Novo'; # Nome nag map

        $GLOBALS['id_set'] = '';
        $GLOBALS['titulo_set'] = '';
        $GLOBALS['descricao_set'] = '';

        /*
         * Dados para o formulario de editando
         */
        if ($id > 0) {
            $Sql = 'select * from phpzon_setor where id_set=' . $id;
            $Lista = new consulta_Class($Sql, 1);
            while ($var = $this->mysql->myLista($Lista->consulta)) {

                $GLOBALS['map'] = $var->titulo_set;
                $GLOBALS['id_set'] = $var->id_set;
                $GLOBALS['titulo_set'] = ($var->titulo_set);
                $GLOBALS['descricao_set'] = ($var->descricao_set);
            }
        }
    }

    function setorSalvar() {
        $dados = array(
            'id_set' => mysql_real_escape_string($_POST['id_set']),
            'titulo_set' => mysql_real_escape_string($_POST['titulo_set']),
            'descricao_set' => mysql_real_escape_string($_POST['descricao_set']),
        );
        # campo origatorio
        if (empty($dados['titulo_set'])) {
            $saida .= 'Setor, ';
        } else {
            $test = $this->mysql->myDados("select * from phpzon_setor where titulo_set like '%" . $dados['titulo_set'] . "%'");
            if (strlen($test->titulo_set) > 1) {
                $test2 = $this->mysql->myDados("select * from phpzon_setor where titulo_set like '%" . $test->titulo_set . "%' 
                    and id_set=" . $dados['id_set']);
                if (empty($test2->titulo_set)) {
                    $saida .= 'Este Setor (' . $test->titulo_set . ' | ' . $dados['titulo_set'] . ') já existe, ';
                }
            }
        }

        # campo origatorio
        if (!empty($saida)) {
            print "<div class=\"alert alert-wornig\">";
            print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
            print "<h5>Faltou informar: </h5>";
            print $saida;
            print "</div>";
        } else {
            if ($dados['id_set'] > 0) {
                $this->mysql->myExecuta('phpzon_setor', $dados, 'update', 'id_set=' . $dados['id_set']);
                print "<div class=\"alert alert-success\">";
                print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
                print "Operação realizado com sucesso";
                print "</div>";
            } else {
                $this->mysql->myExecuta('phpzon_setor', $dados);
                $retorno = $this->mysql->myDados('select * from phpzon_setor order by id_set desc');
                print "<div class=\"alert alert-success\">";
                print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
                print "Operação realizado com sucesso";
                print "</div>";
                print '<script>window.location=\'' . urlDistino($_POST['origem']) . '&id=' . $retorno->id_set . '\';</script>';

                ;
            }
        }
    }

    function setorDelete($id_del) {
        if ($id_del > 0) {
            $sql = 'select * from phpzon_funcionario where setor_fun=' . $id_del;
            $sql1 = 'select * from phpzon_funcao where id_funcao_set=' . $id_del;
            $qt = $this->mysql->myLinhas($this->mysql->myConsulta($sql));
            $qt1 = $this->mysql->myLinhas($this->mysql->myConsulta($sql1));
            $cons = $this->mysql->myDados($sql);
            $cons1 = $this->mysql->myDados($sql1);
            if ($cons->id_fun > 0 || $cons1->id_funcao > 0) {
                $msn .= '<div class="alert alert-block alert-error fade in">';
                #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                $msn .= '<p>Este setor não pode ser excluido, primeiro exclua os registros associados. </p>';
                $msn .= '<p>Total de funcionarios associados ' . $qt . '</p>';
                $msn .= '<p>Total de fuções associadas ' . $qt1 . '</p>';
                $msn .= '<p>';
                $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                $msn .= '</p>';
                $msn .= '</div>';

                return $msn;
            } else {
                $err = $this->mysql->myConsulta('delete from phpzon_setor where id_set=' . $id_del . ' limit 1');
                if ($err == true) {
                    $msn .= "<script>window.location = '{Global_voltar_pra_list}'</script>";
                } else {
                    $msn .= '<div class="alert alert-block alert-error fade in">';
                    #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                    $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                    $msn .= '<p>Não possivel excluir este registro</p>';
                    $msn .= '<p>';
                    $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                    #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                    $msn .= '</p>';
                    $msn .= '</div>';
                }
                return $msn;
            }
        }
    }

    /*
     * Tradando dados do modulo Função
     */

    function funcaoList() {
        $Sql = 'select * from phpzon_funcao
            left join phpzon_setor on phpzon_setor.id_set = phpzon_funcao.id_funcao_set
            order by titulo_set, titulo_funcao asc';
        $Lista = new consulta_Class($Sql, 20);
        while ($var = $this->mysql->myLista($Lista->consulta)) {
            $saida .= '<tr>';
            $saida .= '<td class="input-mini"><center>';
            $saida .= '<a onclick="if (!confirm(\'Tem certeza que deseja excluir?\')) return false;" href="' . PATH_ACTION . '/?pagina=delete&id_del=' . $var->id_funcao . '&origem=' . urlOrigem() . '"';
            $saida .= ' title="Excluir"><i class="icon-trash"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Visualizar"><i class="icon-zoom-in"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=edit&id=' . $var->id_funcao . '&origem=' . urlOrigem() . '" title="Editar"><i class="icon-edit"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Status"><i class=" icon-ok-circle"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-xlarge">' . $var->titulo_set . '</td>';
            $saida .= '<td>' . $var->titulo_funcao . '</td>';
            $saida .= '</tr>';
        }
        $GLOBALS['paginacao'] = $Lista->paginacaoM1();

        /*
         * Criando lista de opcoes para o tipo de exame
         */
        $sql_setor = $this->mysql->myConsulta('select * from phpzon_setor order by titulo_set asc');
        $list_setor .= '<option value="0">SELECIONAR</option>';
        while ($var = $this->mysql->myLista($sql_setor)) {
            $list_setor .= '<option value="' . $var->id_set . '"';
            $list_setor .= '>' . $var->titulo_set . '</option>';
        } $GLOBALS['list_setor'] = $list_setor;

        return $saida;
    }

    function funcaoBusc($setor = '', $funcao = '') {

        if (!empty($setor)) {
            $filtro_setor = " AND phpzon_setor.id_set=$setor ";
        }
        if (!empty($funcao)) {
            $filtro_funcao = " AND phpzon_funcao.titulo_funcao like '%$funcao%' ";
        }

        $Sql = "select * from phpzon_funcao
            left join phpzon_setor on phpzon_setor.id_set = phpzon_funcao.id_funcao_set
            where 1 $filtro_setor $filtro_funcao 
            order by titulo_set, titulo_funcao asc";

        $Lista = new consulta_Class($Sql, 5000);
        while ($var = $this->mysql->myLista($Lista->consulta)) {
            $saida .= '<tr>';
            $saida .= '<td class="input-mini"><center>';
            $saida .= '<a onclick="if (!confirm(\'Tem certeza que deseja excluir?\')) return false;" href="' . PATH_ACTION . '/?pagina=delete&id_del=' . $var->id_funcao . '&origem=' . urlOrigem() . '"';
            $saida .= ' title="Excluir"><i class="icon-trash"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Visualizar"><i class="icon-zoom-in"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=edit&id=' . $var->id_funcao . '&origem=' . urlOrigem() . '" title="Editar"><i class="icon-edit"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Status"><i class=" icon-ok-circle"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-xlarge">' . $var->titulo_set . '</td>';
            $saida .= '<td>' . $var->titulo_funcao . '</td>';
            $saida .= '</tr>';
        }

        $linha = $this->mysql->myLinhas($this->mysql->myConsulta($Sql));
        if ($linha == false) {
            $saida .= '<tr><td>Nenhu registro localizado</td></tr>';
        }


        return $saida;
    }

    function funcaoEdit($id) {
        $GLOBALS['map'] = 'Novo'; # Nome nag map

        $GLOBALS['id_funcao'] = '';
        $GLOBALS['id_funcao_set'] = '';
        $GLOBALS['titulo_funcao'] = '';
        $GLOBALS['descricao_funcao'] = '';

        /*
         * Dados para o formulario de editando
         */
        if ($id > 0) {
            $Sql = 'select * from phpzon_funcao where id_funcao=' . $id;
            $Lista = new consulta_Class($Sql, 1);
            while ($var = $this->mysql->myLista($Lista->consulta)) {

                $GLOBALS['map'] = $var->titulo_funcao;
                $GLOBALS['id_funcao'] = $var->id_funcao;
                $GLOBALS['id_funcao_set'] = $var->id_funcao_set;
                $GLOBALS['titulo_funcao'] = ($var->titulo_funcao);
                $GLOBALS['descricao_funcao'] = ($var->descricao_funcao);
            }
        }

        /*
         * Criando lista de opcoes para select setor
         */
        $sql_setor = $this->mysql->myConsulta('select * from phpzon_setor');
        while ($var = $this->mysql->myLista($sql_setor)) {
            $list_setor .= '<option value="' . $var->id_set . '"';
            if ($GLOBALS['id_funcao_set'] == $var->id_set) {
                $list_setor .= 'selected="selected">' . $var->titulo_set;
            } else {
                $list_setor .= '>' . $var->titulo_set;
            }
            $list_setor .= '</option>';
        } $GLOBALS['select_list_set'] = $list_setor;
    }

    function funcaoSalvar() {
        $dados = array(
            'id_funcao' => mysql_real_escape_string($_POST['id_funcao']),
            'id_funcao_set' => mysql_real_escape_string($_POST['id_funcao_set']),
            'titulo_funcao' => mysql_real_escape_string($_POST['titulo_funcao']),
            'descricao_funcao' => mysql_real_escape_string($_POST['descricao_funcao']),
        );

        # campo origatorio
        if (empty($dados['titulo_funcao'])) {
            $saida .= 'Função, ';
        } else {
            $test = $this->mysql->myDados("select * from phpzon_funcao where titulo_funcao like '%" . $dados['titulo_funcao'] . "%' 
                 and id_funcao_set=" . $dados['id_funcao_set']);
            if (strlen($test->titulo_funcao) > 1) {
                $test2 = $this->mysql->myDados("select * from phpzon_funcao where titulo_funcao like '%" . $test->titulo_funcao . "%' 
                    and id_funcao=" . $dados['id_funcao'] . " and id_funcao_set=" . $dados['id_funcao_set']);
                if (empty($test2->titulo_funcao)) {
                    $saida .= 'Esta Função (' . $test->titulo_funcao . ' | ' . $dados['titulo_funcao'] . ') já existe, ';
                }
            }
        }

        # campo origatorio
        if (!empty($saida)) {
            print "<div class=\"alert alert-wornig\">";
            print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
            print "<h5>Faltou informar: </h5>";
            print $saida;
            print "</div>";
        } else {
            if ($dados['id_funcao'] > 0) {
                $this->mysql->myExecuta('phpzon_funcao', $dados, 'update', 'id_funcao=' . $dados['id_funcao']);
                print "<div class=\"alert alert-success\">";
                print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
                print "Operação realizado com sucesso";
                print "</div>";
            } else {
                $this->mysql->myExecuta('phpzon_funcao', $dados);
                $retorno = $this->mysql->myDados('select * from phpzon_funcao order by id_funcao desc');
                print "<div class=\"alert alert-success\">";
                print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
                print "Operação realizado com sucesso";
                print "</div>";
                print '<script>window.location=\'' . urlDistino($_POST['origem']) . '&id=' . $retorno->id_funcao . '\';</script>';

                ;
            }
        }
    }

    function funcaoDelete($id_del) {
        if ($id_del > 0) {
            $sql = 'select * from phpzon_funcionario where funcao_fun=' . $id_del;
            $qt = $this->mysql->myLinhas($this->mysql->myConsulta($sql));
            $cons = $this->mysql->myDados($sql);
            if ($cons->id_fun > 0) {
                $msn .= '<div class="alert alert-block alert-error fade in">';
                #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                $msn .= '<p>Esta função não pode ser excluido, primeiro exclua as funcionarios associados. </p>';
                $msn .= '<p>Total de funcionarios associados ' . $qt . '</p>';
                $msn .= '<p>';
                $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                $msn .= '</p>';
                $msn .= '</div>';

                return $msn;
            } else {
                $err = $this->mysql->myConsulta('delete from phpzon_funcao where id_funcao=' . $id_del . ' limit 1');
                if ($err == true) {
                    $msn .= "<script>window.location = '{Global_voltar_pra_list}'</script>";
                } else {
                    $msn .= '<div class="alert alert-block alert-error fade in">';
                    #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                    $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                    $msn .= '<p>Não possivel excluir este registro</p>';
                    $msn .= '<p>';
                    $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                    #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                    $msn .= '</p>';
                    $msn .= '</div>';
                }
                return $msn;
            }
        }
    }

    /*
     * Tradando dados do modulo Ficha clinica
     */

    function fichaClinicaList() {
        $Sql = "SELECT DISTINCT a.*, c.* FROM phpzon_funcionario a
                LEFT JOIN phpzon_consultas b ON (b.funcionario_cons = a.id_fun)
                LEFT JOIN phpzon_situacao_funcionario c ON (c.id_sit_fun = a.situacao_fun)
                WHERE b.lixeira_cons=0 
                ORDER BY a.nome_fun ASC";
        
        $Lista = new consulta_Class($Sql, 20);
        while ($var = $this->mysql->myLista($Lista->consulta)) {
            
            $cont = $this->mysql->myConsulta('select * from phpzon_ficha_clinica where ficha_cod_fun = '.$var->id_fun);
            $qt = $this->mysql->myLinhas($cont);
            # Funcionario demitido
            if ($var->situacao_fun == 2) {
                $saida .= '<tr class="error">';
            } else {
                $saida .= '<tr>';
            }
            $saida .= '<td class="input-mini"><center>';
            #$saida .= '<a onclick="if (!confirm(\'Tem certeza que deseja excluir?\')) return false;" href="' . PATH_ACTION . '/?pagina=delete&id_del=' . $var->id_fun . '&origem=' . urlOrigem() . '"';
            #$saida .= ' title="Excluir"><i class="icon-trash"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=edit&id=' . $var->id_fun . '&origem=' . urlOrigem() . '"><i class="icon-zoom-in" title="Visualizar"></i></a>&nbsp;';
            #$saida .= '<a href="' . PATH_ACTION . '/?pagina=edit&id=' . $var->id_fun . '&origem='.urlOrigem().'" title="Editar"><i class="icon-edit"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Status"><i class=" icon-ok-circle"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-mini">' . $var->drt_fun . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_fun) . '</td>';
            $saida .= '<td class="input-small">' . $var->cpf_fun . '</td>';
            $saida .= '<td class="input-small">' . $var->rg_fun . '</td>';
            $saida .= '<td class="input-mini">' . $qt . '</td>';
            $saida .= '<td class="input-mini">' . $var->titulo_sit_fun . '</td>';
            $saida .= '</tr>';
        }
        $GLOBALS['paginacao'] = $Lista->paginacaoM1();

        return $saida;
    }

    function fichaClinicaBusc($nome = '', $drt = '') {

        if (!empty($nome)) {
            $filtro_nome = " AND phpzon_funcionario.nome_fun like '%$nome%' ";
        }
        if (strlen($drt) > 0) {
            $filtro_drt = " AND phpzon_consultas.id_cons=$drt ";
        }

        $Sql = "SELECT DISTINCT phpzon_funcionario.*, phpzon_situacao_funcionario.* FROM phpzon_funcionario
                LEFT JOIN phpzon_consultas ON (phpzon_consultas.funcionario_cons = phpzon_funcionario.id_fun)
                LEFT JOIN phpzon_situacao_funcionario ON (phpzon_situacao_funcionario.id_sit_fun = phpzon_funcionario.situacao_fun)
                WHERE 1 $filtro_nome $filtro_drt  AND phpzon_consultas.lixeira_cons=0 
                ORDER BY nome_fun, drt_fun ASC";

        $Lista = new consulta_Class($Sql, 5000);

        while ($var = $this->mysql->myLista($Lista->consulta)) {
            
            $cont = $this->mysql->myConsulta('select * from phpzon_ficha_clinica where ficha_cod_fun = '.$var->id_fun);
            $qt = $this->mysql->myLinhas($cont);
            
            # Funcionario demitido
            if ($var->situacao_fun == 2) {
                $saida .= '<tr class="error">';
            } else {
                $saida .= '<tr>';
            }
            $saida .= '<td class="input-mini"><center>';
            #$saida .= '<a onclick="if (!confirm(\'Tem certeza que deseja excluir?\')) return false;" href="' . PATH_ACTION . '/?pagina=delete&id_del=' . $var->id_fun . '&origem=' . urlOrigem() . '"';
            #$saida .= ' title="Excluir"><i class="icon-trash"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=edit&id=' . $var->id_fun . '&origem=' . urlOrigem() . '"><i class="icon-zoom-in" title="Visualizar"></i></a>&nbsp;';
            #$saida .= '<a href="' . PATH_ACTION . '/?pagina=edit&id=' . $var->id_fun . '&origem='.urlOrigem().'" title="Editar"><i class="icon-edit"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Status"><i class=" icon-ok-circle"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-mini">' . $var->drt_fun . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_fun) . '</td>';
            $saida .= '<td class="input-small">' . $var->cpf_fun . '</td>';
            $saida .= '<td class="input-small">' . $var->rg_fun . '</td>';
            $saida .= '<td class="input-mini">' . $qt . '</td>';
            $saida .= '<td class="input-mini">' . $var->titulo_sit_fun . '</td>';
            $saida .= '</tr>';
        }

        $linha = $this->mysql->myLinhas($this->mysql->myConsulta($Sql));
        if ($linha == false) {
            $saida .= '<tr><td>Nenhu registro localizado</td></tr>';
        }

        return $saida;
    }

    function fichaClinicaZom($id) {
        $GLOBALS['map'] = 'Novo'; # Nome nag map

        $GLOBALS['id_cons'] = '';
        $GLOBALS['codigo'] = '';
        $GLOBALS['drt'] = '';
        $GLOBALS['nome'] = '';
        $GLOBALS['cpf'] = '';
        $GLOBALS['rg'] = '';
        $GLOBALS['estado_civil'] = '';
        $GLOBALS['sexo'] = '';
        $GLOBALS['idade'] = '';
        $GLOBALS['setor'] = '';
        $GLOBALS['funcao'] = '';
        $GLOBALS['dt_atendimento'] = '';
        $GLOBALS['medico'] = '';
        # Atendimento
        $GLOBALS['tipo_exame'] = '';
        $GLOBALS['pa'] = '';
        $GLOBALS['peso'] = '';
        $GLOBALS['altura'] = '';
        $GLOBALS['imc'] = '';
        $GLOBALS['obesidade'] = '';
        # Anamnese
        $GLOBALS['ficha_data_hemo'] = '';
        $GLOBALS['ficha_valor_hemo'] = '';
        $GLOBALS['ficha_situ_hemo'] = '';

        $GLOBALS['ficha_data_coles'] = '';
        $GLOBALS['ficha_valor_coles'] = '';
        $GLOBALS['ficha_situ_coles'] = '';

        $GLOBALS['ficha_data_trig'] = '';
        $GLOBALS['ficha_valor_trig'] = '';
        $GLOBALS['ficha_situ_trig'] = '';

        $GLOBALS['ficha_data_glic'] = '';
        $GLOBALS['ficha_valor_glic'] = '';
        $GLOBALS['ficha_situ_glic'] = '';

        $GLOBALS['ficha_data_clsa'] = '';
        $GLOBALS['ficha_valor_clsa'] = '';
        $GLOBALS['ficha_situ_clsa'] = '';

        $GLOBALS['ficha_data_prfe'] = '';
        $GLOBALS['ficha_valor_prfe'] = '';
        $GLOBALS['ficha_situ_prfe'] = '';

        $GLOBALS['ficha_data_smur'] = '';
        $GLOBALS['ficha_valor_smur'] = '';
        $GLOBALS['ficha_situ_smur'] = '';

        $GLOBALS['ficha_data_sohe'] = '';
        $GLOBALS['ficha_valor_sohe'] = '';
        $GLOBALS['ficha_situ_sohe'] = '';

        $GLOBALS['ficha_data_soto'] = '';
        $GLOBALS['ficha_valor_soto'] = '';
        $GLOBALS['ficha_situ_soto'] = '';

        $GLOBALS['ficha_data_rxtp'] = '';
        $GLOBALS['ficha_valor_rxtp'] = '';
        $GLOBALS['ficha_situ_rxtp'] = '';

        $GLOBALS['ficha_data_rxcl'] = '';
        $GLOBALS['ficha_valor_rxcl'] = '';
        $GLOBALS['ficha_situ_rxcl'] = '';

        $GLOBALS['ficha_data_rxto'] = '';
        $GLOBALS['ficha_valor_rxto'] = '';
        $GLOBALS['ficha_situ_rxto'] = '';

        $GLOBALS['ficha_data_ecg'] = '';
        $GLOBALS['ficha_valor_ecg'] = '';
        $GLOBALS['ficha_situ_ecg'] = '';

        $GLOBALS['ficha_data_eeg'] = '';
        $GLOBALS['ficha_valor_eeg'] = '';
        $GLOBALS['ficha_situ_eeg'] = '';

        $GLOBALS['ficha_data_audi'] = '';
        $GLOBALS['ficha_valor_audi'] = '';
        $GLOBALS['ficha_situ_audi'] = '';

        $GLOBALS['ficha_data_vdrl'] = '';
        $GLOBALS['ficha_valor_vdrl'] = '';
        $GLOBALS['ficha_situ_vdrl'] = '';

        $GLOBALS['ficha_data_ava_ofta'] = '';
        $GLOBALS['ficha_valor_ava_ofta'] = '';
        $GLOBALS['ficha_situ_ava_ofta'] = '';

        $GLOBALS['ficha_data_acu_visu'] = '';
        $GLOBALS['ficha_valor_acu_visu'] = '';
        $GLOBALS['ficha_situ_acu_visu'] = '';

        $GLOBALS['ficha_data_ava_card'] = '';
        $GLOBALS['ficha_valor_ava_card'] = '';
        $GLOBALS['ficha_situ_ava_card'] = '';

        $GLOBALS['ficha_data_ava_espe'] = '';
        $GLOBALS['ficha_valor_ava_espe'] = '';
        $GLOBALS['ficha_situ_ava_espe'] = '';

        /*
         * Dados para o formulario de editando
         */
        if ($id > 0) {
            $Sql = "SELECT a.*, b.*, c.nome_med,c.id_med, d.*, e.*, f.*, g.*, h.*, i.*, j.*
                    FROM phpzon_consultas a
                    LEFT JOIN phpzon_funcionario b      ON (b.id_fun         = a.funcionario_cons)
                    LEFT JOIN phpzon_medico c           ON (c.id_med         = a.medico_cons)
                    LEFT JOIN phpzon_situacao_ficha d   ON (d.id_sit_fic     = a.id_sit_cons)
                    LEFT JOIN phpzon_estado_civil e     ON (e.id_esci        = b.civil_fun)
                    LEFT JOIN phpzon_sexo f             ON (f.id_sexo        = b.sexo_fun)
                    LEFT JOIN phpzon_setor g            ON (g.id_set         = b.setor_fun)
                    LEFT JOIN phpzon_funcao h           ON (h.id_funcao      = b.funcao_fun)
                    LEFT JOIN phpzon_ficha_clinica i    ON (i.ficha_cod_cons = a.id_cons)
                    LEFT JOIN phpzon_tipo_exame j       ON (j.id_exa         = i.ficha_tipo_exa)
                    WHERE a.funcionario_cons=" . $id . " AND i.ficha_cod_fun=" . $id . " AND a.lixeira_cons  = 0 ORDER BY a.id_cons ASC";
            $Lista = new consulta_Class($Sql, 1);
            while ($var = $this->mysql->myLista($Lista->consulta)) {
                $GLOBALS['map'] = utf8_encode($var->nome_fun);
                $GLOBALS['relIdConsulta'] = base64_encode($var->id_cons);

                # Identificação
                $GLOBALS['id_cons'] = $var->id_fun;
                $GLOBALS['codigo'] = $var->id_cons;
                $GLOBALS['drt'] = $var->drt_fun;
                $GLOBALS['nome'] = $var->nome_fun;
                $GLOBALS['cpf'] = $var->cpf_fun;
                $GLOBALS['rg'] = $var->rg_fun;
                $GLOBALS['estado_civil'] = $var->nome_esci;
                $GLOBALS['sexo'] = $var->nome_sexo;
                $GLOBALS['idade'] = getIdade(dataYMD_DMY($var->data)) . ' Anos';
                $GLOBALS['setor'] = $var->titulo_set;
                $GLOBALS['funcao'] = $var->titulo_funcao;
                $GLOBALS['dt_atendimento'] = $var->data_hora_aten_cons;
                $GLOBALS['medico'] = $var->nome_med;
                # Atendimento
                $GLOBALS['tipo_exame'] = $var->titulo_exa;
                $GLOBALS['pa'] = $var->ficha_pa;
                $GLOBALS['peso'] = $var->ficha_peso;
                $GLOBALS['altura'] = $var->ficha_altu;
                $GLOBALS['imc'] = $var->ficha_imc;
                $GLOBALS['obesidade'] = $var->ficha_obes;
                # Anamnese
                $GLOBALS['anamnese'] = $var->ficha_obs;
                # Exames Complementáres 
                $GLOBALS['ficha_data_hemo'] = dataYMD_DMY($var->ficha_data_hemo);
                $GLOBALS['ficha_valor_hemo'] = $var->ficha_valor_hemo;
                $GLOBALS['ficha_situ_hemo'] = $var->ficha_situ_hemo;

                $GLOBALS['ficha_data_coles'] = dataYMD_DMY($var->ficha_data_coles);
                $GLOBALS['ficha_valor_coles'] = $var->ficha_valor_coles;
                $GLOBALS['ficha_situ_coles'] = $var->ficha_situ_coles;

                $GLOBALS['ficha_data_trig'] = dataYMD_DMY($var->ficha_data_trig);
                $GLOBALS['ficha_valor_trig'] = $var->ficha_valor_trig;
                $GLOBALS['ficha_situ_trig'] = $var->ficha_situ_trig;

                $GLOBALS['ficha_data_glic'] = dataYMD_DMY($var->ficha_data_glic);
                $GLOBALS['ficha_valor_glic'] = $var->ficha_valor_glic;
                $GLOBALS['ficha_situ_glic'] = $var->ficha_situ_glic;

                $GLOBALS['ficha_data_clsa'] = dataYMD_DMY($var->ficha_data_clsa);
                $GLOBALS['ficha_valor_clsa'] = $var->ficha_valor_clsa;
                $GLOBALS['ficha_situ_clsa'] = $var->ficha_situ_clsa;

                $GLOBALS['ficha_data_prfe'] = dataYMD_DMY($var->ficha_data_prfe);
                $GLOBALS['ficha_valor_prfe'] = $var->ficha_valor_prfe;
                $GLOBALS['ficha_situ_prfe'] = $var->ficha_situ_prfe;

                $GLOBALS['ficha_data_smur'] = dataYMD_DMY($var->ficha_data_smur);
                $GLOBALS['ficha_valor_smur'] = $var->ficha_valor_smur;
                $GLOBALS['ficha_situ_smur'] = $var->ficha_situ_smur;

                $GLOBALS['ficha_data_sohe'] = dataYMD_DMY($var->ficha_data_sohe);
                $GLOBALS['ficha_valor_sohe'] = $var->ficha_valor_sohe;
                $GLOBALS['ficha_situ_sohe'] = $var->ficha_situ_sohe;

                $GLOBALS['ficha_data_soto'] = dataYMD_DMY($var->ficha_data_soto);
                $GLOBALS['ficha_valor_soto'] = $var->ficha_valor_soto;
                $GLOBALS['ficha_situ_soto'] = $var->ficha_situ_soto;

                $GLOBALS['ficha_data_rxtp'] = dataYMD_DMY($var->ficha_data_rxtp);
                $GLOBALS['ficha_valor_rxtp'] = $var->ficha_valor_rxtp;
                $GLOBALS['ficha_situ_rxtp'] = $var->ficha_situ_rxtp;

                $GLOBALS['ficha_data_rxcl'] = dataYMD_DMY($var->ficha_data_rxcl);
                $GLOBALS['ficha_valor_rxcl'] = $var->ficha_valor_rxcl;
                $GLOBALS['ficha_situ_rxcl'] = $var->ficha_situ_rxcl;

                $GLOBALS['ficha_data_rxto'] = dataYMD_DMY($var->ficha_data_rxto);
                $GLOBALS['ficha_valor_rxto'] = $var->ficha_valor_rxto;
                $GLOBALS['ficha_situ_rxto'] = $var->ficha_situ_rxto;

                $GLOBALS['ficha_data_ecg'] = dataYMD_DMY($var->ficha_data_ecg);
                $GLOBALS['ficha_valor_ecg'] = $var->ficha_valor_ecg;
                $GLOBALS['ficha_situ_ecg'] = $var->ficha_situ_ecg;

                $GLOBALS['ficha_data_eeg'] = dataYMD_DMY($var->ficha_data_eeg);
                $GLOBALS['ficha_valor_eeg'] = $var->ficha_valor_eeg;
                $GLOBALS['ficha_situ_eeg'] = $var->ficha_situ_eeg;

                $GLOBALS['ficha_data_audi'] = dataYMD_DMY($var->ficha_data_audi);
                $GLOBALS['ficha_valor_audi'] = $var->ficha_valor_audi;
                $GLOBALS['ficha_situ_audi'] = $var->ficha_situ_audi;

                $GLOBALS['ficha_data_vdrl'] = dataYMD_DMY($var->ficha_data_vdrl);
                $GLOBALS['ficha_valor_vdrl'] = $var->ficha_valor_vdrl;
                $GLOBALS['ficha_situ_vdrl'] = $var->ficha_situ_vdrl;

                $GLOBALS['ficha_data_ava_ofta'] = dataYMD_DMY($var->ficha_data_ava_ofta);
                $GLOBALS['ficha_valor_ava_ofta'] = $var->ficha_valor_ava_ofta;
                $GLOBALS['ficha_situ_ava_ofta'] = $var->ficha_situ_ava_ofta;

                $GLOBALS['ficha_data_acu_visu'] = dataYMD_DMY($var->ficha_data_acu_visu);
                $GLOBALS['ficha_valor_acu_visu'] = $var->ficha_valor_acu_visu;
                $GLOBALS['ficha_situ_acu_visu'] = $var->ficha_situ_acu_visu;

                $GLOBALS['ficha_data_ava_card'] = dataYMD_DMY($var->ficha_data_ava_card);
                $GLOBALS['ficha_valor_ava_card'] = $var->ficha_valor_ava_card;
                $GLOBALS['ficha_situ_ava_card'] = $var->ficha_situ_ava_card;

                $GLOBALS['ficha_data_ava_espe'] = dataYMD_DMY($var->ficha_data_ava_espe);
                $GLOBALS['ficha_valor_ava_espe'] = $var->ficha_valor_ava_espe;
                $GLOBALS['ficha_situ_ava_espe'] = $var->ficha_situ_ava_espe;
            }
        }
        $Lista->paginacaoM3();
        $GLOBALS['btnAnt'] = $Lista->btnAnt;
        $GLOBALS['btnPro'] = $Lista->btnPro;
        $GLOBALS['btnAtu'] = $Lista->btnAtu;

        /*
         * Criando lista de opcoes para o sexo do formulario
         */
        $sql_sexo = $this->mysql->myConsulta('select * from phpzon_sexo');
        while ($var = $this->mysql->myLista($sql_sexo)) {
            $list_sexo .= '<option value="' . $var->cod_sexo . '"';
            $list_sexo .= (($GLOBALS['sexo'] == $var->cod_sexo) ? 'selected="selected"' : '' ) . '>' . $var->nome_sexo . '</option>';
        } $GLOBALS['list_sexo'] = $list_sexo;

        /*
         * Criando lista de opcoes para estado civil do formulario
         */
        $sql_civil = $this->mysql->myConsulta('select * from phpzon_estado_civil');
        while ($var = $this->mysql->myLista($sql_civil)) {
            $list_civil .= '<option value="' . $var->id_esci . '"';
            $list_civil .= (($GLOBALS['estado_civil'] == $var->id_esci) ? 'selected="selected"' : '' ) . '>' . $var->nome_esci . '</option>';
        } $GLOBALS['list_civil'] = $list_civil;

        /*
         * Criando lista de opcoes para select setor
         */
        $sql_setor = $this->mysql->myConsulta('select * from phpzon_setor');
        while ($var = $this->mysql->myLista($sql_setor)) {
            $list_setor .= '<option value="' . $var->id_set . '"';
            if ($GLOBALS['setor'] == $var->id_set) {
                $list_setor .= 'selected="selected">' . $var->titulo_set;
            } else {
                $list_setor .= '>' . $var->titulo_set;
            }
            $list_setor .= '</option>';
        } $GLOBALS['list_setor'] = $list_setor;

        /*
         * Criando lista de opcoes para select funcao
         */
        $sql_funcao = $this->mysql->myConsulta('select * from phpzon_funcao where id_funcao_set=' . $GLOBALS['setor']);
        while ($var = $this->mysql->myLista($sql_funcao)) {
            $list_funcao .= '<option value="' . $var->id_funcao . '"';
            $list_funcao .= (($GLOBALS['funcao'] == $var->id_funcao) ? 'selected="selected"' : '' ) . '>' . $var->titulo_funcao . '</option>';
        } $GLOBALS['list_funcao'] = $list_funcao;
    }

    function fichaClinicaLixeira($id_del) {
        if ($id_del > 0) {
            $result = $this->mysql->myConsulta('update phpzon_consultas set lixeira_cons=1 where id_cons=' . $id_del . ' limit 1');
            if ($result == true) {
                #$this->mysql->myConsulta('delete from phpzon_ficha_clinica where ficha_cod_cons=' . $id_del . ' limit 1');
            }
        }
    }

    /*
     * Tradando dados do modulo Consultas Arquivadas
     */

    function consultaArquivadaList() {

        $Sql = "SELECT * FROM phpzon_consultas
               LEFT JOIN phpzon_funcionario ON (phpzon_funcionario.id_fun = phpzon_consultas.funcionario_cons)
               LEFT JOIN phpzon_medico ON (phpzon_medico.id_med = phpzon_consultas.medico_cons)
               LEFT JOIN phpzon_tipo_exame ON (phpzon_tipo_exame.id_exa = phpzon_consultas.tipo_cons)
               LEFT JOIN phpzon_situacao_ficha ON (phpzon_situacao_ficha.id_sit_fic = phpzon_consultas.id_sit_cons)
               WHERE phpzon_consultas.lixeira_cons=0 AND phpzon_consultas.arquivada_cons=1 ORDER BY phpzon_funcionario.nome_fun ASC";

        $Lista = new consulta_Class($Sql, 20);

        while ($var = $this->mysql->myLista($Lista->consulta)) {
            # Funcionario demitido
            if ($var->situacao_fun == 2) {
                $saida .= '<tr class="error">';
            } else {
                # Atendimento em espera
                if ($var->id_sit_cons == 1) {
                    $saida .= '<tr class="warning">';
                }
                # Atendimento em andamento
                elseif ($var->id_sit_cons == 2) {
                    $saida .= '<tr class="info">';
                }
                # Atendimento finalizado
                elseif ($var->id_sit_cons == 3) {
                    $saida .= '<tr class="success">';
                }
                # Atendimento cancelado
                elseif ($var->id_sit_cons == 4) {
                    $saida .= '<tr class="error">';
                } else {
                    $saida .= '<tr>';
                }
            }


            $saida .= '<td class="input-mini"><center>';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=visualizar&id_vis=' . $var->id_cons . '&origem=' . urlOrigem() . '" title="Visualizar"><i class="icon-zoom-in"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=arquivar&id_arq=' . $var->id_cons . '&origem=' . urlOrigem() . '" title="Enviar para lista de atendimento"><i class="icon-share"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-mini">' . $var->id_cons . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_fun) . '</td>';
            $saida .= '<td class="input-medium">' . $var->cpf_fun . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_med) . '</td>';
            $saida .= '<td class="input-small">' . utf8_encode($var->titulo_exa) . '</td>';
            $saida .= '<td class="input-medium">' . utf8_encode($var->titulo_sit_fic) . '</td>';

            $saida .= '</tr>';
        }

        $linha = $this->mysql->myLinhas($this->mysql->myConsulta($Sql));
        if ($linha == false) {
            $saida .= '<tr><td>Nenhu registro localizado</td></tr>';
        }

        /*
         * Criando lista de opcoes para o tipo de exame
         */
        $sql_situacao_ficha = $this->mysql->myConsulta('select * from phpzon_situacao_ficha WHERE id_sit_fic IN (1,3) order by titulo_sit_fic asc');
        $list_situacao_ficha .= '<option value="0">SELECIONAR</option>';
        while ($var = $this->mysql->myLista($sql_situacao_ficha)) {
            $list_situacao_ficha .= '<option value="' . $var->id_sit_fic . '"';
            $list_situacao_ficha .= '>' . $var->titulo_sit_fic . '</option>';
        } $GLOBALS['list_situacao_ficha'] = $list_situacao_ficha;

        $GLOBALS['paginacao'] = $Lista->paginacaoM1();

        return $saida;
    }

    function consultaArquivadaBusc($nome = '', $codigo = '', $situacao = '') {

        if (!empty($nome)) {
            $filtro_nome = " AND phpzon_funcionario.nome_fun like '%$nome%' ";
        }
        if (strlen($codigo) > 0) {
            $filtro_codigo = " AND phpzon_consultas.id_cons=$codigo ";
        }
        if ($situacao > 0) {
            $filtro_situacao = " AND phpzon_situacao_ficha.id_sit_fic=$situacao ";
        }

        $Sql = "SELECT * FROM phpzon_consultas
               LEFT JOIN phpzon_funcionario ON (phpzon_funcionario.id_fun = phpzon_consultas.funcionario_cons)
               LEFT JOIN phpzon_medico ON (phpzon_medico.id_med = phpzon_consultas.medico_cons)
               LEFT JOIN phpzon_tipo_exame ON (phpzon_tipo_exame.id_exa = phpzon_consultas.tipo_cons)
               LEFT JOIN phpzon_situacao_ficha ON (phpzon_situacao_ficha.id_sit_fic = phpzon_consultas.id_sit_cons)
               WHERE 1 $filtro_nome $filtro_codigo $filtro_situacao AND phpzon_consultas.lixeira_cons=0 AND phpzon_consultas.arquivada_cons=1 ORDER BY phpzon_funcionario.nome_fun ASC";

        $Lista = new consulta_Class($Sql, 5000);

        while ($var = $this->mysql->myLista($Lista->consulta)) {
            # Funcionario demitido
            if ($var->situacao_fun == 2) {
                $saida .= '<tr class="error">';
            } else {
                # Atendimento em espera
                if ($var->id_sit_cons == 1) {
                    $saida .= '<tr class="warning">';
                }
                # Atendimento em andamento
                elseif ($var->id_sit_cons == 2) {
                    $saida .= '<tr class="info">';
                }
                # Atendimento finalizado
                elseif ($var->id_sit_cons == 3) {
                    $saida .= '<tr class="success">';
                }
                # Atendimento cancelado
                elseif ($var->id_sit_cons == 4) {
                    $saida .= '<tr class="error">';
                } else {
                    $saida .= '<tr>';
                }
            }
            $saida .= '<td class="input-mini"><center>';
            $saida .= '<a href="#" title="Visualizar"><i class="icon-zoom-in"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=arquivar&id_arq=' . $var->id_cons . '&origem=' . urlOrigem() . '" title="Enviar para lista de atendimento"><i class="icon-share"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-mini">' . $var->id_cons . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_fun) . '</td>';
            $saida .= '<td class="input-small">' . $var->rg_fun . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_med) . '</td>';
            $saida .= '<td class="input-small">' . utf8_encode($var->titulo_exa) . '</td>';
            $saida .= '<td class="input-large">' . utf8_encode($var->titulo_sit_fic) . '</td>';

            $saida .= '</tr>';
        }

        $linha = $this->mysql->myLinhas($this->mysql->myConsulta($Sql));
        if ($linha == false) {
            $saida .= '<tr><td>Nenhu registro localizado</td></tr>';
        }


        return $saida;
    }

    function consultaArquivadaVisua($id) {
        $GLOBALS['map'] = 'Novo'; # Nome nag map
        # Dados consulta
        $GLOBALS['id_cons'] = '';
        $GLOBALS['tipo_cons'] = '';
        $GLOBALS['funcionario_cons'] = '';
        $GLOBALS['medico_cons'] = '';
        $GLOBALS['obs_cons'] = '';
        $GLOBALS['data_hora_aten_cons'] = '';
        # Dados ficha
        $GLOBALS['ficha_pa'] = '';
        $GLOBALS['ficha_peso'] = '';
        $GLOBALS['ficha_altu'] = '';
        $GLOBALS['ficha_imc'] = '';
        $GLOBALS['ficha_obes'] = '';

        $soAtivo = 'AND situacao_fun in(0,1)';

        /*
         * Dados para o formulario de editando
         */
        if ($id > 0) {

            $Sql = "SELECT a.*, i.*
                    FROM phpzon_consultas a
                    LEFT JOIN phpzon_ficha_clinica i ON (i.ficha_cod_cons = a.id_cons)
                    WHERE a.id_cons=" . $id . " AND a.lixeira_cons=0 AND a.arquivada_cons=1 ORDER BY a.id_cons ASC";
            $Lista = new consulta_Class($Sql, 1);

            while ($var = $this->mysql->myLista($Lista->consulta)) {
                $GLOBALS['map'] = 'Consulta: ' . $var->id_cons;
                # Dados consulta
                $GLOBALS['id_cons'] = $var->id_cons;
                $GLOBALS['tipo_cons'] = $var->tipo_cons;
                $GLOBALS['funcionario_cons'] = $var->funcionario_cons;
                $GLOBALS['medico_cons'] = $var->medico_cons;
                $GLOBALS['obs_cons'] = $var->obs_cons;
                $GLOBALS['data_hora_aten_cons'] = $var->data_hora_aten_cons;
                # Dados ficha
                $GLOBALS['ficha_pa'] = (($var->ficha_pa == false) ? '' : $var->ficha_pa);
                $GLOBALS['ficha_peso'] = (($var->ficha_peso == false) ? '' : $var->ficha_peso);
                $GLOBALS['ficha_altu'] = (($var->ficha_altu == false) ? '' : $var->ficha_altu);
                $GLOBALS['ficha_imc'] = (($var->ficha_imc == false) ? '' : $var->ficha_imc);
                $GLOBALS['ficha_obes'] = (($var->ficha_obes == false) ? '' : $var->ficha_obes);
            }

            $soAtivo = '';
        }

        /*
         * Criando lista de opcoes para o tipo de exame
         */
        $sql_tipo_exame = $this->mysql->myConsulta('select * from phpzon_tipo_exame order by titulo_exa asc');
        $list_tipo_exame .= '<option value="0">SELECIONAR</option>';
        while ($var = $this->mysql->myLista($sql_tipo_exame)) {
            $list_tipo_exame .= '<option value="' . $var->id_exa . '"';
            $list_tipo_exame .= (($GLOBALS['tipo_cons'] == $var->id_exa) ? 'selected="selected"' : '' ) . '>' . $var->titulo_exa . '</option>';
        } $GLOBALS['list_tipo_exame'] = $list_tipo_exame;

        /*
         * Criando lista de opcoes para os funcionarios <optgroup label=""></optgroup>
         */
        $sql_funcionario = $this->mysql->myConsulta('select * from phpzon_funcionario where cpf_fun > 0 ' . $soAtivo . ' order by nome_fun asc');
        $list_funcionario .= '<option value="0">SELECIONAR</option>';
        while ($var = $this->mysql->myLista($sql_funcionario)) {
            $list_funcionario .= '<optgroup label="' . $var->cpf_fun . '">';
            $list_funcionario .= '<option value="' . $var->id_fun . '"';
            $list_funcionario .= (($GLOBALS['funcionario_cons'] == $var->id_fun) ? 'selected="selected"' : '' ) . '>' . $var->nome_fun . '</option>';
            $list_funcionario .= '</optgroup>';
        } $GLOBALS['list_funcionario'] = $list_funcionario;

        /*
         * Criando lista de opcoes para select funcao
         */
        $sql_medico = $this->mysql->myConsulta('select * from phpzon_medico order by nome_med asc');
        $list_medico .= '<option value="0">SELECIONAR</option>';
        while ($var = $this->mysql->myLista($sql_medico)) {
            $list_medico .= '<option value="' . $var->id_med . '"';
            $list_medico .= (($GLOBALS['medico_cons'] == $var->id_med) ? 'selected="selected"' : '' ) . '>' . $var->nome_med . '</option>';
        } $GLOBALS['list_medico'] = $list_medico;
    }

    function consultaArquivadaArquivar($id_arq) {
        if ($id_arq > 0) {
            $result = $this->mysql->myConsulta('update phpzon_consultas set arquivada_cons=0 where id_cons=' . $id_arq . ' limit 1');
            if ($result == false) {
                $msn .= '<div class="alert alert-block alert-error fade in">';
                #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                $msn .= '<p>Não possivel enviar este registro</p>';
                $msn .= '<p>';
                $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                $msn .= '</p>';
                $msn .= '</div>';
            } else {
                $msn .= "<script>window.location = '{Global_voltar_pra_list}'</script>";
            }
            return $msn;
        }
    }

    /*
     * Tradando dados do modulo Marcar Consultas
     */

    function marcarConsultaList() {

        $Sql = "SELECT * FROM phpzon_consultas
               LEFT JOIN phpzon_funcionario ON (phpzon_funcionario.id_fun = phpzon_consultas.funcionario_cons)
               LEFT JOIN phpzon_medico ON (phpzon_medico.id_med = phpzon_consultas.medico_cons)
               LEFT JOIN phpzon_tipo_exame ON (phpzon_tipo_exame.id_exa = phpzon_consultas.tipo_cons)
               LEFT JOIN phpzon_situacao_ficha ON (phpzon_situacao_ficha.id_sit_fic = phpzon_consultas.id_sit_cons)
               WHERE phpzon_consultas.lixeira_cons=0 AND phpzon_consultas.arquivada_cons=0 ORDER BY phpzon_funcionario.nome_fun ASC";

        $Lista = new consulta_Class($Sql, 20);

        while ($var = $this->mysql->myLista($Lista->consulta)) {
            # Funcionario demitido
            if ($var->situacao_fun == 2) {
                $saida .= '<tr class="error">';
            } else {
                # Atendimento em espera
                if ($var->id_sit_cons == 1) {
                    $saida .= '<tr class="warning">';
                }
                # Atendimento em andamento
                elseif ($var->id_sit_cons == 2) {
                    $saida .= '<tr class="info">';
                }
                # Atendimento finalizado
                elseif ($var->id_sit_cons == 3) {
                    $saida .= '<tr class="success">';
                }
                # Atendimento cancelado
                elseif ($var->id_sit_cons == 4) {
                    $saida .= '<tr class="error">';
                } else {
                    $saida .= '<tr>';
                }
            }


            $saida .= '<td class="input-mini"><center>';
            $saida .= '<a onclick="if (!confirm(\'Tem certeza que deseja enviar esta ficha para lixeira?\')) return false;" href="' . PATH_ACTION . '/?pagina=lixeira&id_lix=' . $var->id_cons . '&origem=' . urlOrigem() . '"';
            $saida .= ' title="Mover para lixeira"><i class="icon-trash"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Visualizar"><i class="icon-zoom-in"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=edit&id=' . $var->id_cons . '&origem=' . urlOrigem() . '" title="Editar"><i class="icon-edit"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=arquivar&id_arq=' . $var->id_cons . '&origem=' . urlOrigem() . '" title="Arquivar Consulta"><i class="icon-inbox"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-mini">' . $var->id_cons . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_fun) . '</td>';
            $saida .= '<td class="input-medium">' . $var->cpf_fun . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_med) . '</td>';
            $saida .= '<td class="input-small">' . utf8_encode($var->titulo_exa) . '</td>';
            $saida .= '<td class="input-medium">' . utf8_encode($var->titulo_sit_fic) . '</td>';

            $saida .= '</tr>';
        }

        $linha = $this->mysql->myLinhas($this->mysql->myConsulta($Sql));
        if ($linha == false) {
            $saida .= '<tr><td>Nenhu registro localizado</td></tr>';
        }

        /*
         * Criando lista de opcoes para o tipo de exame
         */
        $sql_situacao_ficha = $this->mysql->myConsulta('select * from phpzon_situacao_ficha WHERE id_sit_fic IN (1,3) order by titulo_sit_fic asc');
        $list_situacao_ficha .= '<option value="0">SELECIONAR</option>';
        while ($var = $this->mysql->myLista($sql_situacao_ficha)) {
            $list_situacao_ficha .= '<option value="' . $var->id_sit_fic . '"';
            $list_situacao_ficha .= '>' . $var->titulo_sit_fic . '</option>';
        } $GLOBALS['list_situacao_ficha'] = $list_situacao_ficha;

        $GLOBALS['paginacao'] = $Lista->paginacaoM1();

        return $saida;
    }

    function marcarConsultaBusc($nome = '', $codigo = '', $situacao = '') {

        if (!empty($nome)) {
            $filtro_nome = " AND phpzon_funcionario.nome_fun like '%$nome%' ";
        }
        if (strlen($codigo) > 0) {
            $filtro_codigo = " AND phpzon_consultas.id_cons=$codigo ";
        }
        if ($situacao > 0) {
            $filtro_situacao = " AND phpzon_situacao_ficha.id_sit_fic=$situacao ";
        }

        $Sql = "SELECT * FROM phpzon_consultas
               LEFT JOIN phpzon_funcionario ON (phpzon_funcionario.id_fun = phpzon_consultas.funcionario_cons)
               LEFT JOIN phpzon_medico ON (phpzon_medico.id_med = phpzon_consultas.medico_cons)
               LEFT JOIN phpzon_tipo_exame ON (phpzon_tipo_exame.id_exa = phpzon_consultas.tipo_cons)
               LEFT JOIN phpzon_situacao_ficha ON (phpzon_situacao_ficha.id_sit_fic = phpzon_consultas.id_sit_cons)
               WHERE 1 $filtro_nome $filtro_codigo $filtro_situacao AND phpzon_consultas.lixeira_cons=0 AND phpzon_consultas.arquivada_cons=0 ORDER BY phpzon_funcionario.nome_fun ASC";

        $Lista = new consulta_Class($Sql, 5000);

        while ($var = $this->mysql->myLista($Lista->consulta)) {
            # Funcionario demitido
            if ($var->situacao_fun == 2) {
                $saida .= '<tr class="error">';
            } else {
                # Atendimento em espera
                if ($var->id_sit_cons == 1) {
                    $saida .= '<tr class="warning">';
                }
                # Atendimento em andamento
                elseif ($var->id_sit_cons == 2) {
                    $saida .= '<tr class="info">';
                }
                # Atendimento finalizado
                elseif ($var->id_sit_cons == 3) {
                    $saida .= '<tr class="success">';
                }
                # Atendimento cancelado
                elseif ($var->id_sit_cons == 4) {
                    $saida .= '<tr class="error">';
                } else {
                    $saida .= '<tr>';
                }
            }
            $saida .= '<td class="input-mini"><center>';
            $saida .= '<a onclick="if (!confirm(\'Tem certeza que deseja enviar esta ficha para lixeira?\')) return false;" href="' . PATH_ACTION . '/?pagina=lixeira&id_lix=' . $var->id_cons . '&origem=' . urlOrigem() . '"';
            $saida .= ' title="Excluir"><i class="icon-trash"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Visualizar"><i class="icon-zoom-in"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=edit&id=' . $var->id_cons . '&origem=' . urlOrigem() . '" title="Editar"><i class="icon-edit"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=arquivar&id_arq=' . $var->id_cons . '&origem=' . urlOrigem() . '" title="Arquivar Consulta"><i class="icon-inbox"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-mini">' . $var->id_cons . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_fun) . '</td>';
            $saida .= '<td class="input-small">' . $var->rg_fun . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_med) . '</td>';
            $saida .= '<td class="input-small">' . utf8_encode($var->titulo_exa) . '</td>';
            $saida .= '<td class="input-large">' . utf8_encode($var->titulo_sit_fic) . '</td>';

            $saida .= '</tr>';
        }

        $linha = $this->mysql->myLinhas($this->mysql->myConsulta($Sql));
        if ($linha == false) {
            $saida .= '<tr><td>Nenhu registro localizado</td></tr>';
        }


        return $saida;
    }

    function marcarConsultaEdit($id) {
        $GLOBALS['map'] = 'Novo'; # Nome nag map
        # Dados consulta
        $GLOBALS['id_cons'] = '';
        $GLOBALS['tipo_cons'] = '';
        $GLOBALS['funcionario_cons'] = '';
        $GLOBALS['medico_cons'] = '';
        $GLOBALS['obs_cons'] = '';
        $GLOBALS['data_hora_aten_cons'] = '';
        # Dados ficha
        $GLOBALS['ficha_pa'] = '';
        $GLOBALS['ficha_peso'] = '';
        $GLOBALS['ficha_altu'] = '';
        $GLOBALS['ficha_imc'] = '';
        $GLOBALS['ficha_obes'] = '';

        $soAtivo = 'AND situacao_fun in(0,1)';

        /*
         * Dados para o formulario de editando
         */
        if ($id > 0) {

            $Sql = "SELECT a.*, i.*
                    FROM phpzon_consultas a
                    LEFT JOIN phpzon_ficha_clinica i ON (i.ficha_cod_cons = a.id_cons)
                    WHERE a.id_cons=" . $id . " AND a.lixeira_cons=0 AND a.arquivada_cons=0 ORDER BY a.id_cons ASC";
            $Lista = new consulta_Class($Sql, 1);

            while ($var = $this->mysql->myLista($Lista->consulta)) {
                $GLOBALS['map'] = 'Consulta: ' . $var->id_cons;
                # Dados consulta
                $GLOBALS['id_cons'] = $var->id_cons;
                $GLOBALS['tipo_cons'] = $var->tipo_cons;
                $GLOBALS['funcionario_cons'] = $var->funcionario_cons;
                $GLOBALS['medico_cons'] = $var->medico_cons;
                $GLOBALS['obs_cons'] = $var->obs_cons;
                $GLOBALS['data_hora_aten_cons'] = $var->data_hora_aten_cons;
                # Dados ficha
                $GLOBALS['ficha_pa'] = (($var->ficha_pa == false) ? '' : $var->ficha_pa);
                $GLOBALS['ficha_peso'] = (($var->ficha_peso == false) ? '' : $var->ficha_peso);
                $GLOBALS['ficha_altu'] = (($var->ficha_altu == false) ? '' : $var->ficha_altu);
                $GLOBALS['ficha_imc'] = (($var->ficha_imc == false) ? '' : $var->ficha_imc);
                $GLOBALS['ficha_obes'] = (($var->ficha_obes == false) ? '' : $var->ficha_obes);
            }

            $soAtivo = '';
        }

        /*
         * Criando lista de opcoes para o tipo de exame
         */
        $sql_tipo_exame = $this->mysql->myConsulta('select * from phpzon_tipo_exame order by titulo_exa asc');
        $list_tipo_exame .= '<option value="0">SELECIONAR</option>';
        while ($var = $this->mysql->myLista($sql_tipo_exame)) {
            $list_tipo_exame .= '<option value="' . $var->id_exa . '"';
            $list_tipo_exame .= (($GLOBALS['tipo_cons'] == $var->id_exa) ? 'selected="selected"' : '' ) . '>' . $var->titulo_exa . '</option>';
        } $GLOBALS['list_tipo_exame'] = $list_tipo_exame;

        /*
         * Criando lista de opcoes para os funcionarios <optgroup label=""></optgroup>
         */
        $sql_funcionario = $this->mysql->myConsulta('select * from phpzon_funcionario where cpf_fun > 0 ' . $soAtivo . ' order by nome_fun asc');
        $list_funcionario .= '<option value="0">SELECIONAR</option>';
        while ($var = $this->mysql->myLista($sql_funcionario)) {
            $list_funcionario .= '<optgroup label="' . $var->cpf_fun . '">';
            $list_funcionario .= '<option value="' . $var->id_fun . '"';
            $list_funcionario .= (($GLOBALS['funcionario_cons'] == $var->id_fun) ? 'selected="selected"' : '' ) . '>' . $var->nome_fun . '</option>';
            $list_funcionario .= '</optgroup>';
            #$GLOBALS['funcionario_cpf'] = $var->cpf_fun;
        } $GLOBALS['list_funcionario'] = $list_funcionario;

        if (isset($GLOBALS['funcionario_cpf'])) {
            #return 'Fincionario esta os dados incompleto';
        }

        /*
         * Criando lista de opcoes para select funcao
         */
        $sql_medico = $this->mysql->myConsulta('select * from phpzon_medico order by nome_med asc');
        $list_medico .= '<option value="0">SELECIONAR</option>';
        while ($var = $this->mysql->myLista($sql_medico)) {
            $list_medico .= '<option value="' . $var->id_med . '"';
            $list_medico .= (($GLOBALS['medico_cons'] == $var->id_med) ? 'selected="selected"' : '' ) . '>' . $var->nome_med . '</option>';
        } $GLOBALS['list_medico'] = $list_medico;
    }

    function marcarConsultaSalvar() {

        $dados = array(
            'id_cons' => mysql_real_escape_string($_POST['id_cons']),
            'tipo_cons' => mysql_real_escape_string($_POST['tipo_exame']),
            'data_hora_aten_cons' => mysql_real_escape_string($_POST['data_hora_aten_cons']),
            'funcionario_cons' => mysql_real_escape_string($_POST['id_fun']),
            'medico_cons' => mysql_real_escape_string($_POST['id_med']),
            'obs_cons' => mysql_real_escape_string($_POST['obs_cons']),
        );
        $dados_ficha = array(
            #'ficha_cod_cons' => mysql_real_escape_string($_POST['id_cons']),
            'ficha_cod_fun' => mysql_real_escape_string($_POST['id_fun']),
            'ficha_tipo_exa' => mysql_real_escape_string($_POST['tipo_exame']),
            'ficha_pa' => mysql_real_escape_string($_POST['ficha_pa']),
            'ficha_peso' => mysql_real_escape_string($_POST['ficha_peso']),
            'ficha_altu' => mysql_real_escape_string($_POST['ficha_altu']),
            'ficha_imc' => mysql_real_escape_string($_POST['ficha_imc']),
            'ficha_obes' => mysql_real_escape_string($_POST['ficha_obes']),
        );
        # campo nome
        if ($dados['tipo_cons'] == 0) {
            $saida .= 'Tipo de Exame, ';
        }
        if ($dados['funcionario_cons'] == 0) {
            $saida .= 'Funcionario, ';
        }
        if ($dados['medico_cons'] == 0) {
            $saida .= 'Médico, ';
        }
        if (empty($dados['data_hora_aten_cons'])) {
            $saida .= 'Data do Atendimento, ';
        }

        # campo origatorio
        if (!empty($saida)) {
            print "<div class=\"alert alert-wornig\">";
            print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
            print "<h5>Faltou informar: </h5>";
            print $saida;
            print "</div>";
        } else {
            if ($dados['id_cons'] > 0) {
                $this->mysql->myExecuta('phpzon_consultas', $dados, 'update', 'id_cons=' . $dados['id_cons']);
                $this->mysql->myExecuta('phpzon_ficha_clinica', $dados_ficha, 'update', 'ficha_cod_cons=' . $dados['id_cons']);
                print "<div class=\"alert alert-success\">";
                print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
                print "Operação realizado com sucesso";
                print "</div>";
            } else {
                $dados = array('id_sit_cons' => 1) + $dados;
                $result = $this->mysql->myExecuta('phpzon_consultas', $dados);
                if ($result == true) {
                    $retorno = $this->mysql->myDados('select * from phpzon_consultas order by id_cons desc');
                    # Adicionando elementos no array
                    $dados_ficha = array('ficha_cod_cons' => $retorno->id_cons) + $dados_ficha;
                    $this->mysql->myExecuta('phpzon_ficha_clinica', $dados_ficha);

                    print "<div class=\"alert alert-success\">";
                    print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
                    print "Operação realizado com sucesso";
                    print "</div>";
                    print '<script>window.location=\'' . urlDistino($_POST['origem']) . '&id=' . $retorno->id_cons . '\';</script>';
                } else {
                    print "<div class=\"alert alert-error\">";
                    print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
                    print "<h5>Alerta: </h5>";
                    print "Não foi possivel gravar os registro, por favor contate o administrador do sistema";
                    print "</div>";
                }
            }
        }
    }

    function marcarConsultaLixeira($id_lix) {
        if ($id_lix > 0) {
            $result = $this->mysql->myConsulta('update phpzon_consultas set lixeira_cons=1 where id_cons=' . $id_lix . ' limit 1');
            if ($result == false) {
                $msn .= '<div class="alert alert-block alert-error fade in">';
                #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                $msn .= '<p>Não possivel mover este registro para lixeira</p>';
                $msn .= '<p>';
                $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                $msn .= '</p>';
                $msn .= '</div>';
            } else {
                $msn .= "<script>window.location = '{Global_voltar_pra_list}'</script>";
            }
            return $msn;
        }
    }

    function marcarConsultaArquivar($id_arq) {
        if ($id_arq > 0) {
            $result = $this->mysql->myConsulta('update phpzon_consultas set arquivada_cons=1 where id_cons=' . $id_arq . ' limit 1');
            if ($result == false) {
                $msn .= '<div class="alert alert-block alert-error fade in">';
                #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                $msn .= '<p>Não possivel arquivar este registro</p>';
                $msn .= '<p>';
                $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                $msn .= '</p>';
                $msn .= '</div>';
            } else {
                $msn .= "<script>window.location = '{Global_voltar_pra_list}'</script>";
            }
            return $msn;
        }
    }

    /*
     * Tradando dados do modulo Marcar Consultas
     */

    function consultaMarcardaList() {


        $Sql = "SELECT * FROM phpzon_consultas
               LEFT JOIN phpzon_funcionario ON (phpzon_funcionario.id_fun = phpzon_consultas.funcionario_cons)
               LEFT JOIN phpzon_medico ON (phpzon_medico.id_med = phpzon_consultas.medico_cons)
               LEFT JOIN phpzon_tipo_exame ON (phpzon_tipo_exame.id_exa = phpzon_consultas.tipo_cons)
               LEFT JOIN phpzon_situacao_ficha ON (phpzon_situacao_ficha.id_sit_fic = phpzon_consultas.id_sit_cons)
               WHERE phpzon_consultas.lixeira_cons=0 AND phpzon_consultas.arquivada_cons=0 ORDER BY phpzon_funcionario.nome_fun ASC";
        $Lista = new consulta_Class($Sql, 20);
        while ($var = $this->mysql->myLista($Lista->consulta)) {

            # Funcionario demitido
            if ($var->situacao_fun == 2) {
                $saida .= '<tr class="error">';
            } else {
                # Atendimento em espera
                if ($var->id_sit_cons == 1) {
                    $saida .= '<tr class="warning">';
                }
                # Atendimento em andamento
                elseif ($var->id_sit_cons == 2) {
                    $saida .= '<tr class="info">';
                }
                # Atendimento finalizado
                elseif ($var->id_sit_cons == 3) {
                    $saida .= '<tr class="success">';
                }
                # Atendimento cancelado
                elseif ($var->id_sit_cons == 4) {
                    $saida .= '<tr class="error">';
                } else {
                    $saida .= '<tr>';
                }
            }

            $saida .= '<td class="input-mini"><center>';
            #$saida .= '<a onclick="if (!confirm(\'Tem certeza que deseja excluir?\')) return false;" href="' . PATH_ACTION . '/?pagina=delete&id_del=' . $var->id_cons . '&origem=' . urlOrigem() . '"';
            #$saida .= ' title="Excluir"><i class="icon-trash"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Visualizar"><i class="icon-zoom-in"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=edit&id=' . $var->id_fun . '&id_cons=' . $var->id_cons . '&origem=' . urlOrigem() . '" title="Abrir"><i class="icon-folder-open"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Status"><i class=" icon-ok-circle"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-mini">' . $var->id_cons . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_fun) . '</td>';
            $saida .= '<td class="input-small">' . $var->cpf_fun . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_med) . '</td>';
            $saida .= '<td class="input-small">' . utf8_encode($var->titulo_exa) . '</td>';
            $saida .= '<td class="input-large">' . utf8_encode($var->titulo_sit_fic) . '</td>';

            $saida .= '</tr>';
        }

        $linha = $this->mysql->myLinhas($this->mysql->myConsulta($Sql));
        if ($linha == false) {
            $saida .= '<tr><td>Nenhu registro localizado</td></tr>';
        }

        /*
         * Criando lista de opcoes para o tipo de exame
         */
        $sql_situacao_ficha = $this->mysql->myConsulta('select * from phpzon_situacao_ficha WHERE id_sit_fic IN (1,3) order by titulo_sit_fic asc');
        $list_situacao_ficha .= '<option value="0">SELECIONAR</option>';
        while ($var = $this->mysql->myLista($sql_situacao_ficha)) {
            $list_situacao_ficha .= '<option value="' . $var->id_sit_fic . '"';
            $list_situacao_ficha .= '>' . $var->titulo_sit_fic . '</option>';
        } $GLOBALS['list_situacao_ficha'] = $list_situacao_ficha;

        $GLOBALS['paginacao'] = $Lista->paginacaoM1();

        return $saida;
    }

    function consultaMarcardaBusc($nome = '', $codigo = '', $situacao = '') {

        if (!empty($nome)) {
            $filtro_nome = " AND phpzon_funcionario.nome_fun like '%$nome%' ";
        }
        if (strlen($codigo) > 0) {
            $filtro_codigo = " AND phpzon_consultas.id_cons=$codigo ";
        }
        if ($situacao > 0) {
            $filtro_situacao = " AND phpzon_situacao_ficha.id_sit_fic=$situacao ";
        }

        $Sql = "SELECT * FROM phpzon_consultas
               LEFT JOIN phpzon_funcionario ON (phpzon_funcionario.id_fun = phpzon_consultas.funcionario_cons)
               LEFT JOIN phpzon_medico ON (phpzon_medico.id_med = phpzon_consultas.medico_cons)
               LEFT JOIN phpzon_tipo_exame ON (phpzon_tipo_exame.id_exa = phpzon_consultas.tipo_cons)
               LEFT JOIN phpzon_situacao_ficha ON (phpzon_situacao_ficha.id_sit_fic = phpzon_consultas.id_sit_cons)
               WHERE 1 $filtro_nome $filtro_codigo $filtro_situacao AND phpzon_consultas.lixeira_cons=0 AND phpzon_consultas.arquivada_cons=0 ORDER BY phpzon_funcionario.nome_fun ASC";
        $Lista = new consulta_Class($Sql, 300);
        while ($var = $this->mysql->myLista($Lista->consulta)) {
            # Funcionario demitido
            if ($var->situacao_fun == 2) {
                $saida .= '<tr class="error">';
            } else {
                # Atendimento em espera
                if ($var->id_sit_cons == 1) {
                    $saida .= '<tr class="warning">';
                }
                # Atendimento em andamento
                elseif ($var->id_sit_cons == 2) {
                    $saida .= '<tr class="info">';
                }
                # Atendimento finalizado
                elseif ($var->id_sit_cons == 3) {
                    $saida .= '<tr class="success">';
                }
                # Atendimento cancelado
                elseif ($var->id_sit_cons == 4) {
                    $saida .= '<tr class="error">';
                } else {
                    $saida .= '<tr>';
                }
            }

            $saida .= '<td class="input-mini"><center>';
            #$saida .= '<a onclick="if (!confirm(\'Tem certeza que deseja excluir?\')) return false;" href="' . PATH_ACTION . '/?pagina=delete&id_del=' . $var->id_cons . '&origem=' . urlOrigem() . '"';
            #$saida .= ' title="Excluir"><i class="icon-trash"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Visualizar"><i class="icon-zoom-in"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=edit&id=' . $var->id_fun . '&id_cons=' . $var->id_cons . '&origem=' . urlOrigem() . '" title="Abrir"><i class="icon-folder-open"></i></a>&nbsp;';
            #$saida .= '<a href="#" title="Status"><i class=" icon-ok-circle"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-mini">' . $var->id_cons . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_fun) . '</td>';
            $saida .= '<td class="input-small">' . $var->cpf_fun . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_med) . '</td>';
            $saida .= '<td class="input-small">' . utf8_encode($var->titulo_exa) . '</td>';
            $saida .= '<td class="input-large">' . utf8_encode($var->titulo_sit_fic) . '</td>';

            $saida .= '</tr>';
        }

        $linha = $this->mysql->myLinhas($this->mysql->myConsulta($Sql));
        if ($linha == false) {
            $saida .= '<tr><td>Nenhu registro localizado</td></tr>';
        }

        return $saida;
    }

    function consultaMarcardaEdit($id, $id_cons) {
        $GLOBALS['map'] = 'Novo'; # Nome nag map

        $GLOBALS['id_ficha'] = '';
        $GLOBALS['codigo'] = '';
        $GLOBALS['drt'] = '';
        $GLOBALS['nome'] = '';
        $GLOBALS['cpf'] = '';
        $GLOBALS['rg'] = '';
        $GLOBALS['estado_civil'] = '';
        $GLOBALS['sexo'] = '';
        $GLOBALS['idade'] = '';
        $GLOBALS['setor'] = '';
        $GLOBALS['funcao'] = '';
        $GLOBALS['dt_atendimento'] = '';
        $GLOBALS['medico'] = '';
        # Atendimento
        $GLOBALS['tipo_exame'] = '';
        $GLOBALS['pa'] = '';
        $GLOBALS['peso'] = '';
        $GLOBALS['altura'] = '';
        $GLOBALS['imc'] = '';
        $GLOBALS['obesidade'] = '';
        # Anamnese
        $GLOBALS['ficha_data_hemo'] = '';
        $GLOBALS['ficha_valor_hemo'] = '';
        $GLOBALS['ficha_situ_hemo'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_coles'] = '';
        $GLOBALS['ficha_valor_coles'] = '';
        $GLOBALS['ficha_situ_coles'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_trig'] = '';
        $GLOBALS['ficha_valor_trig'] = '';
        $GLOBALS['ficha_situ_trig'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_glic'] = '';
        $GLOBALS['ficha_valor_glic'] = '';
        $GLOBALS['ficha_situ_glic'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_clsa'] = '';
        $GLOBALS['ficha_valor_clsa'] = '';
        $GLOBALS['ficha_situ_clsa'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_prfe'] = '';
        $GLOBALS['ficha_valor_prfe'] = '';
        $GLOBALS['ficha_situ_prfe'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_smur'] = '';
        $GLOBALS['ficha_valor_smur'] = '';
        $GLOBALS['ficha_situ_smur'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_sohe'] = '';
        $GLOBALS['ficha_valor_sohe'] = '';
        $GLOBALS['ficha_situ_sohe'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_soto'] = '';
        $GLOBALS['ficha_valor_soto'] = '';
        $GLOBALS['ficha_situ_soto'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_rxtp'] = '';
        $GLOBALS['ficha_valor_rxtp'] = '';
        $GLOBALS['ficha_situ_rxtp'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_rxcl'] = '';
        $GLOBALS['ficha_valor_rxcl'] = '';
        $GLOBALS['ficha_situ_rxcl'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_rxto'] = '';
        $GLOBALS['ficha_valor_rxto'] = '';
        $GLOBALS['ficha_situ_rxto'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_ecg'] = '';
        $GLOBALS['ficha_valor_ecg'] = '';
        $GLOBALS['ficha_situ_ecg'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_eeg'] = '';
        $GLOBALS['ficha_valor_eeg'] = '';
        $GLOBALS['ficha_situ_eeg'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_audi'] = '';
        $GLOBALS['ficha_valor_audi'] = '';
        $GLOBALS['ficha_situ_audi'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_vdrl'] = '';
        $GLOBALS['ficha_valor_vdrl'] = '';
        $GLOBALS['ficha_situ_vdrl'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_ava_ofta'] = '';
        $GLOBALS['ficha_valor_ava_ofta'] = '';
        $GLOBALS['ficha_situ_ava_ofta'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_acu_visu'] = '';
        $GLOBALS['ficha_valor_acu_visu'] = '';
        $GLOBALS['ficha_situ_acu_visu'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_ava_card'] = '';
        $GLOBALS['ficha_valor_ava_card'] = '';
        $GLOBALS['ficha_situ_ava_card'] = '<option value="">---------</option>';

        $GLOBALS['ficha_data_ava_espe'] = '';
        $GLOBALS['ficha_valor_ava_espe'] = '';
        $GLOBALS['ficha_situ_ava_espe'] = '<option value="">---------</option>';

        /*
         * Dados para o formulario de editando
         * $id_cons
         */
        if ($id > 0) {
            $Sql = "SELECT a.*, b.*, c.nome_med,c.id_med, d.*, e.*, f.*, g.*, h.*, i.*, j.*
                    FROM phpzon_consultas a
                    LEFT JOIN phpzon_funcionario b ON (b.id_fun = a.funcionario_cons)
                    LEFT JOIN phpzon_medico c ON (c.id_med = a.medico_cons)
                    LEFT JOIN phpzon_situacao_ficha d ON (d.id_sit_fic = a.id_sit_cons)
                    LEFT JOIN phpzon_estado_civil e ON (e.id_esci = b.civil_fun)
                    LEFT JOIN phpzon_sexo f ON (f.id_sexo = b.sexo_fun)
                    LEFT JOIN phpzon_setor g ON (g.id_set = b.setor_fun)
                    LEFT JOIN phpzon_funcao h ON (h.id_funcao = b.funcao_fun)
                    LEFT JOIN phpzon_ficha_clinica i ON (i.ficha_cod_cons = a.id_cons)
                    LEFT JOIN phpzon_tipo_exame j ON (j.id_exa = i.ficha_tipo_exa)
                    WHERE a.funcionario_cons=$id AND a.lixeira_cons=0 GROUP BY a.id_cons ASC";


            /** gera paginação */
            $Lista_pg = new consulta_Class($Sql, 1);
            while ($var = $this->mysql->myLista($Lista_pg->consulta)) {

                if (empty($_GET['pg'])) {
                    $Sql_unico = "SELECT a.*, b.*, c.nome_med,c.id_med, d.*, e.*, f.*, g.*, h.*, i.*, j.*
                    FROM phpzon_consultas a
                    LEFT JOIN phpzon_funcionario b ON (b.id_fun = a.funcionario_cons)
                    LEFT JOIN phpzon_medico c ON (c.id_med = a.medico_cons)
                    LEFT JOIN phpzon_situacao_ficha d ON (d.id_sit_fic = a.id_sit_cons)
                    LEFT JOIN phpzon_estado_civil e ON (e.id_esci = b.civil_fun)
                    LEFT JOIN phpzon_sexo f ON (f.id_sexo = b.sexo_fun)
                    LEFT JOIN phpzon_setor g ON (g.id_set = b.setor_fun)
                    LEFT JOIN phpzon_funcao h ON (h.id_funcao = b.funcao_fun)
                    LEFT JOIN phpzon_ficha_clinica i ON (i.ficha_cod_cons = a.id_cons)
                    LEFT JOIN phpzon_tipo_exame j ON (j.id_exa = i.ficha_tipo_exa)
                    WHERE a.lixeira_cons=0 AND a.id_cons=$id_cons GROUP BY a.id_cons ASC LIMIT 1";
                } else {
                    $Sql_unico = "SELECT a.*, b.*, c.nome_med,c.id_med, d.*, e.*, f.*, g.*, h.*, i.*, j.*
                    FROM phpzon_consultas a
                    LEFT JOIN phpzon_funcionario b ON (b.id_fun = a.funcionario_cons)
                    LEFT JOIN phpzon_medico c ON (c.id_med = a.medico_cons)
                    LEFT JOIN phpzon_situacao_ficha d ON (d.id_sit_fic = a.id_sit_cons)
                    LEFT JOIN phpzon_estado_civil e ON (e.id_esci = b.civil_fun)
                    LEFT JOIN phpzon_sexo f ON (f.id_sexo = b.sexo_fun)
                    LEFT JOIN phpzon_setor g ON (g.id_set = b.setor_fun)
                    LEFT JOIN phpzon_funcao h ON (h.id_funcao = b.funcao_fun)
                    LEFT JOIN phpzon_ficha_clinica i ON (i.ficha_cod_cons = a.id_cons)
                    LEFT JOIN phpzon_tipo_exame j ON (j.id_exa = i.ficha_tipo_exa)
                    WHERE a.lixeira_cons=0 AND a.id_cons=" . $var->id_cons . " GROUP BY a.id_cons ASC LIMIT 1";
                }
            }
            $Lista_pg->paginacaoM3();
            $GLOBALS['btnAnt'] = $Lista_pg->btnAnt;
            $GLOBALS['btnPro'] = $Lista_pg->btnPro;
            $GLOBALS['btnAtu'] = $Lista_pg->btnAtu;

            /** gera registros */
            $Lista = $this->mysql->myConsulta($Sql_unico);
            while ($var = $this->mysql->myLista($Lista)) {
                $GLOBALS['map'] = utf8_encode($var->nome_fun);
                $GLOBALS['relIdConsulta'] = base64_encode($var->id_cons);
                # Identificação
                $GLOBALS['id_ficha'] = $var->ficha_id;
                $GLOBALS['codigo'] = $var->id_cons;
                $GLOBALS['drt'] = $var->drt_fun;
                $GLOBALS['nome'] = $var->nome_fun;
                $GLOBALS['cpf'] = $var->cpf_fun;
                $GLOBALS['rg'] = $var->rg_fun;
                $GLOBALS['estado_civil'] = $var->nome_esci;
                $GLOBALS['sexo'] = $var->nome_sexo;
                $GLOBALS['idade'] = getIdade(dataYMD_DMY($var->data)) . ' Anos';
                $GLOBALS['setor'] = $var->titulo_set;
                $GLOBALS['funcao'] = $var->titulo_funcao;
                $GLOBALS['dt_atendimento'] = $var->data_hora_aten_cons;
                $GLOBALS['medico'] = $var->nome_med;
                # Atendimento
                $GLOBALS['tipo_exame'] = $var->titulo_exa;
                $GLOBALS['pa'] = $var->ficha_pa;
                $GLOBALS['peso'] = $var->ficha_peso;
                $GLOBALS['altura'] = $var->ficha_altu;
                $GLOBALS['imc'] = $var->ficha_imc;
                $GLOBALS['obesidade'] = $var->ficha_obes;
                # Anamnese
                $GLOBALS['anamnese'] = $var->ficha_obs;
                # Exames Complementáres 
                $GLOBALS['ficha_data_hemo'] = dataYMD_DMY($var->ficha_data_hemo);
                $GLOBALS['ficha_valor_hemo'] = $var->ficha_valor_hemo;
                $GLOBALS['ficha_situ_hemo'] .= '<option value="N" ' . (($var->ficha_situ_hemo == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_hemo'] .= '<option value="A" ' . (($var->ficha_situ_hemo == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_coles'] = dataYMD_DMY($var->ficha_data_coles);
                $GLOBALS['ficha_valor_coles'] = $var->ficha_valor_coles;
                $GLOBALS['ficha_situ_coles'] .= '<option value="N" ' . (($var->ficha_situ_coles == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_coles'] .= '<option value="A" ' . (($var->ficha_situ_coles == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_trig'] = dataYMD_DMY($var->ficha_data_trig);
                $GLOBALS['ficha_valor_trig'] = $var->ficha_valor_trig;
                $GLOBALS['ficha_situ_trig'] .= '<option value="N" ' . (($var->ficha_situ_trig == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_trig'] .= '<option value="A" ' . (($var->ficha_situ_trig == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_glic'] = dataYMD_DMY($var->ficha_data_glic);
                $GLOBALS['ficha_valor_glic'] = $var->ficha_valor_glic;
                $GLOBALS['ficha_situ_glic'] .= '<option value="N" ' . (($var->ficha_situ_glic == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_glic'] .= '<option value="A" ' . (($var->ficha_situ_glic == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_clsa'] = dataYMD_DMY($var->ficha_data_clsa);
                $GLOBALS['ficha_valor_clsa'] = $var->ficha_valor_clsa;
                $GLOBALS['ficha_situ_clsa'] .= '<option value="N" ' . (($var->ficha_situ_clsa == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_clsa'] .= '<option value="A" ' . (($var->ficha_situ_clsa == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_prfe'] = dataYMD_DMY($var->ficha_data_prfe);
                $GLOBALS['ficha_valor_prfe'] = $var->ficha_valor_prfe;
                $GLOBALS['ficha_situ_prfe'] .= '<option value="N" ' . (($var->ficha_situ_prfe == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_prfe'] .= '<option value="A" ' . (($var->ficha_situ_prfe == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_smur'] = dataYMD_DMY($var->ficha_data_smur);
                $GLOBALS['ficha_valor_smur'] = $var->ficha_valor_smur;
                $GLOBALS['ficha_situ_smur'] .= '<option value="N" ' . (($var->ficha_situ_smur == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_smur'] .= '<option value="A" ' . (($var->ficha_situ_smur == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_sohe'] = dataYMD_DMY($var->ficha_data_sohe);
                $GLOBALS['ficha_valor_sohe'] = $var->ficha_valor_sohe;
                $GLOBALS['ficha_situ_sohe'] .= '<option value="N" ' . (($var->ficha_situ_sohe == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_sohe'] .= '<option value="A" ' . (($var->ficha_situ_sohe == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_soto'] = dataYMD_DMY($var->ficha_data_soto);
                $GLOBALS['ficha_valor_soto'] = $var->ficha_valor_soto;
                $GLOBALS['ficha_situ_soto'] .= '<option value="N" ' . (($var->ficha_situ_soto == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_soto'] .= '<option value="A" ' . (($var->ficha_situ_soto == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_rxtp'] = dataYMD_DMY($var->ficha_data_rxtp);
                $GLOBALS['ficha_valor_rxtp'] = $var->ficha_valor_rxtp;
                $GLOBALS['ficha_situ_rxtp'] .= '<option value="N" ' . (($var->ficha_situ_rxtp == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_rxtp'] .= '<option value="A" ' . (($var->ficha_situ_rxtp == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_rxcl'] = dataYMD_DMY($var->ficha_data_rxcl);
                $GLOBALS['ficha_valor_rxcl'] = $var->ficha_valor_rxcl;
                $GLOBALS['ficha_situ_rxcl'] .= '<option value="N" ' . (($var->ficha_situ_rxcl == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_rxcl'] .= '<option value="A" ' . (($var->ficha_situ_rxcl == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_rxto'] = dataYMD_DMY($var->ficha_data_rxto);
                $GLOBALS['ficha_valor_rxto'] = $var->ficha_valor_rxto;
                $GLOBALS['ficha_situ_rxto'] .= '<option value="N" ' . (($var->ficha_situ_rxto == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_rxto'] .= '<option value="A" ' . (($var->ficha_situ_rxto == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_ecg'] = dataYMD_DMY($var->ficha_data_ecg);
                $GLOBALS['ficha_valor_ecg'] = $var->ficha_valor_ecg;
                $GLOBALS['ficha_situ_ecg'] .= '<option value="N" ' . (($var->ficha_situ_ecg == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_ecg'] .= '<option value="A" ' . (($var->ficha_situ_ecg == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_eeg'] = dataYMD_DMY($var->ficha_data_eeg);
                $GLOBALS['ficha_valor_eeg'] = $var->ficha_valor_eeg;
                $GLOBALS['ficha_situ_eeg'] .= '<option value="N" ' . (($var->ficha_situ_eeg == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_eeg'] .= '<option value="A" ' . (($var->ficha_situ_eeg == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_audi'] = dataYMD_DMY($var->ficha_data_audi);
                $GLOBALS['ficha_valor_audi'] = $var->ficha_valor_audi;
                $GLOBALS['ficha_situ_audi'] .= '<option value="N" ' . (($var->ficha_situ_audi == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_audi'] .= '<option value="A" ' . (($var->ficha_situ_audi == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_vdrl'] = dataYMD_DMY($var->ficha_data_vdrl);
                $GLOBALS['ficha_valor_vdrl'] = $var->ficha_valor_vdrl;
                $GLOBALS['ficha_situ_vdrl'] .= '<option value="N" ' . (($var->ficha_situ_vdrl == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_vdrl'] .= '<option value="A" ' . (($var->ficha_situ_vdrl == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_ava_ofta'] = dataYMD_DMY($var->ficha_data_ava_ofta);
                $GLOBALS['ficha_valor_ava_ofta'] = $var->ficha_valor_ava_ofta;
                $GLOBALS['ficha_situ_ava_ofta'] .= '<option value="N" ' . (($var->ficha_situ_ava_ofta == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_ava_ofta'] .= '<option value="A" ' . (($var->ficha_situ_ava_ofta == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_acu_visu'] = dataYMD_DMY($var->ficha_data_acu_visu);
                $GLOBALS['ficha_valor_acu_visu'] = $var->ficha_valor_acu_visu;
                $GLOBALS['ficha_situ_acu_visu'] .= '<option value="N" ' . (($var->ficha_situ_acu_visu == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_acu_visu'] .= '<option value="A" ' . (($var->ficha_situ_acu_visu == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_ava_card'] = dataYMD_DMY($var->ficha_data_ava_card);
                $GLOBALS['ficha_valor_ava_card'] = $var->ficha_valor_ava_card;
                $GLOBALS['ficha_situ_ava_card'] .= '<option value="N" ' . (($var->ficha_situ_ava_card == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_ava_card'] .= '<option value="A" ' . (($var->ficha_situ_ava_card == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';

                $GLOBALS['ficha_data_ava_espe'] = dataYMD_DMY($var->ficha_data_ava_espe);
                $GLOBALS['ficha_valor_ava_espe'] = $var->ficha_valor_ava_espe;
                $GLOBALS['ficha_situ_ava_espe'] .= '<option value="N" ' . (($var->ficha_situ_ava_espe == 'N' ) ? 'selected="selected"' : '') . '>NORMAL</option>';
                $GLOBALS['ficha_situ_ava_espe'] .= '<option value="A" ' . (($var->ficha_situ_ava_espe == 'A' ) ? 'selected="selected"' : '') . '>ALTERADO</option>';
            }
        }


        /*
         * Criando lista de opcoes para o sexo do formulario
         */
        $sql_sexo = $this->mysql->myConsulta('select * from phpzon_sexo');
        while ($var = $this->mysql->myLista($sql_sexo)) {
            $list_sexo .= '<option value="' . $var->cod_sexo . '"';
            $list_sexo .= (($GLOBALS['sexo'] == $var->cod_sexo) ? 'selected="selected"' : '' ) . '>' . $var->nome_sexo . '</option>';
        } $GLOBALS['list_sexo'] = $list_sexo;

        /*
         * Criando lista de opcoes para estado civil do formulario
         */
        $sql_civil = $this->mysql->myConsulta('select * from phpzon_estado_civil');
        while ($var = $this->mysql->myLista($sql_civil)) {
            $list_civil .= '<option value="' . $var->id_esci . '"';
            $list_civil .= (($GLOBALS['estado_civil'] == $var->id_esci) ? 'selected="selected"' : '' ) . '>' . $var->nome_esci . '</option>';
        } $GLOBALS['list_civil'] = $list_civil;

        /*
         * Criando lista de opcoes para select setor
         */
        $sql_setor = $this->mysql->myConsulta('select * from phpzon_setor');
        while ($var = $this->mysql->myLista($sql_setor)) {
            $list_setor .= '<option value="' . $var->id_set . '"';
            if ($GLOBALS['setor'] == $var->id_set) {
                $list_setor .= 'selected="selected">' . $var->titulo_set;
            } else {
                $list_setor .= '>' . $var->titulo_set;
            }
            $list_setor .= '</option>';
        } $GLOBALS['list_setor'] = $list_setor;

        /*
         * Criando lista de opcoes para select funcao
         */
        $sql_funcao = $this->mysql->myConsulta('select * from phpzon_funcao where id_funcao_set=' . $GLOBALS['setor']);
        while ($var = $this->mysql->myLista($sql_funcao)) {
            $list_funcao .= '<option value="' . $var->id_funcao . '"';
            $list_funcao .= (($GLOBALS['funcao'] == $var->id_funcao) ? 'selected="selected"' : '' ) . '>' . $var->titulo_funcao . '</option>';
        } $GLOBALS['list_funcao'] = $list_funcao;
    }

    function consultaMarcardaSalvar() {
        # ID de consulta da ficha
        $id_fic = mysql_real_escape_string($_POST['id_fic']);

        $dados = array(
            'ficha_obs' => $_POST['anamnese'],
            'ficha_data_hemo' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_hemo'])),
            'ficha_valor_hemo' => mysql_real_escape_string($_POST['ficha_valor_hemo']),
            'ficha_situ_hemo' => mysql_real_escape_string($_POST['ficha_situ_hemo']),
            'ficha_data_coles' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_coles'])),
            'ficha_valor_coles' => mysql_real_escape_string($_POST['ficha_valor_coles']),
            'ficha_situ_coles' => mysql_real_escape_string($_POST['ficha_situ_coles']),
            'ficha_data_trig' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_trig'])),
            'ficha_valor_trig' => mysql_real_escape_string($_POST['ficha_valor_trig']),
            'ficha_situ_trig' => mysql_real_escape_string($_POST['ficha_situ_trig']),
            'ficha_data_glic' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_glic'])),
            'ficha_valor_glic' => mysql_real_escape_string($_POST['ficha_valor_glic']),
            'ficha_situ_glic' => mysql_real_escape_string($_POST['ficha_situ_glic']),
            'ficha_data_clsa' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_clsa'])),
            'ficha_valor_clsa' => mysql_real_escape_string($_POST['ficha_valor_clsa']),
            'ficha_situ_clsa' => mysql_real_escape_string($_POST['ficha_situ_clsa']),
            'ficha_data_prfe' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_prfe'])),
            'ficha_valor_prfe' => mysql_real_escape_string($_POST['ficha_valor_prfe']),
            'ficha_situ_prfe' => mysql_real_escape_string($_POST['ficha_situ_prfe']),
            'ficha_data_smur' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_smur'])),
            'ficha_valor_smur' => mysql_real_escape_string($_POST['ficha_valor_smur']),
            'ficha_situ_smur' => mysql_real_escape_string($_POST['ficha_situ_smur']),
            'ficha_data_sohe' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_sohe'])),
            'ficha_valor_sohe' => mysql_real_escape_string($_POST['ficha_valor_sohe']),
            'ficha_situ_sohe' => mysql_real_escape_string($_POST['ficha_situ_sohe']),
            'ficha_data_soto' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_soto'])),
            'ficha_valor_soto' => mysql_real_escape_string($_POST['ficha_valor_soto']),
            'ficha_situ_soto' => mysql_real_escape_string($_POST['ficha_situ_soto']),
            'ficha_data_rxtp' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_rxtp'])),
            'ficha_valor_rxtp' => mysql_real_escape_string($_POST['ficha_valor_rxtp']),
            'ficha_situ_rxtp' => mysql_real_escape_string($_POST['ficha_situ_rxtp']),
            'ficha_data_rxcl' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_rxcl'])),
            'ficha_valor_rxcl' => mysql_real_escape_string($_POST['ficha_valor_rxcl']),
            'ficha_situ_rxcl' => mysql_real_escape_string($_POST['ficha_situ_rxcl']),
            'ficha_data_rxto' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_rxto'])),
            'ficha_valor_rxto' => mysql_real_escape_string($_POST['ficha_valor_rxto']),
            'ficha_situ_rxto' => mysql_real_escape_string($_POST['ficha_situ_rxto']),
            'ficha_data_ecg' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_ecg'])),
            'ficha_valor_ecg' => mysql_real_escape_string($_POST['ficha_valor_ecg']),
            'ficha_situ_ecg' => mysql_real_escape_string($_POST['ficha_situ_ecg']),
            'ficha_data_eeg' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_eeg'])),
            'ficha_valor_eeg' => mysql_real_escape_string($_POST['ficha_valor_eeg']),
            'ficha_situ_eeg' => mysql_real_escape_string($_POST['ficha_situ_eeg']),
            'ficha_data_audi' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_audi'])),
            'ficha_valor_audi' => mysql_real_escape_string($_POST['ficha_valor_audi']),
            'ficha_situ_audi' => mysql_real_escape_string($_POST['ficha_situ_audi']),
            'ficha_data_vdrl' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_vdrl'])),
            'ficha_valor_vdrl' => mysql_real_escape_string($_POST['ficha_valor_vdrl']),
            'ficha_situ_vdrl' => mysql_real_escape_string($_POST['ficha_situ_vdrl']),
            'ficha_data_ava_ofta' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_ava_ofta'])),
            'ficha_valor_ava_ofta' => mysql_real_escape_string($_POST['ficha_valor_ava_ofta']),
            'ficha_situ_ava_ofta' => mysql_real_escape_string($_POST['ficha_situ_ava_ofta']),
            'ficha_data_acu_visu' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_acu_visu'])),
            'ficha_valor_acu_visu' => mysql_real_escape_string($_POST['ficha_valor_acu_visu']),
            'ficha_situ_acu_visu' => mysql_real_escape_string($_POST['ficha_situ_acu_visu']),
            'ficha_data_ava_card' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_ava_card'])),
            'ficha_valor_ava_card' => mysql_real_escape_string($_POST['ficha_valor_ava_card']),
            'ficha_situ_ava_card' => mysql_real_escape_string($_POST['ficha_situ_ava_card']),
            'ficha_data_ava_espe' => mysql_real_escape_string(dataDMY_YMD($_POST['ficha_data_ava_espe'])),
            'ficha_valor_ava_espe' => mysql_real_escape_string($_POST['ficha_valor_ava_espe']),
            'ficha_situ_ava_espe' => mysql_real_escape_string($_POST['ficha_situ_ava_espe'])
        );
        $dados_cons = array(
            'id_sit_cons' => 3
        );

        # campo nome
        if ($id_fic == 0) {
            $saida .= 'Ficha sem codigo de consulta, ';
        }

        # campo origatorio
        if (!empty($saida)) {
            print "<div class=\"alert alert-wornig\">";
            print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
            print "<h5>Faltou informar: </h5>";
            print $saida;
            print "</div>";
        } else {
            if ($id_fic > 0) {
                $this->mysql->myExecuta('phpzon_ficha_clinica', $dados, 'update', 'ficha_cod_cons =' . $id_fic);
                $this->mysql->myExecuta('phpzon_consultas', $dados_cons, 'update', 'id_cons =' . $id_fic);
                print "<div class=\"alert alert-success\">";
                print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
                print "Operação realizado com sucesso";
                print "</div>";
            } else {
                print "<div class=\"alert alert-erro\">";
                print "<button type=\"button\" id=\"fechar\"class=\"close\" >×</button>";
                print "Não foi possível salvar as informações, contate o administrador do sistema";
                print "</div>";
            }
        }
    }

    /*
     * Tradando dados do modulo Consultas excluidas
     */

    function lixeiraList() {

        $Sql = "SELECT * FROM phpzon_consultas
               LEFT JOIN phpzon_funcionario ON (phpzon_funcionario.id_fun = phpzon_consultas.funcionario_cons)
               LEFT JOIN phpzon_medico ON (phpzon_medico.id_med = phpzon_consultas.medico_cons)
               LEFT JOIN phpzon_tipo_exame ON (phpzon_tipo_exame.id_exa = phpzon_consultas.tipo_cons)
               LEFT JOIN phpzon_situacao_ficha ON (phpzon_situacao_ficha.id_sit_fic = phpzon_consultas.id_sit_cons)
               WHERE phpzon_consultas.lixeira_cons=1 ORDER BY phpzon_funcionario.nome_fun ASC";

        $Lista = new consulta_Class($Sql, 20);

        while ($var = $this->mysql->myLista($Lista->consulta)) {
            # Funcionario demitido
            if ($var->situacao_fun == 2) {
                $saida .= '<tr class="error">';
            } else {
                # Atendimento em espera
                if ($var->id_sit_cons == 1) {
                    $saida .= '<tr class="warning">';
                }
                # Atendimento em andamento
                elseif ($var->id_sit_cons == 2) {
                    $saida .= '<tr class="info">';
                }
                # Atendimento finalizado
                elseif ($var->id_sit_cons == 3) {
                    $saida .= '<tr class="success">';
                }
                # Atendimento cancelado
                elseif ($var->id_sit_cons == 4) {
                    $saida .= '<tr class="error">';
                } else {
                    $saida .= '<tr>';
                }
            }


            $saida .= '<td class="input-mini"><center>';
            $saida .= '<a onclick="if (!confirm(\'Tem certeza que deseja deletar esta ficha\')) return false;" href="' . PATH_ACTION . '/?pagina=deletar&id_delete=' . $var->id_cons . '&origem=' . urlOrigem() . '"';
            $saida .= ' title="Deletar"><i class="icon-remove"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=visualizar&id_vis=' . $var->id_cons . '&origem=' . urlOrigem() . '" title="Visualizar"><i class="icon-zoom-in"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=arquivar&id_arq=' . $var->id_cons . '&origem=' . urlOrigem() . '" title="Recuperar"><i class="icon-share"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-mini">' . $var->id_cons . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_fun) . '</td>';
            $saida .= '<td class="input-medium">' . $var->cpf_fun . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_med) . '</td>';
            $saida .= '<td class="input-small">' . utf8_encode($var->titulo_exa) . '</td>';
            $saida .= '<td class="input-medium">' . utf8_encode($var->titulo_sit_fic) . '</td>';

            $saida .= '</tr>';
        }

        $linha = $this->mysql->myLinhas($this->mysql->myConsulta($Sql));
        if ($linha == false) {
            $saida .= '<tr><td>Nenhu registro localizado</td></tr>';
        }

        /*
         * Criando lista de opcoes para o tipo de exame
         */
        $sql_situacao_ficha = $this->mysql->myConsulta('select * from phpzon_situacao_ficha WHERE id_sit_fic IN (1,3) order by titulo_sit_fic asc');
        $list_situacao_ficha .= '<option value="0">SELECIONAR</option>';
        while ($var = $this->mysql->myLista($sql_situacao_ficha)) {
            $list_situacao_ficha .= '<option value="' . $var->id_sit_fic . '"';
            $list_situacao_ficha .= '>' . $var->titulo_sit_fic . '</option>';
        } $GLOBALS['list_situacao_ficha'] = $list_situacao_ficha;

        $GLOBALS['paginacao'] = $Lista->paginacaoM1();

        return $saida;
    }

    function lixeiraBusc($nome = '', $codigo = '', $situacao = '') {

        if (!empty($nome)) {
            $filtro_nome = " AND phpzon_funcionario.nome_fun like '%$nome%' ";
        }
        if (strlen($codigo) > 0) {
            $filtro_codigo = " AND phpzon_consultas.id_cons=$codigo ";
        }
        if ($situacao > 0) {
            $filtro_situacao = " AND phpzon_situacao_ficha.id_sit_fic=$situacao ";
        }

        $Sql = "SELECT * FROM phpzon_consultas
               LEFT JOIN phpzon_funcionario ON (phpzon_funcionario.id_fun = phpzon_consultas.funcionario_cons)
               LEFT JOIN phpzon_medico ON (phpzon_medico.id_med = phpzon_consultas.medico_cons)
               LEFT JOIN phpzon_tipo_exame ON (phpzon_tipo_exame.id_exa = phpzon_consultas.tipo_cons)
               LEFT JOIN phpzon_situacao_ficha ON (phpzon_situacao_ficha.id_sit_fic = phpzon_consultas.id_sit_cons)
               WHERE 1 $filtro_nome $filtro_codigo $filtro_situacao AND phpzon_consultas.lixeira_cons=1 ORDER BY phpzon_funcionario.nome_fun ASC";

        $Lista = new consulta_Class($Sql, 5000);

        while ($var = $this->mysql->myLista($Lista->consulta)) {
            # Funcionario demitido
            if ($var->situacao_fun == 2) {
                $saida .= '<tr class="error">';
            } else {
                # Atendimento em espera
                if ($var->id_sit_cons == 1) {
                    $saida .= '<tr class="warning">';
                }
                # Atendimento em andamento
                elseif ($var->id_sit_cons == 2) {
                    $saida .= '<tr class="info">';
                }
                # Atendimento finalizado
                elseif ($var->id_sit_cons == 3) {
                    $saida .= '<tr class="success">';
                }
                # Atendimento cancelado
                elseif ($var->id_sit_cons == 4) {
                    $saida .= '<tr class="error">';
                } else {
                    $saida .= '<tr>';
                }
            }
            $saida .= '<td class="input-mini"><center>';
            $saida .= '<a onclick="if (!confirm(\'Tem certeza que deseja deletar esta ficha\')) return false;" href="' . PATH_ACTION . '/?pagina=deletar&id_delete=' . $var->id_cons . '&origem=' . urlOrigem() . '"';
            $saida .= ' title="Deletar"><i class="icon-trash"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=visualizar&id_vis=' . $var->id_cons . '&origem=' . urlOrigem() . '" title="Visualizar"><i class="icon-zoom-in"></i></a>&nbsp;';
            $saida .= '<a href="' . PATH_ACTION . '/?pagina=arquivar&id_arq=' . $var->id_cons . '&origem=' . urlOrigem() . '" title="Recuperar"><i class="icon-share"></i></a>';
            $saida .= '</center></td>';
            $saida .= '<td class="input-mini">' . $var->id_cons . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_fun) . '</td>';
            $saida .= '<td class="input-small">' . $var->rg_fun . '</td>';
            $saida .= '<td class="input-xlarge">' . utf8_encode($var->nome_med) . '</td>';
            $saida .= '<td class="input-small">' . utf8_encode($var->titulo_exa) . '</td>';
            $saida .= '<td class="input-large">' . utf8_encode($var->titulo_sit_fic) . '</td>';

            $saida .= '</tr>';
        }

        $linha = $this->mysql->myLinhas($this->mysql->myConsulta($Sql));
        if ($linha == false) {
            $saida .= '<tr><td>Nenhu registro localizado</td></tr>';
        }


        return $saida;
    }

    function lixeiraVisua($id) {
        $GLOBALS['map'] = 'Novo'; # Nome nag map
        # Dados consulta
        $GLOBALS['id_cons'] = '';
        $GLOBALS['tipo_cons'] = '';
        $GLOBALS['funcionario_cons'] = '';
        $GLOBALS['medico_cons'] = '';
        $GLOBALS['obs_cons'] = '';
        $GLOBALS['data_hora_aten_cons'] = '';
        # Dados ficha
        $GLOBALS['ficha_pa'] = '';
        $GLOBALS['ficha_peso'] = '';
        $GLOBALS['ficha_altu'] = '';
        $GLOBALS['ficha_imc'] = '';
        $GLOBALS['ficha_obes'] = '';

        $soAtivo = 'AND situacao_fun in(0,1)';

        /*
         * Dados para o formulario de editando
         */
        if ($id > 0) {
            $Sql = "SELECT a.*, i.*
                    FROM phpzon_consultas a
                    LEFT JOIN phpzon_ficha_clinica i ON (i.ficha_cod_cons = a.id_cons)
                    WHERE a.id_cons=" . $id . " AND a.lixeira_cons=1 ORDER BY a.id_cons ASC";
            $Lista = new consulta_Class($Sql, 1);

            while ($var = $this->mysql->myLista($Lista->consulta)) {
                $GLOBALS['map'] = 'Consulta: ' . $var->id_cons;
                # Dados consulta
                $GLOBALS['id_cons'] = $var->id_cons;
                $GLOBALS['tipo_cons'] = $var->tipo_cons;
                $GLOBALS['funcionario_cons'] = $var->funcionario_cons;
                $GLOBALS['medico_cons'] = $var->medico_cons;
                $GLOBALS['obs_cons'] = $var->obs_cons;
                $GLOBALS['data_hora_aten_cons'] = $var->data_hora_aten_cons;
                # Dados ficha
                $GLOBALS['ficha_pa'] = (($var->ficha_pa == false) ? '' : $var->ficha_pa);
                $GLOBALS['ficha_peso'] = (($var->ficha_peso == false) ? '' : $var->ficha_peso);
                $GLOBALS['ficha_altu'] = (($var->ficha_altu == false) ? '' : $var->ficha_altu);
                $GLOBALS['ficha_imc'] = (($var->ficha_imc == false) ? '' : $var->ficha_imc);
                $GLOBALS['ficha_obes'] = (($var->ficha_obes == false) ? '' : $var->ficha_obes);
            }

            $soAtivo = '';
        }

        /*
         * Criando lista de opcoes para o tipo de exame
         */
        $sql_tipo_exame = $this->mysql->myConsulta('select * from phpzon_tipo_exame order by titulo_exa asc');
        $list_tipo_exame .= '<option value="0">SELECIONAR</option>';
        while ($var = $this->mysql->myLista($sql_tipo_exame)) {
            $list_tipo_exame .= '<option value="' . $var->id_exa . '"';
            $list_tipo_exame .= (($GLOBALS['tipo_cons'] == $var->id_exa) ? 'selected="selected"' : '' ) . '>' . $var->titulo_exa . '</option>';
        } $GLOBALS['list_tipo_exame'] = $list_tipo_exame;

        /*
         * Criando lista de opcoes para os funcionarios <optgroup label=""></optgroup>
         */

        $sql_funcionario = $this->mysql->myConsulta('select * from phpzon_funcionario where cpf_fun > 0 ' . $soAtivo . ' order by nome_fun asc');
        $list_funcionario .= '<option value="0">SELECIONAR</option>';
        while ($var = $this->mysql->myLista($sql_funcionario)) {
            $list_funcionario .= '<optgroup label="' . $var->cpf_fun . '">';
            $list_funcionario .= '<option value="' . $var->id_fun . '"';
            $list_funcionario .= (($GLOBALS['funcionario_cons'] == $var->id_fun) ? 'selected="selected"' : '' ) . '>' . $var->nome_fun . '</option>';
            $list_funcionario .= '</optgroup>';
        } $GLOBALS['list_funcionario'] = $list_funcionario;

        /*
         * Criando lista de opcoes para select funcao
         */
        $sql_medico = $this->mysql->myConsulta('select * from phpzon_medico order by nome_med asc');
        $list_medico .= '<option value="0">SELECIONAR</option>';
        while ($var = $this->mysql->myLista($sql_medico)) {
            $list_medico .= '<option value="' . $var->id_med . '"';
            $list_medico .= (($GLOBALS['medico_cons'] == $var->id_med) ? 'selected="selected"' : '' ) . '>' . $var->nome_med . '</option>';
        } $GLOBALS['list_medico'] = $list_medico;
    }

    function lixeiraArquivar($id_arq) {
        if ($id_arq > 0) {
            $result = $this->mysql->myConsulta('update phpzon_consultas set lixeira_cons=0 where id_cons=' . $id_arq . ' limit 1');
            if ($result == false) {
                $msn .= '<div class="alert alert-block alert-error fade in">';
                #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                $msn .= '<p>Não possivel enviar este registro</p>';
                $msn .= '<p>';
                $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                $msn .= '</p>';
                $msn .= '</div>';
            } else {
                $msn .= "<script>window.location = '{Global_voltar_pra_list}'</script>";
            }
            return $msn;
        }
    }

    function lixeiraDeletar($id_delete) {
        if ($id_delete > 0) {

            $result = $this->mysql->myDados('select * from phpzon_consultas where id_cons=' . $id_delete . ' and lixeira_cons=1 and arquivada_cons=0 limit 1');

            if ($result->id_cons > 0) {

                # Excuindo consulta
                $result_del_cons = $this->mysql->myConsulta('delete from phpzon_consultas where id_cons=' . $result->id_cons . ' limit 1');

                # Se aconsulta for excluida inicia o processo de exclusão da ficha
                if ($result_del_cons == true) {

                    # Excluindo ficha da consulta
                    $result_del_ficha = $this->mysql->myConsulta('delete from phpzon_ficha_clinica where ficha_cod_cons=' . $result->id_cons . ' limit 1');
                    if ($result_del_ficha == false) {
                        $msn .= '<div class="alert alert-block alert-error fade in">';
                        #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                        $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                        $msn .= '<p>Não possivel deletar a ficha de consulta.<br /></p>';
                        $msn .= '<p>';
                        $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                        #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                        $msn .= '</p>';
                        $msn .= '</div>';
                    } elseif ($result_del_ficha == true) {
                        $msn .= "<script>window.location = '{Global_voltar_pra_list}/&a_ficha_foi_excluida'</script>";
                    } else {
                        $msn .= '<div class="alert alert-block alert-error fade in">';
                        #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                        $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                        $msn .= '<p>Algo saiu erradi e a ficha não foi excluida.<br /></p>';
                        $msn .= '<p>';
                        $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                        #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                        $msn .= '</p>';
                        $msn .= '</div>';
                    }
                } elseif ($result_del_cons == false) {

                    $msn .= '<div class="alert alert-block alert-error fade in">';
                    #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                    $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                    $msn .= '<p>Não possivel deletar este registro.<br /></p>';
                    $msn .= '<p>Tire o registro do arquivo, depois envie para lixeira e tente deletar novamente</p>';
                    $msn .= '<p>';
                    $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                    #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                    $msn .= '</p>';
                    $msn .= '</div>';
                } else {

                    $msn .= "<script>window.location = '{Global_voltar_pra_list}'</script>";
                }
            } else {
                $msn .= '<div class="alert alert-block alert-error fade in">';
                #$msn .= '<button type="button" class="close" data-dismiss="alert">×</button>';
                $msn .= '<h4 class="alert-heading">Oh! Você tem um erro!</h4>';
                $msn .= '<p>Não foi possivel selecionar o registro</p>';
                $msn .= '<p>';
                $msn .= '<a class="btn btn-danger" href="{Global_voltar_pra_list}">Voltar</a> ';
                #$msn .= '<a class="btn" href="#">Ou faça isto</a> ';
                $msn .= '</p>';
                $msn .= '</div>';
            }

            return $msn;
        }
    }

}

?>
