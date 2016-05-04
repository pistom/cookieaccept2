<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

class JFormFieldTextes extends JFormField {

    protected $type = 'Textes';


    public function getInput() {
        $jinput = JFactory::getApplication()->input;
        $items = $this->getTexts();
        // Wykona się po wysłaniu ajaxem wartości z dodanych imputów
        if($jinput->get('en-GB','','STR') != ''){
            
            $db = JFactory::getDbo();
            
            $query = $db->getQuery(true);
            
            $fields = array();
            foreach($items as $item){
                $query->clear();
                $query->update($db->quoteName('#__cookieaccept2'))
                    ->set(array($db->quoteName('message') . ' = ' . $db->quote($jinput->get($item->lang,'','STR'))))
                    ->where(array($db->quoteName('lang') . ' = ' . $db->quote($item->lang)));
                $db->setQuery($query);
                $db->execute();
            }
        }
        
       
        $html = '<hr /><div id="cookieaccept2_fields">
        <table><thead><tr><th>Language</th><th>Message</th><th>Accept button txt</th><th>More button txt</th><th>Article id</th></thead>
        <tbody>
        ';
        foreach($items as $item){
            $html .= '<tr class="cookieaccept2_language">';
            $html .= '<td><input style="width:50px;" type="text" name="'.$item->lang.'-lang" value="'.$item->lang.'" /></td>';
            $html .= '<td><input style="width:400px;" type="text" name="'.$item->lang.'-message" value="'.$item->message.'" /></td>';
            $html .= '<td><input style="width:100px;" type="text" name="'.$item->lang.'-accept_btn_label" value="'.$item->accept_btn_label.'" /></td>';
            $html .= '<td><input style="width:100px;" type="text" name="'.$item->lang.'-more_btn_label" value="'.$item->more_btn_label.'" /></td>';
            $html .= '<td><input style="width:40px;" type="text" name="'.$item->lang.'-more_btn_article" value="'.$item->more_btn_article.'" /></td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table><p style="margin-top:10px;"><a class="btn">Save</a></p></div><hr />
        
        <script>
             jQuery("form").on("submit", function(event) {
                 alert("test");
             });
            // Wysłać ajaxem wartości z dodanych inputów 
            // Zaktualizować inputy na nowe wartości
        
        </script>';
        return $html;
    }
    

    
    public function getLabel() {
		return 'Languages settings';
	}
    
    public function getTexts(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__cookieaccept2'); 
        $db->setQuery($query);
        $items = $db->loadObjectList();
        
        return $items;
    }
    
    
}