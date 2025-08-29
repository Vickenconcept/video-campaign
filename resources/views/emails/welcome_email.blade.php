<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Video Campaign</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header p {
            margin: 10px 0 0 0;
            font-size: 18px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .welcome-message {
            text-align: center;
            margin-bottom: 30px;
        }
        .welcome-message h2 {
            color: #2d3748;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .welcome-message p {
            color: #4a5568;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .credentials-box {
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            text-align: center;
        }
        .credentials-box h3 {
            color: #2d3748;
            margin: 0 0 15px 0;
            font-size: 18px;
        }
        .password-display {
            background: #667eea;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: 2px;
            margin: 15px 0;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }
        .features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 30px 0;
        }
        .feature-item {
            text-align: center;
            padding: 20px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        .feature-item h4 {
            color: #2d3748;
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        .feature-item p {
            color: #718096;
            margin: 0;
            font-size: 14px;
        }
        .footer {
            background: #f7fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            color: #718096;
            margin: 5px 0;
            font-size: 14px;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 12px;
            }
            .header, .content, .footer {
                padding: 20px;
            }
            .features {
                grid-template-columns: 1fr;
            }
            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header Section -->
        <div class="header">
            <h1>🎉 Welcome!</h1>
            <p>Your Video Campaign journey starts now</p>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="welcome-message">
                <h2>Welcome to Video Campaign</h2>
                <p>We're excited to have you on board! You now have access to powerful video marketing tools that will help you create engaging campaigns and connect with your audience like never before.</p>
            </div>

            <!-- Credentials Section -->
            <div class="credentials-box">
                <h3>🔐 Your Login Credentials</h3>
                <p>Use the password below to access your account:</p>
                <div class="password-display">{{ $password }}</div>
                <p><strong>Keep this password safe!</strong></p>
            </div>

            <!-- Features Section -->
            <div class="features">
                <div class="feature-item">
                    <h4>📹 Video Campaigns</h4>
                    <p>Create engaging video content that converts</p>
                </div>
                <div class="feature-item">
                    <h4>📊 Analytics</h4>
                    <p>Track performance and optimize results</p>
                </div>
                <div class="feature-item">
                    <h4>📧 Email Integration</h4>
                    <p>Connect with your audience via email</p>
                </div>
                <div class="feature-item">
                    <h4>🎯 Targeting</h4>
                    <p>Reach the right people at the right time</p>
                </div>
            </div>

            <!-- Call to Action -->
            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="cta-button">🚀 Get Started Now</a>
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <p style="color: #718096; font-size: 14px;">
                    Need help? Our support team is here for you 24/7
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Video Campaign Team</strong></p>
            <p>Questions? Contact us at <a href="mailto:{{ env('MAIL_FROM_ADDRESS') }}">{{ env('MAIL_FROM_ADDRESS') }}</a></p>
            <p>© {{ date('Y') }} Video Campaign. All rights reserved.</p>
        </div>
    </div>
</body>
</html>