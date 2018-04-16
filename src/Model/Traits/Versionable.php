<?php namespace Anomaly\Streams\Platform\Model\Traits;

use Anomaly\Streams\Platform\Version\Contract\VersionInterface;
use Anomaly\Streams\Platform\Version\VersionModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Versionable
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait Versionable
{

    /**
     * Versionable flag.
     *
     * @var bool
     */
    protected $versionable = false;

    /**
     * The versioning-disabled flag.
     *
     * @var bool
     */
    protected $versioningDisabled = false;

    /**
     * The versioned attributes.
     *
     * @var array
     */
    protected $versionedAttributes = [];

    /**
     * The non-versioned attributes.
     *
     * @var array
     */
    protected $nonVersionedAttributes = [];

    /**
     * The version comparison data.
     *
     * @var array
     */
    protected $versionComparisonData = [];

    /**
     * The version differences.
     *
     * @var null|array
     */
    protected $versionDifferences = null;

    /**
     * Return if the model should version or not.
     *
     * @return bool
     */
    public function shouldVersion()
    {
        if ($this->versioningDisabled()) {
            return false;
        }

        if ($this->wasRecentlyCreated) {
            return true;
        }

        return (count($this->versionedAttributeChanges()) > 0);
    }

    /**
     * Get the versionable flag.
     *
     * @return bool
     */
    public function isVersionable()
    {
        return $this->versionable;
    }

    /**
     * Set the versionable flag.
     *
     * @param $versionable
     * @return $this
     */
    public function setVersionable($versionable)
    {
        $this->versionable = $versionable;

        return $this;
    }

    /**
     * Enable versioning.
     *
     * @return $this
     */
    public function enableVersioning()
    {
        $this->versioningDisabled = false;

        return $this;
    }

    /**
     * Disable versioning.
     *
     * @return $this
     */
    public function disableVersioning()
    {
        $this->versioningDisabled = true;

        return $this;
    }

    /**
     * Return if versioning is disabled.
     *
     * @return bool
     */
    public function versioningDisabled()
    {
        return $this->versioningDisabled == true;
    }

    /**
     * Return versioned attributes.
     *
     * @return array
     */
    public function getVersionedAttributes()
    {
        return $this->versionedAttributes;
    }

    /**
     * Return non-versioned attributes.
     *
     * @return array
     */
    public function getNonVersionedAttributes()
    {
        return array_merge(
            $this->nonVersionedAttributes,
            [
                'created_at',
                'created_by_id',
                'updated_at',
                'updated_by_id',
                'deleted_at',
                'deleted_by_id',
            ]
        );
    }

    /**
     * Return if the attribute is
     * translatable or not.
     *
     * @param $key
     * @return bool
     */
    public function isVersionedAttribute($key)
    {
        return in_array($key, $this->versionedAttributes);
    }

    /**
     * Set the versioned attribute changes (dirty).
     *
     * @param array $attributes
     * @return $this
     */
    public function setVersionComparisonData(array $attributes)
    {
        $this->versionComparisonData = $attributes;

        return $this;
    }

    /**
     * Get the versioned attribute changes (dirty).
     *
     * @return array
     */
    public function getVersionComparisonData()
    {
        return $this->versionComparisonData;
    }

    /**
     * Get the version comparison differences.
     *
     * @return array
     */
    public function getVersionDifferences()
    {
        if ($this->versionDifferences === null) {

            $comparison = $this->getversionComparisonData();

            $this->versionDifferences = array_diff_assoc(
                $comparison,
                $this->toArrayForComparison()
            );
        }

        return $this->versionDifferences;
    }

    /**
     * Return the versioned attribute changes.
     *
     * @return array
     */
    public function versionedAttributeChanges()
    {
        return array_diff_key(
            $this->getVersionDifferences(),
            array_flip($this->getNonVersionedAttributes())
        );
    }

    /**
     * Return the latest version.
     *
     * @return VersionInterface|null
     */
    public function getCurrentVersion()
    {
        return $this
            ->versions()
            ->orderBy('created_at', 'DESC')
            ->first();
    }

    /**
     * Return the previous version.
     *
     * @return VersionInterface
     */
    public function getPreviousVersion()
    {
        return $this
            ->versions()
            ->orderBy('created_at', 'DESC')
            ->limit(1)
            ->offset(1)
            ->first();
    }

    /**
     * Return the versions relation.
     *
     * @return HasMany
     */
    public function versions()
    {
        return $this->morphMany(VersionModel::class, 'versionable');
    }

}
