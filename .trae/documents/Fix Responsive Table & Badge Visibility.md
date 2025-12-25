I have analyzed the issues and here is my plan to fix them:

### **1. Fix Responsive Table in "My Listings" Page**

*   **Issue**: The table on the "My Listing" page (`resources/views/frontend/default/listings/index.blade.php`) overflows or breaks layout on smaller screens.
*   **Fix**:
    *   Ensure the table container has `overflow-x: auto` to allow horizontal scrolling on small screens.
    *   The existing structure uses `common-table-full` which should handle this, but I will reinforce it with Bootstrap's `table-responsive` class on the wrapper div.
    *   Verify the container width settings in SCSS to ensure it fits the viewport properly.

### **2. Fix "White Text on White Background" Badges**

*   **Issue**: The user reports badges are merging because they have white text on a white background. This typically happens when a specific class (like `badge-2` combined with a color class) isn't applying the background color correctly, or is being overridden.
*   **Investigation**:
    *   In `_badge.scss`, `.badge` has `color: #fff !important`.
    *   Classes like `.info`, `.warning`, `.success` set the `background-color`.
    *   However, if a badge has *only* `.badge` and `.badge-2` but misses a specific color class (or if the color class is overridden by a specific context), it defaults to the primary color.
    *   The user mentioned "white text on white background", which implies the background color is missing or forced to white.
*   **Fix**:
    *   I will modify `resources/views/frontend/default/listings/index.blade.php` to ensure all badges have distinct, valid color classes.
    *   I will update `_badge.scss` to ensure that even if a specific color class is missing, it falls back to a visible color scheme (e.g., primary blue background) rather than white-on-white.
    *   Specifically, I will check the badges for `productCatalog->name`, `selected_duration`, and `selected_plan` in the loop to ensure they have the correct `info`, `warning`, `success` classes applied correctly.

### **Execution Plan**

1.  **Modify `index.blade.php`**:
    *   Wrap the table in `<div class="table-responsive">`.
    *   Add `gap-1` or `gap-2` to the flex container for badges to prevent them from merging visually.
    *   Review badge classes to ensure contrast.

2.  **Update SCSS (`_badge.scss` or `_common-dashboard-table.scss`)**:
    *   Add a specific rule to ensure badges inside tables always have a distinct background color.
    *   Fix any potential width issues causing the table to overflow its parent.

3.  **Compile/Save**: (Since I can't run a build process, I will edit the source files directly which should be picked up if the user is running a watcher, or I'll edit the plain CSS if available/relevant, but usually editing the blade + scss source is the way to go here). *Wait, I will edit the Blade file to add inline styles or Bootstrap utility classes for immediate fixes if SCSS compilation isn't possible.* **Correction**: I will edit the Blade file to use standard Bootstrap responsive classes which are likely already available.

