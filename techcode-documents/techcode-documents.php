<?php
/**
 * @package techcode-slider
 * @version 1.0
 * Date: 20.02.2017
 * Time: 11:00
 */

/*
 * Plugin Name: Система списков документов techcode
 * Plugin URI: www.kondraland.ru
 * Description: Плагин для списков документов
 * Armstrong: coding is art
 * Author: Krivoshchekov Artem
 * Version: 1.0
 * Author URI: www.kondraland.ru
 */


function techcode_add_admin_pages()
{
    add_options_page('Настройки документов', 'Документы', 8, 'techcode-documents', 'techcode_documents_options_page');
}


function techcode_documents_options_page()
{
    echo '<h2>Настройка документов techcode</h2>';
    echo '<p>Автор плагина: <a href="https://vk.com/justahuman">Кривощеков Артем</a></p>';
    echo '<strong><p>Внимание! На страницах сайта будут отображаться только первые 9 документов</p></strong>';

    echo '<h3>Глобальные настройки</h3>';
    techcode_documents_change_settings();

    // выводим форму добавления нового документа
    echo '<h3>Добавить новый документ</h3>';
    techcode_add_document();

    // выводим все доступные документы на редактирование
    echo '<h3>Добавленные документы</h3>';
    techcode_show_edit_documents();
}

function techcode_documents_change_settings() {
    if(isset($_POST['techcode_change_settings_btn'])) {
        if (function_exists('current_user_can') &&
            !current_user_can('manage_options')
        )
            die(_e('HACKER?', 'techcode'));

        if (function_exists('check_admin_referer'))
            check_admin_referer('techcode_change_settings');

        var_dump($_POST);

        delete_option('techcode_document_form_id');
        delete_option('techcode_document_form_class');
        delete_option('techcode_document_entry_id');
        delete_option('techcode_document_entry_class');
        delete_option('techcode_document_paragraph_class');

        add_option('techcode_document_form_id', $_POST['techcode_document_form_id']);
        add_option('techcode_document_form_class', $_POST['techcode_document_form_class']);
        add_option('techcode_document_entry_id', $_POST['techcode_document_entry_id']);
        add_option('techcode_document_entry_class', $_POST['techcode_document_entry_class']);
        add_option('techcode_document_paragraph_class', $_POST['techcode_document_paragraph_class']);

        echo 'check' . get_option('techcode_document_entry_id');
    }


    echo '
        <form name="techcode_change_settings" method="post" action="' . $_SERVER['PHP_SELF'] . '?page=techcode-documents&amp;created=true">
        ';

    if (function_exists('wp_nonce_field'))
        wp_nonce_field('techcode_change_settings');

    $techcode_document_form_id = get_option('techcode_document_form_id');
    $techcode_document_form_class = get_option('techcode_document_form_class');
    $techcode_document_entry_id = get_option('techcode_document_entry_id');
    $techcode_document_entry_class = get_option('techcode_document_entry_class');
    $techcode_document_paragraph_class = get_option('techcode_document_paragraph_class');


    echo '
    <table>
    <tr>
        <td style="text-align: right">Идентификатор формы</td>
        <td><input type="text" name="techcode_document_form_id" value="'.$techcode_document_form_id.'"></td>
    </tr>
    <tr>
        <td style="text-align: right">Класс формы</td>
        <td><input type="text" name="techcode_document_form_class" value="'.$techcode_document_form_class.'"></td>
    </tr>
    <tr>
        <td style="text-align: right">Идентификатор элемента списка</td>
        <td><input type="text" name="techcode_document_entry_id" value="'.$techcode_document_entry_id.'"></td>
    </tr>
    <tr>
        <td style="text-align: right">Класс элемента списка</td>
        <td><input type="text" name="techcode_document_entry_class" value="'.$techcode_document_entry_class.'"></td>
    </tr>
    <tr>
        <td style="text-align: right">Класс абзаца списка</td>
        <td><input type="text" name="techcode_document_paragraph_class" value="'.$techcode_document_paragraph_class.'"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>
            <input type="submit" name="techcode_change_settings_btn" value="Сохранить настройки" style="width: 200px"/>
        </td>
    </tr>
    
    </table>';

    echo '</form>';
}

function techcode_add_document() {

    if(isset($_POST['techcode_add_document_btn'])) {
        if (function_exists('current_user_can') &&
            !current_user_can('manage_options')
        )
            die(_e('HACKER?', 'techcode'));

        if (function_exists('check_admin_referer'))
            check_admin_referer('techcode_add_document');

        $document_order = $_POST['techcode_document_order'];
        $document_name = $_POST['techcode_document_name'];
        $document_link = $_POST['techcode_document_link'];

        delete_option('techcode_document_name_' . $document_order);
        delete_option('techcode_document_link_' . $document_order);

        add_option('techcode_document_name_' . $document_order, $document_name);
        add_option('techcode_document_link_' . $document_order, $document_link);
    }

    echo '
        <form name="techcode_add_document" method="post" action="' . $_SERVER['PHP_SELF'] . '?page=techcode-documents&amp;created=true">
        ';

    if (function_exists('wp_nonce_field'))
        wp_nonce_field('techcode_add_document');


    echo '
        <table>
        <tr>
            <td style="text-align: right">Название документа</td>
            <td><input type="text" name="techcode_document_name"></td>
        </tr>
        <tr>
            <td style="text-align: right">Ссылка на документ</td>
            <td><input type="text" name="techcode_document_link"></td>
        </tr>
        <tr>
            <td style="text-align: right">Позиция в списке</td>
            <td><select name="techcode_document_order">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="submit" name="techcode_add_document_btn" value="Добавить документ" style="width: 140px"/>
            </td>
        </tr>
        </table>
    ';

    echo '</form>';
}

