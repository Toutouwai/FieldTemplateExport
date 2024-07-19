<?php namespace ProcessWire;

class FieldTemplateExport extends WireData implements Module {

	/**
	 * Ready
	 */
	public function ready() {
		$this->addHookAfter('ProcessField::buildEditForm, ProcessTemplate::buildEditForm', $this, 'modifyEditForm');
	}

	/**
	 * After ProcessTemplate::buildEditForm
	 *
	 * @param HookEvent $event
	 */
	protected function modifyEditForm(HookEvent $event) {
		$process = $event->object;
		/** @var InputfieldForm $form  */
		$form = $event->return;
		$modules = $event->wire()->modules;
		$config = $this->wire()->config;

		if($process instanceof ProcessField) {
			// ProcessField
			$item = $process->getField();
			$label = $this->_('Field export data');
		} else {
			// ProcessTemplate
			$item = $event->arguments(0);
			$label = $this->_('Template export data');
		}

		// Add module assets
		$info = $modules->getModuleInfo($this);
		$version = $info['version'];
		$config->scripts->add($config->urls->$this . "$this.js?v=$version");

		// Get "Basics" tab
		$basics = $form->children->first();

		// Add textarea
		/** @var InputfieldTextarea $f */
		$f = $modules->get('InputfieldTextarea');
		$f->label = $label;
		$f->icon = 'files-o';
		$f->value = wireEncodeJSON($item->getExportData(), true, true);
		$f->addClass('noAutosize fte-select-on-focus');
		$f->collapsed = Inputfield::collapsedYes;
		$basics->add($f);
	}

}
