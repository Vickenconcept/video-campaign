<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Georgia', serif; background-color: #f9fafb; }
        .container { max-width: 700px; margin: 48px auto; background-color: #ffffff; border-radius: 18px; box-shadow: 0 8px 32px rgba(139,92,246,0.10); border: 2px solid #8b5cf6; overflow: hidden; }
        .header { background-color: #f3f4f6; padding: 36px 24px 18px 24px; text-align: center; border-bottom: 3px solid #8b5cf6; }
        .brand-logo { max-height: 60px; max-width: 200px; margin-bottom: 10px; }
        .header-title { font-size: 30px; font-weight: bold; color: #1f2937; margin: 0 0 5px 0; }
        .header-subtitle { color: #6b7280; font-size: 15px; margin: 0; }
        .content { padding: 44px 24px; }
        .content-text { line-height: 1.7; color: #374151; font-size: 17px; margin-bottom: 32px; }
        .video-container { text-align: center; margin: 32px 0; position: relative; display: flex; justify-content: center; border-radius: 12px; overflow: hidden; border: 2px solid #8b5cf6; box-shadow: 0 4px 16px rgba(139,92,246,0.10); width: 100%; }
        .video-thumbnail-wrapper {
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
        .cta-button { display: inline-block; background-color: #8b5cf6; color: #ffffff; padding: 17px 36px; text-decoration: none; border-radius: 10px; font-weight: bold; font-size: 17px; margin: 24px 0; box-shadow: 0 2px 8px rgba(139,92,246,0.10); transition: background 0.2s; }
        .cta-button:hover { background: #6d28d9; }
        .footer { background-color: #f3f4f6; padding: 32px 24px; text-align: center; color: #6b7280; font-size: 13px; border-top: 1.5px solid #8b5cf6; }
        .tracking-pixel { width: 1px; height: 1px; opacity: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($brandSettings && $brandSettings->is_active && $brandSettings->logo_url)
                <img src="{{ $brandSettings->logo_url }}" alt="{{ $brandSettings->display_name }}" class="brand-logo">
            @endif
            <h1 class="header-title">{{ $campaign->title }}</h1>
            <p class="header-subtitle">{{ $brandSettings && $brandSettings->is_active ? $brandSettings->display_name : 'Personalized Video Campaign' }}</p>
        </div>
        <div class="content">
            <div class="content-text">
                {!! nl2br(e($campaign->body)) !!}
            </div>
            @if($campaign->video_url)
                <div class="video-container">
                    <a href="{{ $viewUrl }}" class="video-thumbnail-wrapper" style="text-decoration: none;">
                        <img src="{{ asset('images/video-thumbnail.jpg') }}" alt="Personalized Video" class="video-thumbnail">
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
            @if($brandSettings && $brandSettings->is_active)
                <div style="margin-top: 10px; font-size: 12px; color: #6b7280;">
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
                        <p>Website: <a href="{{ $brandSettings->website }}" style="color: #8b5cf6;">{{ $brandSettings->website }}</a></p>
                    @endif
                </div>
            @else
                <p>{{ $campaign->template_data['footer_line1'] ?? 'Thank you for your time!' }}</p>
                <p>{{ $campaign->template_data['footer_line2'] ?? 'This email was sent as part of a personalized video campaign.' }}</p>
                <p>{{ $campaign->template_data['footer_line3'] ?? 'If you have any questions, please don\'t hesitate to contact us.' }}</p>
            @endif
        </div>
    </div>
    <!-- Tracking Pixel -->
    <img src="{{ $trackingPixel }}" class="tracking-pixel" alt="">
</body>
</html> 