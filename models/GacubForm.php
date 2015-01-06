<?php
namespace app\models;

use yii\base\Model;

class GacubForm extends Model
{
    public $landingUrl;
    public $medium;
    public $source;
    public $content;
    public $keyword;
    public $campaignName;
    public $campaignTagged;
    public $shortenedUrl;
    public $mailTo;

    public function rules()
    {
        return [
            [['landingUrl', 'medium'], 'required'],

        ];
    }
}