<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\DamageProductController;
use App\Http\Controllers\Backend\DepartmentController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\PurchaseController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\RequisitionController;
use App\Http\Controllers\Backend\IssueController;
use App\Http\Controllers\Backend\ReturnPurchaseController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SaleController;
use App\Http\Controllers\Backend\SaleReturnController;
use App\Http\Controllers\Backend\SupplierController;
use App\Http\Controllers\Backend\TransferController;
use App\Http\Controllers\Backend\WareHouseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SemesterController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalProducts = \App\Models\Product::count();
    $totalUsers = \App\Models\User::count();
    $totalSuppliers = \App\Models\Supplier::count();
    $totalPurchase = \App\Models\Purchase::count();
    $totalRequisitions = \App\Models\Requisition::count();
    $totalIssues = \App\Models\Issue::count();
    $totalDamageProducts = \App\Models\DamageProduct::count();
    $totalCategories = \App\Models\ProductCategory::count();
    $totalBrands = \App\Models\Brand::count();
    $totalSemesters = \App\Models\Semester::count();
    $totalDepartments = \App\Models\Department::count();

    return view('admin.index', compact(
        'totalProducts',
        'totalUsers',
        'totalSuppliers',
        'totalPurchase',
        'totalRequisitions',
        'totalIssues',
        'totalDamageProducts',
        'totalCategories',
        'totalBrands',
        'totalSemesters',
        'totalDepartments'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

Route::middleware('auth')->group(function () {

    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/profile/store', [AdminController::class, 'ProfileStore'])->name('profile.store');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');

});


Route::middleware('auth')->group(function () {

    Route::controller(BrandController::class)->group(function () {
        Route::get('/all/brand', 'AllBrand')->name('all.brand');
        Route::get('/add/brand', 'AddBrand')->name('add.brand');
        Route::post('/store/brand', 'StoreBrand')->name('store.brand');
        Route::get('/edit/brand/{id}', 'EditBrand')->name('edit.brand');
        Route::post('/update/brand', 'UpdateBrand')->name('update.brand');
        Route::get('/delete/brand/{id}', 'DeleteBrand')->name('delete.brand');
    });

    Route::controller(WareHouseController::class)->group(function () {
        Route::get('/all/warehouse', 'AllWarehouse')->name('all.warehouse');
        Route::get('/add/warehouse', 'AddWarehouse')->name('add.warehouse');
        Route::post('/store/warehouse', 'StoreWarehouse')->name('store.warehouse');
        Route::get('/edit/warehouse/{id}', 'EditWarehouse')->name('edit.warehouse');
        Route::post('/update/warehouse', 'UpdateWarehouse')->name('update.warehouse');
        Route::get('/delete/warehouse/{id}', 'DeleteWarehouse')->name('delete.warehouse');
    });


    Route::controller(SupplierController::class)->group(function () {
        Route::get('/all/supplier', 'AllSupplier')->name('all.supplier');
        Route::get('/add/supplier', 'AddSupplier')->name('add.supplier');
        Route::post('/store/supplier', 'StoreSupplier')->name('store.supplier');
        Route::get('/edit/supplier/{id}', 'EditSupplier')->name('edit.supplier');
        Route::post('/update/supplier', 'UpdateSupplier')->name('update.supplier');
        Route::get('/delete/supplier/{id}', 'DeleteSupplier')->name('delete.supplier');
    });

    Route::controller(SemesterController::class)->group(function () {
        Route::get('/all/semester', 'AllSemester')->name('all.semester');
        Route::get('/add/semester', 'AddSemester')->name('add.semester');
        Route::post('/store/semester', 'StoreSemester')->name('store.semester');
        Route::get('/edit/semester/{id}', 'EditSemester')->name('edit.semester');
        Route::post('/update/semester', 'UpdateSemester')->name('update.semester');
        Route::get('/delete/semester/{id}', 'DeleteSemester')->name('delete.semester');
    });

    Route::controller(DepartmentController::class)->group(function () {
        Route::get('/all/department', 'AllDepartment')->name('all.department');
        Route::get('/add/department', 'AddDepartment')->name('add.department');
        Route::post('/store/department', 'StoreDepartment')->name('store.department');
        Route::get('/edit/department/{id}', 'EditDepartment')->name('edit.department');
        Route::post('/update/department', 'UpdateDepartment')->name('update.department');
        Route::get('/delete/department/{id}', 'DeleteDepartment')->name('delete.department');
    });

    Route::controller(SupplierController::class)->group(function () {
        Route::get('/all/customer', 'AllCustomer')->name('all.customer');
        Route::get('/add/customer', 'AddCustomer')->name('add.customer');
        Route::post('/store/customer', 'StoreCustomer')->name('store.customer');
        Route::get('/edit/customer/{id}', 'EditCustomer')->name('edit.customer');
        Route::post('/update/customer', 'UpdateCustomer')->name('update.customer');
        Route::get('/delete/customer/{id}', 'DeleteCustomer')->name('delete.customer');
    });


    Route::controller(ProductController::class)->group(function () {
        Route::get('/all/category', 'AllCategory')->name('all.category');
        Route::post('/store/category', 'StoreCategory')->name('store.category');
        Route::get('/edit/category/{id}', 'EditCategory');
        Route::post('/update/category', 'UpdateCategory')->name('update.category');
        Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');

        Route::get('/all/subcategory', 'AllSubcategory')->name('all.subcategory');
        Route::get('/add/subcategory', 'AddSubcategory')->name('add.subcategory');
        Route::post('/store/subcategory', 'StoreSubcategory')->name('store.subcategory');
        Route::get('/edit/subcategory/{id}', 'EditSubcategory')->name('edit.subcategory');
        Route::get('/edit/subcategory/page/{id}', 'EditSubcategoryPage')->name('edit.subcategory.page');
        Route::post('/update/subcategory', 'UpdateSubcategory')->name('update.subcategory');
        Route::get('/delete/subcategory/{id}', 'DeleteSubcategory')->name('delete.subcategory');
        Route::get('/get/subcategory/{category_id}', 'GetSubcategory');

    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/all/product', 'AllProduct')->name('all.product');
        Route::get('/add/product', 'AddProduct')->name('add.product');
        Route::post('/store/product', 'StoreProduct')->name('store.product');
        Route::get('/edit/product/{id}', 'EditProduct')->name('edit.product');
        Route::post('/update/product', 'UpdateProduct')->name('update.product');
        Route::get('/delete/product/{id}', 'DeleteProduct')->name('delete.product');
        Route::get('/details/product/{id}', 'DetailsProduct')->name('details.product');
    });

    Route::controller(DamageProductController::class)->group(function () {
        Route::get('/all/damage-product', 'AllDamageProduct')->name('all.damage.product');
        Route::get('/add/damage-product', 'AddDamageProduct')->name('add.damage.product');
        Route::get('/damage-product/product/search', 'DamageProductProductSearch')->name('damage.product.product.search');
        Route::get('/damage-product/get/users/by/department/{department_id}', 'GetUsersByDepartment')->name('damage.product.get.users.by.department');

        Route::post('/store/damage-product', 'StoreDamageProduct')->name('store.damage.product');
        Route::get('/edit/damage-product/{id}', 'EditDamageProduct')->name('edit.damage.product');
        Route::post('/update/damage-product/{id}', 'UpdateDamageProduct')->name('update.damage.product');

        Route::get('/details/damage-product/{id}', 'DetailsDamageProduct')->name('details.damage.product');
        Route::get('/invoice/damage-product/{id}', 'InvoiceDamageProduct')->name('invoice.damage.product');
        Route::get('/delete/damage-product/{id}', 'DeleteDamageProduct')->name('delete.damage.product');
    });

    Route::controller(PurchaseController::class)->group(function () {
        Route::get('/all/purchase', 'AllPurchase')->name('all.purchase');
        Route::get('/add/purchase', 'AddPurchase')->name('add.purchase');
        Route::get('/purchase/product/search', 'PurchaseProductSearch')->name('purchase.product.search');
        Route::get('/get/users/by/department/{department_id}', 'GetUsersByDepartment')->name('get.users.by.department');

        Route::post('/store/purchase', 'StorePurchase')->name('store.purchase');
        Route::get('/edit/purchase/{id}', 'EditPurchase')->name('edit.purchase');
        Route::post('/update/purchase/{id}', 'UpdatePurchase')->name('update.purchase');

        Route::get('/details/purchase/{id}', 'DetailsPurchase')->name('details.purchase');
        Route::get('/view/purchase/file/{id}', 'ViewPurchaseFile')->name('view.purchase.file');
        Route::get('/invoice/purchase/{id}', 'InvoicePurchase')->name('invoice.purchase');
        Route::get('/delete/purchase/{id}', 'DeletePurchase')->name('delete.purchase');
    });

    Route::controller(ReturnPurchaseController::class)->group(function () {
        Route::get('/all/return/purchase', 'AllReturnPurchase')->name('all.return.purchase');
        Route::get('/add/return/purchase', 'AddReturnPurchase')->name('add.return.purchase');
        Route::post('/store/return/purchase', 'StoreReturnPurchase')->name('store.return.purchase');

        Route::get('/details/return/purchase/{id}', 'DetailsReturnPurchase')->name('details.return.purchase');
        Route::get('/invoice/return/purchase/{id}', 'InvoiceReturnPurchase')->name('invoice.return.purchase');
        Route::get('/view/return/purchase/file/{id}', 'ViewReturnPurchaseFile')->name('view.return.purchase.file');
        Route::get('/edit/return/purchase/{id}', 'EditReturnPurchase')->name('edit.return.purchase');
        Route::post('/update/return/purchase/{id}', 'UpdateReturnPurchase')->name('update.return.purchase');
        Route::get('/delete/return/purchase/{id}', 'DeleteReturnPurchase')->name('delete.return.purchase');

    });

    Route::controller(RequisitionController::class)->group(function () {
        Route::get('/my/requisition', 'MyRequisition')->name('my.requisition');
        Route::get('/all/requisition', 'AllRequisition')->name('all.requisition');
        Route::get('/add/requisition', 'AddRequisition')->name('add.requisition');
        Route::get('/requisition/product/search', 'RequisitionProductSearch')->name('requisition.product.search');
        Route::post('/store/requisition', 'StoreRequisition')->name('store.requisition');
        Route::get('/edit/requisition/{id}', 'EditRequisition')->name('edit.requisition');
        Route::post('/update/requisition/{id}', 'UpdateRequisition')->name('update.requisition');
        Route::get('/details/requisition/{id}', 'DetailsRequisition')->name('details.requisition');
        Route::get('/invoice/requisition/{id}', 'InvoiceRequisition')->name('invoice.requisition');
        Route::get('/delete/requisition/{id}', 'DeleteRequisition')->name('delete.requisition');
        Route::post('/issue/requisition/{id}', 'IssueRequisition')->name('issue.requisition');
    });

    Route::controller(IssueController::class)->group(function () {
        Route::get('/my/issue', 'MyIssue')->name('my.issue');
        Route::get('/all/issue', 'AllIssue')->name('all.issue');
        Route::get('/add/issue', 'AddIssue')->name('add.issue');
        Route::get('/issue/get/users/by/department/{department_id}', 'GetUsersByDepartment')->name('issue.get.users.by.department');
        Route::get('/issue/product/search', 'IssueProductSearch')->name('issue.product.search');
        Route::post('/store/issue', 'StoreIssue')->name('store.issue');
        Route::get('/edit/issue/{id}', 'EditIssue')->name('edit.issue');
        Route::post('/update/issue/{id}', 'UpdateIssue')->name('update.issue');
        Route::get('/details/issue/{id}', 'DetailsIssue')->name('details.issue');
        Route::get('/invoice/issue/{id}', 'InvoiceIssue')->name('invoice.issue');
        Route::get('/delete/issue/{id}', 'DeleteIssue')->name('delete.issue');
    });

    Route::controller(TransferController::class)->group(function () {
        Route::get('/all/transfer', 'AllTransfer')->name('all.transfer');
        Route::get('/add/transfer', 'AddTransfer')->name('add.transfer');
        Route::post('/store/transfer', 'StoreTransfer')->name('store.transfer');
        Route::get('/edit/transfer/{id}', 'EditTransfer')->name('edit.transfer');
        Route::post('/update/transfer/{id}', 'UpdateTransfer')->name('update.transfer');
        Route::get('/delete/transfer/{id}', 'DeleteTransfer')->name('delete.transfer');
        Route::get('/details/transfer/{id}', 'DetailsTransfer')->name('details.transfer');

    });


    Route::controller(ReportController::class)->group(function () {

        Route::get('/all/report', 'AllReport')->name('all.report');

        Route::get('/purchase/report', 'PurchaseReport')->name('purchase.report');

        Route::get('/damage/product/report', 'DamageProductReport')->name('damage.product.report');

        Route::get('/issue/report', 'IssueReport')->name('issue.report');

        Route::get('/stock/report', 'StockReport')->name('stock.report');

        Route::get('/fixed/asset/report', 'FixedAssetReport')->name('fixed.asset.report');

        Route::get('/purchase/return/report', 'PurchaseReturnReport')->name('purchase.return.report');

        Route::get('/product/stock/report', 'ProductStockReport')->name('product.stock.report');

        Route::get('/filter-purchases', 'FilterPurchases')->name('filter-purchases');

        Route::get('/filter-damage-products', 'FilterDamageProducts')->name('filter-damage-products');

        Route::get('/filter-issues', 'FilterIssues')->name('filter-issues');

        Route::get('/filter-stock', 'FilterStock')->name('filter-stock');

        Route::get('/filter-fixed-asset', 'FilterFixedAsset')->name('filter-fixed-asset');

    });


    Route::controller(RoleController::class)->group(function () {
        Route::get('/all/permission', 'AllPermission')->name('all.permission');
        Route::get('/add/permission', 'AddPermission')->name('add.permission');
        Route::post('/store/permission', 'StorePermission')->name('store.permission');
        Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');
        Route::post('/update/permission', 'UpdatePermission')->name('update.permission');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('/all/roles', 'AllRoles')->name('all.roles');
        Route::get('/add/roles', 'AddRoles')->name('add.roles');
        Route::post('/store/roles', 'StoreRoles')->name('store.roles');
        Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles');
        Route::post('/update/roles', 'UpdateRoles')->name('update.roles');
        Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission');
        Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store');
        Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission');

        Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles');
        Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');
        Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles');

    });


    Route::controller(RoleController::class)->group(function () {
        Route::get('/all/admin', 'AllAdmin')->name('all.admin');
        Route::get('/add/admin', 'AddAdmin')->name('add.admin');
        Route::post('/store/admin', 'StoreAdmin')->name('store.admin');
        Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin');
        Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin');
        Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin');

    });



});
