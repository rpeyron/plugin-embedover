<?php
/**
 * Plugin XSLT : Perform XSL Transformation on provided XML data
 * 
 * To be run with Dokuwiki only
 *
 * Sample data provided at the end of the file
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Rémi Peyronnet  <remi+xslt@via.ecp.fr>
 
    onmouseover : ouvre un popup au dessus, et affiche url contenant le texte

    {[url:mode!http://toto?value=]}
    {[url:mode!inline]}
    {[url:mode!wiki]}
    {[ignore:cam]}
    {[style:]}
    {[mode!texte|affiché]}

    tri dvd inversé (sort) 
    
    Shift + Refresh pour raffraichir sous firefox
 
 */
 
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
class syntax_plugin_embedover extends DokuWiki_Syntax_Plugin {

    public $urls = array();
    public $styles = array();
 
    function getInfo(){
      return array(
        'author' => 'Rémi Peyronnet',
        'email'  => 'remi+embedover@via.ecp.fr',
        'date'   => '2009-05-03',
        'name'   => 'EmbedOver Plugin',
        'desc'   => 'Embed in an overlay a remote web/wiki page',
        'url'    => 'http://people.via.ecp.fr/~remi/',
      );
    }
 
    function getType() { return 'substition'; }
    function getPType() { return 'normal'; }
    function getSort() { return 4212; }
    function connectTo($mode) { $this->Lexer->addSpecialPattern('{\([^}]*\)}',$mode,'plugin_embedover'); }

    function handle($match, $state, $pos, &$handler)
    { 
        switch ($state) {
          case DOKU_LEXER_SPECIAL :
                $data = '';
                // URLs
                if (preg_match('/{\(url\:((?<mode>.*)!)?(?<text>[^|]*)\)}/', $match, $matches))
                {
                    if (!$matches[mode]) $matches[mode] = 'default';
                    $this->urls[$matches[mode]] = $matches[text];
                    $data = '{[embedover_div]}';
                }
                // Style
                else if (preg_match('/{\(style\:((?<mode>.*)!)?(?<text>[^|]*)\)}/', $match, $matches))
                {
                    if (!$matches[mode]) $matches[mode] = 'default';
                    $this->styles[$matches[mode]] = $matches[text];
                }
                // Items
                else if (preg_match('/{\(((?<mode>.*)!)?(?<text>[^|]*)(\|(?<aff>.*))?\)}/', $match, $matches))
                {
                    if (!$matches[aff]) $matches[aff] = $matches[text];
                    if (!$matches[mode]) $matches[mode] = 'default';
                    $dest = $this->urls[$matches[mode]] . urlencode($matches[text]);
                    $style = $this->styles[$matches[mode]];
                    if ($matches[aff]) $data = "<span class='embedover' onclick='embedover_click(event, \"$dest\", \"$style\");'>${matches[aff]}</span>";
                }
                return array($state, $data);
 
          case DOKU_LEXER_UNMATCHED :  return array($state, $match);
          case DOKU_LEXER_ENTRY :          return array($state, '');
          case DOKU_LEXER_EXIT :            return array($state, '');
        }
        return array();
    }
    
    function render($mode, &$renderer, $data) 
    {
         if($mode == 'xhtml'){
            list($state, $match) = $data;
            switch ($state) {
              case DOKU_LEXER_SPECIAL :
                if ($match ==  '{[embedover_div]}')
                {
                    $renderer->doc .= "<iframe id='embedover_div' scrolling='no' marginwidth='0' marginheight='0' frameborder='0' vspace='0' hspace='0'></iframe>";
                }
                else
                {
                    $renderer->doc .= $match; 
                }
                break;
 
              case DOKU_LEXER_UNMATCHED :  $renderer->doc .= $renderer->_xmlEntities($match); break;
              case DOKU_LEXER_EXIT :       $renderer->doc .= ""; break;
            }
            return true;
        }
        return false;
    }
}


/*

Sample data :

*/

?>