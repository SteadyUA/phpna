<?php

namespace SteadyUa\NsAnalyzer\Parser\State;

use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\State;

class GlobalScopeState extends State
{
    public function read(Reader $reader): ?string
    {
        $token = $reader->next();
        if (!$token) {
            return null;
        }
        switch ($token->code()) {
            case T_NEW:
                $nameSeq = $reader->matchRight(T_NS_SEPARATOR, T_STRING);
                if (!$nameSeq->isEmpty()) {
                    $reader->move($nameSeq->count());
                    return $nameSeq->toString();
                }
                break;

            case T_PAAMAYIM_NEKUDOTAYIM:
                $nameSeq = $reader->matchLeft(T_NS_SEPARATOR, T_STRING, T_STATIC, T_VARIABLE);
                return $nameSeq->toString();
        }

        return null;
    }

    public function suggestState(Reader $reader): ?State
    {
        switch ($reader->current()->code()) {
            case T_NAMESPACE:
                return new NamespaceState($this);

            case T_USE:
                return new ImportState($this);

            case T_DOC_COMMENT:
                return new DocCommentState($reader->current()->text(), $this);

            case T_FUNCTION:
                return new FunctionState($this);

            case T_CLASS:
                if ($reader->left(1)->code() !== T_PAAMAYIM_NEKUDOTAYIM) {
                    return new ClassState($this);
                }
                break;

            case T_INTERFACE:
                return new InterfaceState($this);

            case T_TRAIT:
                return new TraitState($this);
        }

        return $this;
    }
}
