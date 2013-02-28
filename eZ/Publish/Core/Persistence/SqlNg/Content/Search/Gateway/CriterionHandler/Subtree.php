<?php
/**
 * File containing the EzcDatabase subtree criterion handler class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\Core\Persistence\SqlNg\Content\Search\Gateway\CriterionHandler;

use eZ\Publish\Core\Persistence\SqlNg\Content\Search\Gateway\CriterionHandler;
use eZ\Publish\Core\Persistence\SqlNg\Content\Search\Gateway\CriteriaConverter;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use ezcQuerySelect;

/**
 * Subtree criterion handler
 */
class Subtree extends CriterionHandler
{
    /**
     * Check if this criterion handler accepts to handle the given criterion.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Query\Criterion$criterion
     *
     * @return boolean
     */
    public function accept( Criterion $criterion )
    {
        return $criterion instanceof Criterion\Subtree;
    }

    /**
     * Generate query expression for a Criterion this handler accepts
     *
     * accept() must be called before calling this method.
     *
     * @param \eZ\Publish\Core\Persistence\SqlNg\Content\Search\Gateway\CriteriaConverter$converter
     * @param \ezcQuerySelect $query
     * @param \eZ\Publish\API\Repository\Values\Content\Query\Criterion$criterion
     *
     * @return \ezcQueryExpression
     */
    public function handle( CriteriaConverter $converter, ezcQuerySelect $query, Criterion $criterion )
    {
        $table = $this->getUniqueTableName();

        $statements = array();
        foreach ( $criterion->value as $pattern )
        {
            $statements[] = $query->expr->like(
                $this->dbHandler->quoteColumn( 'path_string', $table ),
                $query->bindValue( $pattern . '%' )
            );
        }

        $query
            ->leftJoin(
                $query->alias(
                    $this->dbHandler->quoteTable( 'ezcontent_location' ),
                    $this->dbHandler->quoteIdentifier( $table )
                ),
                $query->expr->eq(
                    $this->dbHandler->quoteColumn( 'content_id', $table ),
                    $this->dbHandler->quoteColumn( 'id', 'ezcontent' )
                )
            );

        return $query->expr->lOr(
            $statements
        );
    }
}
