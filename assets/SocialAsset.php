<?php
namespace app\assets;

use yii\web\AssetBundle;

class SocialAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
        'font-awesome/css/font-awesome.css',
        'bootstrap-social/bootstrap-social.css'
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
