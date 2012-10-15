<table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
<tbody>
<?php 
	if(!empty($posts['data'])){
		foreach($posts['data'] as $post){ 
			if(!empty($post['caption'])){
?>
  <tr>
    <td align="justify"><?php echo $post['caption'] ?></td>
  </tr>
  <tr>
    <td><hr /></td>
  </tr>
<?php 		}
		}
	}else{ ?>
    <tr>
    <td align="center">Nenhum post encontrado para o Deputado <?php echo $deputado['nome'] ?></td>
  </tr>
<?php } ?>
</tbody>
</table>
