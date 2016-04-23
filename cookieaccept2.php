<?php
// no direct access
defined( '_JEXEC' ) or die;


class plgSystemCookieaccept2 extends JPlugin
{
	private $app;
	private $doc;
	private $cookieaccept2HTML = '';
	private $getCookieaccept2 = false;
	private $lang;
	private $texts;

	public function __construct(&$subject, $params ) {
		$this->app = &JFactory::getApplication();
		$this->doc = &JFactory::getDocument();
		$this->getValCookieaccept2 = $this->app->input->get('cookieaccept2',false,'INT');
		$this->lang = JFactory::getLanguage()->getTag();
		
		// Get texts from db
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
				->select($db->quoteName(array('message','accept_btn_label','more_btn_label','more_btn_article')))
				->from($db->quoteName('#__cookieaccept2'))
				->where('lang = ' . $db->Quote($this->lang));
		$db->setQuery($query);
		$result = $db->loadObjectList();
		if(count($result) != 0){
			$this->texts = $result[0];
		} else {
			$query = $db->getQuery(true)
					->select($db->quoteName(array('message','accept_btn_label','more_btn_label','more_btn_article')))
					->from($db->quoteName('#__cookieaccept2'))
					->where('lang = ' . $db->Quote('en-GB'));
			$db->setQuery($query);
			$this->texts = $db->loadObjectList()[0];
		};

		parent::__construct( $subject, $params );
	}
	
	public function setCookieaccept2HTML($deleteCookieBtn) {
		if($deleteCookieBtn) {
			// Generate remove cookie btn. 
			$html = '<a class="cookieaccept2__removeBtn" href="'.JURI::current().'?cookieaccept2=1">Remove Cookie</a>';
		}
		else {
			// Generate accept cookie btn.
			$moreBtn = '';
			if($this->params->get('more_btn')){
				$url = rtrim(JUri::base(), '/') . JRoute::_(ContentHelperRoute::getArticleRoute( $this->texts->more_btn_article ));
				$moreBtn = '<a class="cookieaccept2__moreBtn" href="'.$url.'">'.$this->texts->more_btn_label.'</a>';
			}
			$html = '
			<div class="cookieaccept2">
				<div class="cookieaccept2__message">'.
					$this->texts->message.
					$moreBtn.
				'<a class="cookieaccept2__acceptBtn" href="'.JURI::current().'?cookieaccept2=2">'.$this->texts->accept_btn_label.'</a>
				</div>
			</div>
			';	
		}
		$this->cookieaccept2HTML = $html;
	}
	
	public function getCookieaccept2HTML() {
		return $this->cookieaccept2HTML;
	}
	
	public function addCookieAlert($deleteCookieBtn = false) {
		// If $deleteCookieBtn is true, generate remove cookie button
		$this->setCookieaccept2HTML($deleteCookieBtn);		
		$content = $this->app->getBody();
		$content = str_replace("</body>", $this->getCookieaccept2HTML()."\r</body>", $content);
		JFactory::getApplication()->setBody($content);
	}
	
	public function addJS(){
		$js = file_get_contents(dirname(__FILE__)."/cookieaccept2.js");
		$jsDevelop;
		$isDevelop = $this->params->get('develop');
		if($isDevelop)
			$jsDevelop = file_get_contents(dirname(__FILE__)."/cookieaccept2.dev.js");
			
		$this->doc->addScriptDeclaration($jsDevelop.$js.'
			if (window.jQuery) {  
				jQuery(document).ready(function(){cookieAccept2("'.JURI::current().'",true,'.$isDevelop.');}) 
			} else {
				document.addEventListener("DOMContentLoaded", function(){cookieAccept2("'.JURI::current().'",false)});
			}
		');
	}
	public function addCSS(){
		$css = file_get_contents(dirname(__FILE__)."/cookieaccept2.css");
		$this->doc->addStyleDeclaration($css);
	}
	
	function onBeforeCompileHead() {
		$this->addCSS();	
		$this->addJS();
	}
	
	function onAfterRender() {

		// Only on front-end.
		if ($this->app->isSite()) {
			
			// If cookie is not set.
			if (!isset($_COOKIE['cookieaccept2'])) {

				// If accept btn clicked ('cookieaccept2' value in $_GET exists).
				if($this->getValCookieaccept2) {
					// Set cookie.
					if($this->getValCookieaccept2 == 2){	
						setcookie("cookieaccept2", "yes", time()+3600*24*365, "/");
							$this->addCookieAlert(true);
					}
					if($this->getValCookieaccept2 == 1){
						$this->addCookieAlert();
					}
				}
				
				// Display standard Alert
				else {
					$this->addCookieAlert();
				}
			}
			
			// If cookie is set
			else {
				// If develop mode is enabled
				if($this->params->get('develop')){
					// Remove cookie.
					if($this->getValCookieaccept2) {	
						if($this->getValCookieaccept2 == 1){
							setcookie('cookieaccept2', '', time()-300, "/");
							$this->addCookieAlert();
						}
						if($this->getValCookieaccept2 == 2){
							$this->addCookieAlert(true);
						}	
					}
					else {
						$this->addCookieAlert(true);
					}
				}
			}
		}
		return true;
	}
	
}

?>