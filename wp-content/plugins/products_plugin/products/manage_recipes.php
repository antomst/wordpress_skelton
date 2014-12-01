<script type="text/javascript" src="https://tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script type="text/javascript">

    jQuery(document).ready(function() {
        jQuery.fn.dataTableExt.sErrMode = 'throw';
        oTable = jQuery('#tblList').dataTable({//data table
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": ajaxurl + '?page=recipes&action=fn_ajax_list',
            "bDeferRender": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "aoColumns": [{"sWidth": "5%", "bSortable": false}, {"bVisible": false}, null, null, {"bVisible": false}, null, null, null, {"sWidth": "5%", "bSortable": false}],
            "bAutoWidth": false
        });

        tinymce.init({
            selector: "textarea",
            //theme: "modern",
            entity_encoding : "raw",
            //encoding:"xml",
            /*plugins: [
             "advlist autolink lists link image charmap print preview hr anchor pagebreak",
             "searchreplace wordcount visualblocks visualchars code fullscreen",
             "insertdatetime media nonbreaking save table contextmenu directionality",
             "emoticons template paste textcolor colorpicker textpattern"
             ],
             toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
             toolbar2: "print preview media | forecolor backcolor emoticons",
             image_advtab: true,
             templates: [
             {title: 'Test template 1', content: 'Test 1'},
             {title: 'Test template 2', content: 'Test 2'}
             ]
             */
            plugins: [
                "advlist autolink lists charmap hr",
                "wordcount",
                "insertdatetime contextmenu directionality",
                "emoticons paste textcolor colorpicker textpattern"
            ],
            toolbar1: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor | backcolor | emoticons",
            image_advtab: true,
        });



        jQuery('#dialog-form').keypress(function(e) {//on press enter key
            if (e.keyCode == jQuery.ui.keyCode.ENTER && e.target.nodeName != "TEXTAREA") {
                jQuery(this).parent().find('.ui-dialog-buttonpane button:first').click();
                return false;
            }
        });
        var i = 1;
        var title = jQuery("#title");
        var recipe_category = jQuery("#recipe_category");
        var ingredients = jQuery("#ingredients");
        var qty = jQuery("#textbox" + i);

        //var recipe_image1 = jQuery('#recipe_image_val');

        //  alert(tinymce.activeEditor.getContent({format : 'raw'}));exit;


        var other_recipes = jQuery("#other_recipes");
        var related_recipes = jQuery("#related_recipes");
        var directions = jQuery("#directions");

        var id = jQuery("#id");
        var remove;
        var status = jQuery("input:radio[name=status]");
        //var allFields = jQuery([]).add(title).add(recipe_image1).add(ingredients).add(other_recipes).add(related_recipes).add(directions).add(id);//.add(status);
        var allFields = jQuery([]).add(title).add(directions).add(id).add(ingredients).add(related_recipes).add(other_recipes);
        var quantityArray;
        jQuery("#dialog-form").dialog({
            autoOpen: false,
            height: 630,
            width: 450,
            modal: true,
            buttons: {
                "Save": function() {//on click of save
                    // alert(jQuery("#textbox1").val());
                    jQuery("#tb").children("input:text").each(function() {
                        var s = jQuery(this).val();
                    });

                    var bValid = true;
                    allFields.removeClass("ui-state-error");//clear all errors
                    jQuery.fn.updateTips('');//clear the notifications
                    bValid = bValid && jQuery.fn.checkLength(title, 'Title', 1, '');//validate

                    if (bValid) {//after validation succeeded


                        if (jQuery("#statusYes").is(":checked"))
                            var statusVal = jQuery("#statusYes").val();
                        else
                            var statusVal = jQuery("#statusNo").val();
                        var formData = "";
                        var quantity = " ";
                        var j;
                        var nameId = [];
                        jQuery('#ingredients :selected').each(function(k, selected) {
                            nameId[k] = jQuery(selected).val();
                        });
                        for (j = 1; j <= count; j++)
                        {
                            idLab = nameId[j - 1];

                            if ((typeof(jQuery("#textbox" + idLab).val()) != 'undefined') && ((jQuery("#textbox" + idLab).val().length) > 0))
                            {
                                qnty = jQuery("#textbox" + idLab).val();
                                str1 = qnty.replace(/\s{2,}/g, ' ');
                                // quantity += jQuery("#textbox" + idLab).val()+',';
                                quantity += str1 + ',';

                            }
                            // str1 = str.replace(/ +(?= )/g,'');
                        }

                        formData = 'title=' + encodeURIComponent(title.val()) + '&recipe_category=' + encodeURIComponent(recipe_category.val()) + '&ingredients=' + encodeURIComponent(ingredients.val()) + '&other_recipes=' + encodeURIComponent(other_recipes.val()) + '&related_recipes=' + encodeURIComponent(related_recipes.val()) + '&directions=' + tinymce.activeEditor.getContent() + '&status=' + encodeURIComponent(statusVal) + '&recipe_image=' + jQuery('#recipe_image_val').val() + '&thumb_image=' + jQuery('#thumb_image_val').val() + '&quantity=' + quantity + '&count=' + encodeURIComponent(count);

                        if (id.val()) {//id for editing
                            formData += '&id=' + encodeURIComponent(id.val());
                        }
                        jQuery.ajax({//submission
                            url: ajaxurl + '?page=recipes&action=fn_ajax_save',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            success: function(data, textStatus, jqXHR)
                            {
                                if (data.status == 'fail') {
                                    jQuery.fn.updateTips(data.msg);
                                    //   exit();

                                }
                                else {//success
                                    oTable.fnDraw();
                                    jQuery.fn.updatemsgs('save success');
                                    jQuery("#ingredients").multiselect("uncheckAll");
                                    jQuery("#other_recipes").multiselect("uncheckAll");
                                    jQuery("#related_recipes").multiselect("uncheckAll");
                                    jQuery("#recipe_category").multiselect("uncheckAll");
                                    tinymce.activeEditor.setContent("");
                                    jQuery("#ui-miltiselect-filter").innerHtml = "";
                                    jQuery("#dialog-form").dialog("close");
                                    jQuery("#recipe_image").val("");
                                    jQuery("#recipe_image_val").val("");
                                    jQuery("#thumb_image").val("");
                                    jQuery("#thumb_image_val").val("");
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown)
                            {
                                jQuery.fn.updateTips("Insertion Failed");
                            }
                        });
                    }
                },
                Cancel: function() {//on click of cancel

                    jQuery(this).dialog("close");
                    allFields.val("").removeClass("ui-state-error");
                    jQuery.fn.updateTips('');
                    jQuery(".error").html('');

                    jQuery("#recipe_category option[value='" + remove + "']").attr("disabled", false);
                    jQuery("#related_recipes option[value='" + remove + "']").attr("disabled", false);
                    jQuery("#other_recipes option[value='" + remove + "']").attr("disabled", false);

                    jQuery("#recipe_category").multiselect("enable");
                    jQuery("#other_recipes").multiselect("enable");
                    jQuery("#related_recipes").multiselect("enable");
                    tinymce.activeEditor.setContent("");
                    jQuery("#recipe_img").remove();
                    jQuery("#recipe_image").val("");
                    jQuery("#thumb_img").remove();
                    jQuery("#thumb_image").val("");

                }
            },
            close: function() {//what should happen when the dialog is closed
                allFields.val("").removeClass("ui-state-error");
                jQuery.fn.updateTips('');
                jQuery(".error").html('');

                jQuery("#ingredients").multiselect("uncheckAll");
                jQuery("#other_recipes").multiselect("uncheckAll");
                jQuery("#related_recipes").multiselect("uncheckAll");
                jQuery("#recipe_category").multiselect("uncheckAll");
                tinymce.activeEditor.setContent("");
                jQuery("#other_recipes").multiselect().trigger('reset');

                jQuery("#recipe_category option[value='" + remove + "']").attr("disabled", false);
                jQuery("#related_recipes option[value='" + remove + "']").attr("disabled", false);
                jQuery("#other_recipes option[value='" + remove + "']").attr("disabled", false);

                jQuery("span.ui-dialog-title").text('Add New');
                jQuery("#recipe_img").remove();
                jQuery("#recipe_image").val("");
                jQuery("#thumb_img").remove();
                jQuery("#thumb_image").val("");

            }
        });

        jQuery("#create-btn").button().click(function() {//trigger add new button
            jQuery("#dialog-form").dialog("open");

        });

        jQuery.fn.confirmDelete = function(id) {//delete function
            if (confirm('Are you sure to delete?')) {
                var formData = 'id=' + encodeURIComponent(id)
                jQuery.ajax({
                    url: ajaxurl + '?page=recipes&action=fn_ajax_delete',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(data, textStatus, jqXHR)
                    {

                        if (data.status == 'duplicate_comment') {
                            jQuery.fn.updatemsgs('duplicate comment');
                            exit();
                        }
                        if (data.status == 'duplicate') {
                            jQuery.fn.updatemsgs('deletion duplicate');
                            exit();
                        }
                        if (data.status == 'fail') {
                            jQuery.fn.updatemsgs('deletion fail');
                        }
                        else {//success
                            jQuery.fn.updatemsgs('deletion success');
                            oTable.fnDraw();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        jQuery.fn.updateTips("Deletion Failed");
                    }
                });
            }
        }

        jQuery.fn.confirmEdit = function(id) {//To get the data using id
            var formData = 'id=' + encodeURIComponent(id)
            jQuery("span.ui-dialog-title").text('Edit');
            jQuery.ajax({
                url: ajaxurl + '?page=recipes&action=fn_ajax_get',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(data, textStatus, jqXHR)
                {
                    if (data.status == 'fail') {
                        jQuery.fn.updatemsgs('edit fail');
                    }
                    else {//success
                        jQuery("#id").val(data.data.id);
                        jQuery("#title").val(data.data.title);
                        // jQuery("#recipe_category").val(data.data.recipe_category);




                        if ((data.data.recipe_image.length == 0) || (data.data.recipe_image == "") || (data.data.recipe_image == null))
                            jQuery('#recipe_img').hide();
                        else
                        {
                            if (jQuery('#recipe_img').prop('src') == 0 || jQuery('#recipe_img').prop('src') == "" || jQuery('#recipe_img').prop('src') == null)
                            {
                                jQuery('#recipe_image_val').after('<img id="recipe_img" width="150" src="<?php echo UPLOAD_URL; ?>recipe/thumb/' + data.data.recipe_image + '" />');
                                var sss = (jQuery('#recipe_img').prop('src'));
                                var url = sss;
                                jQuery.ajax({
                                    type: "HEAD",
                                    url: url,
                                    success: function(data) {
                                        // alert("File found !!");
                                    },
                                    error: function(request, status) {
                                        jQuery('#recipe_img').hide();
                                    }
                                });
                            }

                        }
                        /////////////////////// thumb ////////////////////////

                        if ((data.data.thumb_image.length == 0) || (data.data.thumb_image == "") || (data.data.thumb_image == null))
                            jQuery('#thumb_img').hide();
                        else
                        {
                            // alert(2);
                            if (jQuery('#thumb_img').prop('src') == 0 || jQuery('#thumb_img').prop('src') == "" || jQuery('#thumb_img').prop('src') == null)
                            {
                                jQuery('#thumb_image_val').after('<img id="thumb_img" width="150" src="<?php echo UPLOAD_URL; ?>recipe/thumb/' + data.data.thumb_image + '" />');
                                var sss = (jQuery('#thumb_img').prop('src'));
                                var url = sss;
                                jQuery.ajax({
                                    type: "HEAD",
                                    url: url,
                                    success: function(data) {
                                        // alert("File found !!");
                                    },
                                    error: function(request, status) {
                                        jQuery('#thumb_img').hide();
                                    }
                                });
                            }

                        }

                        /////////////////////// thumb ////////////////////////

                        var valArr = data.data.ingredients;
                        var array = valArr.split(',');
                        var i = 0, size = array.length;
                        for (i; i < size; i++) {
                            jQuery("#ingredients").multiselect("widget").find(":checkbox[value='" + array[i] + "']").attr("checked", "checked");
                            jQuery("#ingredients option[value='" + array[i] + "']").attr("selected", true);
                            jQuery("#ingredients").multiselect("refresh");
                        }

                        remove = jQuery("#id").val();
                        var valArr1 = data.data.other_recipes;
                        var array1 = valArr1.split(',');

                        var i1 = 0, size1 = array1.length;
                        for (i1; i1 < size1; i1++) {
                            jQuery("#other_recipes").multiselect("widget").find(":checkbox[value='" + array1[i1] + "']").attr("checked", "checked");
                            jQuery("#other_recipes option[value='" + array1[i1] + "']").attr("selected", true);
                            jQuery("#other_recipes option[value='" + remove + "']").attr("disabled", true);
                            jQuery("#other_recipes").multiselect("refresh");
                        }

                        ////
                        count = jQuery("#ingredients :selected").length;
                        var k = 0;
                        var nameLabel = [];
                        var nameId = [];

                        jQuery('#ingredients :selected').each(function(k, selected) {
                            nameLabel[k] = jQuery(selected).text();
                            nameId[k] = jQuery(selected).val();
                        });
                        var quantity = data.data.quantity;
                        quantityArray = quantity.split(',');

                        var j = 1;
                        for (j; j <= count; j++)
                        {
                            var nameLab = nameLabel[j - 1];
                            var val = quantityArray[j - 1];
                            var idLab = nameId[j - 1];
                            var newTextBoxDiv = jQuery(document.createElement('div'))
                                    .attr("id", 'TextBoxDiv' + i);
                            newTextBoxDiv.after().html('<label>' + nameLab + ' : <span class="error1">*</span></label>' +
                                    '<input type="text" name="textbox' + idLab +
                                    '" id="textbox' + idLab + '" value="' + val + ' " >');

                            newTextBoxDiv.appendTo("#tb");
                        }


                        var valRecpCat = data.data.recipe_category;

                        var arrayRecpCat = valRecpCat.split(',');



                        var r = 0, countRecp = arrayRecpCat.length;
                        for (r; r < countRecp; r++) {
                            jQuery("#recipe_category").multiselect("widget").find(":checkbox[value='" + arrayRecpCat[r] + "']").attr("checked", "checked");
                            jQuery("#recipe_category option[value='" + arrayRecpCat[r] + "']").attr("selected", true);
                            jQuery("#recipe_category option[value='" + remove + "']").attr("disabled", true);
                            jQuery("#recipe_category").multiselect("refresh");
                        }





                        var valArr2 = data.data.related_recipes;
                        var array2 = valArr2.split(',');
                        var i2 = 0, size2 = array2.length;

                        for (i2; i2 < size2; i2++) {
                            jQuery("#related_recipes").multiselect("widget").find(":checkbox[value='" + array2[i2] + "']").attr("checked", "checked");
                            jQuery("#related_recipes option[value='" + array2[i2] + "']").attr("selected", true);
                            jQuery("#related_recipes option[value='" + remove + "']").attr("disabled", true);
                            jQuery("#related_recipes").multiselect("refresh");
                        }
                        //jQuery("#directions").val(data.data.directions);
                        tinymce.activeEditor.setContent(data.data.directions);
                        jQuery('input[name=status][value=' + data.data.status + ']').prop("checked", true);
                        jQuery("#dialog-form").dialog("open");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    jQuery.fn.updateTips("Updation Failed");
                }
            });
        }

        jQuery('input[name=recipe_image]').on('change', uploadFiles);
        function uploadFiles(event)
        {
            files = event.target.files;
            event.stopPropagation(); // Stop stuff happening
            event.preventDefault(); // Totally stop stuff happening
            jQuery.fn.updateTips('Please wait as the image is being validated.....');
            var data = new FormData();
            jQuery.each(files, function(key, value)
            {
                data.append(key, value);
            });

            jQuery.ajax({
                url: ajaxurl + '?page=recipes&action=fn_ajax_upload',
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR)
                {
                    if (data.status == 'success')
                    {
                        jQuery("#recipe_img").remove();
                        jQuery('#recipe_image_val').val(data.recipe_image).after('<img id="recipe_img" width="150" src="<?php echo UPLOAD_URL; ?>tmp/' + data.recipe_image + '" />');
                        jQuery.fn.updateTips('');
                        data.recipe_image = '';
                    }
                    else
                        jQuery.fn.updateTips(data.msg);
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    console.log('ERRORS: ' + textStatus);
                }
            });
        }

        jQuery('input[name=thumb_image]').on('change', uploadFilesThumb);
        function uploadFilesThumb(event)
        {
            files = event.target.files;
            event.stopPropagation(); // Stop stuff happening
            event.preventDefault(); // Totally stop stuff happening
            jQuery.fn.updateTips('Please wait as the image is being validated.....');
            var data = new FormData();
            jQuery.each(files, function(key, value)
            {
                data.append(key, value);
            });

            jQuery.ajax({
                url: ajaxurl + '?page=recipes&action=fn_ajax_upload_thumb',
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR)
                {
                    if (data.status == 'success')
                    {
                        jQuery("#thumb_img").remove();
                        jQuery('#thumb_image_val').val(data.thumb_image).after('<img id="thumb_img" width="150" src="<?php echo UPLOAD_URL; ?>tmp/' + data.thumb_image + '" />');
                        jQuery.fn.updateTips('');
                        data.thumb_image = '';
                    }
                    else
                        jQuery.fn.updateTips(data.msg);
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    console.log('ERRORS: ' + textStatus);
                }

            });
        }

        //jQuery("select").multiselect().multiselectfilter();
        jQuery("#ingredients").multiselect().multiselectfilter({
            autoReset: true});
        jQuery("#other_recipes").multiselect().multiselectfilter({
            autoReset: true});
        jQuery("#related_recipes").multiselect().multiselectfilter({
            autoReset: true});
        jQuery("#recipe_category").multiselect().multiselectfilter({
            autoReset: true});

        var count;
        jQuery('#ingredients').change(function() {
            count = jQuery("#ingredients :selected").length;
            var k = 0;
            var nameLabel = [];
            var nameId = [];
            var valArray = [];
            var qval;
            jQuery('#ingredients :selected').each(function(k, selected) {
                nameLabel[k] = jQuery(selected).text();
                nameId[k] = jQuery(selected).val();
                var test = nameId[k];
                if (typeof(jQuery('#textbox' + nameId[k]).val()) !== 'undefined')
                    valArray[test] = jQuery('#textbox' + nameId[k]).val();
            });
            jQuery("#tb").empty();
            var i = 1;

            for (i = 1; i <= count; i++)
            {
                var nameLab = nameLabel[i - 1];
                var idLab = nameId[i - 1];
                if ((typeof(valArray[idLab]) !== "undefined"))
                    qval = valArray[idLab];
                else
                    qval = "";
                var newTextBoxDiv = jQuery(document.createElement('div'))
                        .attr("id", 'TextBoxDiv' + i);
                newTextBoxDiv.after().html('<label>' + nameLab + ' : <span class="error1">*</span></label>' +
                        '<input type="text" name="textbox' + idLab +
                        '" id="textbox' + idLab + '" value= "' + qval + '" >');
                newTextBoxDiv.appendTo("#tb");
            }
        });

    });
</script>
<style type="text/css">
    .error1{ color: #EE0000;}
</style>
<div id="dialog-form" title="Add New">
    <p class="validateTips" style="display:none;"></p>
    <form>
        <fieldset>
            <input type="hidden" name="id" id="id" value="" />

            <label for="title">Title<span class="error1">*</span></label>
            <input type="text" name="title" id="title" rel="1" class="required text ui-widget-content ui-corner-all" />
            <span class="error"></span><br/>



            <label for="recipe_category">Recipe Category<span class="error1">*</span></label>
            <?php
            echo '<select name="recipe_category" id="recipe_category" class="required" multiple="multiple">';
            $res = $wpdb->get_results($wpdb->prepare('select * from `tbl_recipe_categories`', 0), ARRAY_A);
            foreach ($res as $c) {
                echo "<option value=\"{$c['id']}\">{$c['category']}</option>\n";
            }
            echo'</select>';
            ?>
            <span class="error"></span><br/><br/> 

            <label for="recipe_image">Recipe Image</label>
            <input type="file" name="recipe_image" id="recipe_image" style="width:75px;" />
            <input type="hidden" name="recipe_image_val" id="recipe_image_val" value="" />
            <span class="error"></span><br /><br/>

            <label for="thumb_image">Thumb Image</label>
            <input type="file" name="thumb_image" id="thumb_image" style="width:75px;" />
            <input type="hidden" name="thumb_image_val" id="thumb_image_val" value="" />
            <span class="error"></span><br />

            <label for="ingredients">Ingredients<span class="error1">*</span></label>           
            <?php
            echo '<select name="ingredients" id="ingredients" multiple="multiple" class="required">';
            $res1 = $wpdb->get_results($wpdb->prepare('select * from `tbl_ingredients`', 0), ARRAY_A);
            foreach ($res1 as $c1) {
                echo "<option value=\"{$c1['id']}\">{$c1['ingredient']}</option>\n";
            }
            echo'</select>';
            ?>
            <span class="error"></span><br/><br/> 
            <div id="tb"></div>
            <label for="other_recipes">Other Recipes</label>
            <?php
            echo '<select name="other_recipes" id="other_recipes" multiple="multiple">';

            $res2 = $wpdb->get_results($wpdb->prepare('select * from `tbl_recipes`', 0), ARRAY_A);
            foreach ($res2 as $c2) {
                echo "<option value=\"{$c2['id']}\">{$c2['title']}</option>\n";
            }
            echo'</select>';
            ?>
            <span class="error"></span><br/><br/> 

            <label for="related_recipes">Related Recipes</label>
            <?php
            echo '<select name="related_recipes" id="related_recipes" multiple="multiple">';
            $res3 = $wpdb->get_results($wpdb->prepare('select * from `tbl_recipes`', 0), ARRAY_A);
            foreach ($res3 as $c3) {
                echo "<option value=\"{$c3['id']}\">{$c3['title']}</option>\n";
            }
            echo'</select>';
            ?>
            <span class="error"></span><br/><br/>
            <label for="directions">Directions<span class="error1">*</span></label>
            <textarea name="directions" style="width:100%" id="directions"rel="2" class="required"></textarea>
            <span class="error"></span><br/>

            <label for="status">Status <span class="error1">*</span></label>
            <input type="radio" id="statusYes" name="status" value="Y" rel="3" checked="checked"> Active
            <input type="radio" id="statusNo" name="status" value="N" rel="3"> Inactive

        </fieldset>
    </form>
</div>

<div class="wrap" id="headingWrap">
    <div id="icon-edit-pages" class="icon32" align="left"></div>
    <h2 style="float:left;"><?php echo 'Manage Recipes'; ?> </h2>
    <br />
    <button id="create-btn" style="float:right;">Add New</button>
    <br clear="all" />
</div>
<center><div class="msg" style="text-align:center;display:none;width:300px;"></div></center>
<table id="tblList" border="0" cellpadding="0" cellspacing="0" style="width:100%;">
    <thead>
        <tr>
            <th>Sl.No</th>
            <th></th>
            <th>Title</th>
            <th>Recipe Category</th>
            <th>Directions</th>
            <th>Status</th>
            <th>Created On</th>
            <th>Updated On</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="4" class="dataTables_empty">Loading data from server</td>
        </tr>
    </tbody>
</table>