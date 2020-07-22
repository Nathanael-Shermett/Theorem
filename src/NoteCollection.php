<?php

namespace Theorem;

/**
 * A simple abstract class for collections of {@see Note} objects.
 *
 * **NOTE:** `NoteCollection` implements `TransposableCollectionTrait`.
 */
abstract class NoteCollection
{
	use TransposableCollectionTrait;

	/**
	 * @var array Array of {@see Note} objects.
	 */
	protected array $notes;
}