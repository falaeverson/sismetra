<?php

/* -----------------------------------------------------------------------------------------------------------
 * REQUISITOS:
 * Paginacao: Gera paginacao
 * Requer: myLista() e myConsulta() em mysql_Class.php
 * 
 * EXEMPLO DE USO:
 * $Sql = 'select * from phpzon_medico';
 * $Lista = new consulta_Class($Sql, 1);
 * while ($var = $this->mysql->myLista($Lista->consulta)) {
 * 
 * }
 * 
 * MODELO DE PAGINAÇÃO:
 * $Lista->paginacaoM1($style);
 * $Lista->paginacaoM2($style, $alinhamento);
 * $Lista->paginacaoM2(1);
 * $Lista->paginacaoM2(2);
 * --------------------------------------------------------------------------------------------------------- */

class consulta_Class {

    var $sql;
    var $pp;
    var $pgatual;
    var $total_dados;
    var $pgtotal;
    var $consulta;
    var $btnAnt;
    var $btnPro;
    var $btnAtu;

    # Construtor

    function consulta_Class($sql, $quantidadePaginas) {
        $mysql = new mysql_Class();
        if (!empty($_GET['pg']))
            $pgInicial = $_GET['pg'];
        else
            $pgInicial = 1;

        $this->sql = $sql;
        $this->pp = $quantidadePaginas;
        $this->pgatual = $pgInicial;
        $this->total = $mysql->myLinhas($mysql->myConsulta($sql));

        if (($this->total % $this->pp) == 0)
            $this->pgtotal = ($this->total / $this->pp);
        else
            $this->pgtotal = (int) ($this->total / $this->pp) + 1;

        $this->consulta = $mysql->myConsulta($this->sql . ' LIMIT ' . $this->registroInicial() . ',' . $this->pp);


        return true;
    }

    # Registro Inicial

    function registroInicial() {
        return ($this->pp * ($this->pgatual - 1));
    }

    # Total de páginas

    function totalPaginas() {
        return $this->pgtotal;
    }

    function paginacaoM1($style, $alinha = "pagination-centered") {
        /*
         * Style padrao: deiche em branco
         * Style 1: pagination-large
         * Style 2: pagination-small
         * Style 2: pagination-mini
         * Centralizado no centro: pagination-centered
         * Centralizado a direita: pagination-right
         * Centralizado a esquerda: deicha em branco 
         */
        return '<div class="pagination ' . $style . ' ' . $alinha . '"><ul>' . $this->paginarM1($this->pgatual, $this->pgtotal) . '</ul></div>';
    }

    function paginacaoM2($style = true) {
        /*
         * Style 1
         * Style 2
         */
        return '<div class="container"><ul class="pager">' . $this->paginarM2($this->pgatual, $this->pgtotal, $style) . '</ul></div>';
    }

    function paginacaoM3() {
        return '<div class="btn-toolbar"><div class="btn-group">' . $this->paginarM3($this->pgatual, $this->pgtotal) . '</div></div>';
    }

