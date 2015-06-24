<?php
//if there are errors
if (isset($errors)) {
    echo error_template($errors);
} else {
    echo info_template('Use form on the left to select the report you want to generate');

    //print_array($all_post_params);
}

