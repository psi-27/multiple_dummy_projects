<?php
// Define The Namespace For Our Library
namespace VmStoreTemplate;


// import required joomla libraries
use \Joomla\CMS\Factory as JFactory;
use \Joomla\CMS\Language\LanguageHelper as JLanguageHelper;
use \Joomla\CMS\Uri\Uri as JURI;

jimport('joomla.filesystem.file');


// Joomla Security Check - no direct access to this file
// Prevents File Path Exposure
defined('_JEXEC') or die('Restricted access');

class VmStoreTemplate
{
    /**
     * @var VmStoreTemplate[]
     * @since 3.8.4
     */
    protected static $instance = array ();
    protected $platformName;


    // site information
    protected $templateName;
    protected $websiteLanguageOrientation;
    protected $websiteDirection;
    protected $websiteHeadArea = array ();
    protected $sitePath;
    protected $rootPath;


    /**
     * Return an instance of the Class "VmStoreTemplate"
     *
     * @param string $forPlatformName (cms name like 'joomla' or 'wordpress')
     *
     * @return VmStoreTemplate
     *
     * @since 3.8.4
     */
    public static function getInstance ($forPlatformName = 'joomla')
    {
        $forPlatformName = strtolower($forPlatformName);

        if (!isset(static::$instance[$forPlatformName]))
        {
            static::$instance[$forPlatformName] = new VmStoreTemplate($forPlatformName);
        }

        return static::$instance[$forPlatformName];
    }

    /**
     * VmStoreTemplate constructor.
     *
     * @param $platformName
     *
     * @since 3.8.4
     */
    private function __construct ($platformName)
    {
        // set the platform name (i.e. joomla or wordpress)
        $this->setPlatformName($platformName);

        // Set The Site Path (Domain)
        $this->setSitePath();

        // Set The Root Path (Absolute Server Path To Joomla Installation)
        $this->setRootPath();

        // set the template name
        try
        {
            $this->setTemplateName();
        } catch (\Exception $e)
        {
            echo 'Exception abgefangen: ', $e->getMessage(), "\n";
        }

        // set the website language orientation
        $this->setWebsiteLanguageOrientation();

        // set the website direction
        $this->setWebsiteDirection();

        // load bootstrap framework based on virtuemart config setting
        $this->loadBootstrapFrameworkBasedOnVirtueMartConfig();

        // set viewport meta for mobile friendly support
        $this->setWebsiteHeadArea('<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">');

        // set joomla head into the website head area
        $this->setWebsiteHeadArea('<jdoc:include type="head"/>');

        // set meta tag for browser dns prefetch
        $this->setWebsiteHeadArea('<link rel="dns-prefetch" href="' . JUri::base() . '"/>');
    }


    /**
     * Set The Platform Name (i.e. Joomla or Wordpress)
     *
     * @since 3.8.4
     *
     * @return string
     */
    public function getPlatformName ()
    {
        return $this->platformName;
    }

    /**
     * Get The Platform Name (i.e. Joomla or Wordpress)
     *
     * @since 3.8.4
     *
     * @param string $platformName
     */
    private function setPlatformName (string $platformName)
    {
        $this->platformName = $platformName;
    }

    /**
     * Get the template name
     *
     * @return string
     *
     * @since 3.8.4
     */
    public function getTemplateName ()
    {
        return $this->templateName;
    }

    /**
     * Set the template name
     *
     * @since 3.8.4
     * @throws \Exception
     */
    private function setTemplateName ()
    {
        // Get The Joomla Application Factory
        $joomlaApplication = JFactory::getApplication();

        // Get And Save The Joomla Template Name
        $this->templateName = $joomlaApplication->getTemplate();
    }

    /**
     * Get The Website Language Orientation
     *
     * @return string
     *
     * @since 3.8.4
     */
    public function getWebsiteLanguageOrientation ()
    {
        return $this->websiteLanguageOrientation;
    }

    /**
     * Set The Website Language Orientation
     *
     * @since 3.8.4
     */
    private function setWebsiteLanguageOrientation ()
    {
        $language  = JFactory::getLanguage();
        $languages = JLanguageHelper::getLanguages('lang_code');
        $sefCode   = $languages[$language->getTag()]->sef;

        $this->websiteLanguageOrientation = $sefCode;
    }

