I have researched the codebase and have a plan to implement the region restriction features.

### **1. Update Database Schema**

* **Modify** **`listings`** **table**:

  * Add `region_type` column (enum: 'global', 'include', 'exclude').

  * `region` column already exists but stores comma-separated strings. I will repurpose it to store the list of countries for 'include'/'exclude' modes.

### **2. Update Listing Creation (Frontend)**

* **Modify** **`description.blade.php`**:

  * Replace the current "Region" dropdown with a **Region Configuration** section.

  * **Radio Buttons**: "Global", "Select Supported Regions" (Include), "Exclude Specific Regions".

  * **Country Selector**: A `select2` multi-select dropdown populated with all countries from `CountryCodes.json`.

    * If "Global" is selected: Hide country selector.

    * If "Include" is selected: Show selector, user selects allowed countries.

    * If "Exclude" is selected: Show selector (pre-filled with all), user deselects countries to exclude (or selects ones to ban).

  * **Validation**: Ensure logic matches (e.g., if 'Include', at least one country must be selected).

### **3. Update Listing Controller**

* **Update** **`store`** **method**:

  * Handle `region_type` input.

  * Save `region` array as a JSON or comma-separated string based on the new logic.

### **4. Update Product Detail Page**

* **User Location Detection**:

  * Use the existing `getLocation()` helper (which uses `ip-api.com`) to get the visitor's country.

  * Fallback to `auth()->user()->country` if logged in. (here when user logged in and its coutry is in account for example x and its ip saying y then user should be warn about that)

* **Region Check Logic**:

  * Compare user's country against the product's `region_type` and `region` list.

  * **Global**: Always allowed.

  * **Include**: Allowed only if user's country is in the list.

  * **Exclude**: Allowed unless user's country is in the list.

* **UI Updates**:

  * **Badge**: Show "Active in \[User Country]" (Green) or "Not Available in \[User Country]" (Red) near the price/buy button.

  * **"Check Region Restrictions" Modal**:

    * Create a modal that lists all allowed/disallowed countries.

    * Highlight the user's current country.

### **5. Execution Plan**

1. **Migration**: Add `region_type` to `listings` table.
2. **Frontend (Create/Edit)**: Implement the complex region selector in `description.blade.php`.
3. **Backend (Controller)**: Update storage logic.
4. **Frontend (Details)**: Implement location check, badge, and modal.
5. all the migration i will run on server must make changes and push on server

