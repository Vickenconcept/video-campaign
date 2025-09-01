<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
    <style>
        body { margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 18px; box-shadow: 0 8px 32px rgba(0,0,0,0.10); border: 1.5px solid #e5e7eb; overflow: hidden; }
        .header { text-align: center; padding: 36px 24px 18px 24px; background-color: #f9fafb; border-bottom: 1px solid #e5e7eb; }
        .brand-logo { max-height: 60px; max-width: 200px; margin-bottom: 10px; }
        .content { padding: 36px 24px; text-align: center; }
        .video-container { position: relative; width: 100%; margin: 32px auto; border-radius: 12px; overflow: hidden; border: 2px solid #e0e7ef; box-shadow: 0 4px 16px rgba(0,0,0,0.07); }
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
        .cta-button { display: inline-block; background: linear-gradient(90deg, #3b82f6 0%, #6366f1 100%); color: #ffffff; padding: 15px 36px; text-decoration: none; border-radius: 10px; font-weight: bold; font-size: 18px; margin: 24px 0; box-shadow: 0 2px 8px rgba(59,130,246,0.10); transition: background 0.2s; }
        .cta-button:hover { background: linear-gradient(90deg, #6366f1 0%, #3b82f6 100%); }
        .footer { text-align: center; padding: 24px; background-color: #f8f9fa; color: #6c757d; font-size: 13px; border-top: 1px solid #e5e7eb; }
        .tracking-pixel { width: 1px; height: 1px; opacity: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($brandSettings && $brandSettings->is_active && $brandSettings->logo_url)
                <img src="{{ $brandSettings->logo_url }}" alt="{{ $brandSettings->display_name }}" class="brand-logo">
            @endif
            <h1 style="color: #1f2937; margin: 0; font-size: 30px; font-weight: 700; letter-spacing: -1px;">{{ $campaign->title }}</h1>
        </div>
        <div class="content">
            @if($campaign->video_url)
                <div class="video-container">
                    <a href="{{ $viewUrl }}" class="video-thumbnail-wrapper" style="text-decoration: none;">
                        <img src="{{ asset('images/video-thumbnail.jpg') }}" alt="Personalized Video" class="video-thumbnail">
                    </a>
                </div>
            @endif
            <div style="line-height: 1.7; color: #374151; font-size: 17px; margin-bottom: 32px; text-align: left;">
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
                <div style="margin-top: 10px; font-size: 12px; color: #6c757d;">
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
                        <p>Website: <a href="{{ $brandSettings->website }}" style="color: #667eea;">{{ $brandSettings->website }}</a></p>
                    @endif
                </div>
            @else
                <p>{{ $campaign->template_data['footer_line1'] ?? 'This email was sent as part of a personalized video campaign.' }}</p>
                <p>{{ $campaign->template_data['footer_line2'] ?? 'If you have any questions, please contact us.' }}</p>
            @endif
        </div>
    </div>
    <!-- Tracking Pixel -->
    <img src="{{ $trackingPixel }}" class="tracking-pixel" alt="">
</body>
</html> 