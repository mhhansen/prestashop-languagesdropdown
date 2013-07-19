{*
 *  Block Languages Dropdown
 *  Based on default language module from PrestaShop 1.5.3.1
 *
 *  @author     Martin Hansen <martin.hansen@gmail.com>
 *  @license    http://opensource.org/licenses/MIT  The MIT License (MIT)
*}

<!-- Block languages module -->
{if count($languages) > 1}
<div id="languagesdropdown_block_top">
	<div id="countries">
		<select id="languagedropdown" onchange="setLanguage(this.value);">
			{foreach from=$languages key=k item=language name="languages"}
				{if $language.iso_code != $lang_iso}
					{assign var=indice_lang value=$language.id_lang}
				{else}
					{assign var=indice_lang value=false}
				{/if}

				{if $indice_lang && isset($lang_rewrite_urls.$indice_lang)}
					<option value="{$lang_rewrite_urls.$indice_lang|escape:htmlall}" {if $language.iso_code == $lang_iso}selected="selected"{/if}>{$language.name}</option>
				{else}
					<option value="{$link->getLanguageLink($language.id_lang)|escape:htmlall}" {if $language.iso_code == $lang_iso}selected="selected"{/if}>{$language.name}</option>
				{/if}

			{/foreach}
		</select>
	</div>
</div>

{/if}


<script type="text/javascript">

/**
 * Redirect to the right URL language.
 * Fired by <select> in blocklanguagesdropdown.tpl
 *
 * @TODO remove this inline script and include JS file in bootstrap file.
 *
 * @param string Language URL to switch
 */
function setLanguage(url_lang)
{
	if(!url_lang)
		return;

	window.location.href = url_lang;
}
</script>
<!-- /Block languages module -->