    // ------------------------------------------------------------------------------
    // * paginar: Monta paginação padrao
    // ------------------------------------------------------------------------------
    function paginarM1($atual, $qt) {
        # Inicio - Fim
        $inicio = 1;
        $fim = $qt;
        if ($qt > 10) {
            $inicio = $atual - 4;
            $fim = $atual + 5;
            if ($inicio < 1) {
                $fim = $fim - $inicio + 1;
                $inicio = 1;
            }
            if ($fim > $qt) {
                $fim = $qt;
                $inicio = $fim - 9;
            }
        }

        # URL
        $request = 'http://' . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
        if (strpos($request, "?")) {
            if (strpos($request, "/?pg=" . $atual)) {
                $url = str_replace("/?pg=" . $atual, "", $request);
                $pgurl = $url . '/?';
            } elseif (strpos($request, "&pg=" . $atual)) {
                $url = str_replace("&pg=" . $atual, "", $request);
                $pgurl = $url . '&';
            } else {
                $pgurl = $request . '&';
            }
        } else {
            $pgurl = $request . '/?';
        }



        # Botao -Anterior-"$tipo"
        if ($atual == 1) {
            $saida .= '<li class="disabled"><a ';
        } else {
            $saida .= '<li><a ';
        }
        if (!strpos($request, "pg")) {
            if ($atual > 1)
                $saida .= ' href="' . $pgurl . 'pg=' . ($atual - 1) . '" ';
        }else {
            if ($atual > 1)
                $saida .= ' href="' . str_replace(array("?pg=$atual", "&pg=$atual"), array("?pg=" . ($atual - 1), "&pg=" . ($atual - 1)), $request) . '" ';
        }
        $saida .= '">«</a></li>';

        # Primeira pagina
        $saida .= '<li class=""><a href="' . $pgurl . 'pg=1">1</a></li>';
        $saida .= '<li class=""><a>..</a></li>';
        
        # Paginacao
        for ($i = $inicio; $i <= $fim; $i++) {


            if ($i == $atual)
                $saida .= '<li class="active">';
            else
                $saida .= '<li class="">';

            if (!strpos($request, "pg")) {
                $saida .= '<a href="' . $pgurl . 'pg=' . $i . '"';
            } else {
                $saida .= '<a href="' . str_replace(array("?pg=$atual", "&pg=$atual"), array("?pg=" . $i, "&pg=" . $i), $request) . '"';
            }

            $saida .= '>' . $i . '</a></li>';
        }
        
        # Ultima pagina
        $saida .= '<li class=""><a>..</a></li>';
        $saida .= '<li class=""><a href="' . $pgurl . 'pg=' . $qt . '">'.$qt.'</a></li>';

        # Botao -Proxima-
        if ($atual == $qt) {
            $saida .= '<li class="disabled"><a ';
        } else {
            $saida .= '<li><a ';
        }
        if (!strpos($request, "pg")) {
            if ($atual < $qt)
                $saida .= ' href="' . $pgurl . 'pg=' . ($atual + 1) . '" ';
        }else {
            if ($atual < $qt)
                $saida .= 'href="' . str_replace(array("?pg=$atual", "&pg=$atual"), array("?pg=" . ($atual + 1), "&pg=" . ($atual + 1)), $request) . '" ';
        }


        $saida .= '">»</a></li>';



        return $saida;
    }

    // ------------------------------------------------------------------------------
    // * paginar: Monta paginação padrao
    // ------------------------------------------------------------------------------
    function paginarM2($atual, $qt, $style = 1) {
        # Inicio - Fim
        $inicio = 1;
        $fim = $qt;
        if ($qt > 10) {
            $inicio = $atual - 4;
            $fim = $atual + 5;
            if ($inicio < 1) {
                $fim = $fim - $inicio + 1;
                $inicio = 1;
            }
            if ($fim > $qt) {
                $fim = $qt;
                $inicio = $fim - 9;
            }
        }

        # URL
        $request = 'http://' . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
        if (strpos($request, "?")) {
            if (strpos($request, "/?pg=" . $atual)) {
                $url = str_replace("/?pg=" . $atual, "", $request);
                $pgurl = $url . '/?';
            } elseif (strpos($request, "&pg=" . $atual)) {
                $url = str_replace("&pg=" . $atual, "", $request);
                $pgurl = $url . '&';
            } else {
                $pgurl = $request . '&';
            }
        } else {
            $pgurl = $request . '/?';
        }

        if ($style == 1) {
            $btStylePrevious = "";
            $btStyleNext = "";
        } else {
            $btStylePrevious = "previous";
            $btStyleNext = "next";
        }

        # Botao -Anterior-"$tipo"
        if ($atual == 1) {
            $saida .= '<li class="disabled ' . $btStylePrevious . '"><a ';
        } else {
            $saida .= '<li class="' . $btStylePrevious . '"><a ';
        }
        if (!strpos($request, "pg")) {
            if ($atual > 1)
                $saida .= ' href="' . $pgurl . 'pg=' . ($atual - 1) . '" ';
        }else {
            if ($atual > 1)
                $saida .= ' href="' . str_replace(array("?pg=$atual", "&pg=$atual"), array("?pg=" . ($atual - 1), "&pg=" . ($atual - 1)), $request) . '" ';
        }
        $saida .= '">&larr; Anterior</a></li>';


        # Botao -Proxima-
        if ($atual == $qt) {
            $saida .= '<li class="disabled ' . $btStyleNext . '"><a ';
        } else {
            $saida .= '<li class="' . $btStyleNext . '"><a ';
        }
        if (!strpos($request, "pg")) {
            if ($atual < $qt)
                $saida .= ' href="' . $pgurl . 'pg=' . ($atual + 1) . '" ';
        }else {
            if ($atual < $qt)
                $saida .= 'href="' . str_replace(array("?pg=$atual", "&pg=$atual"), array("?pg=" . ($atual + 1), "&pg=" . ($atual + 1)), $request) . '" ';
        }


        $saida .= '">Pr&oacute;ximo &rarr;</a></li>';



        return $saida;
    }

