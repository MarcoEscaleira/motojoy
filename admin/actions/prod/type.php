<?php
    require ('../../core/configActions.php');

    if (Input::exists()) {
        $cat_id = Input::get('cat_id');
        
        
        $types = Db::getInstance()->query("SELECT * FROM `typep` WHERE `cat_id` = $cat_id");
        
        if ($types->count()) {
            echo '
            <div class="form-group">
                <label for="type_id">Tipo</label><br>
                    <select class="custom-select" name="type_id" id="type_id" style="width:100%;">
                        <option selected disabled>Escolha uma categoria</option>';
            foreach ($types->results() as $type) {
                echo '<option value="'.$type->type_id.'">'.ucfirst($type->type_name).'</option>';
            }
            echo '</select>
            </div>';
        }
    }
?>