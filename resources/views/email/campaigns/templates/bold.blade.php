<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Arial Black', 'Helvetica Bold', sans-serif; background-color: #000000; }
        .container { max-width: 800px; margin: 0 auto; background-color: #ffffff; }
        .header { text-align: center; padding: 50px 20px; background-color: #ffffff; }
        .title { font-size: 48px; font-weight: 900; color: #000000; margin: 0; text-transform: uppercase; letter-spacing: -1px; }
        .content { padding: 50px 20px; text-align: center; }
        .video-container { margin: 40px 0; position: relative; display: flex; justify-content: center; }
        .video-thumbnail-wrapper { position: relative; display: inline-block; }
        .video-thumbnail { width: 100%; max-width: 400px; height: 220px; object-fit: cover; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); display: block; }
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
        .cta-button { display: inline-block; background-color: #dc2626; color: #ffffff; padding: 20px 40px; text-decoration: none; border-radius: 12px; font-weight: 900; font-size: 24px; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 8px 16px rgba(220, 38, 38, 0.3); }
        .footer { text-align: center; padding: 30px 20px; background-color: #f3f4f6; color: #6b7280; font-size: 14px; }
        .tracking-pixel { width: 1px; height: 1px; opacity: 0; }
        .content-text { font-size: 20px; line-height: 1.5; color: #1f2937; margin-bottom: 40px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">{{ $campaign->title }}</h1>
        </div>
        
        <div class="content">
            @if($campaign->video_url)
                <div class="video-container" style="position: relative; width: 400px; height: 220px; margin: 40px auto;">
                    <a href="{{ $viewUrl }}" style="display: block; width: 100%; height: 100%; position: relative; text-decoration: none;">
                        <img src="{{ $campaign->thumbnail_url ?: 'https://placehold.co/600x400' }}" alt="Personalized Video" style="width: 100%; height: 100%; object-fit: cover; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); display: block;">
                        <div style="position: absolute; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; top: 0; left: 0;">
                            <span style="width: 56px; height: 56px; background: rgba(0,0,0,0.45); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <svg viewBox="0 0 64 64" width="32" height="32" style="display: block; fill: #fff"><circle cx="32" cy="32" r="32" fill="none"/><polygon points="26,20 48,32 26,44"/></svg>
                            </span>
                        </div>
                    </a>
                </div>
            @endif
            <div class="content-text">
                {!! nl2br(e($campaign->body)) !!}
            </div>
            
            @if($campaign->cta_text && $campaign->cta_url)
                <a href="{{ $clickUrl }}" class="cta-button">
                    {{ $campaign->cta_text }}
                </a>
            @endif
        </div>
        
        <div class="footer">
            <p><strong>{{ $campaign->template_data['footer_line1'] ?? 'PERSONALIZED VIDEO CAMPAIGN' }}</strong></p>
            <p>{{ $campaign->template_data['footer_line2'] ?? 'Don\'t miss out on this exclusive content!' }}</p>
        </div>
    </div>
    
    <!-- Tracking Pixel -->
    <img src="{{ $trackingPixel }}" class="tracking-pixel" alt="">
</body>
</html> 