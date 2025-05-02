<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Language" content="bn" />
        <meta name="viewport" content="width=device-width, initial-scale=1">  
        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="shortcut icon" href="/favicon.ico">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "Organization",
              "name": "ShutkiMart",
              "url": "https://shutkimart.com",
              "logo": "https://shutkimart.com/upload/asset/shutki_mart_logo.png",
              "description": "ShutkiMart থেকে অর্ডার করুন কেমিকেল মুক্ত স্বাস্থ্যকর দেশি অর্গানিক শুটকি। ঘরে বসে পাচ্ছেন ফ্রি হোম ডেলিভারি।",
              "sameAs": [
                "https://www.facebook.com/shutkimartcxb",
                "https://www.instagram.com/shutkimartcxb"
              ]
            }
          </script>
        <!-- Scripts -->
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
          })(window,document,'script','dataLayer','GTM-KCLGDSL4');
        </script>
        <!-- End Google Tag Manager -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
      <!-- Google Tag Manager (noscript) -->
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KCLGDSL4"
          height="0" width="0" style="display:none;visibility:hidden"></iframe>
      </noscript>
      <!-- End Google Tag Manager (noscript) -->
        @inertia
    </body>
</html>
