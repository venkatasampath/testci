Laravel Dusk QA Resources
The authority for Laravel Dusk official documentation: https://laravel.com/docs/5.6/dusk

Key Dusk functionality:
-Elements: https://laravel.com/docs/5.6/dusk#interacting-with-elements
--Frequent selector/tag usage on elements will make testing go much smoother :)
-Pages: https://laravel.com/docs/5.6/dusk#pages
--Pages contain tests that run on each page (e.g., home, login, admin, etc.) and can be used by any test that uses that page
-Components: https://laravel.com/docs/5.6/dusk#components
--Components contain tests on each component (e.g., navigation bar, slide out, hover, etc.) and be used by any test that touches that component

Laracasts.com Tutorials:
-Browser Testing with Laravel Dusk: https://laracasts.com/series/whats-new-in-laravel-5-4/episodes/9
-Learning Dusk: https://laracasts.com/series/whatcha-working-on/episodes/10

Long Tutorial:
https://www.youtube.com/watch?v=V75hPsS6cvk
While lengthy, I found this video helpful as it walks through a handful of examples for using Laravel Dusk. I notated the video into sections below that may help you pick and choose what you'd like to watch depending on your level of familiarity. If you're a visual learner this video is definitely the way to go, if you're more apt to reading, the formal Dusk documentation helpful as well: https://laravel.com/docs/5.6/dusk.

0-4:30 Good overview of Dusk
4:30-11:30 Installation although without first checking with the dev team this may or may not directly apply
11:30 Shifts to writing test cases
17:00 Generating a dusk test for user login
20:00-29:30 Line by line explanation of a test case and results of successful and unsuccessful tests, if you watch nothing else I think this would be most helpful bit especially for dusk novices like myself
29:30+ Walkthrough of the Laravel Dusk documentation: https://laravel.com/docs/5.6/dusk, this section gives helpful detail about getting and setting attributes

Less Long Tutorial:
https://www.youtube.com/watch?v=wukkagu9UNY&t=319s
This video is much shorter than the first and is helpful when discussing how to tag and select elements when using Dusk

0-3:30 Installation
3:30 Test cases
9:00 Shows how to add an id/tag to a page element, the official documentation is also a great resource for explaning interaction with elements: https://laravel.com/docs/5.6/dusk#interacting-with-elements

Additional Dusk Test Example:
Although not as extensive as the YouTube videos, this article is much shorter with a few Dusk test examples
https://www.sitepoint.com/laravel-dusk-intuitive-and-easy-browser-testing-for-all/
