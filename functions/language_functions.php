<?php
function prepareLanguagePost($language_fields) {
    global $db;
    $diller=getLanguages();
    if(count($diller)>0) {
        $lang_arr = [];
        foreach ($diller as $dil) {
            $code=$dil["language_code"];
            foreach ($language_fields as $field) {
                $field_arr = [
                    $field."_".$code => $_POST[$field."_".$code]
                ];
                $lang_arr +=$field_arr;
            }
        }
    }
    return $lang_arr;
}

function postDefaultLangugage($field,$overridelanguage=NULL) {
    global $db;
    if(is_null($overridelanguage)) $default_lng = getConfig()["default_lang"];
    else $default_lng = $overridelanguage;
    return $_POST[$field."_".$default_lng];
}

