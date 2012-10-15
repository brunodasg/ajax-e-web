<table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
<tbody>
<?php 
	if(!empty($tweets['results'])){
		foreach($tweets['results'] as $tweet){ 
?>
  <tr>
    <td align="justify"><?php echo $tweet['text'] ?></td>
  </tr>
  <tr>
    <td><hr /></td>
  </tr>
<?php 	}
	}else{ ?>
    <tr>
    <td align="center">Nenhum tweet encontrado para o Deputado <?php echo $deputado['nome'] ?></td>
  </tr>
<?php } ?>
</tbody>
</table>
