<?php

namespace App\Criterion\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ThisLikeThatCriteria
 *
 * @package App\Criterion\Eloquent
 * @author  Lloric Mayuga Garcia <lloricode@gmail.com>
 */
class ThisLikeThatCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $field;

    /**
     * @var
     */
    private $valueString;

    /**
     * @var string
     */
    private $separator;

    /**
     * @var string
     */
    private $wildcard;

    /**
     * LikeCriteria constructor.
     *
     * @param        $field
     * @param        $valueString
     * @param  string  $separator
     * @param  string  $wildcard
     */
    public function __construct($field, $valueString, $separator = ',', $wildcard = '*')
    {
        $this->field = $field;
        $this->valueString = $valueString;
        $this->separator = $separator;
        $this->wildcard = $wildcard;
    }

    /**
     * @param                                                   $model
     * @param  \Prettus\Repository\Contracts\RepositoryInterface  $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        /** @var \Illuminate\Database\Eloquent\Builder $model */
        return $model->where(
            function (Model $query) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */

                $values = explode($this->separator, $this->valueString);
                $query->where($this->field, 'LIKE', str_replace($this->wildcard, '%', array_shift($values)));
                foreach ($values as $value) {
                    $query->orWhere($this->field, 'LIKE', str_replace($this->wildcard, '%', $value));
                }
            }
        );
    }
}
