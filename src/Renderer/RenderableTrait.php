<?php

namespace Theorem\Renderer;

use Theorem\Accidental\AbstractAccidental;

/**
 * Provides functionality for allowing entities to be rendered (i.e. printed to a string).
 *
 * **NOTE:** `RenderableTrait` does not provide a default implementation of `toString()`. Any classes using
 * `RenderableTrait` *must* write their own implementation.
 *
 * @see AbstractAccidental
 * @see Note
 */
trait RenderableTrait
{
	/**
	 * Setting representing the renderer. Can be set on a per-object basis, or globally with
	 * `Theorem::setRenderer()`.
	 *
	 * @var string $renderer
	 * @see getRenderer()
	 * @see setRenderer()
	 */
	private string $renderer;

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
	 * @see Theorem::getRenderer()
	 * @see Theorem::setRenderer()
	 */
	final public function getRenderer(): RendererInterface
	{
		$renderer = $this->renderer ?? $this->theorem->getRenderer();
		$renderer = new $renderer();

		return $renderer;
	}

	/**
	 * Sets the renderer. Can be set on a per-object basis, or globally with`Setting::setRenderer()` unless
	 * overridden.
	 *
	 * @param string $renderer
	 * @return $this
	 * @see getRenderer()
	 * @see Theorem::getRenderer()
	 * @see Theorem::setRenderer()
	 */
	final public function setRenderer(string $renderer): self
	{
		$this->renderer = $renderer;

		return $this;
	}

	/**
	 * Converts the entity to a string.
	 *
	 * **NOTE**: `RenderableTrait` does not provide a default implementation of this method. Any classes using
	 * `RenderableTrait` *must* write their own implementation.
	 *
	 * @param RendererInterface|null $renderer The render mode used by the implementing entity.
	 * @return string
	 * @see getRenderer()
	 * @see setRenderer()
	 * @see Theorem::getRenderer()
	 * @see Theorem::setRenderer()
	 */
	abstract public function toString(RendererInterface $renderer = NULL): string;
}