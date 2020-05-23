<?php
return [
    'minVer' => '7.4.0',
    'case' => [
    [
        '<?php $ids = array_map(fn(\Post $post): int => $post->id, $posts);',
        ['\Post', 'int']
    ],
    [
        '<?php fn&(Foo\Bar $bar) : ?int => $bar->x',
        ['Foo\Bar', 'int']
    ],
    [
        '<?php 
class Foo {
    public function validBarList() {
        return array_filter($this->items, fn(Foo\Bar $bar) => $bar->isValid());
    }
}',
        ['Foo\Bar']
    ],
    [
        '<?php 
function sortList($list) {
    usort($list, fn($left, $right): int => $left <=> $right);
    
    return $list;
}',
        ['int']
    ]
]];
