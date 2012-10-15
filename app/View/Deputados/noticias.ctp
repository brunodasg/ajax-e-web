<table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
<tbody>
<?php 
	if(!empty($noticias['responseData']['results'])){
		foreach($noticias['responseData']['results'] as $noticia){ ?>
  <tr>
    <td><b><?php echo $noticia['title'] ?></b></td>
  </tr>
  <tr>
    <td align="justify">
		<?php echo $noticia['content'] ?>&nbsp;
		<?php echo $this->Html->link('leia mais', $noticia['unescapedUrl'], array('target' => '_blank')) ?>
    </td>
  </tr>
  <tr>
    <td><hr /></td>
  </tr>
<?php 	}
	}else{ ?>
    <tr>
    <td align="center">Nenhuma notícia encontrada para o Deputado <?php echo $deputado['nome'] ?></td>
  </tr>
<?php } ?>
</tbody>
</table>
