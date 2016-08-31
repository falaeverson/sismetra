<?php

/**
 * Todos os controladores devem extends um Modelo correspondente
 * 
 * @author Elves
 */
class index_Controller extends index_Model {

    function __construct() {
        parent::__construct();
        $GLOBALS['active_home'] = '';
        $GLOBALS['active_cadastro'] = '';
        $GLOBALS['active_atendimento'] = '';
        $GLOBALS['active_crachas'] = '';
        # linha do menu ativo
        $GLOBALS['li_active_home'] = '';
        $GLOBALS['li_active_usuario'] = '';
        $GLOBALS['li_active_medico'] = '';
        $GLOBALS['li_active_funcionario'] = '';
        $GLOBALS['li_active_setor'] = '';
        $GLOBALS['li_active_funcao'] = '';
        $GLOBALS['li_active_fichaclinica'] = '';
        $GLOBALS['li_active_historicoconsulta'] = '';
        $GLOBALS['li_active_marcarconsulta'] = '';
        $GLOBALS['li_active_consultamarcadas'] = '';
        $GLOBALS['li_active_selecionarcracha'] = '';
        $GLOBALS['li_active_gerarcrachas'] = '';
    }

    /**
     * INICIO DO MENU SYSTEMA
     * 
     * 
     * Esta função é obrigatoria em todos os controladores
     */
    function home() {
        # Menu ativo
        $GLOBALS['active_home'] = 'active';
        $GLOBALS['li_active_home'] = 'class="active"';

        # Inicio dos gráficos

        self::graficosHome();


        # Fim dos gráficos

        self::Layout("home", "Sismetra > Sismetra");
    }

    /**
     * Esta função 
     */
    function usuario() {
        # Menu ativo
        $GLOBALS['active_home'] = 'active';
        $GLOBALS['li_active_usuario'] = 'class="active"';

        self::Layout("home", "Sismetra > C.Usuario");
    }

    /**
     * INICIO DO MENU CADASTRO
     * Esta função 
     */
    function medico() {
        # Menu ativo
        $GLOBALS['active_cadastro'] = 'active';
        $GLOBALS['li_active_medico'] = 'class="active"';
        $GLOBALS['Helper']['medico'] = '';
        $GLOBALS['lista'] = '';
        # Paginas
        $pg = $_GET['pagina'];
        $origem = $_GET['origem'];
        # Origem
        $GLOBALS['origem_list'] = urlOrigem();
        $GLOBALS['voltar_pra_list'] = urlDistino($origem);
        switch ($pg) {
            # Exibindo form de edição
            case 'edit':
                $GLOBALS['origem_edit'] = urlOrigem();
                $id = mysql_real_escape_string($_GET['id']);
                $this->medicoEdit($id);
                $GLOBALS['Helper']['medico'] = self::Helper('medicoEdit');
                self::Layout("medico", "Sismetra > C.Médicos");
                break;

            # Exibindo form de edição
            case 'salve':
                $this->medicoSalvar();
                break;

            # Deletando registro
            case 'delete':
                $id_del = mysql_real_escape_string($_GET['id_del']);
                $GLOBALS['Helper']['medico'] = $this->medicoDelete($id_del);
                self::Layout("medico", "Sismetra > C.Médicos");
                break;

            # Exibição padrao listagen
            default:
                $lista = $this->medicoList();
                if (!empty($lista)) {
                    $GLOBALS['lista'] = $lista;
                }
                $GLOBALS['Helper']['medico'] = self::Helper('medicoList');
                self::Layout("medico", "Sismetra > C.Médicos");
                break;
        }
    }

