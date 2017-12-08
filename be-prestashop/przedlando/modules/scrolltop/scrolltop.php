<?php
/*
* PrestaShop module created by VEKIA, a guy from official PrestaShop community ;-)
*
* @author    VEKIA https://www.prestashop.com/forums/user/132608-vekia/
* @copyright 2010-2016 VEKIA
* @license   This program is not free software and you can't resell and redistribute it
*
* CONTACT WITH DEVELOPER http://mypresta.eu
* support@mypresta.eu
*/

class scrolltop extends Module {
	
	public function __construct() {
		$this->name 		= 'scrolltop';
		$this->tab 			= 'front_office_features';
		$this->version 		= '1.4.1';
		$this->author 		= 'mypresta.eu';
		$this->displayName 	= $this->l('Scroll to top');
		$this->description 	= $this->l('Nice and modern button to scroll page to top');
		parent :: __construct();
        $this->trusted();
       
	}
	
	public function install() {
		return parent :: install()
            && $this->registerHook('footer')
            && $this->registerHook('header')
            && Configuration::updateValue('st_color','1')
            && Configuration::updateValue('st_x','50px')
            && Configuration::updateValue('st_y','50px')
            && Configuration::updateValue('st_o','0.35')
            ;
	}

    function trusted() {
        if(_PS_VERSION_ >= "1.6.0.8") {
            if(isset($_GET['controller'])) {
                if($_GET['controller'] == "AdminModules") {
                    if(_PS_VERSION_ >= "1.6.0.8") {
                        if(isset($_GET['controller'])) {
                            if($_GET['controller'] == "AdminModules") {
                                $this->context->controller->addJS(($this->_path).'trusted.js', 'all');
                            }
                        }
                    }
                }
            }
        }
        if(defined('_PS_HOST_MODE_')) {
            if(isset($_GET['controller'])) {
                if($_GET['controller'] == "AdminModules") {
                    if(defined('self::CACHE_FILE_TRUSTED_MODULES_LIST') == true) {
                        $context = Context::getContext();
                        $theme = new Theme($context->shop->id_theme);
                        $xml = simplexml_load_string(file_get_contents(_PS_ROOT_DIR_.self::CACHE_FILE_TRUSTED_MODULES_LIST));
                        if($xml) {
                            $css = $xml->modules->addChild('module');
                            $css->addAttribute('name', $this->name);
                            $xmlcode = $xml->asXML();
                            if(!strpos(file_get_contents(_PS_ROOT_DIR_.self::CACHE_FILE_TRUSTED_MODULES_LIST), $this->name))
                                if(file_exists(_PS_ROOT_DIR_.self::CACHE_FILE_TRUSTED_MODULES_LIST))
                                    file_put_contents(_PS_ROOT_DIR_.self::CACHE_FILE_TRUSTED_MODULES_LIST, $xmlcode);
                        }
                    }
                    if(defined('self::CACHE_FILE_DEFAULT_COUNTRY_MODULES_LIST') == true) {
                        $xml = simplexml_load_string(file_get_contents(_PS_ROOT_DIR_.self::CACHE_FILE_DEFAULT_COUNTRY_MODULES_LIST));
                        //$xml=new SimpleXMLElement('<modules/>');
                        //$cs=$xml->addChild('modules');
                        if($xml) {
                            $css = $xml->addChild('module');
                            $css->addChild('id', 0);
                            $css->addChild('name', "<![CDATA[".$this->name."]]>");
                            $xmlcode = $xml->asXML();
                            $xmlcode = str_replace('&lt;', "<", $xmlcode);
                            $xmlcode = str_replace('&gt;', ">", $xmlcode);
                            if(!strpos(file_get_contents(_PS_ROOT_DIR_.self::CACHE_FILE_DEFAULT_COUNTRY_MODULES_LIST), $this->name))
                                if(file_exists(_PS_ROOT_DIR_.self::CACHE_FILE_DEFAULT_COUNTRY_MODULES_LIST))
                                    file_put_contents(_PS_ROOT_DIR_.self::CACHE_FILE_DEFAULT_COUNTRY_MODULES_LIST, $xmlcode);
                        }
                    }
                }
            }
        }
    }

    public function advert(){
        return '<iframe src="//apps.facepages.eu/somestuff/whatsgoingon.html" width="100%" height="150" border="0" style="border:none;"></iframe>';
    }
     
	public function psversion() {
		$version=_PS_VERSION_;
		$exp=$explode=explode(".",$version);
		return $exp[1];
	}
    
