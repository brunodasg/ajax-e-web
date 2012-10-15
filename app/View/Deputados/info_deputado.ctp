<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#depNoticias").click(function(){
			/* Ação ao iniciar ao Ajax */
		  	jQuery("#ajaxLoad").ajaxStart(function() {
				jQuery(this).show();
		  	});
		  		  
		  	/* Ação ao finalizar ao Ajax */
		  	jQuery("#ajaxLoad").ajaxComplete(function() {
			  	jQuery(this).hide();				
		  	});
		  
			jQuery.ajax({
				type: 'GET',
  				url: 'deputados/noticias/<?php echo $deputado['id'] ?>',
  				success: function(data) {
    				jQuery('#result').empty().html(data);    			
  				}
			});						
		});
		
		
		jQuery("#depTweets").click(function(){
			/* Ação ao iniciar ao Ajax */
		  	jQuery("#ajaxLoad").ajaxStart(function() {
				jQuery(this).show();
		  	});
		  		  
		  	/* Ação ao finalizar ao Ajax */
		  	jQuery("#ajaxLoad").ajaxComplete(function() {
			  	jQuery(this).hide();				
		  	});
		  
			jQuery.ajax({
				type: 'GET',
  				url: 'deputados/tweets/<?php echo $deputado['id'] ?>',
  				success: function(data) {
    				jQuery('#result').empty().html(data);    			
  				}
			});						
		});
		
		
		jQuery("#depFacebook").click(function(){
			/* Ação ao iniciar ao Ajax */
		  	jQuery("#ajaxLoad").ajaxStart(function() {
				jQuery(this).show();
		  	});
		  		  
		  	/* Ação ao finalizar ao Ajax */
		  	jQuery("#ajaxLoad").ajaxComplete(function() {
			  	jQuery(this).hide();				
		  	});
		  
			jQuery.ajax({
				type: 'GET',
  				url: 'deputados/facebook_posts/<?php echo $deputado['id'] ?>',
  				success: function(data) {
    				jQuery('#result').empty().html(data);    			
  				}
			});						
		});

		
		jQuery("#depFaltas").click(function(){
			/* Ação ao iniciar ao Ajax */
		  	jQuery("#ajaxLoad").ajaxStart(function() {
				jQuery(this).show();
		  	});
		  		  
		  	/* Ação ao finalizar ao Ajax */
		  	jQuery("#ajaxLoad").ajaxComplete(function() {
			  	jQuery(this).hide();				
		  	});
		  
			jQuery.ajax({
				type: 'GET',
  				url: 'deputados/faltas/<?php echo $deputado['id'] ?>',
  				success: function(data) {
    				jQuery('#result').empty().html(data);
  				}
			});						
		});
	});
</script>
<table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="108" align="left" valign="top"><?php echo $this->Html->image($deputado['foto']); ?></td>
    <td colspan="4" valign="top">
    	<b>Nome: </b> <?php echo $this->Html->link($deputado['nome'], $deputado['site_camara'], array('title' => 'Página no Portal da Camara')) ?>
        <br />
        <b>Partido/UF: </b> <?php echo $deputado['partido'].' / '.$deputado['uf'] ?>        
        <br />
        <b>Gabinete: </b> <?php echo $deputado['gabinete'] ?>
        <b>Anexo: </b> <?php echo $deputado['anexo'] ?>
        <br />
        <b>Telefone: </b> <?php echo $deputado['fone'] ?>
        <br />
        <b>Fax: </b> <?php echo $deputado['fax'] ?>
        <br />
		<b>e-mail: </b> <?php echo $deputado['email'] ?>
        <br />
        <?php 
			echo $this->Html->link('Página na Camara', $deputado['site_camara'], array('title' => 'Página no Portal da Camara', 'target' => '_blank'));
			if(!empty($deputado['site_pessoal'])){
				echo ' / ';
				echo $this->Html->link('Site Pessoal', $deputado['site_pessoal'], array('target' => '_blank'));				
			}
		?>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top"><?php echo $this->Html->link('Noticías', 'javascript:void(0)', array('id' => 'depNoticias')) ?></td>
    <td width="115" valign="top"><?php echo $this->Html->link('Tweets', 'javascript:void(0)', array('id' => 'depTweets')) ?></td>
    <td width="170" valign="top"><?php echo $this->Html->link('Posts no Facebook', 'javascript:void(0)', array('id' => 'depFacebook')) ?></td>
    <td width="123" valign="top"><?php echo $this->Html->link('Presenças', 'javascript:void(0)', array('id' => 'depFaltas')) ?></td>
    <td width="124" valign="top">&nbsp;</td>
  </tr>
  </table>
<div id="result"></div>