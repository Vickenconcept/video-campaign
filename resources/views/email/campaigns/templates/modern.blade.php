<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; }
        .container { width: 100%; margin: 48px auto; background-color: #ffffff; border-radius: 18px; box-shadow: 0 8px 32px rgba(102,126,234,0.10); border: 2px solid #667eea; overflow: hidden; }
        .header { text-align: center; padding: 44px 24px 24px 24px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-bottom: 2px solid #667eea; }
        .content { padding: 44px 24px; }
        .content-grid { display: flex; align-items: center; gap: 44px; }
        .text-content { flex: 1; }
        .video-content { flex: 1; position: relative; display: flex; justify-content: center; width: 100%; }
        .video-thumbnail-wrapper {
            position: relative;
            display: block;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #764ba2;
            box-shadow: 0 8px 32px rgba(118,75,162,0.10);
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
            border-radius: 12px;
            display: block;
        }
        .cta-button { display: inline-block; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; padding: 14px 32px; text-decoration: none; border-radius: 10px; font-weight: 600; font-size: 17px; margin-top: 24px; box-shadow: 0 2px 8px rgba(16,185,129,0.10); transition: background 0.2s; }
        .cta-button:hover { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
        .footer { text-align: center; padding: 32px 24px; background-color: #f1f5f9; color: #64748b; font-size: 14px; border-top: 2px solid #667eea; }
        .tracking-pixel { width: 1px; height: 1px; opacity: 0; }
        @media (max-width: 600px) {
            .content-grid { flex-direction: column; gap: 24px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; font-size: 34px; font-weight: 400; letter-spacing: -1px;">{{ $campaign->title }}</h1>
        </div>
        <div class="content">
            <div class="content-grid">
                <div class="text-content">
                    <div style="line-height: 1.7; color: #334155; font-size: 17px; margin-bottom: 24px;">
                        {!! nl2br(e($campaign->body)) !!}
                    </div>
                    @if($campaign->cta_text && $campaign->cta_url)
                        <a href="{{ $clickUrl }}" class="cta-button">
                            {{ $campaign->cta_text }}
                        </a>
                    @endif
                </div>
                @if($campaign->video_url)
                    <div class="video-content">
                        <a href="{{ $viewUrl }}" class="video-thumbnail-wrapper" style="text-decoration: none;">
                            <img src="{{ $campaign->thumbnail_url ?: 'https://placehold.co/600x400' }}" alt="Personalized Video" class="video-thumbnail">
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