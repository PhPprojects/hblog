<?php

namespace Apps\Common;

class EditArea {

    static public function create($_name,$options = array()) {
        $create_editor = '';
        if(!isset($options['syntax'])) {
            $options['syntax'] = 'php';
        }
        if(!isset($options['language'])) {
            $options['language'] = 'zh';
        }
        if (is_array($_name)) {
            // foreach ($_name as $value) {
            //     $options['textarea'] = $value;                
            //     $create_editor .= "var editor_$value = UE.getEditor('$value'," . json_encode($options) . ");";
            // }
        } else {
$create_editor = <<<EOF
editAreaLoader.init({
            id: "{$_name}"
            ,start_highlight: true
            ,allow_resize: "both"
            ,allow_toggle: true
            ,word_wrap: true
            ,font_size: "12"
            ,language: "{$options['language']}"            
            ,syntax_selection_allow: "css,html,js,php,python,xml,sql"
            ,syntax: "{$options['syntax']}"
        });
//,display: "later"
EOF;
        }
        $basePath = \hmvc\Web\Application::basePath().'/static/edit_area';

        $editor = <<<EOF
<script type="text/javascript" charset="utf-8" src="$basePath/edit_area_full.js"></script>
<script language="Javascript" type="text/javascript">       
	$create_editor
</script>                
EOF;

        return $editor;
    }

}
