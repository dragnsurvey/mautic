<?php


namespace MauticPlugin\DragnSurveyBundle\Integration;
use Mautic\IntegrationsBundle\Integration\Interfaces\BasicInterface;
use Mautic\IntegrationsBundle\Integration\BasicIntegration;
use Mautic\IntegrationsBundle\Integration\ConfigurationTrait;

class DragnSurveyIntegration extends BasicIntegration implements BasicInterface
{
    use ConfigurationTrait;

    public function getName(): string
    {
        return 'dragnsurvey';
    }


    public function getDisplayName(): string
    {
        return "Drag'n Survey";
    }

    public function getIcon(): string
    {
        return 'plugins/DragnSurveyBundle/Assets/img/sirv.png';
    }
}