<?php

namespace Theorem;

use Theorem\Renderer\RendererInterface;

/**
 * Provides functionality for allowing entities (such as {@see Note} and {@see Chord}) to be rendered (i.e. printed to
 * a string).
 *
 * **NOTE:** `RenderableTrait` does not provide a default implementation of {@see toString()}. Any classes using
 * `RenderableTrait` *must* write their own implementation.
 */
trait RenderableTrait
{
	/**
	 * Setting representing the renderer. Can be set on a per-object basis, or globally with
	 * `Setting::setRenderer()`.
	 *
	 * @see getRenderer()
	 * @see setRenderer()
	 * @var string
	 */
	private static string $RENDERER;

	/**
	 * Calls `toString()` using its default parameters.
	 *
	 * @return string
	 * @see toString()
	 */
	final public function __toString(): string
	{
		return $this->toString($this->getRenderer());
	}

	/**
	 * Gets the renderer. If it has not been set, it defaults to the global renderer setting.
	 *
	 * @return string
	 */
	final public function getRenderer(): RendererInterface
	{
		$renderer = self::$RENDERER ?? Setting::getRenderer();
		$renderer = new $renderer();

		return $renderer;
	}

	/**
	 * Sets the renderer. Can be set on a per-object basis, or globally with`Setting::setRenderer()` unless
	 * overridden.
	 *
	 * @param string $renderer
	 * @return void
	 */
	final public function setRenderer(string $renderer): void
	{
		self::$RENDERER = $renderer;
	}

	/**
	 * Converts the entity to a string.
	 *
	 * **NOTE**: `RenderableTrait` does not provide a default implementation of this method. Any classes using
	 * `RenderableTrait` *must* write their own implementation.
	 *
	 * @param string|null $renderer The render mode used by the implementing entity.
	 * @return string
	 * @see getRenderer()
	 * @see getOutputMode()
	 */
	abstract public function toString($renderer = NULL): string;
}