/**
 *  Block Languages Dropdown
 *  Based on default language module from PrestaShop 1.5.3.1
 *
 *  @author     Martin Hansen <martin.hansen@gmail.com>
 *  @license    http://opensource.org/licenses/MIT  The MIT License (MIT)
 */


//@TODO include JS in hook
function setLanguage(url_lang)
{
    if(!url_lang)
        return;

    window.location.href = url_lang;
}