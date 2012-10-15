<script type="text/javascript">		
	jQuery("#chartPlenario").gchart({
		title: 'Plenário',
		series: [jQuery.gchart.series([<?php echo $faltas['plenario']['qtd_presenca'] ?>, <?php echo ($faltas['plenario']['qtd_justificada'] + $faltas['plenario']['qtd_nao_justificada']) ?>])],
		dataLabels: [<?php echo $faltas['plenario']['qtd_presenca'] ?>, <?php echo ($faltas['plenario']['qtd_justificada'] + $faltas['plenario']['qtd_nao_justificada']) ?>],
		type: 'pie',
		extension: {chdl: 'Presença(s)|Falta(s)'}
	});
	jQuery("#chartComissoes").gchart({		
		title: 'Comissões',
		series: [jQuery.gchart.series([<?php echo $faltas['comissoes']['qtd_presenca'] ?>, <?php echo ($faltas['comissoes']['qtd_justificada'] + $faltas['comissoes']['qtd_nao_justificada'] + $faltas['comissoes']['qtd_escusa']) ?>])],
		dataLabels: [<?php echo $faltas['comissoes']['qtd_presenca'] ?>, <?php echo ($faltas['comissoes']['qtd_justificada'] + $faltas['comissoes']['qtd_nao_justificada'] + $faltas['comissoes']['qtd_escusa']) ?>],		
		extension: {chdl: 'Presença(s)|Falta(s)'},
		type: 'pie'		
	});
</script>
<table width="800" border="0" align="center" cellpadding="1" cellspacing="0">
    <tr align="center">
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr align="center">
      <td><div id="chartPlenario" style="width: 360px; height: 180px;"></div></td>
      <td><div id="chartComissoes" style="width: 360px; height: 180px;"></div></td>
    </tr>
</table>
