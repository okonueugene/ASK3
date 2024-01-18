<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        
    </style>
</head>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,600" rel="stylesheet" type="text/css">
    <!-- Web Font / @font-face : BEGIN -->
    <!--[if mso]>
        <style>
            * {
                font-family: 'Roboto', sans-serif !important;
            }
        </style>
    <![endif]-->

    <!--[if !mso]>
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,600" rel="stylesheet" type="text/css">
    <![endif]-->

    <!-- Web Font / @font-face : END -->

    <!-- CSS Reset : BEGIN -->


    <style>
        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            font-family: 'Roboto', sans-serif !important;
            font-size: 14px;
            margin-bottom: 10px;
            line-height: 24px;
            font-weight: 400;
        }

        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            margin: 0;
            padding: 0;

        }

        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        a {
            color: inherit;
            text-decoration: inherit;
        }

        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
            text-decoration: none;

        }

        table table table {
            table-layout: auto;
        }

        a {
            text-decoration: none;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }
        .fa {
            padding: 10px;
            font-size: 20px;
            width: 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 50%;
        }
    </style>

</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; ">
    <div class="nk-block">
        <div class="card card-bordered">
            <div class="card-inner">
                <table class="email-wraper">
                    <tr>
                        <td class="py-5">
                            <table class="email-header">
                                <tbody>
                                    <tr>
                                        <td class="text-center pb-4">
                                            <a href="#"><img style="height:100px; width:100px" class="email-logo" src="https://www.opticom.co.ke/wp-content/uploads/2023/03/cropped-Opticom-Logo-18.png" alt="logo"></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="email-body">
                                <tbody>
                                    <tr>
                                        <td class="px-3 px-sm-5 pt-3 pt-sm-5 pb-3">
                                            <h2 class="email-heading">Invitation To Join {{ env('APP_NAME') }}</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-3 px-sm-5 pb-2">
                                            <p>Hi {{ $mailData['name'] }},</p>
                                            <p>Welcome! <br> You are receiving this email because you have been invited
                                                to register on our
                                                site.</p>
                                            <p>Click the link below to register your {{ env('APP_NAME') }} account.</p>
                                            <p class="mb-4">This link will expire in 30 minutes and can only be used
                                                once.
                                            </p>
                                            <a href="{{ $mailData['url'] }}" class="email-btn">Verify Email</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-3 px-sm-5 pt-4 pb-3 pb-sm-5">
                                            <p>If you did not make this request, please contact us or ignore this
                                                message.
                                            </p>
                                            <p class="email-note">This is an automatically generated email please do not
                                                reply to this email. If you face any issues, please contact us at
                                                help@dashlite.com</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="email-footer">
                                <tbody>
                                    <tr>
                                        <td class="text-center pt-4">
                                            <p class="email-copyright-text">Copyright © {{ date('Y') }} Askari. All
                                                rights reserved.
                                                <br> Template Made By <a
                                                    href="https://themeforest.net/user/softnio/portfolio">Softnio</a>.
                                            </p>
                                            <ul class="email-social">
                                                <li><a href="#" class="fa fa-facebook"></a>
                                                </li>
                                                <li><a href="#" class="fa fa-twitter"></a>
                                                </li>
                                                <li><a href="#" class="fa fa-linkedin"></a>
                                                </li>
                                                <li><a href="#" class="fa fa-instagram"></a>
                                                </li>
                                            </ul>
                                            <p class="fs-12px pt-4">This email was sent to you as a registered member of
                                                <a href="https://softnio.com">softnio.com</a>. To update your emails
                                                preferences <a href="#">click here</a>.
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div><!-- .nk-block -->
</body>

</html>
