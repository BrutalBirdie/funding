<?php

/*
 * Copyright (C) 2023 SYSTOPIA GmbH
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 3 as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types = 1);

namespace Civi\Funding\DependencyInjection\Util;

use Symfony\Component\Config\Resource\GlobResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @codeCoverageIgnore
 */
final class ServiceRegistrator {

  /**
   * Autowires all implementations of the given class or interface.
   *
   * All PSR conform classes below the given directory (recursively) are
   * considered.
   *
   * @phpstan-param class-string $classOrInterface
   * @phpstan-param array<string, array<string, scalar>> $tags
   *   Tag names mapped to attributes.
   *
   * @phpstan-return array<\Symfony\Component\DependencyInjection\Definition>
   */
  public static function autowireAllImplementing(
    ContainerBuilder $container,
    string $dir,
    string $namespace,
    string $classOrInterface,
    array $tags = []
  ): array {
    $container->addResource(new GlobResource($dir, '/*.php', TRUE));

    $definitions = [];
    $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
    while ($it->valid()) {
      if ($it->isFile() && 'php' === $it->getFileInfo()->getExtension()) {
        // @phpstan-ignore-next-line
        $class = static::getClass($namespace, $it->getInnerIterator());
        if (static::isServiceClass($class, $classOrInterface)) {
          /** @phpstan-var class-string $class */
          $definition = $container->autowire($class);
          foreach ($tags as $tagName => $tagAttributes) {
            $definition->addTag($tagName, $tagAttributes);
          }

          $definitions[] = $definition;
        }
      }

      $it->next();
    }

    return $definitions;
  }

  private static function getClass(string $namespace, \RecursiveDirectoryIterator $it): string {
    $class = $namespace . '\\';
    if ('' !== $it->getSubPath()) {
      $class .= str_replace('/', '\\', $it->getSubPath()) . '\\';
    }

    return $class . $it->getFileInfo()->getBasename('.php');
  }

  /**
   * @phpstan-param class-string $classOrInterface
   */
  private static function isServiceClass(string $class, string $classOrInterface): bool {
    if (!class_exists($class)) {
      return FALSE;
    }

    $reflClass = new \ReflectionClass($class);

    return $reflClass->isSubclassOf($classOrInterface) && !$reflClass->isAbstract();
  }

}
