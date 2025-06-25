<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Georgia', serif; background-color: #f9fafb; }
        .container { max-width: 700px; margin: 0 auto; background-color: #ffffff; }
        .header { background-color: #f3f4f6; padding: 30px 20px; text-align: center; border-bottom: 3px solid #8b5cf6; }
        .header-title { font-size: 28px; font-weight: bold; color: #1f2937; margin: 0 0 5px 0; }
        .header-subtitle { color: #6b7280; font-size: 14px; margin: 0; }
        .content { padding: 40px 20px; }
        .content-text { line-height: 1.7; color: #374151; font-size: 16px; margin-bottom: 30px; }
        .video-container { text-align: center; margin: 30px 0; position: relative; display: flex; justify-content: center; }
        .video-thumbnail-wrapper { position: relative; display: inline-block; }
        .video-thumbnail { max-width: 400px; width: 100%; height: 220px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); display: block; }
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
        .cta-button { display: inline-block; background-color: #8b5cf6; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; margin: 20px 0; }
        .footer { background-color: #f3f4f6; padding: 30px 20px; text-align: center; color: #6b7280; font-size: 12px; }
        .tracking-pixel { width: 1px; height: 1px; opacity: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="header-title">{{ $campaign->title }}</h1>
            <p class="header-subtitle">Personalized Video Campaign</p>
        </div>
        
        <div class="content">
            <div class="content-text">
                {!! nl2br(e($campaign->body)) !!}
            </div>
            
            @if($campaign->video_url)
                <div class="video-container" style="position: relative; width: 400px; height: 220px; margin: 30px auto;">
                    <a href="{{ $viewUrl }}" style="display: block; width: 100%; height: 100%; position: relative; text-decoration: none;">
                        <img src="{{ $campaign->thumbnail_url ?: 'https://placehold.co/600x400' }}" alt="Personalized Video" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); display: block;">
                        <div style="position: absolute; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; top: 0; left: 0;">
                            <span style="width: 56px; height: 56px; background: rgba(0,0,0,0.45); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <svg viewBox="0 0 64 64" width="32" height="32" style="display: block; fill: #fff"><circle cx="32" cy="32" r="32" fill="none"/><polygon points="26,20 48,32 26,44"/></svg>
                            </span>
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
            <p>{{ $campaign->template_data['footer_line1'] ?? 'Thank you for your time!' }}</p>
            <p>{{ $campaign->template_data['footer_line2'] ?? 'This email was sent as part of a personalized video campaign.' }}</p>
            <p>{{ $campaign->template_data['footer_line3'] ?? 'If you have any questions, please don\'t hesitate to contact us.' }}</p>
        </div>
    </div>
    
    <!-- Tracking Pixel -->
    <img src="{{ $trackingPixel }}" class="tracking-pixel" alt="">
</body>
</html> 