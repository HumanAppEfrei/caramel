/* javascript lié aux vues offre (create)*/
$("#error_seg").hide();
var table_segments = new Array();
var cpt = 0;
var segmentAdded = false;

if($("#segments").val())
{
	table_segments = $("#segments").val().split(',');
	for(var i=0; i < table_segments.length; i++)
	{
		if (table_segments[i] != '') {
			$("#affich_segs").append("<h3 id='"+(cpt++)+"'><a href='"+baseURL+'/segment/edit/'+table_segments[i]+"'>"+table_segments[i]+"</a>   <button type='button' class='btn' value='"+(cpt++)+"'>suppr</button></h3><br/>");
			segmentAdded = true;
		}
	}

	if (!segmentAdded)
		table_segments = new Array();
} 

$("#seg_ajout").click( function()
{
	var seg = $("#seg").val();
	$("#error_seg").hide();
	if(seg)
	{
		//vérification segment non déjà saisi
		for(var i=0; i < table_segments.length; i++)
		{
			if(table_segments[i] == seg) 
			{
				alert("Ce segment a déjà été saisi");
				return;
			}
		}

		//vérification segment dans la BDD (requete ajax)
		var requete = $.ajax({
			url: "ajax_IsSeg/"+seg,
			success: function() {
				if(requete.responseText == "true")
				{
					table_segments.push(seg);
					$("#affich_segs").append("<h3 id='seg_"+cpt+"'><a href='"+baseURL+'/segment/edit/'+seg+"'>"+seg+"</a>     <button type='button' class='btn btn-mini suppr_seg' value='"+cpt+"'>Enlever</button></h3>");
					$('button.suppr_seg[value="'+cpt+'"]').click(supprSegment);
					cpt++;
				} else {
						$("#error_seg").show();
				}
			}
		});
	}

});

// Appelé quand on clique sur la suppression d'un segment
function supprSegment(event)
{
	var value = event.target.value;
	$('h3#seg_'+value).remove();
	table_segments[value] = null;
	console.log(table_segments[value]);
}

$("form").submit( function() {
	$("#segments").val(table_segments.toString());
});