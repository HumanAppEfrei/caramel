<div>
    <div id="content" class="export-wrapper">
        <h1>Export de la bdd</h1>
    <form  id="exportForm" method="post" name="export" <?php echo ('action="'.site_url('admin/recuperecsv').'"'); ?>>
        <input name= "is_form_sent" type="hidden" value="true">
    <div id="selectBox">
<span>Nouveau choix : </span>
<button id="addSelectboxButton" class="btn">Ajouter</button>
</div>
<hr>
        <button type="submit" class="btn" value="exporter" id="exporter-bouton">Exporter</button>
    </form>
</div>
<script>
// data parsed on server side containing all column on all table on the db
var datas = <?php echo $tables ?>;
// current select box id auto incrementing
var currentSelectBoxId = 1;
// first select box
var firstSelectBox;

/**
 * build a new select box with all content parsed on server side
 * @param (integer) current id of the newly created selectbox
 * @return (jquery element) new selectbox
 */
function buildSelectBox(id){
    var selectBox = $(document.createElement('select'));
    selectBox.attr('name',"column["+ id +"]");
    selectBox.attr('id',"column["+ id +"]");
    for(var table in datas){
        var optionGroupTmp = $(document.createElement('optgroup'));
        optionGroupTmp.attr('label',table);
        for(var index in datas[table]){
            var optionTmp = $(document.createElement('option'));
            optionTmp.attr('value',table + ':' +datas[table][index]);
            optionTmp.html(datas[table][index]);
            optionGroupTmp.append(optionTmp);
        }
        selectBox.append(optionGroupTmp);
    }
    return selectBox;
}

/**
 * build a delete button for a specified selectBox
 * @param (integer) current id of the newly created delete button
 * @return (jquery element) new button
 */
function createDeleteButton(id){
    var deleteButton = $(document.createElement('button'));
    deleteButton.html('X');
    deleteButton.attr('class','btn delete-btn')
    deleteButton.click(function(){ $('#column'+id).remove(); });
    return deleteButton;
}

/**
 * Build container div for column select and delet button
 * @param (integer) current id of the newly created div
 * @return (jquery element) new div
 */
function createContainingDiv(id){
    var containingDiv = $(document.createElement('div'));
    containingDiv.attr('id','column'+id);
    return containingDiv;
}
/**
 * Build a selection box and append it inside the form
 */
function addSelectBox(){
    var container = createContainingDiv(currentSelectBoxId);
    var newSelectBox = buildSelectBox(currentSelectBoxId);
    var selectedElement = firstSelectBox.val();
    newSelectBox.val(selectedElement);
    container.append(newSelectBox);
    container.append(createDeleteButton(currentSelectBoxId++));
    $("#selectBox").before(container);
}

function initBaseSelectBox(){
    firstSelectBox = buildSelectBox(0);
   $("#addSelectboxButton").before(firstSelectBox);
}

// default initionalisation
initBaseSelectBox();
$('#addSelectboxButton').click(function(event){
    event.preventDefault(); // prevent form submitting
    addSelectBox();
});

</script>
    </div>
</div>
