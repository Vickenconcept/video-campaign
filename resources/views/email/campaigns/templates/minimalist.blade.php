<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #f7fafc; }
        .container { max-width: 500px; margin: 48px auto; padding: 0; background: #fff; border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.10); border: 1.5px solid #e5e7eb; overflow: hidden; }
        .header { margin-bottom: 0; padding: 36px 24px 18px 24px; background: #f9fafb; border-bottom: 1px solid #e5e7eb; }
        .brand-logo { max-height: 60px; max-width: 200px; margin-bottom: 10px; }
        .title { font-size: 28px; font-weight: 400; color: #1a202c; margin: 0; }
        .content { line-height: 1.7; color: #4a5568; font-size: 17px; margin-bottom: 32px; padding: 36px 24px; text-align: left; }
        .video-container { margin: 32px 0; position: relative; display: flex; justify-content: center; border-radius: 8px; overflow: hidden; border: 2px solid #e0e7ef; box-shadow: 0 4px 16px rgba(0,0,0,0.07); }
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
            border-radius: 8px;
            display: block;
        }
        .cta-button { display: inline-block; border: 1.5px solid #6366f1; color: #6366f1; padding: 12px 28px; text-decoration: none; border-radius: 6px; font-size: 16px; font-weight: 600; background: #f9fafb; margin: 24px 0; transition: background 0.2s, color 0.2s; }
        .cta-button:hover { background: #6366f1; color: #fff; }
        .footer { margin-top: 0; padding: 24px; border-top: 1px solid #e5e7eb; text-align: center; color: #718096; font-size: 13px; background: #f9fafb; }
        .tracking-pixel { width: 1px; height: 1px; opacity: 0; }
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
        <div class="footer">
            @if($brandSettings && $brandSettings->is_active)
                <div style="margin-top: 10px; font-size: 12px; color: #718096;">
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
                        <p>Website: <a href="{{ $brandSettings->website }}" style="color: #6366f1;">{{ $brandSettings->website }}</a></p>
                    @endif
                </div>
            @else
                <p>{{ $campaign->template_data['footer_line1'] ?? 'Personalized video campaign' }}</p>
            @endif
        </div>
    </div>
    <!-- Tracking Pixel -->
    <img src="{{ $trackingPixel }}" class="tracking-pixel" alt="">
</body>
</html> 