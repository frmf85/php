
<?php
    date_default_timezone_set('Europe/Lisbon');
    $data_atual = date("Y/m/d");
    
    $auction = $auction_tmp->data;
    
    if($auction->publicado){
        $auction_title = $auction->title;
        $auction_description = $auction->description;
        $auction_hour = $auction->hour;
        $auction_date = $auction->date;
        $auction_distrito = $auction->distrito;
        $auction_concelho = $auction->concelho;
        $auction_freguesia = $auction->freguesia;
        $data_fim_ymd = millisecondsToDate($auction_date, "y/m/d");
        $data_fim_ymd = $data_fim_ymd." ".$auction_hour; //uma vez que no leilão, a hora é colocada em separado da data, tenho de juntar os dois para fazer o calculo do tempo total

        //ir buscar ficheiros
        $download_url_catalogo = "";
        $download_url_condicoes = "";
        $download_url_ficha_insc = "";
        $arrayOutrosDocs = array();
        $documentos_tmp = listAuctionDocumento(array(),array(), $id);
        $documentos = $documentos_tmp->list;
        
        foreach($documentos as $documento){ 
            array_push($arrayOutrosDocs, $documento);
        }
        //print_r($documento);
?>

        <!-- Page Banner Start-->
        <section class="page-banner padding" style="padding:80px 0px 20px 0px; background-attachment:unset;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="text-uppercase"><?= $trans_leilao_detail_1; ?></h1>
                        <p></p>
                        <ol class="breadcrumb text-center">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="index.php?page=bem_list"><?= $trans_geral_listagem; ?></a></li>
                            <li class="active"><?= $trans_geral_leilao; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- Page Banner End -->

        <!-- Property Detail Start -->
        <section id="property" class="padding_top padding_bottom_half" style="padding:60px 0px 100px 0px; background-attachment:unset;">
            <div class="container">
                <div class="row">


                    <!-- Formulário de Pedido de Informação -->
                    <aside class="col-md-4 col-xs-12">

                        <div class=" clearfix">
                            <!-- ========== Contador ========== -->
                            <!--
                            <div style="text-align: center; margin-top:-17px;">
                                <div id="contador_<?php echo $id; ?>" style="vertical-align:middle; height: 72px; display:inline-block;"></div>
                            </div>
                            -->

                            <!-- ============ INFO DO LOTE ============ -->
                            <div class="boxLeilao" style="margin-top:0px; margin-bottom: 20px;">
                                <div style="padding:15px 10px 15px 11px; background:#dedede;"><h4 class="uppercase" style="color:#5f5f5f;"><?php echo $trans_leilaoDetail_infoLeilao; ?></h4></div>
                                <div class="" style="padding:10px; background:#f8f8f8;">
                                    
                                    <div class="row_l">
                                        <div class="item"><i class="fa fa-gavel" style="font-size: 23px;"></i></div>
                                        <div class="value"><?php echo $auction_title; ?></div>
                                    </div>
                                    <div class="row_l">
                                        <div class="item"><i class="fa fa-calendar" style="font-size: 23px;"></i></div>
                                        <div class="value"><?php echo millisecondsToDate($auction_date,"d/m/y"); ?></div>
                                    </div>
                                    <div class="row_l">
                                        <div class="item"><i class="fa fa-clock-o" style="font-size: 23px;"></i></div>
                                        <div class="value"><?php echo $auction_hour; ?></div>
                                    </div>
                                    <div class="row_l">
                                        <div class="item"><i class="fa fa-map-marker" style="font-size: 23px;"></i></div>
                                        <div class="value"><?php echo $auction_distrito.", ".$auction_concelho.", ".$auction_freguesia; ?></div>
                                    </div>
                                    <br/>
                                    <?php if(!empty($download_url_catalogo)) { ?>
                                        <a href="downloadAuctionDoc.php?url=<?php echo $download_url_catalogo; ?>">
                                            <div class="doc_download"> 
                                                <i class="fa fa-file-image-o" style="font-size: 23px; margin-right:10px; vertical-align:middle;"></i>
                                                <span><?php echo $trans_geral_catalogo; ?></span>
                                            </div>
                                        </a>
                                    <?php } ?>
                                    <?php if(!empty($download_url_condicoes)) { ?>
                                        <a href="downloadAuctionDoc.php?url=<?php echo $download_url_condicoes; ?>">
                                            <div class="doc_download" > 
                                                <i class="fa fa-file-text" style="font-size: 23px; margin-right:10px; vertical-align:middle;"></i>
                                                <span style="vertical-align:middle;"><?php echo $trans_geral_condicoesVenda; ?></span>
                                            </div>
                                        </a>
                                    <?php } ?>

                                    <?php if(!empty($download_url_ficha_insc)) { ?>
                                        <a href="downloadAuctionDoc.php?url=<?php echo $download_url_ficha_insc; ?>">
                                            <div class="doc_download" >
                                                <i class="fa fa-file-pdf-o" style="font-size: 23px; margin-right:10px; vertical-align:middle;"></i>
                                                <span style="vertical-align:middle;"><?php echo $trans_geral_fichaInscricao; ?></span>
                                            </div>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="boxLeilao" style="margin-bottom: 20px;">
                                <div style="padding:15px 10px 15px 11px; background:#dedede;"><h4 class="uppercase" style="color:#5f5f5f;"><?= $trans_leilaoDetail_infoProcesso; ?></h4></div>
                                <div class="" style="padding:20px 10px 10px 10px; background:#f8f8f8">

                                    <?php
                                    $processos_tmp = listAuctionProcesso(array(),array(), $id);
                                    $processos = $processos_tmp->list;
                                    $i=0;
                                    foreach($processos as $processo){ 
                                        $i++;
                                        $num_processo = $processo->processo;
                                        $processo_responsavel_nome = $processo->processo_responsavel_nome;
                                        $processo_responsavel_email = $processo->processo_responsavel_email;
                                        $processo_responsavel_contactos = $processo->processo_responsavel_contactos;

                                        if($i>1){
                                            echo "<div style='background:$color_1; height:2px; width:100%; margin: 25px 0px;'></div>";
                                        }
                                    ?>

                                        <?php if(!empty($processo_responsavel_nome) || !empty($processo_responsavel_email) || !empty($processo_responsavel_contactos[0]) ){ ?>
                                    
                                            <?php if(!empty($num_processo)){ ?>
                                                <div class="row_l">
                                                    <div class="item"><?= $trans_leilaoDetail_Processo; ?></div>
                                                    <div class="value"><?php echo $num_processo; ?></div>
                                                </div>    
                                            <?php } ?>
                                            <div style="margin-top:15px; font-family: Dosis; font-size: 13px; text-transform: uppercase;"><?= $trans_leilaoDetail_respProcesso; ?></div>
                                            <?php if(!empty($processo_responsavel_nome)){ ?>
                                                <div class="row_l">
                                                    <div class="item"><i class="fa fa-user" style="margin-right:9px;"></i></div>
                                                    <div class="value"><?php echo $processo_responsavel_nome; ?></div>
                                                </div>
                                            <?php } ?>
                                            <?php if(!empty($processo_responsavel_email)){ ?>
                                                <div class="row_l">
                                                    <div class="item"><i class="fa fa-envelope" style="margin-right:5px;"></i></div>
                                                    <div class="value"><?php echo $processo_responsavel_email; ?></div>
                                                </div>
                                            <?php } ?>
                                            <?php if(!empty($processo_responsavel_contactos[0])){ ?>
                                                <div class="row_l">
                                                    <div class="item"><i class="fa fa-phone" style="margin-right:8px;"></i></div>
                                                    <div class="value"><?php echo $processo_responsavel_contactos[0]; ?></div>
                                                </div>
                                            <?php } ?>
                                    
                                    <?php 
                                        } 
                                    } 
                                    ?>

                                </div>
                            </div>

                        <?php include "areaDocuments.php"; ?>
                        <div id="containerInformationRequest">
                            <?php 
                                //include "form_pedido_informacao.php"; 

                                $info_page = isset($_REQUEST["page"])? $_REQUEST["page"]:"";
                                $info_auction_id = $_REQUEST["page"]=="leilao_detail"? $_REQUEST["id"]:"";
                                $info_lote_id = $_REQUEST["page"]=="lote_detail"? $_REQUEST["id"]:"";
                                $info_bem_id = $_REQUEST["page"]=="bem_detail"? $_REQUEST["id"]:"";
                                $info_event_id = $_REQUEST["page"]=="bem_detail"? $_REQUEST["event_id"]:"";
                                $info_processo = !empty($num_processo)? $num_processo:"";
                                $info_leilao = !empty($auction_title)? $auction_title:"";
                                $info_lote = !empty($lote_number)? $lote_number:"";

                                echo "<script>buildFromInformationRequest('$info_page','$info_auction_id','$info_lote_id','$info_bem_id','$info_event_id','$info_processo','$info_leilao','$info_lote');</script>";
                            ?>
                        </div>
                            
                        

                        <?php include "./blocoPartilhaLeilaoRS.php"; ?>
                        
                    </aside>

                    <!-- ============================ GALERIA DE LOTES ============================ -->
                    <div class="col-xs-12 col-sm-12 col-md-8 listing1 property-details" style="display: inline-block;">
                        <div class="col-sm-12">
                            <h2 class="text-uppercase" style="border-bottom: 3px solid #dedede; padding-bottom: 7px; padding-top: 7px; border-top: 3px solid #dedede;">Lotes</h2>
                        </div>
                        <div class="row">
                            <div class="col-sm-12" style="margin-top:30px;">

                                <section id="news-section-1" class="property-details">
                                    <div class="container property-details">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">

                                                    <?php
                                                        //$greaterThan, $lowerThan
                                                        $filtros = array("publicado", "destacado");
                                                        $values = array("true", "true");

                                                        $lista = getLotesByIdAuction($filtros, $values, $_REQUEST["id"]);
                                                        //print_r($lista);

                                                        usort($lista->list, 'loteAsc');

                                                        $i = 0;
                                                        foreach($lista->list as $row) {
                                                            $i++;
                                                            $id = $row->id;
                                                            $lote_id = $row->lote_id;

                                                            $lote_number = $row->lote_number;
                                                            $descricao = $row->lote_descricao;
                                                            $lote_processo = $row->lote_processo;
                                                            $imagem_1 = $row->foto;

                                                            if($imagem_1 == null || $imagem_1 == ""){
                                                                $imagem_1 = "imagens/img_default.jpg";
                                                            }else{
                                                                $imagem_1 = $image_url_base.$imagem_1;
                                                            }
                                                    ?>



                                                            <div class="news-1-box clearfix" style="padding-bottom:20px;">
                                                                <div class="col-md-5 col-sm-5 col-xs-12">
                                                                    <div class="image-2">
                                                                        <a href="index.php?page=lote_detail&auction_id=<?php echo $_REQUEST["id"]; ?>&id=<?php echo $lote_id; ?>">
                                                                            <img src="<?php echo $imagem_1; ?>" alt="image" class="img-responsive" style="padding-bottom:20px;" />
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-7 col-sm-7 col-xs-12 padding-left-25">
                                                                    <h3><a href="index.php?page=lote_detail&auction_id=<?php echo $_REQUEST["id"]; ?>&id=<?php echo $lote_id; ?>">Lote <?php echo $lote_number; ?></a></h3>
                                                                    <div class="news-details padding-b-10 margin-t-5">
                                                                        <span><i class="fa fa-tasks"></i> <?php echo $lote_processo; ?></span>
                                                                    </div>
                                                                    <p class="p-font-15"><?php echo $descricao; ?></p>
                                                                </div>
                                                            </div>



                                                    <?php } ?>
                                                </div>
                                                <!--
                                                <div class="row margin_bottom">
                                                    <div class="col-md-12">
                                                        <ul class="pager">
                                                            <li><a href="#.">1</a></li>
                                                            <li class="active"><a href="#.">2</a></li>
                                                            <li><a href="#.">3</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                -->
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php 
    }else{ 
        include 'errorPage.php';
    }
?>


