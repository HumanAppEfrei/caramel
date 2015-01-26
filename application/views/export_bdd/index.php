<div>
    <div id="content">
        <h1>Export de la bdd</h1>
<form action="#">
    <div class="selectBox">
<button id="addSelectboxButton">+</button>
</div>
</form>
<script>
// data parsed on server side containing all column on all table on the db
var datas = <?php echo $tables ?>;
// current select box id auto incrementing
var currentSelectBoxId = 0;

/**
 * build a new select box with all content parsed on server side
 * @param (integer) current id of the newly created selectbox
 * @return (jquery element) new selectbox
 */
function buildSelectBox(id){
    var selectBox = $(document.createElement('select'));
    if(id) selectBox.attr('value',"column["+ id+"]");
    for(var table in datas){
        var optionGroupTmp = $(document.createElement('optgroup'));
        optionGroupTmp.attr('label',table);
        for(var index in datas[table]){
            var optionTmp = $(document.createElement('option'));
            optionTmp.attr('value',datas[table][index]);
            optionTmp.html(datas[table][index]);
            optionGroupTmp.append(optionTmp);
        }

        selectBox.append(optionGroupTmp);
    }
    return selectBox;
}

/**
 * Build a selection box and append it inside the form
 */
function addSelectBox(){
    $("form").append(buildSelectBox(currentSelectBoxId));
}

function initBaseSelectBox(){
   $("#addSelectboxButton").before(buildSelectBox());
}
initBaseSelectBox();
</script>
    </div>
</div>
