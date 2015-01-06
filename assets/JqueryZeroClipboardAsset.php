<?php
namespace app\assets;

use yii\web\AssetBundle;

class JqueryZeroClipboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/jquery.zeroclipboard/jquery.zclip.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