    /**
     * Get The Website Direction
     *
     * @return string
     *
     * @since 3.8.4
     */
    public function getWebsiteDirection ()
    {
        return $this->websiteDirection;
    }

    /**
     * Set The Website Direction
     *
     * @since 3.8.4
     */
    private function setWebsiteDirection ()
    {
        $this->websiteDirection = JFactory::getDocument()
            ->getDirection();
    }

    /**
     * Get The Website Head Area
     *
     * @return string
     *
     * @since 3.8.4
     */
    public function getWebsiteHeadArea ()
    {
        return implode('', $this->websiteHeadArea);
    }

    /**
     * Get The Website Head Area
     *
     * @param $websiteHeadArea
     *
     * @since 3.8.4
     */
    public function setWebsiteHeadArea ($websiteHeadArea)
    {
        $this->websiteHeadArea[] = $websiteHeadArea;
    }

    /**
     * Set The Site Path (Domain)
     *
     * @since 3.8.4
     */
    private function setSitePath ()
    {
        $this->sitePath = rtrim(JURI::root(), '/');
    }

    /**
     * Get The Site Path (Domain)
     *
     * @return string
     *
     * @since 3.8.4
     */
    public function getSitePath ()
    {
        return $this->sitePath;
    }

    /**
     * Set The Root Path (Domain)
     *
     * @since 3.8.4
     */
    private function setRootPath ()
    {
        $this->rootPath = JPATH_ROOT;
    }

    /**
     * Get The Root Path (Domain)
     *
     * @return string
     *
     * @since 3.8.4
     */
    private function getRootPath ()
    {
        return $this->rootPath;
    }


    /**
     * load bootstrap framework based on virtuemart config setting
     *
     * @return bool
     *
     * @since 3.8
     */
    private function loadBootstrapFrameworkBasedOnVirtueMartConfig ()
    {
        // Get The Joomla Document Factory
        $joomlaDocument = JFactory::getDocument();

        $vmBootstrapVersionFromConfig = (!empty($this->getSettingFromVmConfig('bootstrap', '')))
            ? $this->getSettingFromVmConfig('bootstrap', '')
            : 'bs2';
        $templatesAssetsPath          = $this->getSitePath() . '/templates/' . $this->getTemplateName() . '/assets/'
            . $vmBootstrapVersionFromConfig;

        switch ($vmBootstrapVersionFromConfig)
        {
            case 'bs2':
                // load bootstrap css
                $joomlaDocument->addStyleSheet($templatesAssetsPath . '/css/bootstrap.css');

                // load bootstrap js
                \JHtml::_('jquery.framework');
                $joomlaDocument->addScript($templatesAssetsPath . '/js/bootstrap.min.js');
                break;
            case 'bs3':
                // load bootstrap css
                $joomlaDocument->addStyleSheet($templatesAssetsPath . '/css/bootstrap.css');
                $joomlaDocument->addStyleSheet($templatesAssetsPath . '/css/bootstrap-theme.css');

                // load bootstrap js
                \JHtml::_('jquery.framework');
                $joomlaDocument->addScript($templatesAssetsPath . '/js/bootstrap.min.js');
                break;
            case 'bs4':
            default:
                // load bootstrap css
                $joomlaDocument->addStyleSheet($templatesAssetsPath . '/css/bootstrap.css');

                // load bootstrap js
                \JHtml::_('jquery.framework');
                $joomlaDocument->addScript($templatesAssetsPath . '/js/bootstrap.bundle.min.js');
                break;
        }

        return TRUE;
    }

    /**
     * Returns A Setting Value From The VirtueMart Configuration
     *
     * @param $settingName
     * @param $defaultValue
     *
     * @return string \Value
     *
     * @since 3.8
     */
    private function getSettingFromVmConfig ($settingName, $defaultValue)
    {
        // load virtuemart config class if it doesn't exist already
        if (!class_exists('VmConfig'))
        {
            require(JPATH_ADMINISTRATOR . '/components/com_virtuemart/helpers/config.php');
        }

        // load virtuemart config
        \VmConfig::loadConfig();

        return \VmConfig::get($settingName, $defaultValue);
    }
}
