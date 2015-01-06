<?php
/* @var $this yii\web\View */
$this->title = 'Google Analytics Campaign URL Builder';

\app\assets\JqueryZeroClipboardAsset::register($this);
?>

<div class="site-index">

    <div class="body-content">

        <legend>Create URL</legend>

        <div class="social-buttons">
            <a class="btn btn-social-icon btn-facebook">
                <i class="fa fa-facebook"></i>
            </a>
            <a class="btn btn-social-icon btn-twitter">
                <i class="fa fa-twitter"></i>
            </a>
            <a class="btn btn-social-icon btn-linkedin">
                <i class="fa fa-linkedin"></i>
            </a>
        </div>

        <form id="gacub form-horizontal">
            <div class="form-group row landing-page-url">
                <label for="landing-page-url" class="col-sm-2 control-label">Landing page URL</label>
                <div class="col-lg-4">
                    <input type="text" name="landing-page-url" id="landing-page-url" class="form-control"/>
                    <div class="error col-lg-12 hidden"></div>
                </div>
                <div class="col-lg-6">
                    <span class="help-inline">Enter the website address where you will be sending traffic to.</span>
                </div>
            </div>

            <div class="form-group row chanel-or-medium">
                <label for="chanel-or-medium"  class="col-sm-2 control-label">Channel / Medium</label>
                <div class="col-lg-4">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                    <input type="text" name="chanel-or-medium" id="chanel-or-medium" class="form-control"/>
                    <ul class="options">
                        <li data-value="cpc">Search</li>
                        <li data-value="display">Display</li>
                        <li data-value="social">Social</li>
                        <li data-value="affiliates">Affiliates</li>
                        <li data-value="email">Email</li>
                        <li data-value="offline">Offline</li>
                    </ul>
                    <div class="error col-lg-12 hidden"></div>
                </div>
                <div class="col-lg-6">
                    <span class="help-inline">Select the channel or medium of the traffic source.</span>
                </div>
            </div>

            <div class="form-group row source">
                <label for="source" class="col-sm-2 control-label">Source</label>
                <div class="col-lg-4">
                    <input type="text" name="source" id="source" class="form-control"/>
                </div>
                <div class="col-lg-6">
                    <span class="help-inline">Enter the traffic source of the channel/medium selected above.</span>
                </div>
            </div>

            <div class="form-group row content">
                <label for="content" class="col-sm-2 control-label">Content</label>
                <div class="col-lg-4">
                    <input type="text" name="content" id="content" class="form-control"/>
                </div>
                <div class="col-lg-6">
                    <span class="help-inline">Use to differentiate ads that point to the same URL. Can be used for A/B testing and content-targeted ads</span>
                </div>
            </div>
            <div class="form-group row term">
                <label for="term" class="col-sm-2 control-label">Keyword</label>
                <div class="col-lg-4">
                    <input type="text" name="term" id="term" class="form-control"/>
                </div>
                <div class="col-lg-6">
                    <span class="help-inline">Enter the keyword being bid on. The keyword is automatically filled in for Yahoo and Bing.</span>
                </div>
            </div>
            <div class="form-group row campaign-name">
                <label for="campaign-name" class="col-sm-2 control-label">Campaign name</label>
                <div class="col-lg-4 controls">
                    <input type="text" name="campaign-name" id="campaign-name" class="form-control"/>
                </div>
                <div class="col-lg-6">
                    <span class="help-inline">Enter a name to define a specific product promotion or strategic campaign. Use a unique name without any spaces.</span>
                </div>
            </div>
            <div class="form-group row separator">
                <label for="parameter-separator" class="col-sm-2 control-label">Parameter separator</label>
                <div class="col-lg-4 controls">
                    <input type="radio" name="optionsRadios" id="separator1" value="?" checked>?
                    <input type="radio" name="optionsRadios" id="separator2" value="#">#
                </div>
            </div>
            <div class="form-group row">
                <label for="tagged-landing-page-url" class="col-sm-2 control-label">Campaign-tagged Landing page URL</label>
                <div class="col-lg-4">
                    <input type="text" name="tagged-landing-page-url" id="tagged-landing-page-url" class="form-control"/>
                    <a href="javascript:void(0)" class="clipboard">Coppy to clipboard</a>
                </div>
                <div class="col-lg-6">
                    <a id="build" class="btn btn-primary" data-url="<?= \yii\helpers\Url::to(['/site/build-url'])?>">Build URL</a>
                </div>
            </div>
            <div class="form-group row">
                <label for="shortened-url" class="col-sm-2 control-label">Shortened URL</label>
                <div class="col-lg-4">
                    <input type="text" name="shortened-url" id="shortened-url" class="form-control"/>
                    <a href="javascript:void(0)" class="clipboard">Coppy to clipboard</a>
                </div>
            </div>
            <div class="form-group row qrcode">
                <label for="qrcode" class="col-sm-2 control-label">QR code</label>
                <div class="col-lg-4">
                    <div id="qrcode"></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="send-to" class="col-sm-2 control-label" style="text-align: right">To:</label>
                <div class="col-lg-4">
                    <input type="text" name="send-to" id="send-to" class="form-control"/>
                </div>
                <div class="col-lg-6">
                    <a class="btn btn-primary" id="mail-to" data-url="<?= \yii\helpers\Url::to(['/site/send-mail'])?>">Email this</a>
                </div>
            </div>
        </form>

        <div class="social-buttons">
            <a class="btn btn-social-icon btn-facebook">
                <i class="fa fa-facebook"></i>
            </a>
            <a class="btn btn-social-icon btn-twitter">
                <i class="fa fa-twitter"></i>
            </a>
            <a class="btn btn-social-icon btn-linkedin">
                <i class="fa fa-linkedin"></i>
            </a>
        </div>

    </div>
</div>
