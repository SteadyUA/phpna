<?php

namespace SteadyUa\NsAnalyzer\Parser;

class Tokenizer
{
    public function parse(string $code): Sequence
    {
        $chain = new Sequence();
        foreach (@token_get_all($code) as $tokenInfo) {
            if (is_array($tokenInfo)) {
                if ($tokenInfo[0] != T_WHITESPACE) {
                    $chain->add(new Token($tokenInfo[0], $tokenInfo[1]));
                }
            } else {
                $chain->add(new Token(-1, $tokenInfo));
            }
        }

        return $chain;
    }
}
