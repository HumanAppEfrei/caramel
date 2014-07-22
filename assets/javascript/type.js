/* javascript lié aux vues des lettres */
$("#buttonModif").attr("disabled", "disabled");
$("#buttonSuppr").attr("disabled", "disabled");

$("#selectTypes").change( function() {
    $("#buttonModif").removeAttr("disabled");
    $("#buttonSuppr").removeAttr("disabled");
	
    var req= $.ajax({
        url : "ajax_listLettres/"+$("#selectTypes option:selected").val(),
        type : 'POST',
        dataType : 'html',
        success: function(data){
            $("#selectLetters").html(data);
        }
    });
});

//action quand on appuie sur supprimer
$("#buttonSuppr").click( function() {
    if(window.confirm("Êtes vous sur de vouloir supprimer ce type?"))
        window.location.replace(baseURL+"/remove_type/"+$("#selectTypes option:selected").val());
});

//action quand on appuie sur modifier
$("#buttonModif").click( function() {
    window.location.replace(baseURL+"/edit_type/"+$("#selectTypes option:selected").val());
});