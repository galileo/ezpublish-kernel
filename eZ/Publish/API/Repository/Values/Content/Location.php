<?php

/**
 * File containing the eZ\Publish\API\Repository\Values\Content\Location class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 *
 * @version //autogentag//
 */
namespace eZ\Publish\API\Repository\Values\Content;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * This class represents a location in the repository.
 *
 * @property-read \eZ\Publish\API\Repository\Values\Content\ContentInfo $contentInfo calls getContentInfo()
 * @property-read mixed $contentId calls getContentInfo()->id
 * @property-read mixed $id the id of the location
 * @property-read int $priority Position of the Location among its siblings when sorted using priority
 * @property-read boolean $hidden Indicates that the Location is explicitly marked as hidden.
 * @property-read boolean $invisible  Indicates that the Location is implicitly marked as hidden by a parent location
 * @property-read string $remoteId a global unique id of the content object
 * @property-read mixed $parentLocationId the id of the parent location
 * @property-read string $pathString the path to this location e.g. /1/2/4/23 where 23 is current id.
 * @property-read array $path Same as $pathString but as array, e.g. [ 1, 2, 4, 23 ]
 * @property-read int $depth Depth location has in the location tree
 *
 * @property-read int $sortField Specifies which property the child locations should be sorted on. Valid values are found at {@link Location::SORT_FIELD_*}
 * @property-read int $sortOrder Specifies whether the sort order should be ascending or descending. Valid values are {@link Location::SORT_ORDER_*}
 */
abstract class Location extends ValueObject
{
    // @todo Rename these to better fit current naming, also reuse these in Persistence or copy the change over.
    const SORT_FIELD_PATH = 1;
    const SORT_FIELD_PUBLISHED = 2;
    const SORT_FIELD_MODIFIED = 3;
    const SORT_FIELD_SECTION = 4;
    const SORT_FIELD_DEPTH = 5;
    const SORT_FIELD_CLASS_IDENTIFIER = 6;
    const SORT_FIELD_CLASS_NAME = 7;
    const SORT_FIELD_PRIORITY = 8;
    const SORT_FIELD_NAME = 9;
    const SORT_FIELD_MODIFIED_SUBNODE = 10;
    const SORT_FIELD_NODE_ID = 11;
    const SORT_FIELD_CONTENTOBJECT_ID = 12;

    const SORT_ORDER_DESC = 0;
    const SORT_ORDER_ASC = 1;

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * Location ID.
     *
     * @var mixed Location ID.
     */
    protected $id;

    /**
     * the status of the location.
     *
     * a location gets the status DRAFT on newly created content which is not published. When content is published the
     * location gets the status STATUS_PUBLISHED
     *
     * @var int
     */
    public $status = self::STATUS_PUBLISHED;

    /**
     * Location priority.
     *
     * Position of the Location among its siblings when sorted using priority
     * sort order.
     *
     * @var int
     */
    protected $priority;

    /**
     * Indicates that the Location entity has been explicitly marked as hidden.
     *
     * @var bool
     */
    protected $hidden;

    /**
     * Indicates that the Location is implicitly marked as hidden by a parent
     * location.
     *
     * @var bool
     */
    protected $invisible;

    /**
     * Remote ID.
     *
     * A universally unique identifier.
     *
     * @var mixed
     */
    protected $remoteId;

    /**
     * Returns the content info of the content object of this location.
     *
     * @return \eZ\Publish\API\Repository\Values\Content\ContentInfo
     */
    abstract public function getContentInfo();

    /**
     * Returns true if current location is a draft.
     *
     * @return bool
     */
    public function isDraft()
    {
        return $this->status === self::STATUS_DRAFT;
    }

    /**
     * Parent ID.
     *
     * @var mixed Location ID.
     */
    protected $parentLocationId;

    /**
     * The materialized path of the location entry, eg: /1/2/.
     *
     * @var string
     */
    protected $pathString;

    /**
     * Depth location has in the location tree.
     *
     * @var int
     */
    protected $depth;

    /**
     * Specifies which property the child locations should be sorted on.
     *
     * Valid values are found at {@link Location::SORT_FIELD_*}
     *
     * @var mixed
     */
    protected $sortField;

    /**
     * Specifies whether the sort order should be ascending or descending.
     *
     * Valid values are {@link Location::SORT_ORDER_*}
     *
     * @var mixed
     */
    protected $sortOrder;
}
