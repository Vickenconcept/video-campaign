<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; }
        .container { max-width: 700px; margin: 0 auto; background-color: #ffffff; }
        .header { text-align: center; padding: 40px 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .content { padding: 40px 20px; }
        .content-grid { display: flex; align-items: center; gap: 40px; }
        .text-content { flex: 1; }
        .video-content { flex: 1; position: relative; display: flex; justify-content: center; }
        .video-thumbnail-wrapper { position: relative; display: inline-block; }
        .video-thumbnail { width: 100%; max-width: 340px; height: 220px; object-fit: cover; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.15); display: block; }
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
        .cta-button { display: inline-block; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; margin-top: 20px; }
        .footer { text-align: center; padding: 30px 20px; background-color: #f1f5f9; color: #64748b; font-size: 14px; }
        .tracking-pixel { width: 1px; height: 1px; opacity: 0; }
        @media (max-width: 600px) {
            .content-grid { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; font-size: 32px; font-weight: 300;">{{ $campaign->title }}</h1>
        </div>
        
        <div class="content">
            <div class="content-grid">
                <div class="text-content">
                    <div style="line-height: 1.7; color: #334155; font-size: 16px; margin-bottom: 20px;">
                        {!! nl2br(e($campaign->body)) !!}
                    </div>
                    
                    @if($campaign->cta_text && $campaign->cta_url)
                        <a href="{{ $clickUrl }}" class="cta-button">
                            {{ $campaign->cta_text }}
                        </a>
                    @endif
                </div>
                
                @if($campaign->video_url)
                    <div class="video-content" style="position: relative; width: 340px; height: 220px; margin: 0 auto;">
                        <a href="{{ $viewUrl }}" style="display: block; width: 100%; height: 100%; position: relative; text-decoration: none;">
                            <img src="{{ $campaign->thumbnail_url ?: 'https://placehold.co/600x400' }}" alt="Personalized Video" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.15); display: block;">
                            <div style="position: absolute; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; top: 0; left: 0;">
                                <span style="width: 56px; height: 56px; background: rgba(0,0,0,0.45); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <svg viewBox="0 0 64 64" width="32" height="32" style="display: block; fill: #fff"><circle cx="32" cy="32" r="32" fill="none"/><polygon points="26,20 48,32 26,44"/></svg>
                                </span>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="footer">
            <p>{{ $campaign->template_data['footer_line1'] ?? 'Thank you for your time!' }}</p>
            <p>{{ $campaign->template_data['footer_line2'] ?? 'This email was sent as part of a personalized video campaign.' }}</p>
        </div>
    </div>
    
    <!-- Tracking Pixel -->
    <img src="{{ $trackingPixel }}" class="tracking-pixel" alt="">
</body>
</html> 