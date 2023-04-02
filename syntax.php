<?php
/**
 * Plugin vertical : Set "vertical-align: middle" to a table
 *
 * Syntax: <vertical>content</vertical>
 *         <vertical head>content</vertical>
 *         <vertical body>content</vertical>
 *
 * @author     Pavel Korotkiy (outdead)
 * @license    MIT (https://opensource.org/license/mit/)
 */

if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

class syntax_plugin_vertical extends DokuWiki_Syntax_Plugin {
    function getInfo(){
        return array(
            'author' => 'outdead',
            'email'  => 'paul.korotkiy@gmail.com',
            'date'   => '2023-04-01',
            'name'   => 'Vertical Plugin',
            'desc'   => 'Simple plugin to set "vertical-align: middle" to a table',
            'url'    => 'http://www.dokuwiki.org/plugin:vertical',
        );
    }

    function getType() {
        return 'container';
    }

    function getPType() {
        return 'normal';
    }

    function getAllowedTypes() {
        return array('container', 'substition', 'protected', 'disabled', 'formatting', 'paragraphs');
    }

    function getSort() {
        return 137;
    }

    function connectTo($mode) {
        $this->Lexer->addEntryPattern('<vertical[^>]*>(?=.*?</vertical>)', $mode, 'plugin_vertical');
    }

    function postConnect() {
        $this->Lexer->addExitPattern('</vertical>', 'plugin_vertical');
    }

    function handle($match, $state, $pos, $handler){
        switch ($state) {
            case DOKU_LEXER_ENTER:
                $data = strtolower(trim(substr($match, 9, -1)));
                $data = trim($data);
                return array($state, $data);
            case DOKU_LEXER_UNMATCHED :
                return array($state, $match);
            case DOKU_LEXER_EXIT :
                return array($state, '');
        }

        return false;
    }

    function render($mode, $renderer, $indata) {
        if ($mode == 'xhtml') {
            list($state, $match) = $indata;

            switch ($state) {
                case DOKU_LEXER_ENTER:
                    $class = "";
                    $instructions = explode(" ", htmlspecialchars($match));

                    foreach ($instructions as $instruction) {
                        $parts = explode("=", $instruction);

                        if (count($parts) != 2) {
                            continue;
                        }

                        $position = $parts[0];
                        $align = $parts[1];

                        if ($position != "head" && $position != "body") {
                            continue;
                        }

                        if ($align != "top" && $align != "center" && $align != "bottom") {
                            continue;
                        }

                        $class .= " vertical_${align}_${position}";
                    }

                    $class = trim($class);

                    $renderer->doc .= '<div class="'.$class.'">';
                    break;
                case DOKU_LEXER_UNMATCHED :
                    $renderer->doc .= $renderer->_xmlEntities($match);
                    break;
                case DOKU_LEXER_EXIT :
                    $renderer->doc .= "</div>";
                    break;
            }

            return true;
        }

        return false;
    }
}
