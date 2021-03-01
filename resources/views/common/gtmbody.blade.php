{{--
 * Google Tag Manager
 *
 * this code must be placed immediately after the opening <body> tag:
 *
 * @category   GoogleTagManager in body of document
 * @package    Common
 * @author     Sachin Pawaskar - spawaskar@unomaha.edu
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
--}}

<!-- Google Tag Manager (noscript) -->
@if (App::environment('production'))
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TMZMS8N" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
@else <!--local/CAT/DEV -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WVX76XZ" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
@endif
<!-- End Google Tag Manager (noscript) -->