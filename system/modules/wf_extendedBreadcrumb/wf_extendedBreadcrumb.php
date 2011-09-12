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
 * Class wf_extendedBreadcrumb
 *
 * @copyright  MEN AT WORK
 * @package    Controller
 */
class wf_extendedBreadcrumb extends Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_extended_breadcrumb';

    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### EXTENDED BREADCRUMB ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'typolight/main.php?do=modules&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * Generate module
     */
    protected function compile()
    {
        mb_internal_encoding("UTF-8");
        
        global $objPage;

        //variables
        $arrPages = array();
        $arrItems = array();
        $intPageID = $objPage->id;

        //init core variables from database
        $intCutLength = $this->wf_extendedBreadcrumb_cutlength;
        $strPlaceholder = $this->wf_extendedBreadcrumb_placeholder;
        $intMaxLength = $intCutLength + strlen($strPlaceholder);
        $strRootPage = $this->wf_extendedBreadcrumb_rootpage;
        $arrKeywords = trimsplit(",", $this->wf_extendedBreadcrumb_keywords);
        $strCurrentPageTitle = $this->replaceInsertTags('{{env::page_title}}');
       
        //declare template variables
        $this->Template->delimiter = $this->wf_extendedBreadcrumb_delimiter;

        //Check if news, article, events
        $booArticle = strlen($this->Input->get('articles')) > 0;
        $booNews = strlen($this->Input->get('items')) > 0;
        $booEvents = strlen($this->Input->get('events')) > 0;

        //Load pages. This page plus all parents
        do
        {
            //DB load Site
            $objPages = $this->Database->prepare("SELECT * FROM tl_page WHERE id=?")
                            ->limit(1)
                            ->execute($intPageID);

            $strType = $objPages->type;
            $intPageID = $objPages->pid;
            $arrPages[] = $objPages->row();
            //Check if ID validate, if we reache root or ult is epmty
        }
        while ($intPageID > 0 && $strType != 'root' && $objPages->numRows);

        //Delete the last page if it the root page
        if ($strType == 'root')
        {
            array_pop($arrPages);
        }

        // Get start page
        if ($strRootPage)
        {
            $objStartPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=?")
                            ->limit(1)
                            ->execute($strRootPage);

            if (!in_array($objStartPage->row(), $arrPages))
            {
                $arrPages[] = $objStartPage->row();
            }
        }

        //--------------------------------------------------------------------//
        // Build breadcrumb menu

        for ($i = (count($arrPages) - 1); $i > 0; $i--)
        {
            //Check if hides should show, if none published should shown, or if flag is set
            if (($arrPages[$i]['hide'] && !$this->wf_extendedBreadcrumb_hidden) || $arrPages[$i]['wf_extendedBreadcrumb'] || (!$arrPages[$i]['published'] && !BE_USER_LOGGED_IN))
            {
                continue;
            }

            $class = "";

            //Check if pageTitle is set or "Only Title" is set
            if ($this->wf_extendedBreadcrumb_onlytitle != 1 && strlen($arrPages[$i]['pageTitle']) > 0)
            {
                //Cut PageTitle
                if (strlen($arrPages[$i]['pageTitle']) > $intMaxLength)
                {
                    $strTitle = mb_substr($arrPages[$i]['pageTitle'], 0, $intCutLength) . $strPlaceholder;
                }
                else
                {
                    $strTitle = $arrPages[$i]['pageTitle'];
                }

                //Save long title
                $strLongTitle = $arrPages[$i]['pageTitle'];
            }
            else
            {
                //Cut Title
                if (strlen($arrPages[$i]['title']) > $intMaxLength)
                {
                    $strTitle = mb_substr($arrPages[$i]['title'], 0, $intCutLength) . $strPlaceholder;
                }
                else
                {
                    $strTitle = $arrPages[$i]['title'];
                }

                //Save long title
                $strLongTitle = $arrPages[$i]['title'];
            }

            //Check keywords
            if (in_array($arrPages[$i]['title'], $arrKeywords) || in_array($arrPages[$i]['pageTitle'], $arrKeywords))
            {
                $class .= " highlight";
            }

            $arrItems[] = array
                (
                'isActive' => false,
                'href' => $this->generateFrontendUrl($arrPages[$i]),
                'title' => $strTitle,
                'longtitle' => $strLongTitle,
                'class' => $class
            );
        }

        //--------------------------------------------------------------------//
        // Active Page

        $class = "";

        //Check if pageTitle is set or "Only Title" is set
        if ($this->wf_extendedBreadcrumb_onlytitle != 1 && strlen($arrPages[$i]['pageTitle']) > 0)
        {
            //Cut PageTitle
            if (strlen($arrPages[$i]['pageTitle']) > $intMaxLength)
            {
                $strTitle = mb_substr($arrPages[$i]['pageTitle'], 0, $intCutLength) . $strPlaceholder;
            }
            else
            {
                $strTitle = $arrPages[$i]['pageTitle'];
            }

            //Save long title
            $strLongTitle = $arrPages[$i]['pageTitle'];
        }
        else
        {
            //Cut Title
            if (strlen($arrPages[$i]['title']) > $intMaxLength)
            {
                $strTitle = mb_substr($arrPages[$i]['title'], 0, $intCutLength) . $strPlaceholder;
            }
            else
            {
                $strTitle = $arrPages[$i]['title'];
            }

            //Save long title
            $strLongTitle = $arrPages[$i]['title'];
        }

        //Check keywords
        if (in_array($arrPages[$i]['title'], $arrKeywords) || in_array($arrPages[$i]['pageTitle'], $arrKeywords))
        {
            $class .= " highlight";
        }

        //If an article, news or event is open, set the page as inactive
        if ($booArticle || $booNews || $booEvents)
        {
            $arrItems[] = array
                (
                'isActive' => FALSE,
                'href' => $this->generateFrontendUrl($arrPages[$i]),
                'title' => $strTitle,
                'longtitle' => $strLongTitle,
                'class' => $class
            );
        }
        else
        {
            $arrItems[] = array
                (
                'isActive' => TRUE,
                'href' => $this->generateFrontendUrl($arrPages[$i]),
                'title' => $strTitle,
                'longtitle' => $strLongTitle,
                'class' => $class
            );
        }

        //--------------------------------------------------------------------//
        // Active article

        if ($booArticle)
        {
            //Load article
            $objArticle = $this->Database->prepare("SELECT * FROM tl_article WHERE alias = ?")
                            ->limit(1)
                            ->execute($this->Input->get('articles'));

            $class = "";

            //Cut article title
            if (strlen($objArticle->title) > $intMaxLength)
            {
                $strTitle = mb_substr($objArticle->title, 0, $intCutLength) . $strPlaceholder;
            }
            else
            {
                $strTitle = $objArticle->title;
            }

            //Check keywords
            if (in_array($objArticle->title, $arrKeywords))
            {
                $class .= " highlight";
            }

            $arrItems[] = array
                (
                'isActive' => TRUE,
                'href' => $this->generateFrontendUrl($objArticle->row()),
                'title' => $strTitle,
                'longtitle' => $objArticle->title,
                'class' => $class
            );
        }

        //--------------------------------------------------------------------//
        // Active news

        if ($booNews)
        {
            //Load news
            $objItems = $this->Database->prepare("SELECT * FROM tl_news WHERE alias = ?")
                            ->limit(1)
                            ->execute($this->Input->get('items'));

            //Style
            $class = "";

            //If db is empty, use the current page as active page
            if ($objItems->numRows == 0)
            {
                //Cut news title
                if (strlen($strCurrentPageTitle) > $intMaxLength)
                {
                    $strTitle = mb_substr($strCurrentPageTitle, 0, $intCutLength) . $strPlaceholder;
                }
                else
                {
                    $strTitle = $strCurrentPageTitle;
                }

                //Check keywords
                if (in_array($strCurrentPageTitle, $arrKeywords))
                {
                    $class .= " highlight";
                }
            }
            else
            {
                //Cut news title
                if (strlen($objItems->headline) > $intMaxLength)
                {
                    $strTitle = mb_substr($objItems->headline, 0, $intCutLength) . $strPlaceholder;
                }
                else
                {
                    $strTitle = $objItems->headline;
                }

                //Check keywords
                if (in_array($objItems->headline, $arrKeywords))
                {
                    $class .= " highlight";
                }
            }

            //Kick the last page, because foo-ready.html is epmty
            array_pop($arrItems);

            $arrItems[] = array
                (
                'isActive' => TRUE,
                'href' => $this->generateFrontendUrl($objItems->row()),
                'title' => $strTitle,
                'longtitle' => $objItems->headline,
                'class' => $class
            );
        }

        //--------------------------------------------------------------------//
        // Active event

        if ($booEvents)
        {
            //Load event
            $objEvent = $this->Database->prepare("SELECT * FROM tl_calendar_events WHERE alias = ?")
                            ->limit(1)
                            ->execute($this->Input->get('events'));

            //Style
            $class = "";

            //If db is empty, use the current page as active page
            if ($objEvent->numRows == 0)
            {
                //Cut news title
                if (strlen($strCurrentPageTitle) > $intMaxLength)
                {
                    $strTitle = mb_substr($strCurrentPageTitle, 0, $intCutLength) . $strPlaceholder;
                }
                else
                {
                    $strTitle = $strCurrentPageTitle;
                }

                //Check keywords
                if (in_array($strCurrentPageTitle, $arrKeywords))
                {
                    $class .= " highlight";
                }
            }
            else
            {

                //Cut event title
                if (strlen($objEvent->title) > $intMaxLength)
                {
                    $strTitle = mb_substr($objEvent->title, 0, $intCutLength) . $strPlaceholder;
                }
                else
                {
                    $strTitle = $objEvent->title;
                }

                //Check keywords
                if (in_array($objEvent->title, $arrKeywords))
                {
                    $class .= " highlight";
                }
            }

            //Kick the last page, because foo-ready.html is epmty
            array_pop($arrItems);

            $arrItems[] = array
                (
                'isActive' => TRUE,
                'href' => $this->generateFrontendUrl($objEvent->row()),
                'title' => $strTitle,
                'longtitle' => $objEvent->title,
                'class' => $class
            );
        }

        //Set first an Last
        if (count($arrItems))
        {
            $intLength = count($arrItems);

            $arrItems[0]['class'] .= " first";
            $arrItems[$intLength - 1]['class'] .= " last";
        }

        $this->Template->items = $arrItems;
    }

}

?>
