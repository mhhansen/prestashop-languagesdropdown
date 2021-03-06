<?php
/**
 *  Block Languages Dropdown
 *  Based on default language module from PrestaShop 1.5.3.1
 *
 *  @author     Martin Hansen <martin.hansen@gmail.com>
 *  @license    http://opensource.org/licenses/MIT  The MIT License (MIT)
 */


if (!defined('_PS_VERSION_'))
	exit;

class BlockLanguagesDropdown extends Module
{
	public function __construct()
	{
		$this->name = 'blocklanguagesdropdown';
		$this->tab = 'front_office_features';
		$this->version = 0.1;
		$this->author = 'EMEICH';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = $this->l('Language block');
		$this->description = $this->l('Adds a block for selecting a language.');
	}

	public function install()
	{
		return (parent::install() && $this->registerHook('top') && $this->registerHook('header'));
	}

	private function _prepareHook($params)
	{
		$languages = Language::getLanguages(true, $this->context->shop->id);
		if (!count($languages))
			return false;
		$link = new Link();

		if ((int)Configuration::get('PS_REWRITING_SETTINGS'))
		{
			$default_rewrite = array();
			if (Dispatcher::getInstance()->getController() == 'product' && ($id_product = (int)Tools::getValue('id_product')))
			{
				$rewrite_infos = Product::getUrlRewriteInformations((int)$id_product);
				foreach ($rewrite_infos as $infos)
					$default_rewrite[$infos['id_lang']] = $link->getProductLink((int)$id_product, $infos['link_rewrite'], $infos['category_rewrite'], $infos['ean13'], (int)$infos['id_lang']);
			}

			if (Dispatcher::getInstance()->getController() == 'category' && ($id_category = (int)Tools::getValue('id_category')))
			{
				$rewrite_infos = Category::getUrlRewriteInformations((int)$id_category);
				foreach ($rewrite_infos as $infos)
					$default_rewrite[$infos['id_lang']] = $link->getCategoryLink((int)$id_category, $infos['link_rewrite'], $infos['id_lang']);
			}

			if (Dispatcher::getInstance()->getController() == 'cms' && (($id_cms = (int)Tools::getValue('id_cms')) || ($id_cms_category = (int)Tools::getValue('id_cms_category'))))
			{
				$rewrite_infos = (isset($id_cms) && !isset($id_cms_category)) ? CMS::getUrlRewriteInformations($id_cms) : CMSCategory::getUrlRewriteInformations($id_cms_category);
				foreach ($rewrite_infos as $infos)
				{
					$arr_link = (isset($id_cms) && !isset($id_cms_category)) ?
						$link->getCMSLink($id_cms, $infos['link_rewrite'], null, $infos['id_lang']) :
						$link->getCMSCategoryLink($id_cms_category, $infos['link_rewrite'], $infos['id_lang']);
					$default_rewrite[$infos['id_lang']] = $arr_link;
				}
			}


			$this->smarty->assign('lang_rewrite_urls', $default_rewrite);

		}
		return true;
	}

	/**
	* Returns module content for header
	*
	* @param array $params Parameters
	* @return string Content
	*/
	public function hookTop($params)
	{
		if (!$this->_prepareHook($params))
			return;

        return $this->display(__FILE__, 'blocklanguagesdropdown.tpl');
	}

	public function hookHeader($params)
	{
		$this->context->controller->addCSS($this->_path.'css/blocklanguagesdropdown.css', 'all');
	}
}


