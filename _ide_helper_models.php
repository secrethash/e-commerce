<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Brand
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string|null $slug
 * @property string|null $website
 * @property string|null $description
 * @property int $position
 * @property bool|null $aftermarket Defines if the brand is an Aftermarket Brand.
 * @property bool $is_enabled
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\Shopper\Framework\Models\Shop\Product\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Brand aftermarket()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand notAftermarket()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereAftermarket($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereIsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereWebsite($value)
 */
	class Brand extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $name
 * @property string|null $slug
 * @property string|null $sku
 * @property string|null $barcode
 * @property string|null $description
 * @property int $security_stock
 * @property bool $featured
 * @property bool $is_visible
 * @property int|null $old_price_amount
 * @property int|null $price_amount
 * @property int|null $cost_amount
 * @property string|null $type
 * @property int $backorder
 * @property bool $requires_shipping
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $weight_value
 * @property string $weight_unit
 * @property string|null $height_value
 * @property string $height_unit
 * @property string|null $width_value
 * @property string $width_unit
 * @property string|null $depth_value
 * @property string $depth_unit
 * @property string|null $volume_value
 * @property string $volume_unit
 * @property int|null $parent_id
 * @property int|null $brand_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Shopper\Framework\Models\Shop\Product\ProductAttribute[] $attributes
 * @property-read int|null $attributes_count
 * @property-read \App\Models\Brand|null $brand
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\Shopper\Framework\Models\Shop\Product\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Shopper\Framework\Models\Shop\Channel[] $channels
 * @property-read int|null $channels_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|Product[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Shopper\Framework\Models\Shop\Product\Collection[] $collections
 * @property-read int|null $collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Shopper\Framework\Models\Shop\DiscountDetail[] $discounts
 * @property-read int|null $discounts_count
 * @property-read string|null $formatted_price
 * @property-read \Shopper\Helpers\Price|null $price
 * @property-read int $stock
 * @property-read int $variations_stock
 * @property-read \Illuminate\Database\Eloquent\Collection|\Shopper\Framework\Models\Shop\Inventory\InventoryHistory[] $inventoryHistories
 * @property-read int|null $inventory_histories_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read Product|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Shopper\Framework\Models\Shop\Review[] $ratings
 * @property-read int|null $ratings_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\Shopper\Framework\Models\Shop\Product\Product[] $relatedProducts
 * @property-read int|null $related_products_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\Shopper\Framework\Models\Shop\Product\Product[] $variations
 * @property-read int|null $variations_count
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|static[] all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product depthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product featured()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|static[] get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product getExpressionGrammar()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product hasChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product hasParent()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product isLeaf()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product isRoot()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product newModelQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product newQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product publish()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product query()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product tree($maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product treeOf(callable $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereBackorder($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereBarcode($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereBrandId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereCostAmount($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereDepthUnit($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereDepthValue($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereDescription($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereFeatured($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereHeightUnit($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereHeightValue($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereIsVisible($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereName($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereOldPriceAmount($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereParentId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product wherePriceAmount($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product wherePublishedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereRequiresShipping($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereSecurityStock($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereSeoDescription($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereSeoTitle($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereSku($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereSlug($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereType($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereVolumeUnit($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereVolumeValue($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereWeightUnit($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereWeightValue($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereWidthUnit($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product whereWidthValue($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Product withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $first_name
 * @property string $last_name
 * @property string|null $gender
 * @property string|null $phone_number
 * @property string|null $birth_date
 * @property string $avatar_type
 * @property string|null $avatar_location
 * @property string|null $timezone
 * @property int $opt_in
 * @property string|null $last_login_at
 * @property string|null $last_login_ip
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Shopper\Framework\Models\User\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Shopper\Framework\Models\Shop\DiscountDetail[] $discounts
 * @property-read int|null $discounts_count
 * @property-read string $birth_date_formatted
 * @property-read string $full_name
 * @property-read string $picture
 * @property-read string $roles_label
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Shopper\Framework\Models\Shop\Order\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User research($term)
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatarLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatarType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOptIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