    public function myfb(){
        return '<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Ffacebook.com%2Fmypresta&amp;send=false&amp;layout=button_count&amp;width=120&amp;show_faces=true&amp;font=verdana&amp;colorscheme=light&amp;action=like&amp;height=21&amp;appId=276212249177933" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px; margin-top:10px;" allowTransparency="true"></iframe></div>';
    }
    
    
    public function getContent(){
        $output="";
        
        //categories functions
        if (isset($_POST['module_settings'])){
            Configuration::updateValue('st_y',Tools::getValue('st_y'));
            Configuration::updateValue('st_x',Tools::getValue('st_x'));
            Configuration::updateValue('st_o',Tools::getValue('st_o'));
            Configuration::updateValue('st_color',Tools::getValue('st_color'));
            $output .= '<div class="conf confirm"><img src="../img/admin/ok.gif" alt="" /></div>';   
        }        
                
       	$output.="";
        return $output.$this->displayForm();
    }
    
    public function displayForm(){
        $form='<form id="settingsform" action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data" >
                        <input type="hidden" name="settings" value="1"/>
                        <input type="hidden" name="selecttab" value="5"/>
        				<fieldset style="position:relative;">
        					<div style="display:block; clear:both; text-align:center; overflow:hidden;">
                                <div style="display:block; clear:both; margin-bottom:20px;">
        							<strong>'.$this->l('Color Scheme').'</strong><br/><br/>
                                    <select name="st_color">
                                        <option value="1" '.(Configuration::get('st_color')=='1' ? 'selected="yes"':'').'>'.$this->l('Dark').'</option>
                                        <option value="2" '.(Configuration::get('st_color')=='2' ? 'selected="yes"':'').'>'.$this->l('Light').'</option>
                                    </select>
        		                </div>
                                <div style="display:block; clear:both; margin-bottom:20px;">
                                    <strong>'.$this->l('Opacity').'</strong><br/><br/>
                                    <input type="text" name="st_o"  value="'.Configuration::get('st_o').'">
                                </div>
                                <div style="margin:auto; position:relative; background: #FFF url(\'../modules/scrolltop/position.png\') no-repeat center; display:block; clear:both; margin-bottom:20px; width:200px; height:200px; padding:10px; border:1px solid black;">
        							<strong>'.$this->l('definie position').'</strong><br/><br/>
                                    <input type="text" name="st_x"  value="'.Configuration::get('st_x').'" style="position:absolute; bottom:40px; left:40px; width:40px;">
                                    <input type="text" name="st_y"  value="'.Configuration::get('st_y').'" style="position:absolute; top:40px; right: 40px; width:40px;">
        		                </div>
                                <div style="margin-top:20px; clear:both; overflow:hidden; display:block; text-align:center">
                	               <input type="submit" name="module_settings" class="button" value="'.$this->l('save').'">
                	            </div>
        	                </div>
                       </fieldset>
               </form>';
            
        return $this->advert().$form.$this->myfb();
	}
    
    public function hookHeader($params){
        if ($this->psversion()==5 || $this->psversion()==6 || $this->psversion()==7){
            $this->context->controller->addCSS(($this->_path).'scrolltop.css', 'all');
            $this->context->controller->addJS(($this->_path).'scrolltop.js','all');
        } else {
            Tools::addCSS(($this->_path).'scrolltop.css');
            Tools::addJS(($this->_path).'scrolltop.js');
        }
    }
    
    
    // HOOKS
	public function hookFooter($params) {
		global $smarty;
        if ($this->psversion()==5 || $this->psversion()==6 || $this->psversion()==7){
            $smarty->assign(array('url' => $this->context->link->protocol_content.Tools::getMediaServer($this->name)._MODULE_DIR_.$this->name.'/'));
            $smarty->assign(array('stx' => Configuration::get('st_x')));
            $smarty->assign(array('sto' => Configuration::get('st_o')));
            $smarty->assign(array('sty' => Configuration::get('st_y')));
            $smarty->assign(array('stc' => Configuration::get('st_color')));
            
        } else {
            $this->context = new StdClass();
            $this->context->link = new Link();
            $smarty->assign(array('url' => $this->context->link->protocol_content._MODULE_DIR_.$this->name.'/'));
            $smarty->assign(array('stx' => Configuration::get('st_x')));
            $smarty->assign(array('sto' => Configuration::get('st_o')));
            $smarty->assign(array('sty' => Configuration::get('st_y')));
            $smarty->assign(array('stc' => Configuration::get('st_color')));
        }
        
        
		return $this->display(__FILE__, 'footer.tpl');
	}        
	
}