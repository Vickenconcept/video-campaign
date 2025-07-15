<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background-color: #0f172a; }
        .container { width: 100%; margin: 40px auto; background-color: #ffffff; border-radius: 20px; box-shadow: 0 12px 40px rgba(99,102,241,0.10); border: 2px solid #e0e7ef; overflow: hidden; }
        .header { background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); padding: 54px 24px 30px 24px; text-align: center; color: white; }
        .header-title { font-size: 38px; font-weight: 700; margin: 0; text-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .content { padding: 54px 24px; }
        .content-text { line-height: 1.8; color: #334155; font-size: 19px; margin-bottom: 44px; font-weight: 400; }
        .video-container { text-align: center; margin: 44px 0; position: relative; display: flex; justify-content: center; width: 100%; }
        .video-thumbnail-wrapper {
            position: relative;
            display: block;
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            border: 2px solid #a855f7;
            box-shadow: 0 8px 32px rgba(168,85,247,0.10);
            aspect-ratio: 16/9;
            height: auto;
            min-height: 120px;
            max-height: 320px;
        }
        .video-thumbnail {
            width: 100%;
            max-width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 16px;
            display: block;
        }
        .cta-button { display: inline-block; background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); color: #ffffff; padding: 20px 44px; text-decoration: none; border-radius: 14px; font-weight: 600; font-size: 20px; margin: 36px 0; box-shadow: 0 8px 20px rgba(99, 102, 241, 0.18); transition: all 0.3s ease; }
        .cta-button:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(99, 102, 241, 0.25); }
        .footer { background-color: #f8fafc; padding: 44px 24px; text-align: center; color: #64748b; font-size: 15px; border-top: 1.5px solid #e0e7ef; }
        .tracking-pixel { width: 1px; height: 1px; opacity: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="header-title">{{ $campaign->title }}</h1>
        </div>
        <div class="content">
            <div class="content-text">
                {!! nl2br(e($campaign->body)) !!}
            </div>
            @if($campaign->video_url)
                <div class="video-container">
                    <a href="{{ $viewUrl }}" class="video-thumbnail-wrapper" style="text-decoration: none;">
                        <img src="{{ asset('images/video-thumbnail.jpg') }}" alt="Personalized Video" class="video-thumbnail">
                    </a>
                </div>
            @endif
            @if($campaign->cta_text && $campaign->cta_url)
                <div style="text-align: center;">
                    <a href="{{ $clickUrl }}" class="cta-button">
                        {{ $campaign->cta_text }}
                    </a>
                </div>
            @endif
        </div>
        <div class="footer">
            <p style="margin: 0 0 10px 0; font-weight: 600;">{{ $campaign->template_data['footer_line1'] ?? 'Thank you for your attention!' }}</p>
            <p style="margin: 0 0 10px 0;">{{ $campaign->template_data['footer_line2'] ?? 'This email was sent as part of a personalized video campaign.' }}</p>
            <p style="margin: 0; font-size: 12px;">{{ $campaign->template_data['footer_line3'] ?? 'Powered by advanced video personalization technology.' }}</p>
        </div>
    </div>
    <!-- Tracking Pixel -->
    <img src="{{ $trackingPixel }}" class="tracking-pixel" alt="">
</body>
</html> 