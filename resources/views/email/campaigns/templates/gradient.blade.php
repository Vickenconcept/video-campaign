<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #ff6a00 0%, #ee0979 100%); min-height: 100vh; }
        .container { width: 100%; max-width: 700px; margin: 48px auto; background: rgba(255,255,255,0.95); border-radius: 28px; box-shadow: 0 12px 40px rgba(238,9,121,0.10); border: 2px solid #ee0979; overflow: hidden; }
        .header { text-align: center; padding: 44px 24px 24px 24px; background: linear-gradient(135deg, #ff6a00 0%, #ee0979 100%); color: white; border-bottom: 2px solid #ee0979; border-top-left-radius: 28px; border-top-right-radius: 28px; }
        .brand-logo { max-height: 60px; max-width: 200px; margin-bottom: 10px; }
        .content { padding: 44px 24px; }
        .content-grid { display: flex; align-items: center; gap: 44px; }
        .text-content { flex: 1; }
        .video-content { flex: 1; position: relative; display: flex; justify-content: center; width: 100%; }
        .video-thumbnail-wrapper { position: relative; display: block; width: 100%; border-radius: 18px; overflow: hidden; border: 2px solid #ff6a00; box-shadow: 0 8px 32px rgba(255,106,0,0.10); aspect-ratio: 16/9; height: auto; min-height: 120px; max-height: 320px; }
        .video-thumbnail { width: 100%; max-width: 100%; height: 100%; object-fit: cover; border-radius: 18px; display: block; }
        .cta-button { display: inline-block; background: linear-gradient(90deg, #ee0979 0%, #ff6a00 100%); color: #fff; padding: 18px 40px; text-decoration: none; border-radius: 14px; font-weight: bold; font-size: 20px; margin-top: 28px; box-shadow: 0 4px 16px rgba(255,106,0,0.13); letter-spacing: 1px; border: none; transition: background 0.2s, transform 0.2s; }
        .cta-button:hover { background: linear-gradient(90deg, #ff6a00 0%, #ee0979 100%); transform: translateY(-2px) scale(1.03); }
        .footer { text-align: center; padding: 32px 24px; background-color: #fff0f6; color: #ee0979; font-size: 15px; border-top: 2px solid #ee0979; border-bottom-left-radius: 28px; border-bottom-right-radius: 28px; }
        .tracking-pixel { width: 1px; height: 1px; opacity: 0; }
        @media (max-width: 600px) {
            .content-grid { flex-direction: column; gap: 24px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($brandSettings && $brandSettings->is_active && $brandSettings->logo_url)
                <img src="{{ $brandSettings->logo_url }}" alt="{{ $brandSettings->display_name }}" class="brand-logo">
            @endif
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
                            <img src="{{ asset('images/video-thumbnail.jpg') }}" alt="Personalized Video" class="video-thumbnail">
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="footer">
            @if($brandSettings && $brandSettings->is_active)
                <div style="margin-top: 10px; font-size: 14px; color: #ee0979;">
                    @if($brandSettings->display_name)
                        <p><strong>{{ $brandSettings->display_name }}</strong></p>
                    @endif
                    @if($brandSettings->phone)
                        <p>Phone: {{ $brandSettings->phone }}</p>
                    @endif
                    @if($brandSettings->email)
                        <p>Email: {{ $brandSettings->email }}</p>
                    @endif
                    @if($brandSettings->website)
                        <p>Website: <a href="{{ $brandSettings->website }}" style="color: #ff6a00;">{{ $brandSettings->website }}</a></p>
                    @endif
                </div>
            @else
                <p>{{ $campaign->template_data['footer_line1'] ?? 'Thank you for your time!' }}</p>
                <p>{{ $campaign->template_data['footer_line2'] ?? 'This email was sent as part of a personalized video campaign.' }}</p>
            @endif
        </div>
    </div>
    <!-- Tracking Pixel -->
    <img src="{{ $trackingPixel }}" class="tracking-pixel" alt="">
</body>
</html> 