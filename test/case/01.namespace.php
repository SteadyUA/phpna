<?php
return [
    ['<?php
namespace Test1\Name;
?>', ['\\Test1\\Name\\']],

    ['<?php
namespace {
   
};
namespace Test2 {
}
?>', ['\\\\', '\Test2\\']],
];
