<?php

namespace Theorem\Renderer;

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
	 * @var string $RENDERER
	 * @see getRenderer()
	 * @see setRenderer()
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
	 * @return RendererInterface
	 * @see setRenderer()
	 * @see Setting::getRenderer()
	 * @see Setting::setRenderer()
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
	 * @return RenderableTrait
	 * @see getRenderer()
	 * @see Setting::getRenderer()
	 * @see Setting::setRenderer()
	 */
	final public function setRenderer(string $renderer): self
	{
		self::$RENDERER = $renderer;

		return $this;
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
	 * @see setRenderer()
	 * @see Setting::getRenderer()
	 * @see Setting::setRenderer()
	 */
	abstract public function toString($renderer = NULL): string;
}