# Opton framework
Right now, I am only sharing example code, but I will add detailed instructions later.

## Metabox code example

```
<?php

use Giganteck\Opton\Abstracts\Metabox;
use Giganteck\Opton\Form;
use Giganteck\Opton\Field;

class My_Metabox extends Metabox
{
    protected function theme(): string
    {
        return 'default'; // another theme is 'modern'
    }

    protected function id(): string
    {
        return 'my_opton_box';
    }

    protected function title(): string
    {
        return 'Opton Example';
    }

    protected function screen(): string|array
    {
        return ['post', 'page'];
    }

    protected function pageTitle(): string
    {
        return 'Opton Fields';
    }

    protected function menus(): ?array
    {
        return ['general' => 'General', 'extra' => 'Extra'];
    }

    protected function form(Form $form): void
    {
        // General Page
        $form->page('general', function($section) {
            $section('Basic Information')->grid(2)->fields(
                Field::text('full_name')->label('Full Name')->placeholder('Enter full name'),
                Field::text('first_name')->label('First Name')->placeholder('Enter first name'),
                Field::text('middle_name')->label('Middle Name')->placeholder('Enter middle name')->fullCol(),
                Field::select('area_name')->label('Area Name')->options(['us' => 'USA', 'ca' => 'Canada']),
                Field::text('last_name')->label('Last Name')->placeholder('Enter last name')
            );

            $section('Contact Information')->grid(2)->repeater(
                Field::text('phone_number')->label('Phone Number')->placeholder('+1234567890'),
                Field::select('phone_type')->label('Phone Type')->options(['mobile' => 'Mobile', 'home' => 'Home', 'work' => 'Work']),
            );

            $section('Addresses')->grid(3)->repeater(
                Field::text('street')->label('Street'),
                Field::text('city')->label('City'),
                Field::text('state')->label('State'),
                Field::text('postal_code')->label('Postal Code'),
                Field::select('country')->label('Country')->options(['us' => 'USA', 'ca' => 'Canada', 'uk' => 'UK']),
                Field::textarea('notes_two')->label('Notes')->placeholder('Additional notes')->fullCol()
            );
        });

        // Extra page
        $form->page('extra', function($section) {
            $section('Contact')->grid(2)->fields(
                Field::email('email')->label('Email')->placeholder('user@example.com'),
                Field::text('phone')->label('Phone')->placeholder('+1234567890'),
                Field::textarea('notes')->label('Notes')->placeholder('Optional notes')->fullCol()
            );
        });
    }
}
```

## Setting code example

```
<?php

use Giganteck\Opton\Abstracts\Setting;
use Giganteck\Opton\Form;
use Giganteck\Opton\Field;

class My_Settings extends Setting
{
    protected function theme(): string
    {
        return 'default'; // 'modern'
    }

    protected function pageTitle(): string
    {
        return 'My Plugin Settings';
    }

    protected function menuTitle(): string
    {
        return 'My Plugin';
    }

    protected function capability(): string
    {
        return 'manage_options';
    }

    protected function menuSlug(): string
    {
        return 'my-plugin-settings';
    }

    protected function description(): string
    {
        return 'Configure your plugin settings below.';
    }

    protected function icon(): string
    {
        return 'dashicons-admin-settings';
    }

    protected function position(): ?int
    {
        return 30;
    }

    protected function menus(): ?array
    {
        return [
            'general' => 'General Settings',
            'advanced' => 'Advanced Settings',
            'integrations' => 'Integrations'
        ];
    }

    protected function form(Form $form): void
    {
        $form->page('general', function($section) {
            $section('Site Information')->grid(2)->fields(
                Field::text('site_name')->label('Site Name')->placeholder('Enter site name'),
                Field::text('site_tagline')->label('Site Tagline')->placeholder('Enter tagline'),
                Field::email('admin_email')->label('Admin Email')->placeholder('admin@example.com'),
                Field::text('contact_phone')->label('Contact Phone')->placeholder('+1234567890'),
            );

            // Social Media Links
            $section('Social Media')->grid(2)->fields(
                Field::text('facebook_url')->label('Facebook URL')->placeholder('https://facebook.com/...'),
                Field::text('twitter_url')->label('Twitter URL')->placeholder('https://twitter.com/...'),
                Field::text('instagram_url')->label('Instagram URL')->placeholder('https://instagram.com/...'),
                Field::text('linkedin_url')->label('LinkedIn URL')->placeholder('https://linkedin.com/...')
            );
        });

        // Advanced Options
        $form->page('advanced', function($section) {
            $section('Performance')->grid(4)->fields(
                Field::checkbox('enable_cache')->label('Enable Caching')->value('yes'),
                Field::checkbox('subscribe_newsletter')
                    ->description('Receive weekly updates about new features')
                    ->label('Subscribe to Newsletter')
                    ->value('1'),
                Field::select('cache_duration')->label('Cache Duration')->options([
                    '3600' => '1 Hour',
                    '7200' => '2 Hours',
                    '86400' => '24 Hours',
                    '604800' => '7 Days'
                ]),
                Field::date('my_date')->id('date_id')->label('Date label'),
            );

            $section('Gender')->grid(4)->fields(
                Field::radio('gender')
                    ->label('Gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other'
                    ])

            );

            // API Settings
            $section('API Configuration')->grid(2)->fields(
                Field::text('api_key')->label('API Key')->placeholder('Enter your API key'),
                Field::text('api_secret')->label('API Secret')->placeholder('Enter your API secret'),
                Field::textarea('webhook_url')->label('Webhook URL')->placeholder('https://example.com/webhook')->fullCol()
            );
        });

        // Third-party Integrations
        $form->page('integrations', function($section) {
            $section('Third Party Services')->grid(2)->repeater(
                Field::text('service_name')->label('Service Name'),
                Field::text('service_key')->label('API Key'),
                Field::select('service_status')->label('Status')->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive'
                ])
            );
        });
    }
}
```
