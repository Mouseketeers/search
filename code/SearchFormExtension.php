<?php 
class SearchFormExtension extends Extension {
	public static $useInlineLabel = true;
	public static $buttonLabel = '';
	function SearchForm() {
		$inlineLabel = (self::$useInlineLabel) ? _t('Search.InlineLabel', 'Enter search...') : '';
		//Requirements::javascript('jsparty/jquery/jquery-packed.js');
		Requirements::javascriptTemplate('search/javascript/search.js', array('InlineLabel' => $inlineLabel));
		$searchText = isset($_REQUEST['Search']) ? $_REQUEST['Search'] : '';
		$searcFieldValue = $searchText ? $searchText : $inlineLabel;
		$searchField = new TextField('Search', '', $searcFieldValue);
		$searchField->addExtraClass('InlineLabel');
		$fields = new FieldSet (
			$searchField
		);
		$actions = new FieldSet(
			new FormAction('Results', self::$buttonLabel ? self::$buttonLabel : _t('SearchForm.SEARCH', 'Search'))
		);
		$SearchForm = new SearchForm($this, 'SearchForm', $fields, $actions);
		//todo: use custom searchform that includes MetaDescription - return new CustomSearch($this, "SearchForm", $fields, $actions);
		if(Translatable::is_enabled()) {
			$locale = Translatable::get_current_locale();
			$search_page = Translatable::get_one_by_locale('SearchPage', $locale);
			if($search_page) {
				$search_page_url = $search_page->URLSegment;
			}
			else {
				return false;
			}
		}
		else $search_page_url = 'search';

		$SearchForm->setFormAction($search_page_url.'/SearchForm');
		$SearchForm->classesToSearch  = array('SiteTree');
		$SearchForm->getValidator()->setJavascriptValidationHandler('none');
		return $SearchForm;
	}
}
?>