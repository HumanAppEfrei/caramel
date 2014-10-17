/* javascript lié aux vues des lettres */
$("#selectedButton button").attr("disabled", "disabled");

//affichage des contenus des types
$("#selectTypes").change( function() {
    $("#selectedButton button").attr("disabled", "disabled");
    $("#buttonCreate").removeAttr("disabled");
	
    var req= $.ajax({
        url : "ajax_listLettres/"+$("#selectTypes option:selected").val(),
        type : 'POST',
        dataType : 'html',
        success: function(data){
            $("#selectLetters").html(data);
        }
    });
});

//déblocage modif et suppr quand on selectionne une lettre
$("#selectLetters").change( function() {
    $("#buttonModif").removeAttr("disabled");
    $("#buttonSuppr").removeAttr("disabled");
    $("#buttonGener").removeAttr("disabled");
});

//action quand on appuie sur créer
$("#buttonCreate").click( function() {
    window.location.replace(baseURL+"/create_letter/"+$("#selectTypes option:selected").val());
});

//action quand on appuie sur modifier
$("#buttonModif").click( function() {
    window.location.replace(baseURL+"/edit_letter/"+$("#selectLetters option:selected").val());
});

//action quand on appuie sur supprimer
$("#buttonSuppr").click( function() {
    if(window.confirm("Êtes vous sur de vouloir supprimer cette lettre?"))
        window.location.replace(baseURL+"/remove_letter/"+$("#selectLetters option:selected").val());
});

//action quand on appuie sur Génération PDF
$("#buttonGener").click( function() {
    window.location.replace(baseURL+"/generate_lettre/"+$("#selectLetters option:selected").val());
});
