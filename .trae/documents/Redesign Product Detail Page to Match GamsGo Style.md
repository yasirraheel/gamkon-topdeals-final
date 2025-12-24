I have updated the plan to include the backend features you requested (Region and Platform management).

### **1. Database & Backend Updates (New Features)**

* **Database Migrations**:
  * Add `regions` and `platforms` columns to the `product_catalogs` table (so Admin can define them).
  * Add `region` and `devices` columns to the `listings` table (so Sellers can select them).

* **Admin Panel**:
  * Update **Product Catalog** pages (Create/Edit) to allow Admins to define available "Regions" (e.g., Global, US, EU) and "Platforms" (e.g., PC, PS5, Xbox).

* **Seller Dashboard**:
  * Update **Listing Creation/Edit** page to include dropdowns for **Region** and **Supported Devices**. These options will populate based on the Product Catalog selected by the seller.

### **2. Frontend Redesign (Product Page)**

* **Layout & Style**:
  * Implement the GamsGo-style 2-column layout (Left: Info, Right: Purchase).
  * Use **Topdealsplus** branding (Theme Primary Color) for the "Buy Now" button instead of hardcoded red.

* **Dynamic Content**:
  * **Region**: Display the dynamically selected Region (e.g., "Global" or "Pakistan") with a "Check region restrictions" link.
  * **Supported Devices**: Display the dynamically selected Platforms (e.g., "PC, Mac").
  * **Sharing Method & Duration**: Continue using existing dynamic data.

* **Modals & Trust Badges**:
  * **Refund Guarantee**: Update text to mention "**Topdealsplus**" instead of GamsGo.
  * **Express Checkout**: Create a new modal explaining the Express Checkout feature.

### **3. Execution Steps**

1.  **Create Migrations**: Add necessary columns to `product_catalogs` and `listings`.
2.  **Update Admin Views**: Add inputs for Regions and Platforms in Product Catalog management.
3.  **Update Seller Views**: Add selection fields in Listing creation wizard.
4.  **Update Controllers**: Ensure new data is saved correctly.
5.  **Redesign Product Page**: Implement the visual changes in `details.blade.php` using the new dynamic data.

This plan ensures everything is dynamic and managed from the Admin/Seller panels as requested.
