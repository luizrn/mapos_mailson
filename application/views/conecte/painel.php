<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/owl.theme.default.min.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/js/instafeed.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/owl.carousel.min.js"></script>

<div class="quick-actions_homepage">
    <ul class="cardBox">
        <li class="card"> <a href="<?php echo base_url() ?>index.php/mine/os"><i class='bx bx-spreadsheet iconBx'></i>
          <div style="font-size: 1.2em" class="numbers">Ordens de Serviço</div></a>
        </li>
        <li class="card"> <a href="<?php echo base_url() ?>index.php/mine/compras"><i class='bx bx-cart-alt iconBx'></i>
          <div style="font-size: 1.2em" class="numbers">Compras</div></a>
        </li>
        <li class="card"> <a href="<?php echo base_url() ?>index.php/mine/conta"><i class='bx bx-user-circle iconBx'></i>
          <div style="font-size: 1.2em" class="numbers">Minha Conta</div></a>
        </li>
        <!-- Adicione seu link do instagram entre aspas no href abaixo -->
        <li class="card"> <a href="<?php echo $insta_link; ?>" target="_blank"><i class='bx bxl-instagram iconBx'></i>
          <div style="font-size: 1.2em" class="numbers">Siga Nosso Instagram</div></a>
        </li>
        <!-- Adicione seu link do whatsApp entre aspas no href abaixo -->
        <li class="card"> <a href="<?php echo $link_whatsapp; ?>" target="_blank"><i class='bx bxl-whatsapp iconBx'></i></i>
          <div style="font-size: 1.2em" class="numbers">Fale Conosco</div></a>
        </li>
    </ul>
</div>
<?php if ($exibir_feed_instagram == '1') { //Se nao for 1 Desativa todo o codigo abaixo  ?>
<div>
    <h5 style="margin-bottom:12px; color:var(--violeta1)" class="cardHeader">Últimos Trabalhos</h5>
   
</div>
<div id="instafeed" class="owl-carousel owl-theme owl-loaded owl-drag"></div>

<script type="text/javascript">
    var feed = new Instafeed({
        accessToken: '<?php echo $insta_token ?>', 
        limit: 8,
        template:'<div class="item"><a href="{{link}}" target="_blank"><img title="{{caption}}" src="{{image}}" /></a></div>',
        after: function(){
            $('.owl-carousel').owlCarousel({
                loop:true,
                margin:10,
                nav:false,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:5,
                        loop:false
                    }
                }
            });
        }
    });
    feed.run();
</script>
<?php } ?>
<div class="span12" style="margin-left: 0">
    <div class="widget-box">
        <div class="widget-title" style="margin: -20px 0 0">
          <span class="icon"><i class="fas fa-signal"></i></span>
            <h5>Últimas Ordens de Serviço</h5>
        </div>
        <div class="widget-content">
            <table id="tabela" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data Inicial</th>
                        <th>Data Final</th>
                        <th>Garantia</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($os != null) {
                        foreach ($os as $o) {
                            $vencGarantia = '';

                            if ($o->garantia && is_numeric($o->garantia)) {
                                $vencGarantia = dateInterval($o->dataFinal, $o->garantia);
                            }
                            $corGarantia = '';
                            if (!empty($vencGarantia)) {
                                $dataGarantia = explode('/', $vencGarantia);
                                $dataGarantiaFormatada = $dataGarantia[2] . '-' . $dataGarantia[1] . '-' . $dataGarantia[0];
                                if (strtotime($dataGarantiaFormatada) >= strtotime(date('d-m-Y'))) {
                                    $corGarantia = '#4d9c79';
                                } else {
                                    $corGarantia = '#f24c6f';
                                }
                            } elseif ($o->garantia == "0") {
                                $vencGarantia = 'Sem Garantia';
                                $corGarantia = '';
                            } else {
                                $vencGarantia = '';
                                $corGarantia = '';
                            }
                            echo '<tr>';
                            echo '<td>' . $o->idOs . '</td>';
                            echo '<td>' . date('d/m/Y', strtotime($o->dataInicial)) . '</td>';
                            echo '<td>' . date('d/m/Y', strtotime($o->dataFinal)) . '</td>';
                            echo '<td><span class="badge" style="background-color: ' . $corGarantia . '; border-color: ' . $corGarantia . '">' . $vencGarantia . '</span> </td>';
                            echo '<td>' . $o->status . '</td>';
                            echo '<td> <a href="' . base_url() . 'index.php/mine/visualizarOs/' . $o->idOs . '" class="btn-nwe tip-top" title="Visualizar"><i class="bx bx-show"></i></a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="3">Nenhum ordem de serviço encontrada.</td></tr>';
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="widget-box">
        <div class="widget-title" style="margin: -20px 0 0">
          <span class="icon"><i class="fas fa-signal"></i></span>
            <h5>Últimas Compras</h5>
        </div>
        <div class="widget-content">
            <table id="tabela" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data de Venda</th>
                        <th>Responsável</th>
                        <th>Faturado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($compras != null) {
                        foreach ($compras as $p) {
                            if ($p->faturado == 1) {
                                $faturado = 'Sim';
                            } else {
                                $faturado = 'Não';
                            }
                            echo '<tr>';
                            echo '<td>' . $p->idVendas . '</td>';
                            echo '<td>' . date('d/m/Y', strtotime($p->dataVenda)) . '</td>';
                            echo '<td>' . $p->nome . '</td>';
                            echo '<td>' . $faturado . '</td>';
                            echo '<td> <a href="' . base_url() . 'index.php/mine/visualizarCompra/' . $p->idVendas . '" class="btn-nwe tip-top" title="Visualizar"><i class="bx bx-show"></i></a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">Nenhum venda encontrada.</td></tr>';
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
