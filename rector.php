<?php

use PHPUnit\Framework\TestCase;
use Rector\CodingStyle\Enum\PreferenceSelfThis;
use Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector;
use Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector;
use Rector\CodingStyle\Rector\ClassConst\SplitGroupedConstantsAndPropertiesRector;
use Rector\CodingStyle\Rector\ClassMethod\FuncGetArgsToVariadicParamRector;
use Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\FuncCall\CallUserFuncArrayToVariadicRector;
use Rector\CodingStyle\Rector\FuncCall\CallUserFuncToMethodCallRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector;
use Rector\CodingStyle\Rector\FuncCall\StrictArraySearchRector;
use Rector\CodingStyle\Rector\If_\NullableCompareToNullRector;
use Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector;
use Rector\CodingStyle\Rector\Property\AddFalseDefaultToBoolPropertyRector;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\CodingStyle\Rector\Switch_\BinarySwitchToIfElseRector;
use Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector;
use Rector\CodingStyle\Rector\Use_\RemoveUnusedAliasRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\Core\Configuration\Option;
use Rector\DeadCode\Rector\Array_\RemoveDuplicatedArrayKeyRector;
use Rector\DeadCode\Rector\Assign\RemoveAssignOfVoidReturnFunctionRector;
use Rector\DeadCode\Rector\Assign\RemoveDoubleAssignRector;
use Rector\DeadCode\Rector\Assign\RemoveUnusedAssignVariableRector;
use Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector;
use Rector\DeadCode\Rector\BinaryOp\RemoveDuplicatedInstanceOfRector;
use Rector\DeadCode\Rector\BooleanAnd\RemoveAndTrueRector;
use Rector\DeadCode\Rector\Cast\RecastingRemovalRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveDeadConstructorRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveDelegatingParentCallRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveLastReturnRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodParameterRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadCode\Rector\Concat\RemoveConcatAutocastRector;
use Rector\DeadCode\Rector\Expression\RemoveDeadStmtRector;
use Rector\DeadCode\Rector\Expression\SimplifyMirrorAssignRector;
use Rector\DeadCode\Rector\For_\RemoveDeadIfForeachForRector;
use Rector\DeadCode\Rector\For_\RemoveDeadLoopRector;
use Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveCodeAfterReturnRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveDeadReturnRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveDuplicatedIfReturnRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveOverriddenValuesRector;
use Rector\DeadCode\Rector\If_\RemoveAlwaysTrueIfConditionRector;
use Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector;
use Rector\DeadCode\Rector\If_\RemoveUnusedNonEmptyArrayBeforeForeachRector;
use Rector\DeadCode\Rector\If_\SimplifyIfElseWithSameContentRector;
use Rector\DeadCode\Rector\If_\UnwrapFutureCompatibleIfFunctionExistsRector;
use Rector\DeadCode\Rector\MethodCall\RemoveEmptyMethodCallRector;
use Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Rector\DeadCode\Rector\Plus\RemoveDeadZeroAndOneOperationRector;
use Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector;
use Rector\DeadCode\Rector\Property\RemoveUselessVarTagRector;
use Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector;
use Rector\DeadCode\Rector\Return_\RemoveDeadConditionAboveReturnRector;
use Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use Rector\DeadCode\Rector\Stmt\RemoveUnreachableStatementRector;
use Rector\DeadCode\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector;
use Rector\DeadCode\Rector\Ternary\TernaryToBooleanOrFalseToBooleanAndRector;
use Rector\DeadCode\Rector\TryCatch\RemoveDeadTryCatchRector;
use Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector;
use Rector\EarlyReturn\Rector\Foreach_\ReturnAfterToEarlyOnBreakRector;
use Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfReturnToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use Rector\EarlyReturn\Rector\Return_\PreparedValueToEarlyReturnRector;
use Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector;
use Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector;
use Rector\Php55\Rector\Class_\ClassConstantToSelfClassRector;
use Rector\Php55\Rector\FuncCall\PregReplaceEModifierRector;
use Rector\Php56\Rector\FuncCall\PowToExpRector;
use Rector\Php56\Rector\FunctionLike\AddDefaultValueForUndefinedVariableRector;
use Rector\Php70\Rector\Assign\ListSplitStringRector;
use Rector\Php70\Rector\Assign\ListSwapArrayOrderRector;
use Rector\Php70\Rector\Break_\BreakNotInLoopOrSwitchToReturnRector;
use Rector\Php70\Rector\FuncCall\CallUserMethodRector;
use Rector\Php70\Rector\FuncCall\EregToPregMatchRector;
use Rector\Php70\Rector\FuncCall\MultiDirnameRector;
use Rector\Php70\Rector\FuncCall\NonVariableToVariableOnFunctionCallRector;
use Rector\Php70\Rector\FuncCall\RandomFunctionRector;
use Rector\Php70\Rector\FuncCall\RenameMktimeWithoutArgsToTimeRector;
use Rector\Php70\Rector\FunctionLike\ExceptionHandlerTypehintRector;
use Rector\Php70\Rector\If_\IfToSpaceshipRector;
use Rector\Php70\Rector\Switch_\ReduceMultipleDefaultSwitchRector;
use Rector\Php70\Rector\Ternary\TernaryToNullCoalescingRector;
use Rector\Php70\Rector\Ternary\TernaryToSpaceshipRector;
use Rector\Php70\Rector\Variable\WrapVariableVariableNameInCurlyBracesRector;
use Rector\Php71\Rector\Assign\AssignArrayToStringRector;
use Rector\Php71\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector;
use Rector\Php71\Rector\BooleanOr\IsIterableRector;
use Rector\Php71\Rector\ClassConst\PublicConstantVisibilityRector;
use Rector\Php71\Rector\FuncCall\CountOnNullRector;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use Rector\Php71\Rector\List_\ListToArrayDestructRector;
use Rector\Php71\Rector\TryCatch\MultiExceptionCatchRector;
use Rector\Php72\Rector\Assign\ListEachRector;
use Rector\Php72\Rector\Assign\ReplaceEachAssignmentWithKeyCurrentRector;
use Rector\Php72\Rector\FuncCall\CreateFunctionToAnonymousFunctionRector;
use Rector\Php72\Rector\FuncCall\GetClassOnNullRector;
use Rector\Php72\Rector\FuncCall\IsObjectOnIncompleteClassRector;
use Rector\Php72\Rector\FuncCall\ParseStrWithResultArgumentRector;
use Rector\Php72\Rector\FuncCall\StringifyDefineRector;
use Rector\Php72\Rector\FuncCall\StringsAssertNakedRector;
use Rector\Php72\Rector\Unset_\UnsetCastRector;
use Rector\Php72\Rector\While_\WhileEachToForeachRector;
use Rector\Php73\Rector\BooleanOr\IsCountableRector;
use Rector\Php73\Rector\ConstFetch\SensitiveConstantNameRector;
use Rector\Php73\Rector\FuncCall\ArrayKeyFirstLastRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\Php73\Rector\FuncCall\SensitiveDefineRector;
use Rector\Php73\Rector\FuncCall\SetCookieRector;
use Rector\Php73\Rector\FuncCall\StringifyStrNeedlesRector;
use Rector\Php74\Rector\Assign\NullCoalescingOperatorRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php74\Rector\Double\RealToFloatTypeCastRector;
use Rector\Php74\Rector\FuncCall\ArrayKeyExistsOnPropertyRector;
use Rector\Php74\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector;
use Rector\Php74\Rector\FuncCall\FilterVarToAddSlashesRector;
use Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php80\Rector\Class_\StringableForToStringRector;
use Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector;
use Rector\Php80\Rector\ClassMethod\OptionalParametersAfterRequiredRector;
use Rector\Php80\Rector\ClassMethod\SetStateToStaticRector;
use Rector\Php80\Rector\FuncCall\ClassOnObjectRector;
use Rector\Php80\Rector\FuncCall\TokenGetAllToObjectRector;
use Rector\Php80\Rector\Identical\StrEndsWithRector;
use Rector\Php80\Rector\Identical\StrStartsWithRector;
use Rector\Php80\Rector\If_\NullsafeOperatorRector;
use Rector\Php80\Rector\NotIdentical\StrContainsRector;
use Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector;
use Rector\Php80\Rector\Ternary\GetDebugTypeRector;
use Rector\PostRector\Rector\ClassRenamingPostRector;
use Rector\PostRector\Rector\NameImportingPostRector;
use Rector\PostRector\Rector\NodeAddingPostRector;
use Rector\PostRector\Rector\NodeRemovingPostRector;
use Rector\PostRector\Rector\NodeToReplacePostRector;
use Rector\PostRector\Rector\PropertyAddingPostRector;
use Rector\PostRector\Rector\UseAddingPostRector;
use Rector\Privatization\Rector\ClassMethod\ChangeGlobalVariablesToPropertiesRector;
use Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector;
use Rector\Privatization\Rector\MethodCall\ReplaceStringWithClassConstantRector;
use Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector;
use Rector\Restoration\Rector\ClassLike\UpdateFileNameByClassNameFileSystemRector;
use Rector\Restoration\Rector\Property\MakeTypedPropertyNullableIfCheckedRector;
use Rector\Set\ValueObject\SetList;
use Rector\Transform\Rector\Class_\ChangeSingletonToServiceRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ParamTypeByMethodCallTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ParamTypeByParentCallTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnNeverTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnNewRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedPropertyRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector;
use Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\MethodCall\FormerNullableArgumentToScalarTypedRector;
use Rector\TypeDeclaration\Rector\Param\ParamTypeFromStrictTypedPropertyRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;