    /**
     * Esta função 
     */
    function funcionario() {
        # Menu ativo
        $GLOBALS['active_cadastro'] = 'active';
        $GLOBALS['li_active_funcionario'] = 'class="active"';

        $GLOBALS['Helper']['funcinario'] = '';
        $GLOBALS['lista'] = '';
        # Paginas
        $pg = $_GET['pagina'];
        $origem = $_GET['origem'];
        # Origem
        $GLOBALS['origem_list'] = urlOrigem();
        $GLOBALS['voltar_pra_list'] = urlDistino($origem);
        switch ($pg) {
            # Exibindo form de edição
            case 'edit':
                $GLOBALS['origem_edit'] = urlOrigem();
                $id = mysql_real_escape_string($_GET['id']);
                $this->funcinarioEdit($id);
                $GLOBALS['Helper']['funcinario'] = self::Helper('funcinarioEdit');
                self::Layout("funcionario", "Sismetra > C.Funcionario");
                break;

            # Exibindo form de edição
            case 'salve':
                $this->funcinarioSalvar();
                break;

            # Fasendo busca de dados 
            case 'busca':
                print $this->funcinarioBusc($_POST['nome'], $_POST['drt']);
                break;

            # Exibindo form de edição
            case 'select':
                $this->funcinarioSelectAuto();
                break;

            # Deletando registro
            case 'delete':
                $id_del = mysql_real_escape_string($_GET['id_del']);
                $GLOBALS['Helper']['funcinario'] = $this->funcinarioDelete($id_del);
                self::Layout("funcionario", "Sismetra > C.Funcionario");
                break;

            # Exibição padrao listagen
            default:
                $lista = $this->funcinarioList();
                if (!empty($lista)) {
                    $GLOBALS['lista'] = $lista;
                }
                $GLOBALS['Helper']['funcinario'] = self::Helper('funcinarioList');
                self::Layout("funcionario", "Sismetra > C.Funcionario");
                break;
        }
    }

    /**
     * Esta função 
     */
    function setor() {
        # Menu ativo
        $GLOBALS['active_cadastro'] = 'active';
        $GLOBALS['li_active_setor'] = 'class="active"';
        $GLOBALS['Helper']['setor'] = '';
        $GLOBALS['lista'] = '';
        # Paginas
        $pg = $_GET['pagina'];
        $origem = $_GET['origem'];
        # Origem
        $GLOBALS['origem_list'] = urlOrigem();
        $GLOBALS['voltar_pra_list'] = urlDistino($origem);
        switch ($pg) {
            # Exibindo form de edição
            case 'edit':
                $GLOBALS['origem_edit'] = urlOrigem();
                $id = mysql_real_escape_string($_GET['id']);
                $this->setorEdit($id);
                $GLOBALS['Helper']['setor'] = self::Helper('setorEdit');
                self::Layout("setor", "Sismetra > C.Setor");
                break;

            # Fasendo busca de dados 
            case 'busca':
                print $this->setorBusc($_POST['nome']);
                break;

            # Exibindo form de edição
            case 'salve':
                $this->setorSalvar();
                break;

            # Deletando registro
            case 'delete':
                $id_del = mysql_real_escape_string($_GET['id_del']);
                $GLOBALS['Helper']['setor'] = $this->setorDelete($id_del);
                self::Layout("setor", "Sismetra > C.Setor");
                break;

            # Exibição padrao listagen
            default:
                $lista = $this->setorList();
                if (!empty($lista)) {
                    $GLOBALS['lista'] = $lista;
                }
                $GLOBALS['Helper']['setor'] = self::Helper('setorList');
                self::Layout("setor", "Sismetra > C.Setor");
                break;
        }
    }

    /**
     * Esta função 
     */
    function funcao() {
        # Menu ativo
        $GLOBALS['active_cadastro'] = 'active';
        $GLOBALS['li_active_funcao'] = 'class="active"';
        $GLOBALS['Helper']['funcao'] = '';
        $GLOBALS['lista'] = '';
        # Paginas
        $pg = $_GET['pagina'];
        $origem = $_GET['origem'];
        # Origem
        $GLOBALS['origem_list'] = urlOrigem();
        $GLOBALS['voltar_pra_list'] = urlDistino($origem);
        switch ($pg) {
            # Exibindo form de edição
            case 'edit':
                $GLOBALS['origem_edit'] = urlOrigem();
                $id = mysql_real_escape_string($_GET['id']);
                $this->funcaoEdit($id);
                $GLOBALS['Helper']['funcao'] = self::Helper('funcaoEdit');
                self::Layout("funcao", "Sismetra > C.Função");
                break;

            # Fasendo busca de dados 
            case 'busca':
                print $this->funcaoBusc($_POST['setor'], $_POST['funcao']);
                break;

            # Exibindo form de edição
            case 'salve':
                $this->funcaoSalvar();
                break;

            # Deletando registro
            case 'delete':
                $id_del = mysql_real_escape_string($_GET['id_del']);
                $GLOBALS['Helper']['funcao'] = $this->funcaoDelete($id_del);
                self::Layout("funcao", "Sismetra > C.Função");
                break;

            # Exibição padrao listagen
            default:
                $lista = $this->funcaoList();
                if (!empty($lista)) {
                    $GLOBALS['lista'] = $lista;
                }
                $GLOBALS['Helper']['funcao'] = self::Helper('funcaoList');
                self::Layout("funcao", "Sismetra > C.Função");
                break;
        }
    }

