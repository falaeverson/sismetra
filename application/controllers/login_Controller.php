<?php

/**
 * Todos os controladores devem extends um Modelo correspondente
 * 
 * @author Elves
 */
class login_Controller extends login_Model {

    private $mysql;
    private $usuario;

    /**
     * Esta função é obrigatoria em todos os controladores
     */
    function __construct() {
        parent::__construct();
        $GLOBALS['Helper']['alerta'] = '';
        $this->mysql = new mysql_Class();

        $GLOBALS['login'] = '';
        $GLOBALS['password'] = '';
        $GLOBALS['erro_login'] = 'success';
        $GLOBALS['erro_senha'] = 'success';

        # Nova Conta
        $GLOBALS['nNome'] = '';
        $GLOBALS['nLogin'] = '';
        $GLOBALS['nEmail'] = '';
        $GLOBALS['nPassword'] = '';
        $GLOBALS['nPassword_conf'] = '';
    }

    function home() {

        $session = usuario('name_user');
        if ($session) {
            header('Location: ' . config('path'));
        }



        self::Layout("login", "Sismetra > Login");
    }

    function verificadadoslogin($pUser = false, $pSenha = false) {
        if ($pUser == false && $pSenha == false) {
            $user = mysql_real_escape_string($_POST['usuario']);
            $password = mysql_real_escape_string($_POST['senha']);
        } else {
            $user = mysql_real_escape_string($pUser);
            $password = mysql_real_escape_string($pSenha);
        }


        # Verificando Login
        if (!empty($user)) {
            $ver = strpos($user, '@');
            if ($ver === false) {
                $dadosUser = $this->mysql->myDados('select * from phpzon_user where login_user = "' . $user . '"');
            } else {
                $dadosUser = $this->mysql->myDados('select * from phpzon_user where email_user = "' . $user . '"');
            }

            if ($dadosUser->login_user === $user or $dadosUser->email_user === $user) {

                $GLOBALS['login'] = $user;

                # Verificando senha
                if (!empty($password)) {
                    $dadosPassword = $this->mysql->myDados('select * from phpzon_password where 
                        id_user_password = "' . $dadosUser->id_user . '" and senha_password="' . md5($password) . '"');
                    if ($dadosPassword->id_user_password === $dadosUser->id_user) {

                        if ($dadosUser->id_user > 0 && strlen($dadosPassword->senha_password) == 32):

                            $usuario = $this->mysql->myDados('select * from phpzon_user where id_user in 
                                (select id_user_password from phpzon_password 
                                where id_user_password="' . $dadosUser->id_user . '" 
                                and senha_password="' . $dadosPassword->senha_password . '") 
                                 limit 1');


                            $this->usuario = $usuario;

                            if ($this->usuario->status_user == 1) {
                                $_SESSION['PhpZon_User'] = $this->usuario;

                                if ($_SESSION['PhpZon_User']->id_user > 0) {
                                    # print "<script>alert('Seja bem vindo');</script>";
                                    print "<script>window.location='" . config('path') . "';</script>";
                                }
                            } elseif ($this->usuario->status_user == 0) {
                                # print "<script>alert('Usuario bloqueado');</script>";
                            } else {
                                #print "<script>alert('Ocorreu um erro');</script>";
                                exit;
                            }

                        endif;
                    } else {
                        $GLOBALS['password'] = $password;
                        $GLOBALS['erro_senha'] = 'error';
                    }
                } else {
                    $GLOBALS['erro_senha'] = 'error';
                }
            } else {
                $GLOBALS['login'] = $user;
                $GLOBALS['erro_login'] = 'error';
            }
        } else {
            $GLOBALS['erro_login'] = 'error';
        }


        self::Layout("login", "PhpZon::Login");
    }

    function novaconta() {

        $name = mysql_real_escape_string($_POST['name']);
        $login = mysql_real_escape_string($_POST['login']);
        $email = mysql_real_escape_string($_POST['email']);
        $password = mysql_real_escape_string($_POST['password']);
        $password_conf = mysql_real_escape_string($_POST['password_conf']);

        # Verificando Nome
        if (empty($name)) {
            $GLOBALS['nNome'] = '';
            $GLOBALS['erro_nNome'] = 'style="border:1px solid #ff0a1d;"';
        } else {
            $GLOBALS['nNome'] = $name;
            $nomeOk = $name;
        }
        
        # Verificando Login
        if (!empty($login)) {
            $nLogin = $this->mysql->myDados('select * from phpzon_user where login_user ="' . $login . '"');
            if ($nLogin->login_user === $login) {
                $GLOBALS['nLogin'] = $nLogin->login_user;
                $GLOBALS['erro_nLogin'] = 'style="border:1px solid #ff0a1d;"';
            } else {
                $GLOBALS['nLogin'] = $login;
                $loginOk = $login;
            }
        } else {
            $GLOBALS['erro_nLogin'] = 'error';
        }

        # Verificando Email
        if (!empty($email)) {
            $nEmail = $this->mysql->myDados('select * from phpzon_user where email_user ="' . $email . '"');
            if ($nEmail->email_user === $email) {
                $GLOBALS['nEmail'] = $nEmail->email_user;
                $GLOBALS['erro_nEmail'] = 'style="border:1px solid #ff0a1d;"';
            } else {
                $GLOBALS['nEmail'] = $email;
                $emailOk = $email;
            }
        } else {
            $GLOBALS['erro_nEmail'] = 'style="border:1px solid #ff0a1d;"';
        }

        # Verificando Senha
        if (!empty($password) && !empty($password_conf)) {
            if (md5($password) === md5($password_conf)) {
                $GLOBALS['nPassword'] = $password;
                $GLOBALS['nPassword_conf'] = $password_conf;
                $passwordOk = $password;
            } else {
                $GLOBALS['nPassword'] = $password;
                $GLOBALS['nPassword_conf'] = $password_conf;
                $GLOBALS['erro_nPassword'] = 'style="border:1px solid #ff0a1d;"';
            }
        } else {
            $GLOBALS['erro_nPassword'] = 'style="border:1px solid #ff0a1d;"';
        }

        if ($nomeOk === $name && $loginOk === $login && $emailOk === $email && $passwordOk === $password) {
            $insUser = array(
                'name_user' => $nomeOk,
                'login_user' => $loginOk,
                'email_user' => $emailOk,
                'status_user' => '1'
            );
            $this->mysql->myExecuta('phpzon_user', $insUser);

            $dadosPassword = $this->mysql->myDados('select * from phpzon_user where login_user ="' . $loginOk . '"');

            $insPassword = array(
                'id_user_password' => $dadosPassword->id_user,
                'senha_password' => md5($passwordOk)
            );
            $this->mysql->myExecuta('phpzon_password', $insPassword);

            if ($dadosPassword->status_user == 1) {
                #$this->verificadadoslogin($loginOk, md5($passwordOk));

                $destinatario = $emailOk;
                $assunto = "PhpZon - Confirmando seu E-mail";
                $corpo = '
                    <html>
                    <head>
                       <title>Confirmando seu E-mail</title>
                    </head>
                    <body>
                    <h1>Ol&aacute; '.$nomeOk.' !</h1>
                    <p>
                    <h3>Sej&aacute; Bem Vindo a PhpZon</h3>
                    <b>a rede social mais badalada do momento</b>.<br/> 
                    <a href="'.config('path').'/login/confirmando_email/?em='.$emailOk.'">Confirma meu e-mail</a>
                    </p>
                    </body>
                    </html>
                ';

                //para o envio em formato HTML
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html;charset=iso-8859-1\r\n";

                //endereço do remitente
                $headers .= "From: PhpZom <contato@agenciaconecte.com.br>\r\n";

                //endereço de resposta, se queremos que seja diferente a do remitente
                $headers .= "Reply-To: contato@agenciaconecte.com.br\r\n";

                //endereços que receberão uma copia 
                # $headers .= "Cc: manel@desarrolloweb.com\r\n"; 
                //endereços que receberão uma copia oculta
                # $headers .= "Bcc: vinnie@criarweb.com,joao@criarweb.com\r\n";
                mail($destinatario, $assunto, $corpo, $headers);
                
                header('Location: '.config('path').'/login/confirmando_email');
            }
        }


        self::Layout("login", "Sismetra > Nova Conta");
    }

    function confirmando_email() {
        $em = strpos($_GET['em'], '@');
        
        if($em == true){
            $GLOBALS['login'] = $_GET['em'];
            $GLOBALS['email'] = "Seu e-mail foi confirmado com sucesso";
        }else{
            $GLOBALS['email'] = "Enviamos um e-mail de confirmação.<br /> 
                             Verifique sua caixa de entrada ou span";
        }
        self::Layout("conf_email", "Sismetra > Aguardando");
    }
    
    function sair() {
        $_SESSION["PhpZon_User"] = false;
        session_destroy();
        header("Location: " . config('path') . "/login");
    }

}

?>
