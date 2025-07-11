<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #18181b; color: #e0e0e0; min-height: 100vh; }
        .container { width: 100%; max-width: 700px; margin: 48px auto; background: #23232a; border-radius: 28px; box-shadow: 0 12px 40px rgba(0,255,255,0.08); border: 2px solid #0ea5e9; overflow: hidden; }
        .header { text-align: center; padding: 44px 24px 24px 24px; background: linear-gradient(135deg, #0ea5e9 0%, #0f766e 100%); color: #fff; border-bottom: 2px solid #0ea5e9; border-top-left-radius: 28px; border-top-right-radius: 28px; }
        .content { padding: 44px 24px; }
        .content-grid { display: flex; align-items: center; gap: 44px; }
        .text-content { flex: 1; }
        .video-content { flex: 1; position: relative; display: flex; justify-content: center; width: 100%; }
        .video-thumbnail-wrapper { position: relative; display: block; width: 100%; border-radius: 18px; overflow: hidden; border: 2px solid #0ea5e9; box-shadow: 0 8px 32px rgba(14,165,233,0.10); aspect-ratio: 16/9; height: auto; min-height: 120px; max-height: 320px; }
        .video-thumbnail { width: 100%; max-width: 100%; height: 100%; object-fit: cover; border-radius: 18px; display: block; }
        .cta-button { display: inline-block; background: linear-gradient(90deg, #0ea5e9 0%, #22d3ee 100%); color: #18181b; padding: 18px 40px; text-decoration: none; border-radius: 14px; font-weight: bold; font-size: 20px; margin-top: 28px; box-shadow: 0 4px 16px rgba(14,165,233,0.13); letter-spacing: 1px; border: none; transition: background 0.2s, transform 0.2s; text-shadow: 0 0 8px #22d3ee; }
        .cta-button:hover { background: linear-gradient(90deg, #22d3ee 0%, #0ea5e9 100%); transform: translateY(-2px) scale(1.03); color: #fff; }
        .footer { text-align: center; padding: 32px 24px; background-color: #18181b; color: #0ea5e9; font-size: 15px; border-top: 2px solid #0ea5e9; border-bottom-left-radius: 28px; border-bottom-right-radius: 28px; }
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