function check_selected($index, $index_original) {
    if($index == $index_original)
        return 'selected';
    else {
        return '';
    };
}

function techcode_show_edit_documents() {
    if(isset($_POST['techcode_edit_document_btn'])) {
        if (function_exists('current_user_can') &&
            !current_user_can('manage_options')
        )
            die(_e('HACKER?', 'techcode'));

        if (function_exists('check_admin_referer'))
            check_admin_referer('techcode_edit_document');

        $index_origin = $_POST['techcode_document_order_origin'];
        $index = $_POST['techcode_document_order'];

        $document_name = $_POST['techcode_document_name'];
        $document_link = $_POST['techcode_document_link'];

        delete_option('techcode_document_name_'.$index_origin);
        delete_option('techcode_document_link_'.$index_origin);

        add_option('techcode_document_name_'.$index, $document_name);
        add_option('techcode_document_link_'.$index, $document_link);

    }

    if(isset($_POST['techcode_delete_document_btn'])) {
        if (function_exists('current_user_can') &&
            !current_user_can('manage_options')
        )
            die(_e('HACKER?', 'techcode'));

        if (function_exists('check_admin_referer'))
            check_admin_referer('techcode_edit_document');

        $index_origin = $_POST['techcode_document_order_origin'];
        delete_option('techcode_document_name_'.$index_origin);
        delete_option('techcode_document_link_'.$index_origin);
    }

    $index = 9;

    do {
        $document_name = get_option('techcode_document_name_'.$index);
        if(!$document_name) {
            $index = $index - 1;
            continue;
        }


        $document_link = get_option('techcode_document_link_'.$index);

        echo '
        <form name="techcode_edit_document" method="post" action="' . $_SERVER['PHP_SELF'] . '?page=techcode-documents&amp;created=true">
        ';

        if (function_exists('wp_nonce_field'))
            wp_nonce_field('techcode_edit_document');


        echo '
            <table>
            <tr>
                <td style="text-align: right">Название документа</td>
                <td><input type="text" name="techcode_document_name" value="'.$document_name.'"></td>
            </tr>
            <tr>
                <td style="text-align: right">Ссылка на документ</td>
                <td><input type="text" name="techcode_document_link" value="'.$document_link.'"></td>
            </tr>
            <tr>
                <td style="text-align: right">Позиция в списке</td>
                <td>
                <select name="techcode_document_order">
                    <option value="0"'. check_selected(0, $index) .'>0</option>
                    <option value="1"'. check_selected(1, $index) .'>1</option>
                    <option value="2"'. check_selected(2, $index) .'>2</option>
                    <option value="3"'. check_selected(3, $index) .'>3</option>
                    <option value="4"'. check_selected(4, $index) .'>4</option>
                    <option value="5"'. check_selected(5, $index) .'>5</option>
                    <option value="6"'. check_selected(6, $index) .'>6</option>
                    <option value="7"'. check_selected(7, $index) .'>7</option>
                    <option value="8"'. check_selected(8, $index) .'>8</option>
                </select>
                
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="techcode_document_order_origin" value="'.$index.'">
                </td>
                <td>
                    <input type="submit" name="techcode_edit_document_btn" value="Изменить документ" style="width: 140px"/>
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>
                <td>
                    <input type="submit" name="techcode_delete_document_btn" value="Удалить документ" style="width: 140px"/>
                </td>
            </tr>
            </table><hr/>
        ';

        echo '</form>';

        $index = $index - 1;
    } while($index > 0);


}

function techcode_display_documents()
{
    $techcode_document_form_id = get_option('techcode_document_form_id');
    $techcode_document_form_class = get_option('techcode_document_form_class');
    $techcode_document_entry_id = get_option('techcode_document_entry_id');
    $techcode_document_entry_class = get_option('techcode_document_entry_class');
    $techcode_document_paragraph_class = get_option('techcode_document_paragraph_class');

    $result = "";

    $result.='<div id="'.$techcode_document_form_id.'" class="'.$techcode_document_form_class.'">';

    for($i=0; $i<9; $i++){

        $techcode_document_name = get_option('techcode_document_name_'.$i);
        $techcode_document_link = get_option('techcode_document_link_'.$i);

        $result.='<div id="'.$techcode_document_entry_id.'" class="'.$techcode_document_entry_class.'">';

        if(!empty($techcode_document_link))
            $result.='<a href="'.$techcode_document_link.'" target="_blank">';

        $result.='<p class="'.$techcode_document_paragraph_class.'">'.$techcode_document_name.'</p>';

        if(!empty($techcode_document_link))
            $result.='</a>';

        $result.='</div>';
    }

    $result.='</div>';
    return $result;

}

function techcode_documents_uninstall(){
    delete_option('techcode_document_form_id');
    delete_option('techcode_document_form_class');
    delete_option('techcode_document_entry_id');
    delete_option('$techcode_document_entry_class');

    for($i=0; $i<9; $i++) {
        delete_option('techcode_document_name_'.$i);
        delete_option('techcode_document_link_'.$i);
    }
}

add_shortcode('techcode-documents', 'techcode_display_documents');

//register_activation_hook(__FILE__, 'install');
register_deactivation_hook(__FILE__, 'techcode_documents_uninstall');

add_action('admin_menu', 'techcode_add_admin_pages');
//add_action('init', 'run');

