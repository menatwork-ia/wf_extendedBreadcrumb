<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Andi Platen, MEN AT WORK
 * @package    wf_extendedBreadcrumb
 * @license    GNU/LGPL
 * @filesource
 */

/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['wf_extendedBreadcrumb_rootpage'] = array
(
	'label'                	=> &$GLOBALS['TL_LANG']['tl_module']['wf_extendedBreadcrumb_rootpage'],
	'inputType'            	=> 'pageTree',
	'search'               	=> false,
	'eval'                 	=> array('fieldType'=>'radio', 'tl_class'=>'clr')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['wf_extendedBreadcrumb_defineRoot'] = array
(
	'label'					=> &$GLOBALS['TL_LANG']['tl_module']['wf_extendedBreadcrumb_defineRoot'],
	'inputType'				=> 'checkbox',
	'eval'					=> array('submitOnChange'=>true,'tl_class'=>'clr w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['wf_extendedBreadcrumb_delimiter'] = array
(
	'label'            		=> &$GLOBALS['TL_LANG']['tl_module']['wf_extendedBreadcrumb_delimiter'],
	'default'          		=> '>',
	'inputType'        		=> 'text',
	'search'           		=> false,
	'eval'             		=> array('mandatory'=>true, 'maxlength'=>64, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['wf_extendedBreadcrumb_cutlength'] = array
(
	'label'       			=> &$GLOBALS['TL_LANG']['tl_module']['wf_extendedBreadcrumb_cutlength'],
	'default'     			=> '20',
	'inputType'   			=> 'text',
	'search'      			=> false,
	'eval'        			=> array('maxlength'=>3, 'rgxp'=>'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['wf_extendedBreadcrumb_placeholder'] = array
(
	'label'        			=> &$GLOBALS['TL_LANG']['tl_module']['wf_extendedBreadcrumb_placeholder'],
	'default'      			=> '...',
	'inputType'    			=> 'text',
	'search'       			=> false,
	'eval'         			=> array('maxlength'=>5, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['wf_extendedBreadcrumb_keywords'] = array
(
	'label'        			=> &$GLOBALS['TL_LANG']['tl_module']['wf_extendedBreadcrumb_keywords'],
	'inputType'    			=> 'text',
	'search'       			=> false,
	'eval'         			=> array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['wf_extendedBreadcrumb_hidden'] = array
(
	'label'        			=> &$GLOBALS['TL_LANG']['tl_module']['wf_extendedBreadcrumb_hidden'],
	'inputType'    			=> 'checkbox',
	'exclude'      			=> true,
	'search'       			=> false,
	'eval'         			=> array('tl_class'=>'clr')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['wf_extendedBreadcrumb_onlytitle'] = array
(
	'label'         		=> &$GLOBALS['TL_LANG']['tl_module']['wf_extendedBreadcrumb_onlytitle'],
	'inputType'     		=> 'checkbox',
	'exclude'       		=> true,
	'search'        		=> false
);

$GLOBALS['TL_DCA']['tl_module']['fields']['wf_extendedBreadcrumb_hideOnFirstLevel'] = array
(
	'label'         		=> &$GLOBALS['TL_LANG']['tl_module']['wf_extendedBreadcrumb_hideOnFirstLevel'],
	'inputType'     		=> 'checkbox',
	'exclude'       		=> true,
	'search'        		=> false
);


// add palettes to tl_module
$GLOBALS['TL_DCA']['tl_module']['palettes']['wf_extendedBreadcrumb'] = '{title_legend},name,headline,type;{wf_extendedBreadcrumb_config},wf_extendedBreadcrumb_delimiter,wf_extendedBreadcrumb_cutlength,wf_extendedBreadcrumb_placeholder,wf_extendedBreadcrumb_keywords,wf_extendedBreadcrumb_hidden,wf_extendedBreadcrumb_hideOnFirstLevel,wf_extendedBreadcrumb_onlytitle;{wf_extendedBreadcrumb_startpage},wf_extendedBreadcrumb_defineRoot;{protected_legend},protected;{expert_legend},align,space,cssID';

// extend selector
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'wf_extendedBreadcrumb_defineRoot';

// extend subpalettes
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['wf_extendedBreadcrumb_defineRoot'] = 'wf_extendedBreadcrumb_rootpage';


?>