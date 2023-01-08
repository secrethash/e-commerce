<!DOCTYPE html>
<html class="no-js" lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title>
            @hasSection('title')
                @yield('title')
            @endif
            @sectionMissing('title')
                {{ config('app.name') }} - {{ config('app.tagline') }}
            @endif
        </title>
        <meta name="description"
            content="240+ Best Bootstrap Templates are available on this website. Find your template for your project compatible with the most popular HTML library in the world." />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="profile" href="https://gmpg.org/xfn/11">
        <link rel="canonical" href="Replace_with_your_PAGE_URL" />

        <!-- Open Graph (OG) meta tags are snippets of code that control how URLs are displayed when shared on social media  -->
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Add a Title" />
        <meta property="og:url" content="PAGE_URL" />
        <meta property="og:site_name" content="SITE_NAME" />
        <!-- For the og:image content, replace the # with a link of an image -->
        <meta property="og:image" content="#" />
        <meta property="og:description" content="Add_Description_Text" />
        <meta name="robots" content="noindex, follow" />
        <!-- Add site Favicon -->
        <link rel="icon" href="{{asset('frontend/assets/images/favicon/manarat-favicon.png')}}" sizes="32x32" />
        <link rel="icon" href="{{asset('frontend/assets/images/favicon/manarat-favicon.png')}}" sizes="192x192" />
        <link rel="apple-touch-icon" href="{{asset('frontend/assets/images/favicon/manarat-favicon.png')}}" />
        <meta name="msapplication-TileImage" content="{{asset('frontend/assets/images/favicon/manarat-favicon.png')}}" />
        <!-- Structured Data  -->
        <script type="application/ld+json">
            {
            "@context": "http://schema.org",
            "@type": "WebSite",
            "name": "Replace_with_your_site_title",
            "url": "Replace_with_your_site_URL"
            }
        </script>
        @include('includes.styles')
    </head>

    <body>
        @include('components.header')
        @yield('content')
        @include('components.footer')
        @include('includes.scripts')
        @yield('scripts')
    </body>

</html>
