I will implement the requested changes to the product listing creation, detail page, and fix the dashboard table.

### **1. Listing Creation Updates (Frontend)**

* **Multi-Select for Region & Devices**:

  * Update `description.blade.php` to use `select2` for "Region" and "Supported Devices" fields, allowing multiple selections.

  * Remove `readonly` attribute from the "Product Name" field to make it editable.

  * **Dynamic Title Generation**: Add JavaScript to listen to changes in Catalog, Plan, Duration, Region, and Devices. It will auto-update the Product Name field with a format like `[Catalog Name] [Plan] [Duration]` (e.g., "Gemini Buy, 1 Month Pro") while still allowing manual edits.

* **Controller Update**:

  * Update `ListingController::store` method to handle array inputs for `region` and `devices`. It will save them as comma-separated strings (e.g., "US,EU,Global").

### **2. Product Detail Page Redesign**

* **Visual Enhancements**:

  * **Text Size**: Increase the overall font size for better readability (base text 15px/16px, headers larger).

  * **Buy Now Button**: Ensure it strictly uses the admin-defined site primary color (`var(--td-primary)`).

  * **Icons**: Replace current icons with **Solar Filled** icons (or similar bold/filled style) to better match the GamsGo aesthetic (e.g., filled stars, shields, globes).

* **Data Display**:

  * Update the "Region" and "Supported Devices" sections to display the multiple selected values (e.g., "PC, Mobile, PS5").

### **3. Fix "My Listing" Table Visibility**

* **Issue**: Values merging with the background.

* **Fix**: I will force the text color of the table cells in `index.blade.php` / `_common-dashboard-table.scss` to a dark contrast color (`#303030` or similar) to ensure they are always visible against the background.

### **4. Execution Plan**

1. **Modify Frontend View**: Update `description.blade.php` (multi-select, JS for title).
2. **Update Controller**: Handle array data in `ListingController`.
3. **Update Details Page**: Apply styling changes (font size, buttons) and icon updates in `details.blade.php`.
4. **Fix Table Styles**: Adjust CSS for the dashboard table to ensure text visibility.

