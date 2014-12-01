<?php

include(PLUGIN_PATH . 'inc/classes/resize-class.php');

add_action('wp_ajax_fn_ajax_save', 'fn_ajax_save');
add_action('wp_ajax_nopriv_fn_ajax_save', 'fn_ajax_save');

add_action('wp_ajax_fn_ajax_delete', 'fn_ajax_delete');
add_action('wp_ajax_nopriv_fn_ajax_delete', 'fn_ajax_delete');

add_action('wp_ajax_fn_ajax_list', 'fn_ajax_list');
add_action('wp_ajax_nopriv_fn_ajax_list', 'fn_ajax_list');

add_action('wp_ajax_fn_ajax_get', 'fn_ajax_get');
add_action('wp_ajax_nopriv_fn_ajax_get', 'fn_ajax_get');

add_action('wp_ajax_fn_ajax_upload', 'fn_ajax_upload');
add_action('wp_ajax_nopriv_fn_ajax_upload', 'fn_ajax_upload');

add_action('wp_ajax_fn_ajax_upload_thumb', 'fn_ajax_upload_thumb');
add_action('wp_ajax_nopriv_fn_ajax_upload_thumb', 'fn_ajax_upload_thumb');

function fn_ajax_save() {//add/update
    global $wpdb;

    date_default_timezone_set('Asia/Calcutta');
    $id = (isset($_POST['id'])) ? $_POST['id'] : '';
    $title = (isset($_POST['title'])) ? $_POST['title'] : '';
    $recipe_category = (isset($_POST['recipe_category'])) ? $_POST['recipe_category'] : '';
    $ingredients = (isset($_POST['ingredients'])) ? $_POST['ingredients'] : '';
    $other_recipes = (isset($_POST['other_recipes'])) ? $_POST['other_recipes'] : '';
    $related_recipes = (isset($_POST['related_recipes'])) ? $_POST['related_recipes'] : '';
    $directions = (isset($_POST['directions'])) ? $_POST['directions'] : '';
    $status = (isset($_POST['status'])) ? $_POST['status'] : '';
    $recipe_image = (isset($_POST['recipe_image'])) ? $_POST['recipe_image'] : '';
    $thumb_image = (isset($_POST['thumb_image'])) ? $_POST['thumb_image'] : '';

    $quantity = (isset($_POST['quantity'])) ? $_POST['quantity'] : '';
    $count = (isset($_POST['count'])) ? $_POST['count'] : '';
    $created_on = $today = date("Y-m-d H:i:s");
    $supported_image = array('gif', 'jpg', 'jpeg', 'png');

    if (!empty($_POST["recipe_image"])) {
        $ext = strtolower(pathinfo($recipe_image, PATHINFO_EXTENSION));
        if (!(in_array($ext, $supported_image))) {
            echo json_encode(array('status' => 'fail', 'msg' => 'Invalid Recipe Image Extension '));
            exit();
        }
    }

    if (!empty($_POST["thumb_image"])) {
        $ext = strtolower(pathinfo($thumb_image, PATHINFO_EXTENSION));
        if (!(in_array($ext, $supported_image))) {
            echo json_encode(array('status' => 'fail', 'msg' => 'Invalid  Thumb Image Extension '));
            exit();
        }
    }

    if (trim($title) == '') {
        echo json_encode(array('status' => 'fail', 'msg' => 'Title not entered'));
        exit();
    }
    if (!(ctype_alpha(str_replace(' ', '', $title))) || strlen($title) > 30) {
        echo json_encode(array('status' => 'fail', 'msg' => 'Invalid Title entered'));
        exit();
    }

    if (trim($recipe_category) == '' || trim($recipe_category) == 'undefined' || ($_POST['recipe_category'] == "null") || ($_POST['recipe_category'] == null)) {
        echo json_encode(array('status' => 'fail', 'msg' => 'Recipe Category type not selected'));
        exit();
    }

    if ((trim($ingredients) == '') || (trim($ingredients) == 'undefined') || ($ingredients === 'null') || ($ingredients === null)) {
        echo json_encode(array('status' => 'fail', 'msg' => 'Ingredients not entered'));
        exit();
    }


    if (trim($directions) == '') {
        echo json_encode(array('status' => 'fail', 'msg' => 'Directions not entered'));
        exit();
    }
    $qtyArray = array();
    $qtyArray = explode(",", $quantity);
    $qtyArrayLength = count($qtyArray);

    if ($count != ($qtyArrayLength - 1)) {
        echo json_encode(array('status' => 'fail', 'msg' => 'Quantity not entered'));
        exit();
    } else
        {
        $processed_title = preg_replace("/\s{2,}/", " ", $title);
        $processed_directions = stripslashes(preg_replace("/\s{2,}/", " ", $directions));
        //echo json_encode(array('status' => 'fail', 'msg' => stripslashes($processed_directions)));exit;
        $processed_recipe_image = str_replace(' ', '', $recipe_image);
        $processed_thumb_image = str_replace(' ', '', $thumb_image);
        $data = array('title' => $processed_title, 'recipe_category' => $recipe_category, 'ingredients' => $ingredients, 'other_recipes' => $other_recipes, 'related_recipes' => $related_recipes, 'directions' => $processed_directions, 'status' => $status, 'created_on' => $created_on, 'updated_on' => $created_on, 'quantity' => $quantity);
       
       // print_r($data);exit;
        if ($recipe_image != '') {

            $data['recipe_image'] = $processed_recipe_image;
            $resizeObj = new resize(UPLOAD_PATH . 'tmp/' . $recipe_image);
            $resizeObj->resizeImage(800, 600, 'auto'); //(options: exact, portrait, landscape, auto, crop)
            $resizeObj->saveImage(UPLOAD_PATH . 'recipe/' . $processed_recipe_image, 100);

            $resizeObj = new resize(UPLOAD_PATH . 'tmp/' . $recipe_image);
            $resizeObj->resizeImage(400, 300, 'auto'); //(options: exact, portrait, landscape, auto, crop)
            $resizeObj->saveImage(UPLOAD_PATH . 'recipe/thumb/' . $processed_recipe_image, 100);
            @unlink(UPLOAD_PATH . 'tmp/' . $recipe_image);
        }

        if ($thumb_image != '') {

            $data['thumb_image'] = $processed_thumb_image;
            $resizeObj = new resize(UPLOAD_PATH . 'tmp/' . $thumb_image);
            $resizeObj->resizeImage(400, 300, 'auto'); //(options: exact, portrait, landscape, auto, crop)
            $resizeObj->saveImage(UPLOAD_PATH . 'recipe/thumb/' . $processed_thumb_image, 100);
            @unlink(UPLOAD_PATH . 'tmp/' . $thumb_image);
        }

        if ($id == '') {//add
            /*if ($thumb_image == '') {
                echo json_encode(array('status' => 'fail', 'msg' => 'Thumb not entered'));
                exit();
            }*/
            $cnt = $wpdb->get_var($wpdb->prepare('select count(*) from `tbl_recipes` 
                where 
                    `title` = %s', $processed_title));
            if ($cnt > 0) {
                echo json_encode(array('status' => 'fail', 'msg' => 'Duplicate entry found'));
                exit();
            } else {

                if ($wpdb->insert('tbl_recipes', $data)) {
                    $data['id'] = $wpdb->insert_id;
                    echo json_encode(array('status' => 'success', 'data' => $data));
                }
                else
                    echo json_encode(array('status' => 'fail'));
            }
        } else {//edit
            $cnt = $wpdb->get_var($wpdb->prepare('select count(*) from `tbl_recipes` 
                where 
                    `title` = %s and `id` != %d', $processed_title, $id));
            if ($cnt > 0) {
                echo json_encode(array('status' => 'fail', 'msg' => 'Duplicate entry found'));
                exit();
            } else {
                if ($recipe_image != '') {
                    $old_recipe_image = $wpdb->get_var($wpdb->prepare('select recipe_image from `tbl_recipes` 
                        where `id` = %d', $id));
                    if ($processed_recipe_image != $old_recipe_image) {
                        @unlink(UPLOAD_PATH . 'recipe/' . $old_recipe_image);
                        @unlink(UPLOAD_PATH . 'recipe/thumb/' . $old_recipe_image);
                    }
                }
                if ($thumb_image != '') {

                    $old_thumb_image = $wpdb->get_var($wpdb->prepare('select thumb_image from `tbl_recipes` 
                        where `id` = %d', $id));
                    if ($processed_thumb_image != $old_thumb_image)
                        @unlink(UPLOAD_PATH . 'recipe/thumb/' . $old_thumb_image);
                }
                $created_on = $wpdb->get_var($wpdb->prepare('select created_on from `tbl_recipes` 
                        where `id` = %d', $id));
                $data['created_on'] = $created_on;

                $condition = array('id' => $id);
                $wpdb->update('tbl_recipes', $data, $condition);
                echo json_encode(array('status' => 'success', 'data' => $data));
            }
        }
    }
    exit();
}

function fn_ajax_get() {//get the record
    global $wpdb;

    $id = (isset($_POST['id'])) ? $_POST['id'] : '';

    if ($id != '') {
        $row = $wpdb->get_row($wpdb->prepare('select * from `tbl_recipes` 
                where 
                    `id` = %d', $id));
        if (isset($row->id)) {

            $data = array(
                'id' => $row->id,
                'title' => $row->title,
                'recipe_category' => $row->recipe_category,
                'ingredients' => $row->ingredients,
                'other_recipes' => $row->other_recipes,
                'related_recipes' => $row->related_recipes,
                'directions' => $row->directions,
                'status' => $row->status,
                'recipe_image' => $row->recipe_image,
                'thumb_image' => $row->thumb_image,
                'quantity' => $row->quantity,
            );
           // print_r($data);exit;
            echo json_encode(array('status' => 'success', 'data' => $data));
        }
        else
            echo json_encode(array('status' => 'fail'));
    }
    else 
        echo json_encode(array('status' => 'fail'));
    exit();
}

function fn_ajax_delete() {//delete
    global $wpdb;

    $id = $_POST['id'];
    if ($id != '') {
        $old_recipe_image = $wpdb->get_var($wpdb->prepare('select recipe_image from `tbl_recipes` 
			where 
				`id` = %d', $id));
        @unlink(UPLOAD_PATH . 'recipe/' . $old_recipe_image);
        @unlink(UPLOAD_PATH . 'recipe/thumb/' . $old_recipe_image);

        $old_thumb_image = $wpdb->get_var($wpdb->prepare('select thumb_image from `tbl_recipes` 
			where 
				`id` = %d', $id));
        @unlink(UPLOAD_PATH . 'recipe/thumb/' . $old_thumb_image);
    }
    $cnt = $wpdb->get_var($wpdb->prepare('select count(*) from `tbl_recipe_comments` 
                where 
                    `recipe_id` = %d', $_POST['id']));
    $cnt1 = $wpdb->get_var($wpdb->prepare('select count(*) from `tbl_recipe_day` 
                where 
                    `recipe_id` = %d', $_POST['id']));
    if ($cnt > 0) {
        echo json_encode(array('status' => 'duplicate_comment'));
        exit();
    } elseif ($cnt1 > 0) {
        echo json_encode(array('status' => 'duplicate'));
        exit();
    } else {
        $condition = array('id' => $_POST['id']);
        if ($wpdb->delete('tbl_recipes', $condition)) {
            echo json_encode(array('status' => 'success'));
        } else 
            echo json_encode(array('status' => 'fail'));
    }
    exit();
}

function fn_ajax_list() {//list the records
    global $wpdb;
    $aColumns = array('`tbl_recipes`.`id`', 'title', '`tbl_recipe_categories`.`category`', 'directions', '`tbl_recipes`.`status`', 'created_on', 'updated_on');
    // $aColumns = array('`tbl_recipes`.`id`', 'title','`tbl_recipe_categories`.`category`', '`tbl_ingredients`.`ingredient`','other_recipes', 'related_recipes', 'directions', '`tbl_recipes`.`status`', 'created_on','updated_on','`tbl_recipe_categories`.`id`','`tbl_ingredients`.`id`');
    $aColumnsIndex = array('id', 'title', 'category', 'directions', 'status', 'created_on', 'updated_on', 'recipe_id', 'ingredients_id');
    $sIndexColumn = 'id';
    $sTable = "tbl_recipes";
    $sTable2 = "tbl_recipe_categories";
    $sTable3 = "tbl_ingredients";

    if (isset($aColumnsIndex)) {
        $cols = '';
        for ($i = 0; $i < count($aColumns); $i++) {
            $cols .= '' . $aColumns[$i] . ' as `' . $aColumnsIndex[$i] . '`, ';
        }
        $cols = substr_replace($cols, "", -2);
    }


    $sLimit = "";
    if (isset($_REQUEST['iDisplayStart']) && $_REQUEST['iDisplayLength'] != '-1') {
        $sLimit = "LIMIT " . intval($_REQUEST['iDisplayStart']) . ", " .
                intval($_REQUEST['iDisplayLength']);
    }

    $sOrder = "";
    if (isset($_REQUEST['iSortCol_0'])) {
        $sOrder = "ORDER BY  ";
        for ($i = 0; $i < intval($_REQUEST['iSortingCols']); $i++) {
            if ($_REQUEST['bSortable_' . intval($_REQUEST['iSortCol_' . $i])] == "true") {
                $sOrder .= "" . $aColumns[intval($_REQUEST['iSortCol_' . $i]) - 1] . " " .
                        ($_REQUEST['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
            }
        }

        $sOrder = substr_replace($sOrder, "", -2);
        if ($sOrder == "ORDER BY") 
            $sOrder = "";
    }

    $sWhere = "";
    $bindValues = array();
    if (isset($_REQUEST['sSearch']) && $_REQUEST['sSearch'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= "" . $aColumns[$i] . " LIKE %s OR ";
            $bindValues[] = '%%' . like_escape($_REQUEST['sSearch']) . '%%';
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }

    for ($i = 0; $i < count($aColumns); $i++) {
        if (isset($_REQUEST['bSearchable_' . $i]) && $_REQUEST['bSearchable_' . $i] == "true" && $_REQUEST['sSearch_' . $i] != '') {
            if ($sWhere == "") {
                $sWhere = "WHERE ";
            } else {
                $sWhere .= " AND ";
            }
            $sWhere .= "" . $aColumns[$i] . " LIKE %s ";
            $bindValues[] = '%%' . like_escape($_REQUEST['sSearch_' . $i]) . '%%';
        }
    }

    $sQuery = $wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS " . $cols . " FROM   $sTable
                   LEFT JOIN
            $sTable2
             
            ON ($sTable2.id = $sTable.recipe_category)
                
            LEFT JOIN 
            $sTable3
                
            ON ($sTable3.id = $sTable.ingredients)
                  $sWhere
                  $sOrder
                  $sLimit
               ", $bindValues);
    $rResult = $wpdb->get_results($sQuery, ARRAY_A);

    $sQuery = "SELECT FOUND_ROWS()";
    $rResultFilterTotal = $wpdb->get_results($sQuery, ARRAY_N);
    if (isset($rResultFilterTotal[0]))
        $iFilteredTotal = $rResultFilterTotal[0];
    else
        $iFilteredTotal = 0;

    $sQuery = "SELECT COUNT(`" . $sIndexColumn . "`) FROM   $sTable ";
    $rResultTotal = $wpdb->get_results($sQuery, ARRAY_N);
    if (isset($rResultTotal[0]))
        $iTotal = $rResultTotal[0];
    else
        $iTotal = 0;

    if (!isset($_REQUEST['sEcho']))
        $_REQUEST['sEcho'] = 1;
    $output = array(
        "sEcho" => intval($_REQUEST['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );

    $row_no = intval($_REQUEST['iDisplayStart']);
    foreach ($rResult as $aRow) {
        $row = array();
        $row[] = ++$row_no;
        for ($i = 0; $i < count($aColumns); $i++) {
            if ($aColumnsIndex[$i] == "id") {
                $id = $aRow[$aColumnsIndex[$i]];
            }
            if ($aColumnsIndex[$i] == "status") {
                $row[] = ($aRow[$aColumnsIndex[$i]] == "Y") ? 'Active' : 'InActive';
            } else if ($aColumnsIndex[$i] != ' ') {
                $row[] = stripslashes_deep($aRow[$aColumnsIndex[$i]]);
            }
        }
        $row[] = '<a href="#" onclick="javascript:jQuery.fn.confirmEdit(' . $id . ');return false;" style="float:left;"><span class="ui-icon ui-icon-pencil"></span></a>' .
                '<a href="#" onclick="javascript:jQuery.fn.confirmDelete(' . $id . ');return false;"><span class="ui-icon ui-icon-closethick"></span></a>';
        $output['aaData'][] = $row;
    }

    echo json_encode($output);
    die();
}

function fn_ajax_upload() {

    $uploaddir = UPLOAD_PATH . 'tmp/';

    list($width, $height, $img_type) = @getimagesize($_FILES[0]['tmp_name']);

    if (!in_array($img_type, array(1, 2, 3)) || $_FILES[0]['size'] == 0) {

        echo json_encode(array('status' => 'fail', 'msg' => 'Image Not Valid'));
        exit();
    }

    $dest = time() . '-' . basename($_FILES[0]['name']);
    if (move_uploaded_file($_FILES[0]['tmp_name'], $uploaddir . $dest)) {
        $data = array('status' => 'success', 'recipe_image' => $dest);
    } else {
        $data = array('status' => 'fail', 'msg' => 'There was an error uploading your files');
    }
    echo json_encode($data);
    exit();
}

function fn_ajax_upload_thumb() {

    $uploaddir = UPLOAD_PATH . 'tmp/';
    list($width, $height, $img_type) = @getimagesize($_FILES[0]['tmp_name']);

    if (!in_array($img_type, array(1, 2, 3)) || $_FILES[0]['size'] == 0) {

        echo json_encode(array('status' => 'fail', 'msg' => 'Image Not Valid'));
        exit();
    }

    $dest = time() . '-' . basename($_FILES[0]['name']);
    if (move_uploaded_file($_FILES[0]['tmp_name'], $uploaddir . $dest)) {
        $data = array('status' => 'success', 'thumb_image' => $dest);
    } else {
        $data = array('status' => 'fail', 'msg' => 'There was an error uploading your files');
    }
    echo json_encode($data);
    exit();
}

