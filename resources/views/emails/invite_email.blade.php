<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Rating Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
        }

        p {
            color: #666666;
        }

        .rating {
            font-size: 24px;
            color: #ffc107;
            margin: 10px 0;
        }

        .review-content {
            color: #333333;
            margin: 10px 0;
        }

        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #ffffff;
            text-decoration: none;
            border-radius: 3px;
        }
    </style>
</head>

<body>

    <div class="container" style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <h2>Hello {{ $name ?: '' }},</h2>

        <p>We appreciate you connecting with us!</p>

        <p>To move forward, we need a quick response from you. It only takes a minute — just click the link or image
            below to continue:</p>

        <a href="{{ $link }}">
            <img height="270" style="border-radius: 16px; max-width: 460px; width: 100%;"
                src="https://res.cloudinary.com/videoask/image/fetch/t_social-image/https://images.pexels.com/videos/3002769/free-video-3002769.jpg?fit=crop&amp;w=1200&amp;h=630&amp;auto=compress&amp;cs=tinysrgb"
                alt="Continue Here" />
        </a>

        <p><strong>Required Action:</strong> Please <a href="{{ $link }}">click here</a> to take the next step.
            This is important to keep things moving forward.</p>

        <p>If you have any questions or need help, just reply to this email — we're here for you!</p>

        <p>Warm regards,</p>
        <p>The Team</p>

        <hr style="margin: 24px 0;" />

        <p style="font-size: 0.9em;">From: <a
                href="mailto:{{ auth()->user()->email }}">{{ auth()->user()->email }}</a></p>
    </div>


</body>

</html>
