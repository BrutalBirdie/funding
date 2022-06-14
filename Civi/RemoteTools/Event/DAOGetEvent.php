<?php
declare(strict_types = 1);

namespace Civi\RemoteTools\Event;

use Civi\Api4\Utils\CoreUtil;

class DAOGetEvent extends GetEvent {

  /**
   * @var string[]
   */
  protected array $groupBy = [];

  /**
   * @var array<array<scalar|array{string, string, 2?: scalar}>>
   */
  protected array $join = [];

  /**
   * @var array<array{string, string, mixed}>
   */
  protected array $having = [];

  /**
   * @param string $fieldName
   * @param string $op
   * @param mixed $value
   * @param bool $isExpression
   *
   * @return $this
   *
   * @throws \API_Exception
   *
   * @noinspection PhpMissingParentCallCommonInspection
   */
  public function addWhere(string $fieldName, string $op, $value = NULL, bool $isExpression = FALSE): GetEvent {
    if (!in_array($op, CoreUtil::getOperators(), TRUE)) {
      throw new \API_Exception('Unsupported operator');
    }
    $this->where[] = [$fieldName, $op, $value, $isExpression];

    return $this;
  }

  /**
   * @return string[]
   */
  public function getGroupBy(): array {
    return $this->groupBy;
  }

  public function addGroupBy(string $field): self {
    $this->groupBy[] = $field;

    return $this;
  }

  /**
   * @param string $expr
   * @param string $op
   * @param mixed $value
   *
   * @return $this
   *
   * @throws \API_Exception
   */
  public function addHaving(string $expr, string $op, $value = NULL): self {
    if (!in_array($op, CoreUtil::getOperators(), TRUE)) {
      throw new \API_Exception('Unsupported operator');
    }
    $this->having[] = [$expr, $op, $value];

    return $this;
  }

  /**
   * @return array<array{string, string, mixed}>
   */
  public function getHaving(): array {
    return $this->having;
  }

  /**
   * @param string $entity
   * @param string $type
   * @param null|string|array{string, string, 2?: scalar} $bridge
   * @param array{string, string, 2?: scalar} ...$conditions
   *
   * @return $this
   */
  public function addJoin(string $entity, string $type = 'LEFT', $bridge = NULL, array ...$conditions): self {
    if (NULL !== $bridge) {
      array_unshift($conditions, $bridge);
    }
    array_unshift($conditions, $entity, $type);
    $this->join[] = $conditions;

    return $this;
  }

  /**
   * @return array<array<scalar|array{string, string, 2?: scalar}>>
   */
  public function getJoin(): array {
    return $this->join;
  }

}
