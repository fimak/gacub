$(document).ready(function() {
    $('#build').click(function() {
        var landing = $('#landing-page-url').val();
        var medium = $('#chanel-or-medium').data('value');
        var source = $('#source').val();
        var content = $('#content').val();
        var term = $('#term').val();
        var campaign = $('#campaign-name').val();
        var parameter = $('.separator div').children('input:checked').val();
        var url = $(this).data('url');

        $('.error').text('');
        $('.error').addClass('hidden');

        $.ajax({
            type: "POST",
            url: url,
            data: {
                landing: landing,
                medium: medium,
                source: source,
                content: content,
                term: term,
                campaign: campaign,
                parameter: parameter
            },
            success: function(response) {
                if (JSON.parse(response).error) {
                    if (JSON.parse(response).error.landing) {
                        $('.landing-page-url .error').text(JSON.parse(response).error.landing);
                        $('.landing-page-url .error').removeClass('hidden');
                    }
                    if (JSON.parse(response).error.medium) {
                        $('.chanel-or-medium .error').text(JSON.parse(response).error.medium);
                        $('.chanel-or-medium .error').removeClass('hidden');
                    }
                } else {
                    $('#tagged-landing-page-url').val(JSON.parse(response).longUrl);
                    $('#shortened-url').val(JSON.parse(response).id);
                    $('#qrcode').html('<img src="'+JSON.parse(response).qrcode+'"><br /><a href="javascript:void(0)" class="clipboard">Coppy to clipboard</a>');
                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

    $('#chanel-or-medium').click(function() {
        $('.chanel-or-medium ul.options').toggle();
    });

    $('.chanel-or-medium .options li').click(function() {
        $('.chanel-or-medium ul.options').toggle();
        $('#chanel-or-medium').val($(this).text());
        $('#chanel-or-medium').attr('data-value', $(this).data('value'));
        $('.term').hide();

        var searchValue = $('#chanel-or-medium').val().toLowerCase();
        switch (searchValue) {
            case 'search':
                $('.term').show();
                $('label[for="source"]').text('Search Engine');
                $('label[for="content"]').text('Ad Group');
                $('.source .help-inline').text('Enter the search engine name.');
                $('.content .help-inline').text('Enter the name of the ad group. The ad group name is automatically filled in for Yahoo and Bing.');
                $('#source').keyup(function() {
                    if ($(this).val().toLowerCase() == 'bing') {
                        $('#content').val('{AdId}');
                        $('#term').val('{QueryString}');
                        $('#campaign-name').val('');
                    }
                    if ($(this).val().toLowerCase() == 'yahoo') {
                        $('#content').val('{OVADID}');
                        $('#term').val('{OVKEY}');
                        $('#campaign-name').val('{OVCAMPGID}');
                    }
                });
                break;
            case 'display':
                $('label[for="source"]').text('Site Name');
                $('label[for="content"]').text('Creative Name & Placement Type');
                $('.source .help-inline').text('Enter the name Email List or of the website where the display ad is being placed.');
                $('.content .help-inline').text('Enter the name of the ad (including the size) and the type of placement.');
                break;
            case 'social':
                $('label[for="source"]').text('Social Network Name');
                $('label[for="content"]').text('Placement Type');
                $('.source .help-inline').text('Enter the name of the social media website.');
                $('.content .help-inline').text('Enter the placement type (tweet, post, promoted post, promoted tweet, etc.)');
                break;
            case 'affiliates':
                $('label[for="source"]').text('Affiliate Name');
                $('label[for="content"]').text('Affiliate Type');
                $('.source .help-inline').text('Enter the name of the affiliate or affiliate network.');
                $('.content .help-inline').text('Specify whether this is a direct affiliate or an affiliate network.');
                break;
            case 'email':
                $('label[for="source"]').text('Email list or Segment Name');
                $('label[for="content"]').text('Template Type');
                $('.source .help-inline').text('Enter the name of the email list segment.');
                $('.content .help-inline').text('Enter the name of the email  template (newsletter, onboarding, etc.).');
                break;
            case 'offline':
                $('label[for="source"]').text('Media Source');
                $('label[for="content"]').text('Ad Name & Format');
                $('.source .help-inline').text('Examples include: newspaper name, billboard location, etc');
                $('.content .help-inline').text('Examples include: Short URL, QR Code, etc');
                break;
            default:
                $('label[for="source"]').text('Source');
                $('label[for="content"]').text('Content');
                $('.source .help-inline').text('Enter the traffic source of the channel/medium selected above.');
                $('.content .help-inline').text('Use to differentiate ads that point to the same URL. Can be used for A/B testing and content-targeted ads');
        }
    });

    $('a.clipboard').zclip({
        path:'/gacub/js/jquery.zeroclipboard/ZeroClipboard.swf',
        copy:function(){
            return $(this).prev('input').val();
        }
    });
    $('#qrcode a.clipboard').zclip({
        path:'/gacub/js/jquery.zeroclipboard/ZeroClipboard.swf',
        copy:function(){
            return $(this).prev('img').attr('src');
        }
    });

    $('#mail-to').click(function() {
        var email = $('#send-to').val();
        var url = $(this).data('url');
        var landing = $('#landing-page-url').val();
        var taggedUrl = $('#tagged-landing-page-url').val();
        var shortenedUrl = $('#shortened-url').val();
        $.ajax({
            type: "POST",
            url: url,
            data: {
                email: email,
                landing: landing,
                taggedUrl: taggedUrl,
                shortenedUrl: shortenedUrl
            },
            success: function(data) {
                alert('Mail has been sent to ' + data);
            },
            error: function(e) {
                console.log(e);
            }
        });
    });

});