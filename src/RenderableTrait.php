<?php

namespace Theorem;

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
	 * Setting representing the output mode. Can be set on a per-object basis, or globally with
	 * `Setting::setOutputMode()`.
	 *
	 * @see getOutputMode()
	 * @see setOutputMode()
	 * @var string
	 */
	private static string $OUTPUT_MODE;

	/**
	 * Setting representing the rendering mode. Can be set on a per-object basis, or globally with
	 * `Setting::setRenderMode()`.
	 *
	 * @see getRenderMode()
	 * @see setRenderMode()
	 * @var string
	 */
	private static string $RENDER_MODE;

	/**
	 * Calls `toString()` using its default parameters.
	 *
	 * @return string
	 * @see toString()
	 */
	final public function __toString(): string
	{
		return $this->toString($this->getOutputMode(), $this->getRenderMode());
	}

	/**
	 * Gets the output mode. If it has not been set, it defaults to the global output mode setting.
	 *
	 * @return string
	 */
	final public function getOutputMode(): string
	{
		return self::$OUTPUT_MODE ?? Setting::getOutputMode();
	}

	/**
	 * Sets the output mode. Can be set on a per-object basis, or globally with `Setting::setOutputMode()` unless
	 * overridden.
	 *
	 * @param string $outputMode
	 * @return void
	 */
	final public function setOutputMode(string $outputMode): void
	{
		self::$OUTPUT_MODE = $outputMode;
	}

	/**
	 * Gets the rendering mode. If it has not been set, it defaults to the global rendering mode setting.
	 *
	 * @return string
	 */
	final public function getRenderMode(): string
	{
		return self::$RENDER_MODE ?? Setting::getRenderMode();
	}

	/**
	 * Sets the rendering mode. Can be set on a per-object basis, or globally with`Setting::setRenderMode()` unless
	 * overridden.
	 *
	 * @param string $renderMode
	 * @return void
	 */
	final public function setRenderMode(string $renderMode): void
	{
		self::$RENDER_MODE = $renderMode;
	}

	/**
	 * Converts the entity to a string.
	 *
	 * **NOTE**: `RenderableTrait` does not provide a default implementation of this method. Any classes using
	 * `RenderableTrait` *must* write their own implementation.
	 *
	 * @param string|null $outputMode The output mode used by the implementing entity.
	 * @param string|null $renderMode The render mode used by the implementing entity.
	 * @return string
	 * @see getRenderMode()
	 * @see getOutputMode()
	 */
	abstract public function toString($outputMode = NULL, $renderMode = NULL): string;
}