# TODO: Add Badminton Slider to Dashboard

## Information Gathered

-   The user dashboard (`resources/views/user/dashboard.blade.php`) currently has a hero slider that groups locations by type (e.g., futsal, badminton).
-   Below the hero slider, there are static cards displaying sample Futsal and Badminton fields.
-   The user wants a second slider specifically for Lapangan Badminton, where each slide represents an individual badminton field, and clicking navigates to the field's detail page (similar to how the hero slider works but dedicated to badminton locations).
-   Locations are passed as a collection, grouped by type in the hero slider.
-   JavaScript is generic and initializes all `.slider` elements, so adding another slider should work seamlessly.

## Plan

-   Add a new section after the hero slider in `resources/views/user/dashboard.blade.php`.
-   Filter locations where `type` is 'badminton'.
-   Create a slider with each slide representing one badminton location:
    -   Display the field's image (or placeholder).
    -   Show field name and price.
    -   Make the entire slide clickable to link to `route('locations.show', ['id' => $loc->id])`.
-   Use similar HTML structure and CSS classes as the hero slider for consistency.
-   Include accessibility features like ARIA labels, dots for navigation, and live announcements.

## Dependent Files to be Edited

-   `resources/views/user/dashboard.blade.php`: Add the new badminton slider section after the hero slider.

## Followup Steps

-   [x] Test the dashboard to ensure the new slider loads and functions correctly (navigation, clicks, autoplay).
-   [x] Verify that clicking a slide navigates to the correct location detail page.
-   [x] Check responsiveness on different screen sizes.
-   [x] If issues arise (e.g., with JavaScript or data), debug and fix accordingly.
