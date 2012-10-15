<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8" />
	<title>Deputados.com - <?php echo $title_for_layout; ?></title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<?php
		echo $this->Html->meta('icon');

		# jQuery + jQuery UI
		echo $this->Html->script('jquery-1.7.1.min');
		echo $this->Html->script('jquery-ui-1.8.18.custom.min');
		echo $this->Html->css('cupertino/jquery-ui-1.8.23.custom');
		
		# CSS
		echo $this->Html->css('default');
		echo $this->Html->css('message');
		
		# JS
		echo $this->Html->script('operacional');
		echo $this->Html->script('jquery.gchart.min');
		

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<header id="header">
    	<section id="topo">
            <nav id="topo_menu"><ul>
                <?php echo $this->Html->link($this->Html->tag('li', 'Página Inicial'), array('controller' => 'pages', 'action' => 'display'), array('escape' => false)) ?>
            </ul></nav>
            
            <aside id="autenticacao">&nbsp;</aside>
        </section>                
	</header>

    <article id="body">
        <header id="title_page"><?php echo $title_for_layout ?></header>
        <section id="content">
        	<div id="ajaxLoad"><?php echo $this->Html->image("loading.gif") ?></div>
            <div align="center">
                <?php 
                    echo $this->Session->flash();
                    echo $this->fetch('content'); 
                ?>
            </div>
        </section>
    </article>
        
	<footer id="footer">
    	<section id="footer-content">Componentes Distribuídos Web</section>
    </footer>
</body>
</html>