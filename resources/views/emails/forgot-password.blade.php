<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .header {
            background: #F44A40;
            text-align: center;
            padding: 40px 30px;
            color: white;
        }

        .title {
            font-size: 28px;
            font-weight: 600;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .subtitle {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 16px;
        }

        .content {
            padding: 40px;
            color: #444;
        }

        .greeting {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .message {
            font-size: 16px;
            margin-bottom: 30px;
            color: #555;
            line-height: 1.7;
        }

        .button-container {
            text-align: center;
            margin: 35px 0;
        }

        .button {
            display: inline-block;
            background: #F44A40;
            color: #FFFFFF !important;
            padding: 16px 40px;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(244, 74, 64, 0.2);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(244, 74, 64, 0.3);
        }

        .notice {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            font-size: 14px;
            color: #666;
            line-height: 1.6;
        }

        .notice-icon {
            color: #F44A40;
            margin-right: 8px;
        }

        .footer {
            text-align: center;
            color: #999;
            font-size: 14px;
            margin-top: 20px;
            padding: 30px;
            background: #f8f9fa;
            border-top: 1px solid #eee;
        }

        .divider {
            height: 1px;
            background: #eee;
            margin: 30px 0;
        }

        @media (max-width: 640px) {
            .container {
                margin: 0;
                border-radius: 0;
            }

            .content {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 class="title">Reset Password</h1>
            <p class="subtitle">Kami akan membantu Anda membuat password baru</p>
        </div>

        <div class="content">
            <h2 class="greeting">Halo!</h2>

            <p class="message">
                Kami menerima permintaan untuk mengatur ulang password akun Anda.
                Silakan klik tombol di bawah ini untuk membuat password baru:
            </p>

            <div class="button-container">
                <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}" class="button">
                    Reset Password
                </a>
            </div>

            <div class="notice">
                <p><span class="notice-icon">⚠️</span> Link reset password ini akan kadaluarsa dalam 60 menit.</p>
                <p><span class="notice-icon">ℹ️</span> Jika Anda tidak merasa melakukan permintaan reset password, Anda
                    dapat mengabaikan email ini.</p>
            </div>

            <div class="divider"></div>

            <div class="footer">
                <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
                <p style="margin-top: 15px;">&copy; {{ date('Y') }} Walet App. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>