    /**
     * INICIO DO MENU ATENDIMENTO
     * Esta função 
     */
    function fichaclinica() {
        # Menu ativo
        $GLOBALS['active_atendimento'] = 'active';
        $GLOBALS['li_active_fichaclinica'] = 'class="active"';

        $GLOBALS['Helper']['fichaclinica'] = '';
        $GLOBALS['lista'] = '';
        # Paginas
        $pg = $_GET['pagina'];
        $origem = $_GET['origem'];
        # Origem
        $GLOBALS['origem_list'] = urlOrigem();
        $GLOBALS['voltar_pra_list'] = urlDistino($origem);
        switch ($pg) {
            # Exibindo form de edição
            case 'edit':
                $GLOBALS['origem_edit'] = urlOrigem();
                $id = mysql_real_escape_string($_GET['id']);
                $this->fichaClinicaZom($id);
                $GLOBALS['Helper']['fichaclinica'] = self::Helper('fichaclinicaEdit');
                self::Layout("fichaclinica", "Sismetra > F.Clinica");
                break;

            # Fasendo busca de dados 
            case 'busca':
                print $this->fichaClinicaBusc($_POST['nome'], $_POST['drt']);
                break;

            # Deletando registro
            case 'lixeira':
                $id_del = mysql_real_escape_string($_GET['id_del']);
                $this->fichaClinicaLixeira($id_del);
                header('Location: ' . urlDistino($origem));
                self::Layout("marcarConsulta", "Sismetra > F.Clinica");
                break;

            # Exibição padrao listagen
            default:
                $lista = $this->fichaClinicaList();
                if (!empty($lista)) {
                    $GLOBALS['lista'] = $lista;
                }
                $GLOBALS['Helper']['fichaclinica'] = self::Helper('fichaclinicaList');
                self::Layout("fichaclinica", "Sismetra > F.Clinica");
                break;
        }
    }

    /**
     * Esta função 
     */
    function consultasarquivada() {
        # Menu ativo
        $GLOBALS['active_atendimento'] = 'active';
        $GLOBALS['li_active_historicoconsulta'] = 'class="active"';
        $GLOBALS['Helper']['consultaArquivada'] = '';
        $GLOBALS['lista'] = '';
        # Paginas
        $pg = $_GET['pagina'];
        $origem = $_GET['origem'];
        # Origem
        $GLOBALS['origem_list'] = urlOrigem();
        $GLOBALS['voltar_pra_list'] = urlDistino($origem);
        switch ($pg) {
            # Exibindo form de edição
            case 'visualizar':
                $GLOBALS['origem_edit'] = urlOrigem();
                $id = mysql_real_escape_string($_GET['id_vis']);
                $this->consultaArquivadaVisua($id);
                $GLOBALS['Helper']['consultaArquivada'] = self::Helper('consutasArquivadasEdit');
                self::Layout("consultasArquivada", "Sismetra > M.Consultas");
                break;

            # Fasendo busca de dados 
            case 'busca':
                print $this->consultaArquivadaBusc($_POST['nome'], $_POST['codigo'], $_POST['situacao']);
                break;

            # Arquivando registro
            case 'arquivar':
                $id_arq = mysql_real_escape_string($_GET['id_arq']);
                $GLOBALS['Helper']['consultaArquivada'] = $this->consultaArquivadaArquivar($id_arq);
                self::Layout("consultasArquivada", "Sismetra > A.Consultas");
                break;

            # Exibição padrao listagen
            default:
                $lista = $this->consultaArquivadaList();
                if (!empty($lista)) {
                    $GLOBALS['lista'] = $lista;
                }
                $GLOBALS['Helper']['consultaArquivada'] = self::Helper('consutasArquivadasList');
                self::Layout("consultasArquivada", "Sismetra > A.Consultas");
                break;
        }
    }

