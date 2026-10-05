<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f8fafc;
            padding-bottom: 40px;
            padding-top: 40px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05), 0 0 0 1px rgba(0, 0, 0, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.025em;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
            color: #64748b;
            margin-top: 0;
            margin-bottom: 24px;
        }
        .code-container {
            background-color: #f1f5f9;
            border-radius: 12px;
            padding: 20px;
            margin: 30px 0;
            display: inline-block;
            letter-spacing: 6px;
            border: 1px solid #e2e8f0;
        }
        .code {
            font-family: 'Courier New', Courier, monospace;
            font-size: 36px;
            font-weight: 800;
            color: #4f46e5;
            margin: 0;
            padding-left: 6px; /* offset letter-spacing on the last character */
        }
        .footer {
            padding: 24px 30px;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
        .footer p {
            margin: 0 0 8px 0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1>Verification Required</h1>
            </div>
            <div class="content">
                <p>Hello,</p>
                <p>You are receiving this email because a login request was made for your admin account. Please use the verification code below to complete your login:</p>
                
                <div class="code-container">
                    <div class="code">{{ $code }}</div>
                </div>
                
                <p style="font-size: 14px; margin-bottom: 0;">This code is valid for a limited time. If you did not request this login, please ignore this email or secure your account.</p>
            </div>
            <div class="footer">
                <p>&copy; {{ date('Y') }} Admin Dashboard. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
