<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

class JFormFieldTextes extends JFormField {

    protected $type = 'Textes';
    
    public function __construct($config = array())
	{
		parent::__construct($config);
	}

    public function getInput() {
        
        $items = $this->getTexts();
        $html = '';
        foreach($items as $item){
            $html .= '<input type="text" name="'.$item->lang.'" value="'.$item->lang.'" />';
        }
        return $html;
    }
    
    public function setForm(){
       
    }
    
    public function getLabel() {
		return 'Label';
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