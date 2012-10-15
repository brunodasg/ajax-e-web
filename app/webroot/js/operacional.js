jQuery(document).ready(function(){
    /* Oculta o load do ajax */
    jQuery("#ajaxLoad").hide();
	
    /* Tranforma botao com jQuery UI*/
    jQuery(".submit input, .submit a").button();

	
    /* Zebrar tabelas */
    jQuery(".zebra tr:even").attr("bgcolor", "#C6C68C");

	
    /* Adiciona calendario nos campos datas */
    jQuery(function() {
        jQuery(".date").datepicker({
            dateFormat: "dd/mm/yy",
			changeMonth: true,
			changeYear: true,
			yearRange: "1920:",
            dayNames: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'],
            dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            showOn: "button",
            buttonImage: "/syspastor/img/icons/cal22.png",
            buttonImageOnly: true
        });
    });
	

    /* Adiciona mascara nos elementos */	
    jQuery("body").delegate(".tel", "focus", function(){
        jQuery(this).setMask({
            mask: '(99) 9999-9999', 
            autoTab: false
        });		
    });
	
    jQuery("body").delegate(".titulo", "focus", function(){
        jQuery(this).setMask({
            mask: '9999 9999 9999', 
            autoTab: false
        });		
    });
	
	jQuery("body").delegate(".cpf", "focus", function(){
        jQuery(this).setMask({
            mask: '999.999.999-99', 
            autoTab: false
        });		
    });
	
    jQuery("body").delegate(".cnpj", "focus", function(){
        jQuery(this).setMask({
            mask: '99.999.999/9999-99', 
            autoTab: false
        });		
    });
	
    jQuery("body").delegate(".cep", "focus", function(){
        jQuery(this).setMask({
            mask: '99999-999', 
            autoTab: false
        });		
    });
	
    jQuery("body").delegate(".date", "focus", function(){
        jQuery(this).setMask({
            mask: '39/19/2999', 
            autoTab: false
        });		
    });
	
    jQuery("body").delegate(".time", "focus", function(){
        jQuery(this).setMask({
            mask: '29:59', 
            autoTab: false
        });		
    });
	
    jQuery("body").delegate(".dateTime", "focus", function(){
        jQuery(this).setMask({
            mask: '39/19/2999 29:59', 
            autoTab: false
        });		
    });
	
    jQuery("body").delegate(".maskMoney", "focus", function(){
        jQuery(this).setMask({
            mask : '99,999.999.999.999', 
            type : 'reverse', 
            defaultValue: ''
        });		
    });
	

    /* Oculta alerta do set-flash do cake */
	jQuery("#flashMessage").click(function(){
		jQuery(this).fadeOut();		
    });
});


/* Exibe imagem de load na execucao do ajax */
function showLoad(){
    jQuery(document).ready(function(){
        jQuery("#ajaxLoad").show();
    });
}


/* Oculta imagem no fim da execucao do ajax */
function hideLoad(){
    jQuery(document).ready(function(){
        jQuery("#ajaxLoad").hide();
    });
}


/* Popula um select a partir de json object */
function populaSelectJson(json, selectId, empty){
	// Limpa o select
	jQuery("#" + selectId).empty();
	
	// Adiciona um option vazio
	if(empty){
		var option = new Option('', '');
	
		jQuery("#" + selectId).append(option);
	}
	
	jQuery.each(json, function(id, nome){
		var option = new Option(nome, id);
	
		jQuery("#" + selectId).append(option);
	});
}