    // ------------------------------------------------------------------------------
    // * paginar: Monta paginação padrao
    // ------------------------------------------------------------------------------
    function paginarM3($atual, $qt) {
        # Inicio - Fim
        $inicio = 1;
        $fim = $qt;
        if ($qt > 10) {
            $inicio = $atual - 4;
            $fim = $atual + 5;
            if ($inicio < 1) {
                $fim = $fim - $inicio + 1;
                $inicio = 1;
            }
            if ($fim > $qt) {
                $fim = $qt;
                $inicio = $fim - 9;
            }
        }

        # URL
        $request = 'http://' . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
        if (strpos($request, "?")) {
            if (strpos($request, "/?pg=" . $atual)) {
                $url = str_replace("/?pg=" . $atual, "", $request);
                $pgurl = $url . '/?';
            } elseif (strpos($request, "&pg=" . $atual)) {
                $url = str_replace("&pg=" . $atual, "", $request);
                $pgurl = $url . '&';
            } else {
                $pgurl = $request . '&';
            }
        } else {
            $pgurl = $request . '/?';
        }

        # Botao -Anterior-"$tipo" $btnAtu
        if ($atual == 1) {
            $this->btnAnt .= '<button class="btn" disabled="disabled"';
        } else {
            $this->btnAnt .= '<button class="btn" ';
        }
        if (!strpos($request, "pg")) {
            if ($atual > 1)
                $this->btnAnt .= 'onclick="window.location=\'' . $pgurl . 'pg=' . ($atual - 1) . '\'"';
        }else {
            if ($atual > 1)
                $this->btnAnt .= 'onclick="window.location=\'' . str_replace(array("?pg=$atual", "&pg=$atual"), array("?pg=" . ($atual - 1), "&pg=" . ($atual - 1)), $request) . '\'"';
        }
        $this->btnAnt .= '>&larr; Anterior</button>';
        
        # Mapeamento
        $this->btnAtu = '<button class="btn" disabled="disabled">'.$atual.' / '.$qt.'</button>';
        
        # Botao -Proxima-
        if ($atual == $qt) {
            $this->btnPro .= '<button class="btn"  disabled="disabled"';
        } else {
            $this->btnPro .= '<button class="btn" ';
        }
        if (!strpos($request, "pg")) {
            if ($atual < $qt)
                $this->btnPro .= 'onclick="window.location=\'' . $pgurl . 'pg=' . ($atual + 1) . '\'"';
        }else {
            if ($atual < $qt)
                $this->btnPro .= 'onclick="window.location=\'' . str_replace(array("?pg=$atual", "&pg=$atual"), array("?pg=" . ($atual + 1), "&pg=" . ($atual + 1)), $request) . '\'"';
        }
        $this->btnPro .= '>Pr&oacute;ximo &rarr;</button>';

        #'<button class="btn">1</button>';

    }

}

