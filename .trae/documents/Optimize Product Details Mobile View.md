I have analyzed the `details.blade.php` file and the corresponding SCSS. The current mobile layout has a few issues:

1. **Image Positioning**: The thumbnail is currently forced to `margin: 0 auto` and centered on mobile, which pushes the title down and creates a disjointed look.
2. **Info Grid**: The `pd-info-grid` collapses to a single column (`1fr`) on mobile, making the list very long and taking up too much vertical space.
3. **Alignment**: Text alignment is forced to center/left in a way that might look messy on small screens.

**My Plan to Fix Mobile Layout:**

1. **Layout Restructuring (Mobile First approach via Media Queries)**:

   * **Thumbnail**: Instead of centering it as a block, I will let it be full-width or side-by-side with the title if space permits, but for true mobile, a full-width header image or a cleaner top-aligned image looks better. However, given the current structure, I will optimize the flex container.

   * **Info Grid**: I will change the mobile grid to **2 columns** (instead of 1) for the `pd-info-grid` where possible, or keep it 1 but reduce the gap and padding to make it more compact. Actually, for small screens, a 2-column grid for short info (like Region, Duration) is often better than a long list. I will check if `1fr 1fr` fits on mobile (min-width 350px).

2. **CSS Refactoring**:

   * Update the `@media (max-width: 991px)` block in `details.blade.php`.

   * Remove `text-align: center` for the summary to keep it left-aligned and clean (standard for e-commerce).

   * Adjust `pd-thumb` size on mobile to be responsive (e.g., `width: 80px` or `100px`) so it doesn't dominate the screen, or make it a full-width banner style if high-res. Given it's a "listing", a smaller square icon (like an app icon) next to the title is usually best.

3. **Specific Changes**:

   * **Header**: Flex row on mobile too! `flex-direction: row` (instead of column) for the thumbnail + title section, but make the thumbnail smaller (`80px`). This saves huge vertical space.

   * **Grid**: `grid-template-columns: 1fr 1fr` on mobile for the info grid.

   * **Spacing**: Reduce gaps from `24px` to `16px` on mobile.

**Execution Steps:**

1. Modify `resources/views/frontend/default/listings/details.blade.php`.
2. Update the `<style>` block to refine the media queries for `max-width: 768px`.

