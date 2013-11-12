<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Wf_extendedBreadcrumb
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'wf_extendedBreadcrumb' => 'system/modules/wf_extendedBreadcrumb/wf_extendedBreadcrumb.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_extended_breadcrumb' => 'system/modules/wf_extendedBreadcrumb/templates',
));