    /**
     * Esta função 
     */
    function marcarconsulta() {
        # Menu ativo
        $GLOBALS['active_atendimento'] = 'active';
        $GLOBALS['li_active_marcarconsulta'] = 'class="active"';
        $GLOBALS['Helper']['marConsulta'] = '';
        $GLOBALS['lista'] = '';
        # Paginas
        $pg = $_GET['pagina'];
        $origem = $_GET['origem'];
        # Origem
        $GLOBALS['origem_list'] = urlOrigem();
        $GLOBALS['voltar_pra_list'] = urlDistino($origem);
        switch ($pg) {
            # Exibindo form de edição
            case 'edit':
                $GLOBALS['origem_edit'] = urlOrigem();
                $id = mysql_real_escape_string($_GET['id']);
                $GLOBALS['Helper']['marConsulta'] .= $this->marcarConsultaEdit($id);
                $GLOBALS['Helper']['marConsulta'] .= self::Helper('marConsultaEdit');
                self::Layout("marcarConsulta", "Sismetra > M.Consultas");
                break;

            # Exibindo form de edição
            case 'salve':
                $this->marcarConsultaSalvar();
                break;

            # Fasendo busca de dados 
            case 'busca':
                print $this->marcarConsultaBusc($_POST['nome'], $_POST['codigo'], $_POST['situacao']);
                break;

            # Movendo para lixeira
            case 'lixeira':
                $id_lix = mysql_real_escape_string($_GET['id_lix']);
                $GLOBALS['Helper']['marConsulta'] = $this->marcarConsultaLixeira($id_lix);
                self::Layout("marcarConsulta", "Sismetra > M.Consultas");
                break;

            # Arquivando registro
            case 'arquivar':
                $id_arq = mysql_real_escape_string($_GET['id_arq']);
                $GLOBALS['Helper']['marConsulta'] = $this->marcarConsultaArquivar($id_arq);
                self::Layout("marcarConsulta", "Sismetra > M.Consultas");
                break;

            # Exibição padrao listagen
            default:
                $lista = $this->marcarConsultaList();
                if (!empty($lista)) {
                    $GLOBALS['lista'] = $lista;
                }
                $GLOBALS['Helper']['marConsulta'] = self::Helper('marConsultaList');
                self::Layout("marcarConsulta", "Sismetra > M.Consultas");
                break;
        }
    }

    /**
     * Esta função 
     */
    function consultamarcadas() {
        # Menu ativo
        $GLOBALS['active_atendimento'] = 'active';
        $GLOBALS['li_active_consultamarcadas'] = 'class="active"';
        $GLOBALS['Helper']['consultasMarcadas'] = '';
        $GLOBALS['lista'] = '';
        # Paginas
        $pg = $_GET['pagina'];
        $origem = $_GET['origem'];
        # Origem
        $GLOBALS['origem_list'] = urlOrigem();
        $GLOBALS['voltar_pra_list'] = urlDistino($origem);
        switch ($pg) {
            # Exibindo form de edição
            case 'edit':
                $GLOBALS['origem_edit'] = urlOrigem();
                $id = mysql_real_escape_string($_GET['id']);
                $id_cons = mysql_real_escape_string($_GET['id_cons']);
                $this->consultaMarcardaEdit($id, $id_cons);
                $GLOBALS['Helper']['consultasMarcadas'] = self::Helper('consultasMarcadasEdit');
                self::Layout("consultasMarcadas", "Sismetra > M.Consultas");
                break;

            # Exibindo form de edição
            case 'salve':
                $this->consultaMarcardaSalvar();
                break;

            # Fasendo busca de dados 
            case 'busca':
                print $this->consultaMarcardaBusc($_POST['nome'], $_POST['codigo'], $_POST['situacao']);
                break;

            # Deletando registro
            case 'delete':
                $id_del = mysql_real_escape_string($_GET['id_del']);
                $this->consultaMarcardaDelete($id_del);
                header('Location: ' . urlDistino($origem));
                self::Layout("marcarConsulta", "Sismetra > M.Consultas");
                break;

            # Exibição padrao listagen
            default:
                $lista = $this->consultaMarcardaList();
                if (!empty($lista)) {
                    $GLOBALS['lista'] = $lista;
                }
                $GLOBALS['Helper']['consultasMarcadas'] = self::Helper('consultasMarcadasList');
                self::Layout("consultasMarcadas", "Sismetra > M.Consultas");
                break;
        }
    }

