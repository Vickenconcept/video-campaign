# Brand Settings Feature

## Overview
The Brand Settings feature allows users to customize their brand information for email campaigns and communications. This replaces the default "Video Campaign" branding with the user's own brand information.

## Features

### Brand Information
- **Brand Name**: Custom brand name for emails
- **Address**: Business address
- **Phone**: Contact phone number
- **Website**: Company website URL
- **Email**: Contact email address

### Branding
- **Logo Upload**: Upload company logo to Cloudinary (max 2MB)

### Settings
- **Active/Inactive**: Toggle to enable/disable custom branding

## How It Works

### Email Templates
When a user has brand settings configured and enabled:
1. **Logo**: Displays in email headers
2. **Contact Information**: Shows in email footers
3. **Fallback**: If no custom settings, defaults to "Video Campaign" branding

### Database Structure
- `brand_settings` table stores user-specific brand information
- One-to-one relationship with users
- Automatic creation of default settings for new users

## Usage

### Accessing Brand Settings
1. Navigate to the sidebar
2. Click on "Brand Settings" (pink palette icon)
3. Fill in your brand information
4. Upload your logo to Cloudinary
5. Save settings

### Email Campaigns
- Brand settings are automatically applied to all email campaigns
- Users can preview how their brand will appear in emails
- Settings can be toggled on/off without losing data

## Technical Implementation

### Files Created/Modified
- `database/migrations/2025_09_01_091745_create_brand_settings_table.php`
- `app/Models/BrandSettings.php`
- `app/Livewire/BrandSettings.php`
- `resources/views/livewire/brand-settings.blade.php`
- `app/Mail/VideoEmailCampaignMailable.php`
- Email templates (classic.blade.php, modern.blade.php, welcome_email.blade.php)
- `routes/web.php` (added brand-settings route)
- `resources/views/components/sidebar.blade.php` (added navigation link)

### Key Methods
- `User::getBrandSettings()`: Gets or creates brand settings for a user
- `BrandSettings::getDisplayNameAttribute()`: Returns brand or company name
- `BrandSettings::getContactInfoAttribute()`: Returns formatted contact information

## Migration
Run the migration to create the brand_settings table:
```bash
php artisan migrate
```

## Notes
- Logo files are uploaded to Cloudinary in the `brand-logos` folder
- Brand settings are user-specific
- Email templates gracefully fall back to default branding if no custom settings are configured
