<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background-color: #0f172a; }
        .container { max-width: 750px; margin: 0 auto; background-color: #ffffff; }
        .header { background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); padding: 50px 20px; text-align: center; color: white; }
        .header-title { font-size: 36px; font-weight: 700; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .content { padding: 50px 20px; }
        .content-text { line-height: 1.8; color: #334155; font-size: 18px; margin-bottom: 40px; font-weight: 400; }
        .video-container { text-align: center; margin: 40px 0; position: relative; display: flex; justify-content: center; }
        .video-thumbnail-wrapper { position: relative; display: inline-block; }
        .video-thumbnail { max-width: 400px; width: 100%; height: 220px; object-fit: cover; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.15); display: block; }
        .play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 56px;
            height: 56px;
            background: rgba(0,0,0,0.45);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .play-icon svg {
            display: block;
            width: 32px;
            height: 32px;
            fill: #fff;
        }
        .cta-button { display: inline-block; background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); color: #ffffff; padding: 18px 36px; text-decoration: none; border-radius: 12px; font-weight: 600; font-size: 18px; margin: 30px 0; box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3); transition: all 0.3s ease; }
        .cta-button:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(99, 102, 241, 0.4); }
        .footer { background-color: #f8fafc; padding: 40px 20px; text-align: center; color: #64748b; font-size: 14px; }
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
                        <img src="{{ $campaign->thumbnail_url ?: 'https://placehold.co/600x400' }}" alt="Personalized Video" class="video-thumbnail" style="display: block; margin: 0 auto;">
                        <div style="text-align: center; margin-top: -32px;">
                            <img src="https://res.cloudinary.com/demo/image/upload/v1719850000/play_icon_email.png" alt="Play Video" width="56" height="56" style="display: inline-block; vertical-align: middle; background: rgba(0,0,0,0.15); border-radius: 50%;">
                        </div>
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