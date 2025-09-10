<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Welcome to {{ config('app.name') }}</title>

    <style>
        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background-color: #fafafa;
        }

        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        #MessageViewBody,
        #MessageWebViewDiv {
            width: 100% !important;
        }

        table {
            border-collapse: collapse !important;
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        th {
            font-weight: normal;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            background-color: #09090b;
            color: #fafafa !important;
            text-decoration: none !important;
            border-radius: 6px;
            font-weight: 500;
            font-size: 14px;
            line-height: 20px;
            text-align: center;
            mso-padding-alt: 0;
            text-underline-color: transparent;
            border: 1px solid #09090b;
        }

        .button:hover {
            background-color: #18181b !important;
            border-color: #18181b !important;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e4e4e7;
            border-radius: 8px;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        }

        .content {
            padding: 48px 32px;
        }

        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #e4e4e7;
            padding: 32px;
            text-align: center;
        }

        .header h1 {
            color: #09090b;
            font-size: 28px;
            font-weight: 600;
            margin: 0;
            line-height: 36px;
            letter-spacing: -0.025em;
        }

        .body-text {
            color: #52525b;
            font-size: 14px;
            line-height: 20px;
            margin: 0 0 16px 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .email-box {
            background-color: #f4f4f5;
            border: 1px solid #e4e4e7;
            border-radius: 6px;
            padding: 12px 16px;
            margin: 16px 0;
            font-family: ui-monospace, SFMono-Regular, 'SF Mono', Consolas, 'Liberation Mono', Menlo, monospace;
            color: #71717a;
            word-break: break-all;
            font-size: 13px;
        }

        .footer {
            background-color: #fafafa;
            padding: 24px 32px;
            text-align: center;
            border-top: 1px solid #e4e4e7;
            border-radius: 0 0 8px 8px;
        }

        .footer-text {
            color: #71717a;
            font-size: 12px;
            line-height: 16px;
            margin: 4px 0;
        }

        .security-note {
            background-color: #fef7ec;
            border: 1px solid #fed7aa;
            padding: 12px 16px;
            margin: 16px 0;
            border-radius: 6px;
            border-left: 3px solid #fb923c;
        }

        .security-note p {
            color: #9a3412;
            font-size: 13px;
            margin: 0;
            font-weight: 500;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                max-width: 100% !important;
            }

            .content {
                padding: 24px 16px !important;
            }

            .header {
                padding: 24px 16px !important;
            }

            .header h1 {
                font-size: 24px !important;
                line-height: 32px !important;
            }

            .button {
                display: block !important;
                width: 100% !important;
                box-sizing: border-box;
            }
        }
    </style>
</head>

<body>
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td style="padding: 40px 20px;">
                <div class="container">
                    <!-- Header -->
                    <div class="header">
                        <h1>Welcome to {{ config('app.name') }}</h1>
                    </div>

                    <!-- Main Content -->
                    <div class="content">
                        <p class="body-text">Hi {{ $user->name }},</p>

                        <p class="body-text">Your account has been successfully created! We're excited to have you on board.</p>

                        <p class="body-text"><strong>Your login email:</strong></p>
                        <div class="email-box">{{ $user->email }}</div>

                        <p class="body-text">To get started, you'll need to set up your password. Click the button below to create your secure password:</p>

                        <!-- CTA Button -->
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: 24px 0;">
                            <tr>
                                <td style="text-align: center;">
                                    <a href="{{ $resetPasswordUrl }}" class="button">Set Up Your Password</a>
                                </td>
                            </tr>
                        </table>

                        <p class="body-text">If the button doesn't work, you can copy and paste this link into your browser:</p>
                        <p class="body-text" style="word-break: break-all; color: #71717a; font-size: 12px;">{{ $resetPasswordUrl }}</p>

                        <!-- Security Notice -->
                        <div class="security-note">
                            <p>This link will expire in 60 minutes for your security.</p>
                        </div>

                        <p class="body-text">If you didn't expect this email or have any questions, please contact our support team.</p>

                        <p class="body-text">Welcome aboard!<br>The {{ config('app.name') }} Team</p>
                    </div>

                    <!-- Footer -->
                    <div class="footer">
                        <p class="footer-text">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                        <p class="footer-text">This email was sent to {{ $user->email }}</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
