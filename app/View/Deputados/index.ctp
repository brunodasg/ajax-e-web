<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#DeputadoId").change(function(){
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
  				url: '<?php echo $this->Html->url(array("controller" => "deputados",
														"action" => "infoDeputado",));?>/' + jQuery("#DeputadoId").val(),
  				success: function(dados) {
    				jQuery('#infoDeputado').empty().html(dados);    			
  				}
			});
		});
	});
</script>
<div class="home form">
<?php echo $this->Form->create('Deputado', array('action' => 'adicionar', 'class' => 'formValidate')) ?>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="tblForm">
  <tr class="titleForm">
    <td colspan="2">Dados</td>
  </tr>
  <tr>
    <td colspan="2">Deputados*</td>
  </tr>
  <tr>
    <td colspan="2"><?php echo $this->Form->select('id', $deputados); ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="2"><div id="infoDeputado"></div></td>
  </tr>
</table>
<div id="#face"></div>

<?php echo $this->Form->end() ?>
</div>