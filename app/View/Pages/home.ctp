<div class="home form">
<?php echo $this->Form->create('Campo', array('action' => 'adicionar', 'class' => 'formValidate')) ?>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="tblForm">
  <tr class="titleForm">
    <td colspan="2">Dados</td>
  </tr>
  <tr>
    <td colspan="2">Deputados*</td>
  </tr>
  <tr>
    <td colspan="2"><?php echo $this->Form->select('Deputado.id', array('Nome do deputado B', 'Nome do deputado A'), array()) ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="2"><?php echo $this->Form->submit('Cadastrar') ?></td>
  </tr>
</table>
<?php echo $this->Form->end() ?>
</div>