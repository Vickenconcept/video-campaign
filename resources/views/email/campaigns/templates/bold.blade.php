<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Arial Black', 'Helvetica Bold', sans-serif; background-color: #000000; }
        .container { max-width: 800px; margin: 48px auto; background-color: #ffffff; border-radius: 20px; box-shadow: 0 12px 40px rgba(220,38,38,0.10); border: 2px solid #dc2626; overflow: hidden; }
        .header { text-align: center; padding: 54px 24px 30px 24px; background-color: #ffffff; border-bottom: 2px solid #dc2626; }
        .brand-logo { max-height: 60px; max-width: 200px; margin-bottom: 10px; }
        .title { font-size: 48px; font-weight: 900; color: #dc2626; margin: 0; text-transform: uppercase; letter-spacing: -1px; }
        .content { padding: 54px 24px; text-align: center; }
        .video-container { margin: 44px 0; position: relative; display: flex; justify-content: center; border-radius: 16px; overflow: hidden; border: 2px solid #dc2626; box-shadow: 0 8px 32px rgba(220,38,38,0.10); width: 100%; }
        .video-thumbnail-wrapper {
            position: relative;
            display: block;
            width: 100%;
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
        .cta-button { display: inline-block; background-color: #dc2626; color: #ffffff; padding: 22px 48px; text-decoration: none; border-radius: 14px; font-weight: 900; font-size: 26px; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 8px 16px rgba(220, 38, 38, 0.18); margin: 36px 0; transition: background 0.2s; }
        .cta-button:hover { background: #b91c1c; }
        .footer { text-align: center; padding: 36px 24px; background-color: #f3f4f6; color: #6b7280; font-size: 15px; border-top: 2px solid #dc2626; }
        .tracking-pixel { width: 1px; height: 1px; opacity: 0; }
        .content-text { font-size: 22px; line-height: 1.6; color: #1f2937; margin-bottom: 44px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($brandSettings && $brandSettings->is_active && $brandSettings->logo_url)
                <img src="{{ $brandSettings->logo_url }}" alt="{{ $brandSettings->display_name }}" class="brand-logo">
            @endif
            <h1 class="title">{{ $campaign->title }}</h1>
        </div>
        <div class="content">
            @if($campaign->video_url)
                <div class="video-container">
                    <a href="{{ $viewUrl }}" class="video-thumbnail-wrapper" style="text-decoration: none;">
                        <img src="{{ asset('images/video-thumbnail.jpg') }}" alt="Personalized Video" class="video-thumbnail">
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
            @if($brandSettings && $brandSettings->is_active)
                <div style="margin-top: 10px; font-size: 14px; color: #6b7280;">
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
                        <p>Website: <a href="{{ $brandSettings->website }}" style="color: #dc2626;">{{ $brandSettings->website }}</a></p>
                    @endif
                </div>
            @else
                <p><strong>{{ $campaign->template_data['footer_line1'] ?? 'PERSONALIZED VIDEO CAMPAIGN' }}</strong></p>
                <p>{{ $campaign->template_data['footer_line2'] ?? 'Don\'t miss out on this exclusive content!' }}</p>
            @endif
        </div>
    </div>
    <!-- Tracking Pixel -->
    <img src="{{ $trackingPixel }}" class="tracking-pixel" alt="">
</body>
</html> 