    /**
     * Esta função 
     */
    function lixeira() {
        # Menu ativo
        $GLOBALS['active_lixeira'] = 'active';
        $GLOBALS['li_active_lixeira'] = 'class="active"';
        $GLOBALS['Helper']['lixeira'] = '';
        $GLOBALS['lista'] = '';
        # Paginas
        $pg = $_GET['pagina'];
        $origem = $_GET['origem'];
        # Origem
        $GLOBALS['origem_list'] = urlOrigem();
        $GLOBALS['voltar_pra_list'] = urlDistino($origem);
        switch ($pg) {
            # Exibindo form de edição
            case 'visualizar':
                $GLOBALS['origem_edit'] = urlOrigem();
                $id_vis = mysql_real_escape_string($_GET['id_vis']);
                $this->lixeiraVisua($id_vis);
                $GLOBALS['Helper']['lixeira'] = self::Helper('lixeiraEdit');
                self::Layout("lixeira", "Sismetra > A.Lixeira");
                break;

            # Fasendo busca de dados 
            case 'busca':
                print $this->lixeiraBusc($_POST['nome'], $_POST['codigo'], $_POST['situacao']);
                break;

            # Arquivando registro
            case 'arquivar':
                $id_arq = mysql_real_escape_string($_GET['id_arq']);
                $GLOBALS['Helper']['lixeira'] = $this->lixeiraArquivar($id_arq);
                self::Layout("lixeira", "Sismetra > A.Lixeira");
                break;

            # Arquivando registro
            case 'deletar':
                $id_delete = mysql_real_escape_string($_GET['id_delete']);
                $GLOBALS['Helper']['lixeira'] = $this->lixeiraDeletar($id_delete);
                self::Layout("lixeira", "Sismetra > A.Lixeira");
                break;

            # Exibição padrao listagen
            default:
                $lista = $this->lixeiraList();
                if (!empty($lista)) {
                    $GLOBALS['lista'] = $lista;
                }
                $GLOBALS['Helper']['lixeira'] = self::Helper('lixeiraList');
                self::Layout("lixeira", "Sismetra > A.Lixeira");
                break;
        }
    }

    /**
     * INICIO DO MENU CRACHÁ
     * 
     * 
     * Esta função é obrigatoria em todos os controladores
     */
    function selecionarcracha() {
        # Menu ativo
        $GLOBALS['active_crachas'] = 'active';
        $GLOBALS['li_active_selecionarcracha'] = 'class="active"';

        self::Layout("arquivo_impressao", "Sismetra > S.Crachás");
    }

    /**
     * Esta função 
     */    
    function relatorio() {


        # Relatorio
        // New - Novo documento PDF com orientaÃ§Ã£o P - Retrato (Picture) que pode ser tambÃ©m L - Paisagem (Landscape)
        $pdf = new FPDF('P');
        $SQL = "select phpzon_ficha_clinica.*, phpzon_funcionario.*, phpzon_medico.nome_med, phpzon_setor.*,
                phpzon_funcao.*, phpzon_sexo.*, phpzon_estado_civil.*, phpzon_tipo_exame.*,phpzon_consultas.*,
                DATE_FORMAT(data_cons, '%d/%m/%Y %H:%s') as data_cons 
                from phpzon_consultas
                left join phpzon_ficha_clinica on phpzon_ficha_clinica.ficha_cod_cons = phpzon_consultas.id_cons 
                left join phpzon_funcionario   on phpzon_funcionario.id_fun           = phpzon_consultas.funcionario_cons 
                left join phpzon_medico        on phpzon_medico.id_med                = phpzon_consultas.medico_cons
                left join phpzon_tipo_exame    on phpzon_tipo_exame.id_exa            = phpzon_consultas.tipo_cons
                left join phpzon_setor         on phpzon_setor.id_set                 = phpzon_funcionario.setor_fun 
                left join phpzon_funcao        on phpzon_funcao.id_funcao             = phpzon_funcionario.funcao_fun 
                left join phpzon_sexo          on phpzon_sexo.id_sexo                 = phpzon_funcionario.sexo_fun 
                left join phpzon_estado_civil  on phpzon_estado_civil.id_esci         = phpzon_funcionario.civil_fun 
                where id_cons=" . base64_decode($_GET['p']) . " and lixeira_cons=0 limit 1";

        # base64_decode(base64_encode($_GET['p']))  and lixeira_cons=0 and arquivada_cons=0
        
        $ficha = $this->mysql->myDados($SQL);

        // Definindo Fonte
        $pdf->SetFont('arial', '', 9);

        //posicao vertical no caso -1 e o limite da margem
        $pdf->SetY("-2");
        $pdf->SetFillColor(122, 122, 122);
        $borda = 0;    # Borda das tabelas
        $altura = 6;   # Altura de todo o documento
        $aling = 'L';  # Alinhamento dos texto nas celulas
        //::::::::::::::::::Cabecalho::::::::::::::::::::
        $pdf->Image(DIR_PATH . '/img/HeaderPDF.jpg');
        $pdf->SetFontSize(12);
        #$pdf->Cell(0,5,'COMPANHIA SISAL DO BRASIL - COSIBRA',0,1,'C');
        $pdf->SetFont('', 'BU');
        $pdf->Ln(4);
        $pdf->Cell(0, 5, utf8_decode('FICHA CLÍNICA'), 0, 1, 'C');
        $pdf->Ln(5);

        //::::::::::::::::::IDENTIFICACAO::::::::::::::::::::
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, utf8_decode('IDENTIFICAÇÃO'), 'B', 1, 'C');

