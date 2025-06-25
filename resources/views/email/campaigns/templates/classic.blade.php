<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; }
        .header { text-align: center; padding: 30px 20px; background-color: #ffffff; }
        .content { padding: 30px 20px; text-align: center; }
        .video-container { margin: 30px 0; position: relative; display: flex; justify-content: center; }
        .video-thumbnail-wrapper { position: relative; display: inline-block; }
        .video-thumbnail { max-width: 400px; width: 100%; height: 220px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); display: block; }
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
        .cta-button { display: inline-block; background-color: #3b82f6; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 18px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; background-color: #f8f9fa; color: #6c757d; font-size: 12px; }
        .tracking-pixel { width: 1px; height: 1px; opacity: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #1f2937; margin: 0; font-size: 28px;">{{ $campaign->title }}</h1>
        </div>
        
        <div class="content">
            @if($campaign->video_url)
                <div class="video-container" style="position: relative; width: 400px; height: 220px; margin: 30px auto;">
                    <a href="{{ $viewUrl }}" style="display: block; width: 100%; height: 100%; position: relative; text-decoration: none;">
                        <img src="{{ $campaign->thumbnail_url ?: 'https://placehold.co/600x400' }}" alt="Personalized Video" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); display: block;">
                        <div style="position: absolute; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; top: 0; left: 0;">
                            <span style="width: 56px; height: 56px; background: rgba(0,0,0,0.45); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <svg viewBox="0 0 64 64" width="32" height="32" style="display: block; fill: #fff"><circle cx="32" cy="32" r="32" fill="none"/><polygon points="26,20 48,32 26,44"/></svg>
                            </span>
                        </div>
                    </a>
                </div>
            @endif
            
            <div style="line-height: 1.6; color: #374151; font-size: 16px; margin-bottom: 30px;">
                {!! nl2br(e($campaign->body)) !!}
            </div>
            
            @if($campaign->cta_text && $campaign->cta_url)
                <a href="{{ $clickUrl }}" class="cta-button">
                    {{ $campaign->cta_text }}
                </a>
            @endif
        </div>
        
        <div class="footer">
            <p>{{ $campaign->template_data['footer_line1'] ?? 'This email was sent as part of a personalized video campaign.' }}</p>
            <p>{{ $campaign->template_data['footer_line2'] ?? 'If you have any questions, please contact us.' }}</p>
        </div>
    </div>
    
    <!-- Tracking Pixel -->
    <img src="{{ $trackingPixel }}" class="tracking-pixel" alt="">
</body>
</html> 