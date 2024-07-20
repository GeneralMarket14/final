<?php

namespace App\Http\Controllers\Api\V2\Seller;
use App\Http\Controllers\Api\V2\UserController;

use Route;

Route::group(['prefix' => 'endpoint', 'middleware' => ['app_language']], function () {

    Route::middleware(['auth:sanctum'])->group(function () {

        //Order Section
        Route::controller(OrderController::class)->group(function () {
            Route::get('orders', 'getOrderList');
            Route::get('orders/details/{id}', 'getOrderDetails');
            Route::post('orders/items/{id}', 'getOrderItems');
            Route::post('orders/update-delivery-status', 'update_delivery_status');
            Route::post('orders/update-payment-status', 'update_payment_status');

            // Route::apiResource('shops', 'App\Http\Controllers\Api\V2\ShopController')->only('index');
        });
           Route::controller(AllWorkingHourController::class)->group(function () {
            // Route::get('/working-hours', 'index');
    Route::post('/working-hours', 'store');
    Route::get('/working-hours/{id}', 'show');
    Route::post('/working-hours-update/', 'update');
    Route::post('/working-hours-delete/{id}', 'destroy');
    
           });

        //Shop Section
        Route::controller(ShopController::class)->group(function () {
            Route::get('payment-history', 'payment_histories');
            Route::get('commission-list', 'collection_histories');
            Route::get('profile', 'profile');
            Route::get('dashboard/category-wise-products', 'category_wise_products');
            Route::get('dashboard/sales-stat', 'sales_stat');
            Route::get('dashboard/top-12-product', 'top_12_products');
            Route::get('dashboard/dashboard-counters', 'app_dashboard_counters');
            Route::get('shop/info', 'info');
            Route::get('package/info', 'pacakge');
            Route::post('shop-update', 'update');
            Route::get('shop-verify-form', 'getVerifyForm');
            Route::post('shop-verify-info-store', 'store_verify_info');
       });

        //Refund Section
        Route::controller(RefundController::class)->group(function () {
            Route::get('refunds', 'index');
            Route::post('refunds/approve', 'request_approval_vendor');
            Route::post('refunds/reject', 'reject_refund_request');
        });
        //Withdraw Request Section
        Route::controller(WithdrawRequestController::class)->group(function () {
            Route::get('withdraw-request', 'index');
            Route::post('withdraw-request/store', 'store');
        });
        
          Route::controller(UserController::class)->group(function () {
               Route::get('users/all', 'userlist');
          });
        //Product Section
        Route::controller(ProductController::class)->group(function () {
            Route::get('products/all', 'index');
            Route::get('products/byusers', 'byusers');
            // Route::get('products/withuser', 'withuser');
            Route::get('products/categories', 'getCategory');
            Route::post('merchant/audienceset', 'audiencetype');
            Route::get('products/brands', 'getBrands');
            Route::get('products/taxes', 'getTaxes');
            Route::get('products/attributes', 'getAttributes');
            Route::get('products/colors', 'getColors');
            Route::post('products/add', 'store');
            Route::get('/isfollowing/{id}', 'isfollowing');
            Route::post('/follow/{id}', 'follow');
            Route::post('/unfollow/{id}', 'unfollow');
            Route::get('/followers/{id}','followers');
            Route::get('/pricehistory/{id}','pricehistory');
            Route::get('/followees/{id}','followees');
            Route::post('gettimestamp', 'getTimestamp');
            Route::post('notificationhistory', 'notificationhistory');
            Route::post('retreive', 'retreive');
            Route::get('products/edit/{id}', 'edit');
            Route::post('products/update/{product}', 'update');
            Route::post('product/change-featured', 'change_featured_status');
            Route::post('product/change-status', 'change_status');
            Route::get('product/duplicate/{id}', 'duplicate');
            Route::get('product/delete/{id}', 'destroy');
            Route::get('products/remaining-uploads', 'remainingUploads');

            Route::get('products/reviews', 'product_reviews');
            Route::get('products/queries', 'product_queries');
            Route::get('products/query-show/{id}', 'product_queries_show');
            Route::post('products/query-reply/{id}', 'product_queries_reply');

            Route::get('products/view', 'viewProduct');
            Route::get('products/viewad', 'viewAd');
            Route::get('products/search', 'search');
            Route::get('products/suggestion', 'suggestion');
            
                  Route::get('ads/all', 'adsIndex');
                  Route::get('admin/ads', 'adminads');
            Route::post('ads/create', 'adsStore');
            Route::post('ads/delete/{id}', 'adsDelete');
            Route::post('ads/update/{ad}', 'adsupdate');
            Route::post('ad/like/{ad}', 'likead');
            Route::post('ad/likecheck/{ad}', 'likecheck');
            Route::post('ad/unlike/{ad}', 'unlikead');
        });


        //Product Query Section
        Route::controller(ProductQueryController::class)->group(function () {
            Route::get('products/queries', 'product_queries');
            Route::get('products/query-show/{id}', 'product_queries_show');
            Route::post('products/query-reply/{id}', 'product_queries_reply');
        });
        // Digital Product Section
        Route::controller(DigitalProductController::class)->group(function () {
            Route::get('digital-products', 'index'); 
            Route::get('digital-products/categories', 'getCategory');
            Route::post('digital-products/store', 'store');
            Route::get('digital-products/edit/{id}', 'edit');
            Route::post('digital-products/update/{product}', 'update');
            Route::get('digital-products/destroy/{id}', 'destroy');
            Route::get('digital-products/download/{id}', 'download');

        });

        //Whole Sale Product Section
        Route::controller(WholesaleProductController::class)->group(function () {
            Route::get('wholesale-products', 'wholesale_products');
            Route::post('wholesale-product/create', 'product_store');
            Route::get('wholesale-product/edit/{id}', 'product_edit');
            Route::post('wholesale-product/update/{id}', 'product_update');
            Route::get('wholesale-product/destroy/{id}', 'product_destroy');
        });

        // Auction Product Section
        Route::controller(SellerAuctionProductController::class)->group(function () {
            Route::get('auction-products', 'index');
            Route::post('auction-products/create', 'store');
            Route::get('auction-products/edit/{id}', 'edit');
            Route::post('auction-products/update/{id}', 'update');

            Route::get('auction-product-bids/edit/{id}', 'productBids');
            Route::get('/auction-product-bids/destroy/{id}', 'bidDestroy');
            Route::get('auction-products/orders', 'getAuctionOrderList');

        });

        //Coupon Section
        Route::controller(CouponController::class)->group(function () {
            Route::get('coupon/all', 'index');
            Route::post('coupon/create', 'store');
            Route::get('coupon/edit/{id}', 'edit');
            Route::get('coupon/delete/{id}', 'destroy');
            Route::post('coupon/update/{coupon}', 'update');
            Route::get('coupon/for-product', 'coupon_for_product');
        });

        //Conversations 
        Route::controller(ConversationController::class)->group(function () {
            Route::get('conversations', 'index');
            Route::get('conversations/show/{id}', 'showMessages');
            Route::post('conversations/message/store', 'send_message_to_customer');
        });

        //Seller Package 
        Route::controller(SellerPackageController::class)->group(function () {
            Route::get('seller-packages-list', 'seller_packages_list');
            Route::post('seller-package/offline-payment', 'purchase_package_offline');
            Route::post('seller-package/free-package', 'purchase_free_package');
        });

        //Seller File Upload 
        Route::controller(SellerFileUploadController::class)->group(function () {
            Route::post('file/upload', 'upload');
            Route::get('file/all', 'index');
            Route::get('file/delete/{id}', 'destroy');
        });

        // ...

        // POS
        Route::controller(PosController::class)->group(function () {
            Route::get('pos/products', 'productsList');
            Route::get('pos/get-customers', 'getCustomers');
            Route::post('pos/update-session-user', 'updateSessionUser');
            Route::get('pos/get-shipping_address/{id}', 'getShippingAddress');
            Route::post('pos/create-shipping-address', 'createShippingAddress');
            Route::post('pos/add-to-cart', 'addToCart');
            Route::post('pos/update-cart', 'updateQuantity');
            Route::get('pos/delete-cart/{id}', 'removeFromCart');
            Route::post('pos/order-place', 'orderStore');
            Route::post('pos/user-cart-data', 'getUserCartData');
            Route::get('pos/configuration', 'posConfiguration');
            Route::post('pos/configuration/update', 'posConfigurationUpdate');
            
        });

    });

    // Route::post('shops/create', [ShopController::class, 'store']);
});