return static function(ContainerConfigurator $containerConfigurator): void
{
	// Parameters
	$parameters = $containerConfigurator->parameters();
	$parameters->set(Option::PATHS, [__DIR__ . '/src', __DIR__ . '/tests']);

	$containerConfigurator->import(SetList::CODE_QUALITY);
	$containerConfigurator->import(SetList::CARBON_2);

	// Services
	$services = $containerConfigurator->services();

	// Coding style
	$services->set(AddArrayDefaultToArrayPropertyRector::class);
	$services->set(AddFalseDefaultToBoolPropertyRector::class);
	$services->set(BinarySwitchToIfElseRector::class);
	$services->set(CallUserFuncArrayToVariadicRector::class);
	$services->set(CallUserFuncToMethodCallRector::class);
	$services->set(ConsistentImplodeRector::class);
	$services->set(ConsistentPregDelimiterRector::class)->call('configure', [
		[
			ConsistentPregDelimiterRector::DELIMITER => '/',
		],
	]);
	$services->set(FuncGetArgsToVariadicParamRector::class);
	$services->set(NewlineBeforeNewAssignSetRector::class);
	$services->set(NullableCompareToNullRector::class);
	$services->set(PreferThisOrSelfMethodCallRector::class)->call('configure', [
		[
			PreferThisOrSelfMethodCallRector::TYPE_TO_PREFERENCE => [
				TestCase::class => ValueObjectInliner::inline(PreferenceSelfThis::PREFER_SELF()),
			],
		],
	]);
	$services->set(RemoveUnusedAliasRector::class);
	$services->set(SeparateMultiUseImportsRector::class);
	$services->set(SplitDoubleAssignRector::class);
	$services->set(SplitGroupedConstantsAndPropertiesRector::class);
	$services->set(StrictArraySearchRector::class);
	$services->set(SymplifyQuoteEscapeRector::class);
	$services->set(TernaryConditionVariableAssignmentRector::class);
	$services->set(WrapEncapsedVariableInCurlyBracesRector::class);
	$services->set(RecastingRemovalRector::class);

	// Dead code
	$services->set(RemoveAlwaysTrueIfConditionRector::class);
	$services->set(RemoveAndTrueRector::class);
	$services->set(RemoveAssignOfVoidReturnFunctionRector::class);
	$services->set(RemoveCodeAfterReturnRector::class);
	$services->set(RemoveConcatAutocastRector::class);
	$services->set(RemoveDeadConditionAboveReturnRector::class);
	$services->set(RemoveDeadConstructorRector::class);
	$services->set(RemoveDeadIfForeachForRector::class);
	$services->set(RemoveDeadInstanceOfRector::class);
	$services->set(RemoveDeadLoopRector::class);
	$services->set(RemoveDeadReturnRector::class);
	$services->set(RemoveDeadStmtRector::class);
	$services->set(RemoveDeadTryCatchRector::class);
	$services->set(RemoveDeadZeroAndOneOperationRector::class);
	$services->set(RemoveDelegatingParentCallRector::class);
	$services->set(RemoveDoubleAssignRector::class);
	$services->set(RemoveDuplicatedArrayKeyRector::class);
	$services->set(RemoveDuplicatedCaseInSwitchRector::class);
	$services->set(RemoveDuplicatedIfReturnRector::class);
	$services->set(RemoveDuplicatedInstanceOfRector::class);
	$services->set(RemoveEmptyClassMethodRector::class);
	$services->set(RemoveEmptyMethodCallRector::class);
	$services->set(RemoveLastReturnRector::class);
	$services->set(RemoveNonExistingVarAnnotationRector::class);
	$services->set(RemoveNullPropertyInitializationRector::class);
	$services->set(RemoveOverriddenValuesRector::class);
	$services->set(RemoveParentCallWithoutParentRector::class);
	$services->set(RemoveUnreachableStatementRector::class);
	$services->set(RemoveUnusedAssignVariableRector::class);
	$services->set(RemoveUnusedConstructorParamRector::class);
	$services->set(RemoveUnusedForeachKeyRector::class);
	$services->set(RemoveUnusedNonEmptyArrayBeforeForeachRector::class);
	$services->set(RemoveUnusedPrivateMethodParameterRector::class);
	$services->set(RemoveUnusedPrivateMethodRector::class);
	$services->set(RemoveUnusedPrivatePropertyRector::class);
	$services->set(RemoveUnusedPromotedPropertyRector::class);
	$services->set(RemoveUnusedVariableAssignRector::class);
	$services->set(RemoveUselessParamTagRector::class);
	$services->set(RemoveUselessReturnTagRector::class);
	$services->set(RemoveUselessVarTagRector::class);
	$services->set(SimplifyIfElseWithSameContentRector::class);
	$services->set(SimplifyMirrorAssignRector::class);
	$services->set(TernaryToBooleanOrFalseToBooleanAndRector::class);
	$services->set(UnwrapFutureCompatibleIfFunctionExistsRector::class);

	// Early return
	$services->set(ChangeIfElseValueAssignToEarlyReturnRector::class);
	$services->set(ChangeNestedForeachIfsToEarlyContinueRector::class);
	$services->set(ChangeNestedIfsToEarlyReturnRector::class);
	$services->set(ChangeOrIfReturnToEarlyReturnRector::class);
	$services->set(PreparedValueToEarlyReturnRector::class);
	$services->set(RemoveAlwaysElseRector::class);
	$services->set(ReturnAfterToEarlyOnBreakRector::class);

	// PHP 5.4
	$services->set(RemoveReferenceFromCallRector::class);
	$services->set(RemoveZeroBreakContinueRector::class);

	// PHP 5.5
	$services->set(ClassConstantToSelfClassRector::class);
	$services->set(PregReplaceEModifierRector::class);

	// PHP 5.6
	$services->set(AddDefaultValueForUndefinedVariableRector::class);
	$services->set(PowToExpRector::class);

	// PHP 7.0
	$services->set(BreakNotInLoopOrSwitchToReturnRector::class);
	$services->set(CallUserMethodRector::class);
	$services->set(EregToPregMatchRector::class);
	$services->set(ExceptionHandlerTypehintRector::class);
	$services->set(IfToSpaceshipRector::class);
	$services->set(ListSplitStringRector::class);
	$services->set(ListSwapArrayOrderRector::class);
	$services->set(MultiDirnameRector::class);
	$services->set(NonVariableToVariableOnFunctionCallRector::class);
	$services->set(RandomFunctionRector::class);
	$services->set(ReduceMultipleDefaultSwitchRector::class);
	$services->set(RenameMktimeWithoutArgsToTimeRector::class);
	$services->set(TernaryToNullCoalescingRector::class);
	$services->set(TernaryToSpaceshipRector::class);
	$services->set(WrapVariableVariableNameInCurlyBracesRector::class);

	// PHP 7.1
	$services->set(AssignArrayToStringRector::class);
	$services->set(BinaryOpBetweenNumberAndStringRector::class);
	$services->set(CountOnNullRector::class);
	$services->set(IsIterableRector::class);
	$services->set(ListToArrayDestructRector::class);
	$services->set(MultiExceptionCatchRector::class);
	$services->set(PublicConstantVisibilityRector::class);
	$services->set(RemoveExtraParametersRector::class);

	// PHP 7.2
	$services->set(CreateFunctionToAnonymousFunctionRector::class);
	$services->set(GetClassOnNullRector::class);
	$services->set(IsObjectOnIncompleteClassRector::class);
	$services->set(ListEachRector::class);
	$services->set(ParseStrWithResultArgumentRector::class);
	$services->set(ReplaceEachAssignmentWithKeyCurrentRector::class);
	$services->set(StringifyDefineRector::class);
	$services->set(StringsAssertNakedRector::class);
	$services->set(UnsetCastRector::class);
	$services->set(WhileEachToForeachRector::class);

	// PHP 7.3
	$services->set(ArrayKeyFirstLastRector::class);
	$services->set(IsCountableRector::class);
	$services->set(JsonThrowOnErrorRector::class);
	$services->set(SensitiveConstantNameRector::class);
	$services->set(SensitiveDefineRector::class);
	$services->set(SetCookieRector::class);
	$services->set(StringifyStrNeedlesRector::class);

	// PHP 7.4
	$services->set(ArrayKeyExistsOnPropertyRector::class);
	$services->set(ArraySpreadInsteadOfArrayMergeRector::class);
	$services->set(ClosureToArrowFunctionRector::class);
	$services->set(FilterVarToAddSlashesRector::class);
	$services->set(NullCoalescingOperatorRector::class);
	$services->set(RealToFloatTypeCastRector::class);

	// PHP 8.0
	//$services->set(AnnotationToAttributeRector::class)->call('configure', [
	//		[
	//			AnnotationToAttributeRector::ANNOTATION_TO_ATTRIBUTE => ValueObjectInliner::inline([
	//				new AnnotationToAttribute('Symfony\Component\Routing\Annotation\Route', NULL),
	//			]),
	//		],
	//	]);
	$services->set(ChangeSwitchToMatchRector::class);
	$services->set(ClassOnObjectRector::class);
	$services->set(ClassPropertyAssignToConstructorPromotionRector::class);
	$services->set(FinalPrivateToPrivateVisibilityRector::class);
	$services->set(GetDebugTypeRector::class);
	$services->set(NullsafeOperatorRector::class);
	$services->set(OptionalParametersAfterRequiredRector::class);
	$services->set(RemoveUnusedVariableInCatchRector::class);
	$services->set(SetStateToStaticRector::class);
	$services->set(StrContainsRector::class);
	$services->set(StrEndsWithRector::class);
	$services->set(StrStartsWithRector::class);
	$services->set(StringableForToStringRector::class);
	$services->set(TokenGetAllToObjectRector::class);

	// PHP 8.1
	//$services->set(MyCLabsClassToEnumRector::class);
	//$services->set(MyCLabsMethodCallToEnumConstRector::class);
	//$services->set(ReadOnlyPropertyRector::class);
	//$services->set(SpatieEnumClassToEnumRector::class);

	// PostRector
	$services->set(ClassRenamingPostRector::class);
	$services->set(NameImportingPostRector::class);
	$services->set(NodeAddingPostRector::class);
	$services->set(NodeRemovingPostRector::class);
	$services->set(NodeToReplacePostRector::class);
	$services->set(PropertyAddingPostRector::class);
	$services->set(UseAddingPostRector::class);

	// Privatization
	$services->set(ChangeGlobalVariablesToPropertiesRector::class);
	$services->set(PrivatizeFinalClassMethodRector::class);
	$services->set(PrivatizeFinalClassPropertyRector::class);
	$services->set(ReplaceStringWithClassConstantRector::class);

	// Restoration
	$services->set(MakeTypedPropertyNullableIfCheckedRector::class);
	$services->set(UpdateFileNameByClassNameFileSystemRector::class);

	// Transform
	$services->set(ChangeSingletonToServiceRector::class);

	// TypeDeclaration
	$services->set(AddArrayParamDocTypeRector::class);
	$services->set(AddArrayReturnDocTypeRector::class);
	$services->set(AddClosureReturnTypeRector::class);
	$services->set(AddVoidReturnTypeWhereNoReturnRector::class);
	$services->set(FormerNullableArgumentToScalarTypedRector::class);
	$services->set(ParamTypeByMethodCallTypeRector::class);
	$services->set(ParamTypeByParentCallTypeRector::class);
	$services->set(ParamTypeDeclarationRector::class);
	$services->set(ParamTypeFromStrictTypedPropertyRector::class);
	$services->set(ReturnNeverTypeRector::class);
	$services->set(ReturnTypeDeclarationRector::class);
	$services->set(ReturnTypeFromReturnNewRector::class);
	$services->set(ReturnTypeFromStrictTypedCallRector::class);
	$services->set(ReturnTypeFromStrictTypedPropertyRector::class);
	$services->set(TypedPropertyFromStrictConstructorRector::class);
};