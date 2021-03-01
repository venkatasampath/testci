<?php

$protocol = 'https://';
if (! isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off') {
    $protocol = 'http://';
}

return [

    /*
     * Server
     *
     * Reference: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Server
     *
     * Note: when server is empty string, it will not add to response header
     */

    'server' => '',

    /*
     * X-Content-Type-Options
     *
     * Reference: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options
     *
     * Available Value: 'nosniff'
     */

    'x-content-type-options' => 'nosniff',

    /*
     * X-Download-Options
     *
     * Reference: https://msdn.microsoft.com/en-us/library/jj542450(v=vs.85).aspx
     *
     * Available Value: 'noopen'
     */

    'x-download-options' => 'noopen',

    /*
     * X-Frame-Options
     *
     * Reference: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options
     *
     * Available Value: 'deny', 'sameorigin', 'allow-from <uri>'
     */

    'x-frame-options' => 'sameorigin',

    /*
     * X-Permitted-Cross-Domain-Policies
     *
     * Reference: https://www.adobe.com/devnet/adobe-media-server/articles/cross-domain-xml-for-streaming.html
     *
     * Available Value: 'all', 'none', 'master-only', 'by-content-type', 'by-ftp-filename'
     */

    'x-permitted-cross-domain-policies' => 'none',

    /*
     * X-XSS-Protection
     *
     * Reference: https://blogs.msdn.microsoft.com/ieinternals/2011/01/31/controlling-the-xss-filter
     *
     * Available Value: '1', '0', '1; mode=block'
     */

    'x-xss-protection' => '1; mode=block',

    /*
     * Referrer-Policy
     *
     * Reference: https://w3c.github.io/webappsec-referrer-policy
     *
     * Available Value: 'no-referrer', 'no-referrer-when-downgrade', 'origin', 'origin-when-cross-origin',
     *                  'same-origin', 'strict-origin', 'strict-origin-when-cross-origin', 'unsafe-url'
     */

    'referrer-policy' => 'strict-origin-when-cross-origin',

    /*
     * Clear-Site-Data
     *
     * Reference: https://w3c.github.io/webappsec-clear-site-data/
     */

    'clear-site-data' => [
        'enable' => false,

        'all' => false,

        'cache' => true,

        'cookies' => true,

        'storage' => true,

        'executionContexts' => true,
    ],

    /*
     * HTTP Strict Transport Security
     *
     * Reference: https://developer.mozilla.org/en-US/docs/Web/Security/HTTP_strict_transport_security
     *
     * Please ensure your website had set up ssl/tls before enable hsts.
     */

    'hsts' => [
        'enable' => env('SECURITY_HEADER_HSTS_ENABLE', false),

        'max-age' => 31536000,

        'include-sub-domains' => true,
    ],

    /*
     * Expect-CT
     *
     * Reference: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Expect-CT
     */

    'expect-ct' => [
        'enable' => false,

        'max-age' => 2147483648,

        'enforce' => false,

        'report-uri' => null,
    ],

    /*
     * Public Key Pinning
     *
     * Reference: https://developer.mozilla.org/en-US/docs/Web/Security/Public_Key_Pinning
     *
     * hpkp will be ignored if hashes is empty.
     */

    'hpkp' => [
        'hashes' => [
            // 'sha256-hash-value',
        ],

        'include-sub-domains' => false,

        'max-age' => 31536000,

        'report-only' => false,

        'report-uri' => 'https://spawaskar.report-uri.com/r/d/hpkp/enforce',
//        'report-uri' => 'https://spawaskar.report-uri.com/r/d/hpkp/reportOnly',
    ],

    /*
     * Feature Policy
     *
     * Reference: https://wicg.github.io/feature-policy/
     */

    'feature-policy' => [
        'enable' => true,

        /*
         * Each directive details can be found on:
         *
         * https://github.com/WICG/feature-policy/blob/master/features.md
         *
         * 'none', '*' and 'self allow' are mutually exclusive,
         * the priority is 'none' > '*' > 'self allow'.
         */

        'camera' => [
            'none' => false,

            '*' => false,

            'self' => true,

            'allow' => [
                // 'url',
            ],
        ],

        'fullscreen' => [
            'none' => false,

            '*' => false,

            'self' => true,

            'allow' => [
                // 'url',
            ],
        ],

        'geolocation' => [
            'none' => false,

            '*' => false,

            'self' => true,

            'allow' => [
                // 'url',
            ],
        ],

        'microphone' => [
            'none' => false,

            '*' => false,

            'self' => true,

            'allow' => [
                // 'url',
            ],
        ],

        'midi' => [
            'none' => false,

            '*' => false,

            'self' => true,

            'allow' => [
                // 'url',
            ],
        ],

        'payment' => [
            'none' => false,

            '*' => false,

            'self' => true,

            'allow' => [
                // 'url',
            ],
        ],

//        'picture-in-picture' => [
//            'none' => false,
//
//            '*' => true,
//
//            'self' => false,
//
//            'allow' => [
//                // 'url',
//            ],
//        ],

        'accelerometer' => [
            'none' => false,

            '*' => false,

            'self' => true,

            'allow' => [
                // 'url',
            ],
        ],

        'ambient-light-sensor' => [
            'none' => false,

            '*' => false,

            'self' => true,

            'allow' => [
                // 'url',
            ],
        ],

        'gyroscope' => [
            'none' => false,

            '*' => false,

            'self' => true,

            'allow' => [
                // 'url',
            ],
        ],

        'magnetometer' => [
            'none' => false,

            '*' => false,

            'self' => true,

            'allow' => [
                // 'url',
            ],
        ],

        'speaker' => [
            'none' => false,

            '*' => false,

            'self' => true,

            'allow' => [
                // 'url',
            ],
        ],

        'usb' => [
            'none' => false,

            '*' => false,

            'self' => true,

            'allow' => [
                // 'url',
            ],
        ],

        'vr' => [
            'none' => false,

            '*' => false,

            'self' => true,

            'allow' => [
                // 'url',
            ],
        ],
    ],

    /*
     * Content Security Policy
     *
     * Reference: https://developer.mozilla.org/en-US/docs/Web/Security/CSP
     *
     * csp will be ignored if custom-csp is not null. To disable csp, set custom-csp to empty string.
     *
     * Note: custom-csp does not support report-only.
     */

    'custom-csp' => null,
//    'custom-csp' => "",

    'csp' => [
        'report-only' => false,

        'report-uri' => 'https://spawaskar.report-uri.com/r/d/csp/enforce',
//        'report-uri' => 'https://spawaskar.report-uri.com/r/d/csp/reportOnly',

        'block-all-mixed-content' => false,

        'upgrade-insecure-requests' => false,

        /*
         * Please references script-src directive for available values, only `script-src` and `style-src`
         * supports `add-generated-nonce`.
         *
         * Note: when directive value is empty, it will use `none` for that directive.
         */

        'script-src' => [
            'allow' => [
                $protocol.'ajax.googleapis.com',
                $protocol.'maps.googleapis.com',
                $protocol.'developers.google.com',
                $protocol.'code.jquery.com',
                $protocol.'www.googletagmanager.com',
                $protocol.'www.google-analytics.com',
                $protocol.'tagmanager.google.com',
                $protocol.'stackpath.bootstrapcdn.com',
                $protocol.'cdnjs.cloudflare.com',
                $protocol.'cdn.datatables.net',
                $protocol.'s3.amazonaws.com',
                $protocol.'www.youtube.com',
                $protocol.'d3js.org',
                $protocol.'vizjs.org'
            ],

            'hashes' => [
                // 'sha256' => [
                //     'hash-value',
                // ],
            ],

            'nonces' => [
                // 'base64-encoded',
            ],

            'schemes' => [
                'https:',
            ],

            'self' => true,

            'unsafe-inline' => true,

            'unsafe-eval' => true,

            'strict-dynamic' => false,

            'unsafe-hashed-attributes' => false,

            'add-generated-nonce' => false,
        ],

        'style-src' => [
            'allow' => [
                $protocol.'fonts.googleapis.com',
                $protocol.'developers.google.com',
                $protocol.'stackpath.bootstrapcdn.com',
                $protocol.'cdnjs.cloudflare.com',
                $protocol.'cdn.datatables.net',
                $protocol.'use.fontawesome.com',
            ],

            'hashes' => [
                // 'sha256' => [
                //     'hash-value',
                // ],
            ],

            'nonces' => [
                //
            ],

            'schemes' => [
                'https:',
            ],

            'self' => true,

            'unsafe-inline' => true,

            'add-generated-nonce' => false,
        ],

        /*
         * The 'data' => false is the most secure option.
         * So using 'data' => 'image/png' is less secure.
         * once the plugin (chatter) using this is fixed, to revert back.
         */
        'img-src' => [
            'allow' => [
                $protocol.'maps.gstatic.com',
                $protocol.'developers.google.com',
                $protocol.'maps.googleapis.com',
                $protocol.'www.google-analytics.com',
                $protocol.'www.googletagmanager.com',
                $protocol.'chart.googleapis.com',
                $protocol.'spawaskar-cora.s3.us-west-2.amazonaws.com',
                $protocol.'spawaskar-cora-cat.s3.us-west-2.amazonaws.com',
            ],

            'types' => [
                //
            ],

            'self' => true,

            'schemes' => [
                'data:',
                'https:',
            ],
        ],

        'default-src' => [
            'self' => true,
        ],

        'child-src' => [
            'allow' => [
                $protocol.'cora-docs.readthedocs.io',
                $protocol.'www.youtube.com',
            ],
            'self' => true,
        ],

        'base-uri' => [
            //
        ],

        'connect-src' => [
            'self' => true,
        ],

        /*
         * The following directives are all use 'allow' and 'self' flag.
         *
         * Note: default value of 'self' flag is false.
         */
        'font-src' => [
            'allow' => [
                $protocol.'fonts.gstatic.com',
                $protocol.'cdnjs.cloudflare.com',
                $protocol.'use.fontawesome.com',
            ],

            'self' => true,

            'schemes' => [
                'data:',
                'https:',
            ],
        ],

        'form-action' => [
            'self' => true,
        ],

        'frame-ancestors' => [
            'self' => true,
        ],

        'frame-src' => [
            'allow' => [
                $protocol.'cora-docs.readthedocs.io',
                $protocol.'www.youtube.com',
                $protocol.'content.googleapis.com',
                $protocol.'accounts.google.com',
            ],

            'self' => true,
        ],

        'manifest-src' => [
            //
        ],

        'media-src' => [
            'allow' => [
                $protocol.'www.youtube.com',
                $protocol.'m.youtube.com',
                $protocol.'youtubei.googleapis.com',
                $protocol.'youtube.googleapis.com',
                $protocol.'www.youtube-nocookie.com',
            ],
        ],

        'object-src' => [
            'allow' => [
                $protocol.'cora-docs.readthedocs.io',
            ],
        ],

        'worker-src' => [
            //
        ],

        'plugin-types' => [
            // 'application/x-shockwave-flash',
        ],

        'require-sri-for' => '',

        'sandbox' => '',

    ],

];
