<?php
// Joomla Security Check - no direct access to this file 
// Prevents File Path Exposure
defined('_JEXEC') or die('Restricted access');

// load an instance of the VmStoreTemplate framework
$vmStoreTemplate = VmStoreTemplate::getInstance('joomla');
?>

<!DOCTYPE html>
<html lang="<?php echo $vmStoreTemplate->getWebsiteLanguageOrientation(); ?>"
      dir="<?php echo $vmStoreTemplate->getWebsiteDirection(); ?>">
<head>
    <?php echo $vmStoreTemplate->getWebsiteHeadArea(); ?>
</head>
<body class="d-flex flex-column">
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="bg-secondary p-5">
                <h1 class="mb-0 text-center text-white">Header Position</h1>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 col-sm-9 col-md-9 col-lg-9 col-xl-9">
            <jdoc:include type="message"/>
            <jdoc:include type="component"/>
        </div>
        <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 display-none-xs">
            <jdoc:include type="modules" name="right" />
        </div>
    </div>
</div>
</body>
</html>