<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #ffffff; }
        .container { max-width: 500px; margin: 0 auto; padding: 40px 20px; }
        .header { margin-bottom: 40px; }
        .title { font-size: 24px; font-weight: 300; color: #1a202c; margin: 0; }
        .content { line-height: 1.6; color: #4a5568; font-size: 16px; margin-bottom: 30px; }
        .video-container { margin: 30px 0; position: relative; display: flex; justify-content: center; }
        .video-thumbnail-wrapper { position: relative; display: inline-block; }
        .video-thumbnail { width: 100%; max-width: 340px; height: 220px; object-fit: cover; border-radius: 4px; display: block; }
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
        .cta-button { display: inline-block; border: 1px solid #e2e8f0; color: #4a5568; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-size: 14px; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #e2e8f0; text-align: center; color: #718096; font-size: 12px; }
        .tracking-pixel { width: 1px; height: 1px; opacity: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">{{ $campaign->title }}</h1>
        </div>
        
        <div class="content">
            {!! nl2br(e($campaign->body)) !!}
        </div>
        
        @if($campaign->video_url)
            <div class="video-container" style="position: relative; width: 340px; height: 220px; margin: 30px auto;">
                <a href="{{ $viewUrl }}" style="display: block; width: 100%; height: 100%; position: relative; text-decoration: none;">
                    <img src="{{ $campaign->thumbnail_url ?: 'https://placehold.co/600x400' }}" alt="Personalized Video" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px; display: block;">
                    <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 56px; height: 56px; background: rgba(0,0,0,0.45); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <svg viewBox="0 0 64 64" width="32" height="32" style="display: block; fill: #fff;"><circle cx="32" cy="32" r="32" fill="none"/><polygon points="26,20 48,32 26,44"/></svg>
                    </span>
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
        
        <div class="footer">
            <p>{{ $campaign->template_data['footer_line1'] ?? 'Personalized video campaign' }}</p>
        </div>
    </div>
    
    <!-- Tracking Pixel -->
    <img src="{{ $trackingPixel }}" class="tracking-pixel" alt="">
</body>
</html> 