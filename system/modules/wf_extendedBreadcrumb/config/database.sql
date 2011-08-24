-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************


-- --------------------------------------------------------

--
-- Table `tl_module`
--

CREATE TABLE `tl_module` (
  `wf_extendedBreadcrumb_cutlength` int(10) NOT NULL default '20',
  `wf_extendedBreadcrumb_placeholder` varchar(64) NOT NULL default '',
  `wf_extendedBreadcrumb_delimiter` varchar(64) NOT NULL default '',
  `wf_extendedBreadcrumb_hidden` char(1) NOT NULL default '',  
  `wf_extendedBreadcrumb_rootpage` varchar(64) NOT NULL default '',
  `wf_extendedBreadcrumb_defineRoot` char(1) NOT NULL default '',
  `wf_extendedBreadcrumb_keywords` text NULL,
  `wf_extendedBreadcrumb_onlytitle` char(1) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_page`
--

CREATE TABLE `tl_page` (
  `wf_extendedBreadcrumb` char(1) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
