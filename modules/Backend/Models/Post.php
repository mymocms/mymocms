<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Juzaweb\CMS\Database\Factories\PostFactory;
use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Traits\PostTypeModel;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

/**
 * Juzaweb\Backend\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string|null $thumbnail
 * @property string $slug
 * @property string|null $description
 * @property string|null $content
 * @property string $status
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string $type
 * @property array|null $json_metas
 * @property array|null $json_taxonomies
 * @property float $rating
 * @property int $total_rating
 * @property int $total_comment
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Juzaweb\CMS\Models\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\MenuItem[] $menuItems
 * @property-read int|null $menu_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\PostMeta[] $metas
 * @property-read int|null $metas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\PostRating[] $postRatings
 * @property-read int|null $post_ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\PostView[] $postViews
 * @property-read int|null $post_views_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\Taxonomy[] $taxonomies
 * @property-read int|null $taxonomies_count
 * @property-read \Juzaweb\CMS\Models\User|null $updatedBy
 * @method static \Juzaweb\CMS\Database\Factories\PostFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereFilter($params = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereJsonMetas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereJsonTaxonomies($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMeta($key, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublish()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSearch($params)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTaxonomy($taxonomy)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTaxonomyIn($taxonomies)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTotalComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTotalRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereViews($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMetaIn($key, $values)
 * @property int|null $site_id
 * @property string|null $locale
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSiteId($value)
 */
class Post extends Model implements Feedable
{
    use PostTypeModel;
    use HasFactory;

    public const STATUS_PUBLISH = 'publish';
    public const STATUS_PRIVATE = 'private';
    public const STATUS_DRAFT = 'draft';
    public const STATUS_TRASH = 'trash';

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'content',
        'status',
        'views',
        'thumbnail',
        'slug',
        'type',
        'json_metas',
        'json_taxonomies',
        'rating',
        'total_rating',
    ];

    protected $searchFields = [
        'title',
    ];

    protected $casts = [
        'json_metas' => 'array',
        'json_taxonomies' => 'array',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return PostFactory::new();
    }

    public function categories(): BelongsToMany
    {
        return $this->taxonomies()
            ->where('taxonomy', '=', 'categories');
    }

    public function tags(): BelongsToMany
    {
        return $this->taxonomies()->where('taxonomy', '=', 'tags');
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(
            MenuItem::class,
            'model_id',
            'id'
        )
            ->where(
                'model_class',
                '=',
                'Juzaweb\\Models\\Post'
            );
    }

    public function postViews(): HasMany
    {
        return $this->hasMany(PostView::class, 'post_id', 'id');
    }

    public function postRatings(): HasMany
    {
        return $this->hasMany(PostRating::class, 'post_id', 'id');
    }

    public function getTotalRating(): int
    {
        return $this->postRatings()->count(['id']);
    }

    public function getStarRating(): float|int
    {
        $total = $this->postRatings()->sum('star');
        $count = $this->getTotalRating();

        if ($count <= 0) {
            return 0;
        }

        return round($total * 5 / ($count * 5), 2);
    }

    public function toFeedItem(): FeedItem
    {
        $name = $this->getCreatedByName();
        $updated = $this->updated_at ?: now();
        if (empty($name)) {
            $name = 'Admin';
        }

        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->description)
            ->updated($updated)
            ->link($this->getLink())
            ->authorName($name);
    }
}
