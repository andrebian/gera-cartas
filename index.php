<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Gera cartas</title>
        
        <style type="text/css">
            html{ font-family:Arial, Helvetica, sans-serif; font-size:12px;}
            #cart{ border:solid 1px #000;}
            #titulo{ font-size:18px; font-weight:bold; width:100%; text-align:center; background-color:#DFDFDF;}
            #destaque{ color:red; font-weight:bold;}
        </style>
    </head>
    <body>
        <center> 
            Gera cartas - Desenvolvido por <a href="https://github.com/andrebian">
            Andre Cardoso</a>, Daniel Barbosa Filho e Thiago Cardoso. <br />
            A geração de cartas era a fase inicial do algoritmo de um jogo que 
            estava sendo desenvolvido como trabalho de conslusão de semestre na 
            faculdade em que estudávamos até cada um dos membros trancar a 
            matrícula.<br />
            Tal jogo finalizaríamos em Junho de 2013 caso permacessêcemos na 
            faculdade. Como não permanecemos os jogo não foi finalizado mas um 
            pouco de colaboração para demais pessoas com o mesmo problema que 
            enfrentamos (gerar X números de cartas sem repetir os valores de 
            cada atributo) possam usufruir.
            <hr>
        <form method="post" action="">
            <h3>Informe as propriedades das cartas a serem geradas</h3>
            Valor mínimo: 
            <input type="number" name="minimo" id="minimo" class="input number" value="10"/>&nbsp;-&nbsp;
            Valor máximo: 
            <input type="number" name="maximo" id="maximo" class="input number" value="100" />&nbsp;-&nbsp;
            Quantidade de cartas: 
            <input type="number" name="numero" id="numero" class="input number" value="48" />&nbsp;-&nbsp;
            <input type="submit" name="gera" id="gera" value="GERAR CARTAS"/>
        </form>
        
            <table border="0" cellspacing="20">
                <?php
                
                    $quantidadeCartas = 0;
                    $arrayContent = array();
                    $tableData = 1;
                    $conteudoTabela = '';

                    if(isset($_POST["gera"])) {
                        
                        $minimo = (int)$_POST["minimo"];
                        $maximo = (int)$_POST["maximo"];
                        $numeroCartas = (int)$_POST["numero"];

                        // caso o número de cartas a serem geradas for menor que
                        // a subtração do máximo pelo mínimo informa que não é possível
                        // gerar as cartas pois os valores estão incorretos    
                        if( $maximo - $minimo < $numeroCartas ){ 
                            die('Não é possível gerar as cartas. Valores inválidos.');
                        }

                        // para cada carta a ser gerada
                        for($cont = 1, $tableData = 1; $cont <= $numeroCartas; $cont++) {
                            
                            // solicita um valor para cada atributo com seu 
                            // respectivo iterador
                            $arrayContent = geraCarta($arrayContent, $cont, 'forca', $minimo, $maximo);
                            $arrayContent = geraCarta($arrayContent, $cont, 'agilidade', $minimo, $maximo);
                            $arrayContent = geraCarta($arrayContent, $cont, 'vitalidade', $minimo, $maximo);

                            // se for a primeira célula da tabela então a cria
                            if ( $tableData == 1 ) {
                                  $conteudoTabela .= '<tr>';
                            }
                            
                            // simplificando para posterior utilização
                            $forca = $arrayContent['forca'][$cont];
                            $agilidade = $arrayContent['agilidade'][$cont];
                            $vitalidade = $arrayContent['vitalidade'][$cont];

                            // adicionando conteúdo do iterador para posterior impressão
                            $conteudoTabela .= '
                                        <td>
                                            <div id="cart">
                                                <table cellpadding="5" cellspacing="10">
                                                    <tr>
                                                        <td colspan="3">
                                                            <div id="titulo">CARTA ' . $cont . '</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Força</td>
                                                        <td>Agilidade</td>
                                                        <td>Vitalidade</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">
                                                            <b> ' . $forca . ' </b>
                                                        </td>
                                                        <td align="center">
                                                            <b> ' . $agilidade . ' </b>
                                                        </td>
                                                        <td align="center">
                                                            <b> ' . $vitalidade . ' </b>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div> 
                                        </td>   
                            ';
                            
                            // incrementando o contador de quantidade de cartas geradas
                            $quantidadeCartas++;

                            // se for a últim célula
                            if ( $tableData == 5 ) {
                                
                                  // finaliza a linha  
                                  $conteudoTabela .= '</tr>';
                                  
                                  // reseta o contador de células
                                  $tableData = 0;
                            }
                            
                            // incrementa o contador da célula, independente 
                            // da posição que esteja (TEM que ser dessa forma)
                            $tableData++;
                        }

                    }

                    // sendo a quantidade de cartas maior que 0 (zero)
                    if ( $quantidadeCartas > 0 ) {
                        echo '<br />' . $quantidadeCartas.' carta(s) gerada(s).';
                        echo $conteudoTabela;
                    }

                    
                    ############################################################

                    /**
                     * Recebe o array inicial (pode ser vazio ou com dados inclusos)
                     * o iterador, a definição do atributo, os valores mínimo e
                     * máximo.
                     *  
                     * 
                     * @param array $arrayContent
                     * @param int $i
                     * @param string $atributo
                     * @param int $min
                     * @param int $max
                     * @return array
                     */
                    function geraCarta($arrayContent, $i, $atributo, $min, $max) {
                        
                        // gera um valor aleatório entre o minimo e máximo
                        $valorCarta = rand($min,$max);

                        // verifica se o atributo informado está presente no array
                        // caso não esteja o adiciona 
                        if ( empty($arrayContent[$atributo]) ) {
                          $arrayContent[$atributo] = array();
                        }

                        // verifica cada item do atributo fornecido e
                        // enquanto o valor do atributo se repetir gera um novo 
                        // valor aleatório entre o mínimo e máximo
                        while( in_array($valorCarta, $arrayContent[$atributo]) ) {
                            $valorCarta = rand($min,$max);
                        }
                        
                        // ao final adiciona o valor da carta no iterador do atributo
                        $arrayContent[$atributo][$i] = $valorCarta;


                        return $arrayContent;
                    }
                    
                    ############################################################
                    ?>
    </body>
</html>
