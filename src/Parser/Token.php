<?php

namespace SteadyUa\NsAnalyzer\Parser;

class Token
{
    private $code;
    private $text;

    const TEST = 1;

    public function __construct(int $code, string $text)
    {
        $this->code = $code;
        $this->text = $text;
    }

    public function eq($definition)
    {
        if (is_int($definition)) {
            return $this->code == $definition;
        }

        return $this->text == $definition;
    }

    public function code(): int
    {
        return $this->code;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function name(): string
    {
        if ($this->code == -1) {
            return '_';
        }

        $constList = [ // php 7.4
            'T_ABSTRACT', 'T_AND_EQUAL', 'T_ARRAY', 'T_ARRAY_CAST', 'T_AS', 'T_BAD_CHARACTER', 'T_BOOLEAN_AND',
            'T_BOOLEAN_OR', 'T_BOOL_CAST', 'T_BREAK', 'T_CALLABLE', 'T_CASE', 'T_CATCH', 'T_CHARACTER', 'T_CLASS',
            'T_CLASS_C', 'T_CLONE', 'T_CLOSE_TAG', 'T_COALESCE', 'T_COALESCE_EQUAL', 'T_COMMENT', 'T_CONCAT_EQUAL',
            'T_CONST', 'T_CONSTANT_ENCAPSED_STRING', 'T_CONTINUE', 'T_CURLY_OPEN', 'T_DEC', 'T_DECLARE', 'T_DEFAULT',
            'T_DIR', 'T_DIV_EQUAL', 'T_DNUMBER', 'T_DO', 'T_DOC_COMMENT', 'T_DOLLAR_OPEN_CURLY_BRACES',
            'T_DOUBLE_ARROW', 'T_DOUBLE_CAST', 'T_DOUBLE_COLON', 'T_ECHO', 'T_ELLIPSIS', 'T_ELSE', 'T_ELSEIF',
            'T_EMPTY', 'T_ENCAPSED_AND_WHITESPACE', 'T_ENDDECLARE', 'T_ENDFOR', 'T_ENDFOREACH', 'T_ENDIF',
            'T_ENDSWITCH', 'T_ENDWHILE', 'T_END_HEREDOC', 'T_EVAL', 'T_EXIT', 'T_EXTENDS', 'T_FILE', 'T_FINAL',
            'T_FINALLY', 'T_FN', 'T_FOR', 'T_FOREACH', 'T_FUNCTION', 'T_FUNC_C', 'T_GLOBAL', 'T_GOTO',
            'T_HALT_COMPILER', 'T_IF', 'T_IMPLEMENTS', 'T_INC', 'T_INCLUDE', 'T_INCLUDE_ONCE', 'T_INLINE_HTML',
            'T_INSTANCEOF', 'T_INSTEADOF', 'T_INTERFACE', 'T_INT_CAST', 'T_ISSET', 'T_IS_EQUAL',
            'T_IS_GREATER_OR_EQUAL', 'T_IS_IDENTICAL', 'T_IS_NOT_EQUAL', 'T_IS_NOT_IDENTICAL', 'T_IS_SMALLER_OR_EQUAL',
            'T_LINE', 'T_LIST', 'T_LNUMBER', 'T_LOGICAL_AND', 'T_LOGICAL_OR', 'T_LOGICAL_XOR', 'T_METHOD_C',
            'T_MINUS_EQUAL', 'T_MOD_EQUAL', 'T_MUL_EQUAL', 'T_NAMESPACE', 'T_NEW', 'T_NS_C', 'T_NS_SEPARATOR',
            'T_NUM_STRING', 'T_OBJECT_CAST', 'T_OBJECT_OPERATOR', 'T_OPEN_TAG', 'T_OPEN_TAG_WITH_ECHO', 'T_OR_EQUAL',
            'T_PAAMAYIM_NEKUDOTAYIM', 'T_PLUS_EQUAL', 'T_POW', 'T_POW_EQUAL', 'T_PRINT', 'T_PRIVATE', 'T_PROTECTED',
            'T_PUBLIC', 'T_REQUIRE', 'T_REQUIRE_ONCE', 'T_RETURN', 'T_SL', 'T_SL_EQUAL', 'T_SPACESHIP', 'T_SR',
            'T_SR_EQUAL', 'T_START_HEREDOC', 'T_STATIC', 'T_STRING', 'T_STRING_CAST', 'T_STRING_VARNAME', 'T_SWITCH',
            'T_THROW', 'T_TRAIT', 'T_TRAIT_C', 'T_TRY', 'T_UNSET', 'T_UNSET_CAST', 'T_USE', 'T_VAR', 'T_VARIABLE',
            'T_WHILE', 'T_WHITESPACE', 'T_XOR_EQUAL', 'T_YIELD', 'T_YIELD_FROM'
        ];
        static $constMap = [];
        if (empty($constMap)) {
            foreach ($constList as $constName) {
                if (defined($constName)) {
                    $constMap[constant($constName)] = $constName;
                }
            }
        }

        return $constMap[$this->code];
    }
}