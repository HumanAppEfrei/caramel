<script type="text/javascript" src="<?php echo js_url('tiny_mce/tiny_mce'); ?>"></script>
<script type="text/javascript">

tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,iManager,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect,|,cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
        theme_advanced_buttons2 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen,|,insertlayer,imanager,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Skin options

        // Example content CSS (should be your site CSS)
        content_css : "<?php echo css_url('style'); ?>css/example.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "<?php echo js_url('template_list'); ?>template_list",
        external_link_list_url : "<?php echo js_url('link_list'); ?>link_list",
        external_image_list_url : "<?php echo js_url('image_list'); ?>image_list",
        media_external_list_url : "<?php echo js_url('media_list'); ?>media_list",

    });
</script>

<script type="text/javascript">
function get_editor_content() {
	return tinyMCE.get('myarea1').getContent();
}
</script> 

<form class="form-horizontal" method="post" action="<?php echo site_url('document/create_letter/'.$typeID)?>">
	<div id="content-form">
		<div class="input-prepend">
			<div class="control-group">
				<label class="control-label" for="titre">Titre</label>
				<div class="controls">
					<span class="add-on"><i class="icon-envelope"></i></span><input class="span2" name="titre" type="text" value="" >
					<?php echo "<br/>".form_error('titre'); ?>
				</div>
			</div>
			<input name= "is_form_sent" type="hidden" value="true">	
			
		</div>
	</div>

	<input id="TinyTextHTML" name="TinyTextHTML" type="hidden" value="get_editor_content();"> 

	<div id="button-container">
		<center>
			<div id="button-position" style="margin-top: 20px";>
				<a href="<?php echo site_url('document/lettre')?>" ><button class="btn btn-small" type="button">Retour</button></a>
				<button class="btn btn-small" type="submit">Sauvegarder</button>
			</div>
		</center>
	</div>



	<div id="width-ctn" style="min-width: 800px;">
		<textarea id="myarea1" name="content" style="width:100%; height: 500px"></textarea>




	</div>

</form>
<script>
$("form").submit( function() {
		tinyMCE.triggerSave(true, true); // place la valeur dans le textearea
		var HTML = $("#myarea1").val();
		// on modifie l'HTML car les "=" ne passent pas (ils sont interpretés lors du transfert)
		$("#TinyTextHTML").attr("value",HTML.replace(/=/g,"&|&"));
	});
</script>