        # Consulta
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(13, $altura, 'COD: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(30, $altura, $ficha->id_cons, $borda, 0);
        # Nome
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(16, $altura, 'NOME: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(99, $altura, $ficha->nome_fun, $borda, 0);
        # DRT
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, $altura, 'DRT: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(22, $altura, $ficha->drt_fun, $borda, 1);
        # CPF
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(13, $altura, 'CPF: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(30, $altura, $ficha->cpf_fun, $borda, 0);
        # RG
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(16, $altura, 'RG: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(22, $altura, $ficha->rg_fun, $borda, 0);
        # Estado Civil
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(16, $altura, 'E. CIVIL: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(23, $altura, $ficha->nome_esci, $borda, 0);
        # Sexo
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(13, $altura, 'SEXO: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(9, $altura, $ficha->nome_sexo, $borda, 0);
        # Data de nascimento
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(19, $altura, 'DN: ', $borda, 0, 'R');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(32, $altura, dataYMD_DMY($ficha->data), $borda, 1);

        # Idade
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(13, $altura, 'IDADE: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $ficha->idade_fun = getIdade(dataYMD_DMY($ficha->data));
        $pdf->Cell(30, $altura, $ficha->idade_fun . ' anos', $borda, 0);
        # Funcao
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(16, $altura, utf8_decode('FUNÇÃO:'), $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(66, $altura, utf8_decode($ficha->titulo_funcao), $borda, 0);
        # Setor
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(13, $altura, 'SETOR: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(52, $altura, $ficha->titulo_set, $borda, 1);
        # Data do Atendimento
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(13, $altura, 'DATA: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(30, $altura, $ficha->data_hora_aten_cons, $borda, 0);
        # Nome do medico responsavel
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(40, $altura, utf8_decode('MÉDICO RESPONSÁVEL: '), $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(107, $altura, $ficha->nome_med, $borda, 1);

        //::::::::::::::::::ATENDIMENTO::::::::::::::::::::
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, 'ATENDIMENTO', 'B', 1, 'C');

        # Idade
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(25, $altura, 'EXAME: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(30, $altura, $ficha->titulo_exa, $borda, 0);
        # PA
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(7, $altura, 'PA: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(13, $altura, $ficha->ficha_pa, $borda, 0);
        # Peso
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(11, $altura, 'PESO: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(9, $altura, $ficha->ficha_peso, $borda, 0);
        # Altura
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(9, $altura, 'ALT: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(9, $altura, $ficha->ficha_altu, $borda, 0);
        # Imc
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(9, $altura, 'IMC: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(8, $altura, $ficha->ficha_imc, $borda, 0);
        # Obesidade
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'OBESIDADE: ', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(37, $altura, $ficha->ficha_obes, $borda, 1);


        //::::::::::::::::::ANAMNESE::::::::::::::::::::
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, 'ANAMNESE', 'B', 1, 'C');
        $pdf->Ln(1);
        $pdf->SetFont('', '');
        $pdf->MultiCell(190, 4, utf8_decode($ficha->ficha_obs), $borda, 'J');


        //::::::::::::::::::EXAMES COMPLEMENTARES::::::::::::::::::::
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, utf8_decode('EXAMES COMPLEMENTÁRES'), 'B', 1, 'C');

        $larTituExame = 60; # Largura exames complementares
        $alData = 30;
        $alValor = 25;

        # HEMOGRAMA
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'HEMOGRAMA', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_hemo), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valor_hemo, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_hemo, $borda, 1);
        # COLESTERÃ“L TOTAL
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'COLESTEROL TOTAL', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_coles), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valor_coles, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_coles, $borda, 1);
        # TRIGLICERIDEOS
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'TRIGLICERIDEOS', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_trig), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valor_trig, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_trig, $borda, 1);
        # GLICEMIA
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'GLICEMIA', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_glic), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valor_glic, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_glic, $borda, 1);
        # CLASS. SANGINEA
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'CLASS. SANGUINEA', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_clsa), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valor_clsa, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_clsa, $borda, 1);
        # PAR. DE FEZES
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'PAR. DE FEZES', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_prfe), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valor_prfe, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_prfe, $borda, 1);
        # SUMÃ�RIO DE URINA
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'SUMARIO DE URINA', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_smur), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valor_smur, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_smur, $borda, 1);
        # SOROL. HEPATITE IGG/IGM
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'SOROL. HEPATITE IGG/IGM', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_sohe), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valor_sohe, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_sohe, $borda, 1);
        # SOROL. TOXOPLASMOSE
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'SOROL. TOXOPLASMOSE', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_soto), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valor_soto, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_soto, $borda, 1);
        # RX DO TÃ“RAX E PERFIL
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'RX DO TORAX E PERFIL', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_rxtp), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valor_rxtp, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_rxtp, $borda, 1);
        # RX DA COLUNA LOMBAR
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'RX DA COLUNA LOMBAR', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_rxcl), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valo_rxcl, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_rxcl, $borda, 1);
        # RX DO TÃ“RAX
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'RX DO TORAX', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_rxto), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valo_rxto, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_rxto, $borda, 1);
        # ECG
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'ECG', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_ecg), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valo_ecg, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_ecg, $borda, 1);
        # EEG
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'EEG', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_eeg), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valo_eeg, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_eeg, $borda, 1);
        # AUDIOMETRIA
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'AUDIOMETRIA', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_audi), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valo_audi, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_audi, $borda, 1);
        # VDRL
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'VDRL', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_vdrl), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valo_vdrl, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_vdrl, $borda, 1);
        # AVALIAÇÃO OFTALMOLÓGICA
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, utf8_decode('AVALIAÇÃO OFTALMOLÓGICA'), $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_ava_ofta), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valo_ava_ofta, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_ava_ofta, $borda, 1);
        # ACUIDADE VISUAL
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, 'ACUIDADE VISUAL', $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_acu_visu), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valo_acu_visu, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_acu_visu, $borda, 1);
        # AVALIAÇÃO CARDÍACA
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, utf8_decode('AVALIAÇÃO CARDÍACA'), $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_ava_card), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valo_ava_card, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_ava_card, $borda, 1);
        # AVALIAÇÃO ESPECIALISTA
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($larTituExame, $altura, utf8_decode('AVALIAÇÃO ESPECIALISTA'), $borda, 0, $aling);
        $pdf->Cell(13, $altura, 'DATA:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alData, $altura, dataYMD_DMY($ficha->ficha_data_ava_espe), $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(23, $altura, 'RESULTADO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($alValor, $altura, $ficha->ficha_valo_ava_espe, $borda, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(22, $altura, 'SITUACAO:', $borda, 0, $aling);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(5, $altura, $ficha->ficha_situ_ava_espe, $borda, 1);

        #$pdf->SetFont('Arial','',10);
        #$pdf->Cell(75,5,'Everson Teixeira',1,1);
        # Tipo de saida | 
        $pdf->Output("");
        
        /*
         * 
         * VDRL
AVALIAÇÃO OFTALMOLÓGICA
ACUIDADE VISUAL
AVALIAÇÃO CARDÍACA
AVALIAÇÃO ESPECIALISTA
         */

        # Fim Relatorio
    }

    /**
     * Esta função 
     */
    function gerarcrachas() {
        # Menu ativo
        $GLOBALS['active_crachas'] = 'active';
        $GLOBALS['li_active_gerarcrachas'] = 'class="active"';

        self::Layout("home", "Sismetra > G.Crachás");
    }

}

?>
