<?php
return [
    ['<?php
    try {
        try {
            throw new MyException("foo!");
        } catch (MyException $e) {
            // rethrow it
            throw $e;
        }
    } catch (Exception $e) {
        var_dump($e->getMessage());
    }
    ', ['MyException', 'MyException', 'Exception']
    ],

    ['<?php
    class Test {
        public function testing() {
            try {
                throw new MyException();
            } catch (MyException1 | MyOtherException $e) {
                var_dump(get_class($e));
            }
        }
    }', ['MyException', 'MyException1', 'MyOtherException']
    ],
];
